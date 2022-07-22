<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| AuthorController
|--------------------------------------------------------------------------
|
| AuthorController je odgovaran za povezivanje logike
| izmedju autor view-a i neophodnih Modela
|
*/

class AuthorController extends Controller
{

    private $viewFolder = 'pages/authors';

    /**
     * Prikazi sve autore
     *
     * @param  AuthorService $authorService
     */
    public function index(AuthorService $authorService) {

        $viewName = $this->viewFolder . '.authors';

        $viewModel = [
            'authors' => $authorService->getAuthors()->paginate(7)
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi konkretnog autora
     *
     * @param  Author $auhtor
     */
    public function show(Author $author) {

        $viewName = $this->viewFolder . '.authorProfile';

        $viewModel = [
            'author' => $author
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi stranicu za editovanje autora
     *
     * @param  Author $author
     */
    public function showEdit(Author $author) {
        
        $viewName = $this->viewFolder . '.editAuthor';

        $viewModel = [
            'author' => $author
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi stranicu za unos novog autora
     *
     */
    public function showAdd() {

        $viewName = $this->viewFolder . '.addAuthor';

        return view($viewName);
    }

    /**
     * Izmijeni podatke o autoru
     *
     * @param  Author $author
     * @param  AuthorService $authorService
     */
    public function update(Author $author, AuthorService $authorService) {

        $authorService->editAuthor($author);

        $viewModel = [
            'author' => $author
        ];

        return redirect('authors')->with('success', 'Autor je uspješno izmijenjen!');
    }

    /**
     * Izbrisi autora
     *
     * @param  Author $author
     */
    public function delete(Author $author) {

        Author::destroy($author->id);

        return redirect('authors')->with('success', 'Autor je uspješno izbrisan!');
    }

    /**
     * Kreiraj i sacuvaj novog autora
     *
     * @param  AuthorService $authorService
     */
    public function save(AuthorService $authorService) {

        $author = $authorService->saveAuthor();

        $viewModel = [
            'author' => $author
        ];

        return redirect('authors')->with('success', 'Autor je uspješno unesen!');
    }

    /**
     * Prikazi pretrazene autore
     *
     * @param  AuthorService $authorService
     */
    public function search(AuthorService $authorService) {

        $viewName = $this->viewFolder . '.authors';

        $authors = $authorService->searchAuthors();

        $viewModel = [
            'authors' => $authors
        ];

        return view($viewName, $viewModel);
    }
}
