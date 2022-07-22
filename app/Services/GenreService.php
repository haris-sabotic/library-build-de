<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GenreService {

    /**
     * Vrati sve zanrove iz baze podataka
     *
     */
    public function getGenres(){

        return $genres = DB::table('genres');
    }

    /**
     * Kreiraj novi zanr i sacuvaj ga u bazi
     *
     * @param  UserService $userService
     * @param  Request $request
     */
    public function saveGenre($userService, $request) {

        //request all data, validate and add genre
        request()->validate([
            'genreName' => 'required|string|max:256',
            'userImage'  => 'nullable|mimes:jpeg,png,jpg'
        ]);

        $genre = new Genre();

        $genre->name = request('genreName');
        $userService->uploadPhoto($genre, $request);

        $genre->save();
    }

    /**
     * Izvrsi validaciju podataka i edituj zanr
     *
     * @param  Genre $genre
     * @param  UserService $userService
     * @param  Request $request
     */
    public function editGenre($genre, $userService, $request) {
        
         //request all data, validate and update genre
         request()->validate([
            'genreNameEdit' => 'string|max:256',
            'userImage'      => 'nullable|mimes:jpeg,png,jpg'
        ]);

        $genre->name = request('genreNameEdit');
        $userService->uploadEditPhoto($genre, $request);

        $genre->save();
    }

}
