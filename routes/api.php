<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Book;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Script;
use App\Models\Language;

use App\Models\BookAuthor;
use App\Models\BookCategory;
use App\Models\BookGenre;

use App\Models\User;
use App\Models\Reservation;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', function (Request $request) {
    $username = $request->get('username');
    $password = $request->get('password');

    if (!Auth::attempt(['username' => $username, 'password' => $password])) {
        return [
            'msg' => 'failure',
            'plainTextToken' => null,
        ];
    }

    $user = User::where('username', $username)->first();

    $token = $user->createToken('authToken');

    return [
        'msg' => 'success',
        'plainTextToken' => $token->plainTextToken,
    ];
});

Route::get('/user', function (Request $request) {
    $user = $request->user();
    return [
        'jmbg' => $user->jmbg,
        'name' => $user->name,
        'email' => $user->email,
        'username' => $user->username,
        'photo' => $user->photo,
    ];
})->middleware(['auth:sanctum']);

Route::post('/edit-user', function (Request $request) {
    $user = $request->user();
    $name = $request->get('name');
    $email = $request->get('email');
    $username = $request->get('username');
    $oldPass = $request->get('oldPass');
    $newPass = $request->get('newPass');

    if (!Auth::guard('web')->attempt(['username' => $user->username, 'password' => $oldPass])) {
        return [ 'msg' => 'old password invalid' ];
    }


    $user->name = $name;
    $user->email = $email;
    $user->username = $username;
    $user->password = Hash::make($newPass);

    $user->save();

    return [ 'msg' => 'success' ];
})->middleware(['auth:sanctum']);

Route::post('/rezervisi', function (Request $request) {
    $user = $request->user();
    $bookId = $request->get('id');
    $dateFrom = $request->get('dateFrom');
    $dateTo = $request->get('dateTo');

    $reservation = new Reservation();

    $reservation->book_id             = $bookId;
    $reservation->librarian_id        = Auth::id();
    $reservation->student_id          = $user->id;
    $reservation->reservation_date    = $dateFrom;
    $reservation->close_date          = $dateTo;
    $reservation->request_date        = now();
    $reservation->closeReservation_id = 5;

    $reservation->save();
})->middleware(['auth:sanctum']);

Route::get('/aktivnosti', function (Request $request) {
    $user = $request->user();

    return Reservation::All()->where('student_id', $user->id);
})->middleware(['auth:sanctum']);

Route::get('/book', function (Request $request) {
    $id = $request->get('id');
    $book = Book::where('id', $id);

    $authors = [];
    foreach(BookAuthor::All()->where('book_id', $id) as $va) {
        array_push($authors, Author::find($va->author_id)->name);
    }

    $categories = [];
    foreach(BookCategory::All()->where('book_id', $id) as $vc) {
        array_push($categories, Category::find($vc->category_id)->name);
    }

    $genres = [];
    foreach(BookGenre::All()->where('book_id', $id) as $vg) {
        array_push($genres, Genre::find($vg->genre_id)->name);
    }

    $result = [
        'title' => $book->value('title'),
        'authors' => $authors,
        'summary' => $book->value('summary'),
        'available' => $book->value('quantity') > 0,
        'quantity' => $book->value('quantity'),
        'categories' => $categories,
        'genres' => $genres,
        'publisher' => Publisher::find($book->value('publisher_id'))->name,
        'publishYear' => $book->value('publishYear'),
    ];

    return $result;
});

Route::get('/books', function () {
    $books = Book::All();
    return $books;
});

Route::get('/search-books', function (Request $request) {
    return Book::query()->where('title', 'LIKE', '%'.$request->get('query').'%')->get();
});

Route::get('/kategorije', function () {
    $categories = Category::All();
    return $categories;
});

Route::get('/zanrovi', function () {
    $genres = Genre::All();
    return $genres;
});

Route::get('/autori', function () {
    $authors = Author::All();
    return $authors;
});

Route::get('/izdavaci', function () {
    $publishers = Publisher::All();
    return $publishers;
});

Route::get('/pisma', function () {
    $scripts = Script::All();
    return $scripts;
});

Route::get('/jezici', function () {
    $langs = Language::All();
    return $langs;
});