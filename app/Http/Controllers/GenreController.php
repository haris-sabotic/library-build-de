<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Services\GenreService;
use App\Services\UserService;

class GenreController extends Controller
{
    
    private $viewFolder = 'pages/settings/genres';
 
    /**
     * Prikazi stranicu za editovanje zanra
     *
     * @param  Genre $genre
     */
    public function showEdit(Genre $genre) {

        $viewName = $this->viewFolder . '.editGenre';

        $viewModel = [
            'genre'=>$genre
        ];

        return view($viewName,$viewModel);
    }

    /**
     * Prikazi sve zanrove
     *
     * @param  GenreService $genreService
     */
    public function index(GenreService $genreService) {

        $viewName = $this->viewFolder . '.genres';

        $viewModel = [
            'genres'=> $genreService->getGenres()->paginate(7)
        ];

        return view($viewName,$viewModel);
    }

    /**
     * Prikazi stranicu za unos novog zanra
     *
     */
    public function showAdd() {
        
        $viewName = $this->viewFolder . '.addGenre';

        return view($viewName);
    }

    /**
     * Kreiraj i sacuvaj novi zanr
     *
     * @param  GenreService $genreService
     * @param  UserService $userService
     * @param  Request $request
     */
    public function save(GenreService $genreService, UserService $userService, Request $request) {
        
        $genreService->saveGenre($userService, $request);

        return redirect('genres')->with('success', 'Žanr je uspješno unesen!');
    }

    /**
     * Izmijeni podatke o zanru
     *
     * @param  Genre $genre
     * @param  GenreService $genreService
     * @param  UserService $userService
     * @param  Request $request
     */
    public function update(Genre $genre, GenreService $genreService, UserService $userService, Request $request) {
        
        $genreService->editGenre($genre, $userService, $request);

        //return back to all genres
        return redirect('genres')->with('success', 'Žanr je uspješno izmijenjen!');
    }

    /**
     * Izbrisi zanr
     *
     * @param  Genre $genre
     */
    public function delete(Genre $genre) {

        Genre::destroy($genre->id);
        
        return back()->with('success', 'Žanr je uspješno izbrisan!');
    }
}
