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

use App\Http\Controllers\ResetPasswordController;

use App\Mail\UsernameMail;

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

function getBookDetails(Book $book) {
    $authors = [];
    foreach(BookAuthor::All()->where('book_id', $book->id) as $va) {
        array_push($authors, Author::find($va->author_id)->name);
    }

    $categories = [];
    foreach(BookCategory::All()->where('book_id', $book->id) as $vc) {
        array_push($categories, Category::find($vc->category_id)->name);
    }

    $genres = [];
    foreach(BookGenre::All()->where('book_id', $book->id) as $vg) {
        array_push($genres, Genre::find($vg->genre_id)->name);
    }

    $photo = '';
    $book_gallery = DB::table('galeries')
                    ->where('book_id', $book->id);
    if ($book_gallery != null) {
        $cover = $book_gallery->where('cover', 0);

        if ($cover->first() != null) {
            $photo = $cover->first()->photo;
        }
    }


    $result = [
        'title' => $book->title,
        'authors' => $authors,
        'summary' => $book->summary,
        'available' => $book->quantity > 0,
        'quantity' => $book->quantity,
        'categories' => $categories,
        'genres' => $genres,
        'publisher' => Publisher::find($book->publisher_id)->name,
        'publishYear' => $book->publishYear,
        'photo' => $photo
    ];

    return $result;
}

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

    // delete all previous tokens
    $user->tokens()->delete();

    $token = $user->createToken('authToken');

    return [
        'msg' => 'success',
        'plainTextToken' => $token->plainTextToken,
    ];
});

Route::post('/forgot-password', function (Request $request) {
    $user = User::query()->where('username', $request['username'])->first();

    if ($user == null) {
        return ['msg'=> 'invalid username'];
    }

    $controller = new ResetPasswordController();

    $controller->sendResetPasswordMail($request);

    return ['msg'=> 'success'];
});

Route::post('/forgot-username', function (Request $request) {
    $user = User::query()->where('email', $request['email'])->first();

    if ($user == null) {
        return ['msg'=> 'invalid email'];
    }

    Mail::to($user->email)->send(new UsernameMail($user->username));

    return ['msg'=> 'success'];
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


/*
 {
    "id": 73827328,
    "bookId": 11,
    "dateFrom": "2021-06-08",
    "dateTo": "2021-06-28" | "",
    "type": "reservation" | "rent" | "reservation rejected",
 }
*/
Route::get('/zahtjevi', function (Request $request) {
    $user = $request->user();

    $filter = $request->get('filter');

    if ($filter == null) {
        $data = [];

        $reservations =  DB::table('reservations')
            ->where('student_id', $user->id)
            ->get();

        foreach($reservations as $reservation) {
            $type = 'reservation';

            $reservation_status = DB::table('reservation_statuses')
                ->where('reservation_id', $reservation->id)
                ->get()
                ->first();
            
            $status = null;
            if ($reservation_status != null) {
                $status = $reservation_status->statusReservation_id;
            }
            
            if ($status == 3) {
                $type = 'reservation rejected';
            }


            $librarian = DB::table('users')
                ->where('id', $reservation->librarian_id)
                ->get()
                ->first();

            array_push($data, [
                'id' => $reservation->id,
                'book' => array_intersect_key(getBookDetails(Book::find($reservation->book_id)), array_fill_keys(array('title', 'authors', 'photo'), '1')),
                'librarian' => $librarian->name,
                'dateFrom' => $reservation->reservation_date,
                'dateTo' => $reservation->close_date,
                'type' => $type, 
            ]);
        }


        $rents =  DB::table('rents')
            ->where('student_id', $user->id)
            ->get();

        foreach($rents as $rent) {
            $return_date = '';
            if ($rent->librarian_received_id != null) {
                $return_date = $rent->return_date;
            }


            $librarian = DB::table('users')
                ->where('id', $rent->librarian_id)
                ->get()
                ->first();

            array_push($data, [
                'id' => $rent->id,
                'book' => array_intersect_key(getBookDetails(Book::find($rent->book_id)), array_fill_keys(array('title', 'authors', 'photo'), '1')),
                'librarian' => $librarian->name,
                'dateFrom' => $rent->rent_date,
                'dateTo' => $return_date,
                'type' => 'rent', 
            ]);
        }

        return $data;
    } else if ($filter == 'reservations') {
        $data = [];

        $reservations =  DB::table('reservations')
            ->where('student_id', $user->id)
            ->get();

        foreach($reservations as $reservation) {
            $type = 'reservation';

            $reservation_status = DB::table('reservation_statuses')
                ->where('reservation_id', $reservation->id)
                ->get()
                ->first();
            
            $status = null;
            if ($reservation_status != null) {
                $status = $reservation_status->statusReservation_id;
            }
            
            if ($status == 3) {
                $type = 'reservation rejected';
            }


            $librarian = DB::table('users')
                ->where('id', $reservation->librarian_id)
                ->get()
                ->first();

            array_push($data, [
                'id' => $reservation->id,
                'book' => array_intersect_key(getBookDetails(Book::find($reservation->book_id)), array_fill_keys(array('title', 'authors', 'photo'), '1')),
                'librarian' => $librarian->name,
                'dateFrom' => $reservation->reservation_date,
                'dateTo' => $reservation->close_date,
                'type' => $type, 
            ]);
        }

        return $data;
    } else if ($filter == 'rents') {
        $data = [];

        $rents =  DB::table('rents')
            ->where('student_id', $user->id)
            ->get();

        foreach($rents as $rent) {
            $return_date = '';
            if ($rent->librarian_received_id != null) {
                $return_date = $rent->return_date;
            }


            $librarian = DB::table('users')
                ->where('id', $rent->librarian_id)
                ->get()
                ->first();

            array_push($data, [
                'id' => $rent->id,
                'book' => array_intersect_key(getBookDetails(Book::find($rent->book_id)), array_fill_keys(array('title', 'authors', 'photo'), '1')),
                'librarian' => $librarian->name,
                'dateFrom' => $rent->rent_date,
                'dateTo' => $return_date,
                'type' => 'rent', 
            ]);
        }

        return $data;
    } else if ($filter == 'returned') {
        $data = [];

        $rents =  DB::table('rents')
            ->where('student_id', $user->id)
            ->get();

        foreach($rents as $rent) {
            if ($rent->librarian_received_id != null) {
                $return_date = $rent->return_date;


                $librarian = DB::table('users')
                    ->where('id', $rent->librarian_id)
                    ->get()
                    ->first();

                array_push($data, [
                    'id' => $rent->id,
                    'book' => array_intersect_key(getBookDetails(Book::find($rent->book_id)), array_fill_keys(array('title', 'authors', 'photo'), '1')),
                    'librarian' => $librarian->name,
                    'dateFrom' => $rent->rent_date,
                    'dateTo' => $return_date,
                    'type' => 'rent', 
                ]);
            }
        }

        return $data;
    }
})->middleware(['auth:sanctum']);

Route::delete('/izbrisi-transakciju', function (Request $request) {
    $user = $request->user();

    $id = $request->get('id');
    $type = $request->get('type');

    if ($type == 'reservation' || $type == 'reservation rejected') {
        $reservation =  DB::table('reservations')
            ->where('student_id', $user->id)
            ->where('id', $id);

        $reservation->delete();
    } else if ($type == 'rent') {
        $rent =  DB::table('rents')
            ->where('student_id', $user->id)
            ->where('id', $id);

        if ($rent->librarian_received_id == null) {
            return [ "msg" => "Book not returned" ];
        }

        $rent->delete();
    }

    return [ "msg" => "success" ];
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

Route::get('/books/{book}', function (Book $book) {
    return getBookDetails($book);
});

Route::get('/books', function () {
    $books = Book::All();
    return $books;
});

// for authors, genres and categories do the following in the query string:
//   genres[]=1&genres[]=2&authors[]=4&authors[]=7&categories[]=1
Route::get('/search-books', function (Request $request) {
    $data = Book::query()->where('title', 'LIKE', '%'.$request->get('query').'%');

    if ($request->get('script')) {
        $data = $data->where('script_id', $request->get('script'));
    }
    if ($request->get('language')) {
        $data = $data->where('language_id', $request->get('language'));
    }
    if ($request->get('binding')) {
        $data = $data->where('binding_id', $request->get('binding'));
    }
    if ($request->get('format')) {
        $data = $data->where('format_id', $request->get('format'));
    }
    if ($request->get('publisher')) {
        $data = $data->where('publisher_id', $request->get('publisher'));
    }

    if ($request->get('genres')) {
        $bookGenres = DB::table('book_genres')
                        ->whereIn('genre_id', $request->get('genres'))
                        ->get();

        $bookGenresIds = [];
        foreach($bookGenres as $bookGenre) {
            array_push($bookGenresIds, $bookGenre->book_id);
        }
        $data = $data->whereIn('id', $bookGenresIds);
    }

    if ($request->get('categories')) {
        $bookCategories = DB::table('book_categories')
                        ->whereIn('category_id', $request->get('categories'))
                        ->get();

        $bookCategoriesIds = [];
        foreach($bookCategories as $bookCategory) {
            array_push($bookCategoriesIds, $bookCategory->book_id);
        }
        $data = $data->whereIn('id', $bookCategoriesIds);
    }

    if ($request->get('authors')) {
        $bookAuthors = DB::table('book_authors')
                        ->whereIn('author_id', $request->get('authors'))
                        ->get();

        $bookAuthorsIds = [];
        foreach($bookAuthors as $bookAuthor) {
            array_push($bookAuthorsIds, $bookAuthor->book_id);
        }
        $data = $data->whereIn('id', $bookAuthorsIds);
    }

    return $data->get();
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