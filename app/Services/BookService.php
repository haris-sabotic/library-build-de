<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Rent;
use App\Models\RentStatus;
use App\Models\BookCategory;
use App\Models\BookGenre;
use App\Models\BookAuthor;
use App\Models\Galery;
use Carbon\Carbon;
use Auth;

/*
|--------------------------------------------------------------------------
| BookService
|--------------------------------------------------------------------------
|
| RentService je odgovaran za svu logiku koja se desava
| unutar BookControllera. Ovdje je moguce definisati sve
| pomocne metode koji su potrebni.
|
*/

class BookService {

    /**
     * Vrati sve knjige
     *
     */
    public function getBooks() {

        return DB::table('books');
    }

    /**
     * Sacuvaj izdavanje knjige
     *
     * @param  Book $book
     * @param  RentService $rentService
     * @param  ReservationService $reservationService
     */
    public function saveRent($book, $rentService, $reservationService) {

        request()->validate([
            'student'         => 'required',
            'rentDate' => 'required',
            'returnDate'  => 'required',
        ]);

        //sacuvaj izdavanje
        $rent = $rentService->saveRent($book);

        //promijeni status rezervacije u izdata i zatvori rezervaciju
        $reservation = $reservationService->getReservation($book, $rent->student_id);

        if($reservation != null) {
            $reservation->closeReservation_id = 4;
            $reservation->save();

            $reservationService->updateReservationStatus($reservation->id);
        }

        //dodavanje u tabelu rent_statuses
        $rentService->saveRentStatus($rent->id, $rent->rent_date);

        //update broj izdatih knjiga
        $rentedBook = Book::find($book);
        $updateRentedBook = $rentedBook->rentedBooks + 1;
        $rentedBook->rentedBooks = $updateRentedBook;

        if($reservation != null) {
            $rentedBook->reservedBooks = $rentedBook->reservedBooks-1;
        }

        $rentedBook->save();
    }

    /**
     * Sacuvaj rezervaciju knjige
     *
     * @param  Book $book
     * @param  ReservationService $reservationService
     * @param  GlobalVariableService $globalVariableService
     */
    public function saveReservation($book, $reservationService, $globalVariableService) {

        request()->validate([
            'student'         => 'required',
            'reservationDate' => 'required',
        ]);

        $reservation = $reservationService->saveReservation($book->id, $globalVariableService);

        //dodavanje u tabelu reservation_statuses
        $reservationService->saveReservationStatus($reservation->id, $reservation->reservation_date);

        //update broj rezervisanih knjiga
        $reservedBook = Book::find($book->id);
        $reservedBook->reservedBooks = $reservedBook->reservedBooks + 1;
        $reservedBook->save();
    }

    /**
     * Sacuvaj knjigu
     *
     */
    public function saveBook() {

        $book = new Book();

        $book->title=request('bookTitle');
        $book->pages=request('pages');
        $book->publishYear=request('publishYear');
        $book->ISBN=request('bookIsbn');
        $book->quantity=request('quantity');
        $book->summary=request('summary');
        $book->format_id=request('bookFormat');
        $book->binding_id=request('bookBinding');
        $book->script_id=request('bookScript');
        $book->publisher_id=request('bookPublisher');
        $book->language_id=request('bookLanguage');


        $book->save();

        return $book;
    }

    /**
     * Sacuvaj kategorije za konkretnu knjigu
     *
     * @param Book $book
     * @param Category $category
     */
    public function saveBookCategories($categoriesValues, $book) {

        $categories = explode(',', $categoriesValues);

        foreach($categories as $category) {
            $bookCategories = new BookCategory();

            $bookCategories->book_id = $book;
            $bookCategories->category_id = $category;

            $bookCategories->save();
       }
    }

    /**
     * Sacuvaj zanrove za konkretnu knjigu
     *
     * @param Book $book
     * @param Genre $genre
     */
    public function saveBookGenres($genresValues, $book) {

        $genres = explode(',', $genresValues);

        foreach($genres as $genre) {
            $bookGenres = new BookGenre();

            $bookGenres->book_id = $book;
            $bookGenres->genre_id = $genre;

            $bookGenres->save();
        }
    }

    /**
     * Sacuvaj autore za konkretnu knjigu
     *
     * @param Book $book
     * @param Author $author
     */
    public function saveBookAuthors($authorsValues, $book) {

        $authors = explode(',', $authorsValues);

        foreach($authors as $author) {
            $bookAuthors = new BookAuthor();

            $bookAuthors->book_id = $book;
            $bookAuthors->author_id = $author;

            $bookAuthors->save();
        }

    }

    /**
     * Vrati trazene autore
     *
     */
    public function filterAuthors() {

        $books = Book::query();
        $books = $books->with('author', 'category');

        if(request('authorsFilter')) {
            $authors = request('authorsFilter');
            foreach($authors as $author) {
                $books->whereHas('author', function($q) use ($author) {
                    $q->where('author_id', $author);
                });
            }
        }

        if(request('categoriesFilter')) {
            $categories = request('categoriesFilter');
            foreach($categories as $category) {
                $books->whereHas('category', function($q) use ($category) {
                    $q->where('category_id', $category);
                });
            }
        }

        return $books;
    }

    /**
     * Sacuvaj vracanje knjiga
     * 
     * @param GlobalVariableServis $globalVariableService
     */
    public function returnBooks($globalVariableService) {

        $books=request('returnBook');

        foreach($books as $oneBook){
            $rent=Rent::find($oneBook);

            $rent->librarian_received_id = Auth::user()->id;
            $rent->save();

            $rentStatus=new RentStatus();
            $rentStatus->rent_id=$rent->id;

            if($rent->rent_date<Carbon::now()->subDays($globalVariableService->getReturnDueDate() + $globalVariableService->getOverdraftPeriod())){
                $rentStatus->statusBook_id=3;
            }
            else{
                $rentStatus->statusBook_id=1;
            }

            $rentStatus->date=Carbon::now();
            $rentStatus->save();

            $book=Book::find($rent->book_id);
            $book->rentedBooks=$book->rentedBooks-1;
            $book->save();
        }
    }

    /**
     * Sacuvaj otpisivanje knjiga
     *
     */
    public function writeOffBooks() {

        $books = request('writeOffBook');

        foreach($books as $oneBook){
            $rent=Rent::find($oneBook);
            $book=Book::find($rent->book_id);
            $book->rentedBooks=$book->rentedBooks-1;
            $book->quantity=$book->quantity-1;
            $book->save();
            Rent::destroy($rent->id);
        }
    }

    /**
     * Vrati pretrazene knjige
     *
     */
    public function searchBooks() {

        $books = Book::query();

        if(request('searchBooks')) {
            $bookSearch = request('searchBooks');
            $books = $books->where('title', 'LIKE', '%'.$bookSearch.'%');
        }

        $books = $books->paginate(7);

        return $books;
    }

    public function uploadBookImages($book, $request) {

        if ($request->hasFile('movieImages')) {
            $movieImages = $request->file('movieImages');
            $coverImage = request('imageCover');

            foreach($movieImages as $movieImage) {

                $filenameWithExt = $movieImage->getClientOriginalName();
                // Get Filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just Extension
                $extension = $movieImage->getClientOriginalExtension();
                // Filename To store
                $fileNameToStore = $filename. '_'. time().'.'.$extension;
                // Upload Image
                $path = $movieImage->storeAs('public/image', $fileNameToStore);

                // Save image in Galery
                $galery = new Galery();

                $galery->book_id = $book;
                $galery->photo = $fileNameToStore;

                if($movieImages[$coverImage] == $movieImage) {
                    $galery->cover = 1;
                }

                $galery->save();
            }
        }
    }

    public function editBookImages($book, $request) {

        if ($request->hasFile('movieImages')) {
            $movieImages = $request->file('movieImages');
            $coverImage = request('imageCover');
            foreach($movieImages as $movieImage) {

                $filenameWithExt = $movieImage->getClientOriginalName();
                // Get Filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just Extension
                $extension = $movieImage->getClientOriginalExtension();
                // Filename To store
                $fileNameToStore = $filename. '_'. time().'.'.$extension;
                // Upload Image
                $path = $movieImage->storeAs('public/image', $fileNameToStore);

                // Save image in Galery
                $galery = new Galery();

                $galery->book_id = $book;
                $galery->photo = $fileNameToStore;

                if($movieImages[$coverImage] == $movieImage) {
                    $galery->cover = 1;
                }

                $galery->save();
            }
        }
    }

    /**
     * Vrati pretrazene ucenike od kojih se vraca knjiga
     *
     */
    public function searchReturnBook(Book $book, RentService $rentService) {

        $rentedBooks = Rent::query();
        if(request('searchReturn')) {
            $searchedStudent = request('searchReturn');
            $rentedBooks = $rentService->getRentedBooks()
                            ->where('book_id', '=', $book->id)
                            ->where(function ($query) {
                                $query->select('name')
                                    ->from('users')
                                    ->whereColumn('users.id', 'rents.student_id');
                            }, 'LIKE', '%'.$searchedStudent.'%');
        }else{
            $rentedBooks = $rentService->getRentedBooks()
                            ->where('book_id', '=', $book->id);
        }

        $rentedBooks = $rentedBooks->paginate(7);

        return $rentedBooks;
    }

    /**
     * Vrati pretrazene ucenike od kojih se otpisuje knjiga
     *
     * @param Book $book
     * @param RentService $rentService
     */
    public function searchWriteOffBooks(Book $book, RentService $rentService) {
        
        $rent = Rent::query();
        if(request('searchWriteOff')) {
            $searchedStudent = request('searchWriteOff');
            $rent = $rentService->getOverdueBooks()
                            ->where('book_id', '=', $book->id)
                            ->where(function ($query) {
                                $query->select('name')
                                    ->from('users')
                                    ->whereColumn('users.id', 'rents.student_id');
                            }, 'LIKE', '%'.$searchedStudent.'%');
        }else{
            $rent = $rentService->getOverdueBooks()
                            ->where('book_id', '=', $book->id);
        }

        $rent = $rent->paginate(7);

        return $rent;
    }

    // public function getCoverImage($knjiga) {
    //     return Galery::where('book_id', '=', $knjiga)
    //                         ->where('cover', '=', 1)
    //                         ->first();
    // }
}
