<?php

namespace App\Http\Controllers;

use http\Client\Response;
use Illuminate\Http\Request;
use App\Models\Galery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GaleryController extends Controller
{

    private $viewFolderBook = 'pages/books';

    /**
     * Update slike
     *
     * @param  Request $request
     */
    public function update(Request $request)
    {
        $bookId = (int)$request->bookId;

        foreach ($request->movieImages as $image) {

            $filenameWithExt = $image->getClientOriginalName();

            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get just Extension
            $extension = $image->getClientOriginalExtension();

            // Filename To store
            $fileNameToStore = $filename. '_'. time().'.'.$extension;

            // Upload Image
            $image->storeAs('public/image', $fileNameToStore);

            $gallery = new Galery();
            $gallery->book_id = $bookId;
            $gallery->photo = $fileNameToStore;
            $gallery->save();
        }

        return response()->json(['success'=>'Slika je uspješno sačuvana!']);
    }

    /**
     * Izbrisi sliku
     *
     * @param  User $user
     */
    public function deleteImage(Galery $photo)
    {
        Galery::destroy($photo->id);

        return response()->json([
            'success' => 'Slika je uspješno obrisana!'
        ]);
    }
}
