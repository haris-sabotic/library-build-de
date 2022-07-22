<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CategoryService {

    /**
     * Vrati sve kategorije iz baze podataka
     *
     */
    public function getCategories(){

        return $categories = DB::table('categories');
    }

    /**
     * Izvrsi validaciju podataka i edituj kategoriju
     *
     * @param  Category  $category
     * @param  UserService $userService
     * @param  Request $request
     */
    public function editCategory($category, $userService, $request){

        //request all data, validate and update category
        request()->validate([
            'categoryNameEdit'          => 'string|max:256',
            'userImage'                 => 'nullable|mimes:jpeg,png,jpg',
            'categoryDescriptionEdit'   => 'nullable|string|max:2048'
        ]);

        $category->name        = request('categoryNameEdit');
        $category->description = request('categoryDescriptionEdit');

        $userService->uploadEditPhoto($category, $request);

        $category->save();
   }

   /**
     * Kreiraj novu kategoriju i sacuvaj je u bazi
     *
     * @param  UserService $userService
     * @param  Request $request
     */
   public function saveCategory($userService, $request) {
       
    //request all data, validate and update category
    request()->validate([
        'categoryName'         => 'required|string|max:256',
        'userImage'            => 'nullable|mimes:jpeg,png,jpg',
        'categoryDescription'  => 'nullable|string|max:2048',
    ]);

    $category = new Category();

    $category->name        = request('categoryName');
    $category->description = request('categoryDescription');

    $userService->uploadPhoto($category, $request);

    $category->save();
   }
}
