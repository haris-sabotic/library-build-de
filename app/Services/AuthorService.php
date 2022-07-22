<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Author;

/*
|--------------------------------------------------------------------------
| AuthorService
|--------------------------------------------------------------------------
|
| AuthorService je odgovaran za svu logiku koja se desava
| unutar AuthorControllera. Ovdje je moguce definisati sve
| pomocne metode koji su potrebni.
|
*/

class AuthorService {

    /**
     * Vrati sve autore iz baze podataka
     *
     */
    public function getAuthors() {

        return DB::table('authors');
    }

    /**
     * Izvrsi validaciju podataka i edituj autora
     *
     * @param  Author  $author
     */
    public function editAuthor($author) {

        //request all data, validate and update movie
        request()->validate([
            'name'        => 'sometimes|regex:/^([^0-9]*)$/|max:128',
            'biography'   => 'nullable|string|max:4128'
        ]);

        $author->name      = request('name');
        $author->biography = request('biography');

        $author->save();
    }

    /**
     * Kreiraj novog autora i sacuvaj ga u bazi
     *
     */
    public function saveAuthor() {
        
        //request all data, validate and update author
        request()->validate([
            'authorName'        => 'required|max:128|regex:/^([^0-9]*)$/',
            'authorBiography'   => 'nullable|string|max:4128'
        ]);

        $author = new Author();

        $author->name      = request('authorName');
        $author->biography = request('authorBiography');

        $author->save();

        return $author;
    }

    /**
     * Vrati pretrazene autore
     *
     */
    public function searchAuthors() {

        $authors = Author::query();

        if(request('searchAuthors')) {
            $authorsSearch = request('searchAuthors');
            $authors = $authors->where('name', 'LIKE', '%'.$authorsSearch.'%');
        }

        $authors = $authors->paginate(7);

        return $authors;
    }
}
