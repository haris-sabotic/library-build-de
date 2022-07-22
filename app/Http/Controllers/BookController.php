<?php

namespace App\Http\Controllers;

use App\Services\GlobalVariableService;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Author;
use App\Models\BookAuthor;
use App\Models\Category;
use App\Models\BookCategory;
use App\Models\BookGenre;
use App\Models\Rent;
use App\Models\Galery;
use App\Models\RentStatus;
use App\Models\Reservation;
use App\Models\ReservationStatus;
use App\Models\GlobalVariable;
use App\Services\AuthorService;
use App\Services\BookService;
use App\Services\DashboardService;
use App\Services\RentService;
use App\Services\UserService;
use App\Services\CategoryService;
use App\Services\ReservationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| BookController
|--------------------------------------------------------------------------
|
| BookController je odgovaran za povezivanje logike
| izmedju book view-a i neophodnih Modela
|
*/

class BookController extends Controller
{
    private $viewFolder = 'pages/books';

    /**
     * Prikazi stranicu za editovanje knjige
     *
     * @param  Book $book
     */
    public function showEditBook(Book $book) {

        $viewName = $this->viewFolder . '.editBook';

        $viewModel = [
            'book'         => $book,
            'categories'   => DB::table('categories')->get(),
            'genres'       => DB::table('genres')->get(),
            'authors'      => DB::table('authors')->get(),
            'publishers'   => DB::table('publishers')->get(),
            'scripts'      => DB::table('scripts')->get(),
            'bindings'     => DB::table('bindings')->get(),
            'formats'      => DB::table('formats')->get(),
            'languages'    => DB::table('languages')->get(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi sve knjige
     *
     * @param  AuthorService $authorService
     */
    public function showBookRecords(AuthorService $authorService) {

        $viewName = $this->viewFolder . '.bookRecords';

        $viewModel = [
            'books'       => Book::paginate(7),
            'authors'     => $authorService->getAuthors()->get(),
            'categories'  => Category::all(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi stranicu sa multimedijom kod konkretne knjige
     *
     * @param  Book $book
     * @param  DashboardService $dashboardService
     */
    public function showBookMultimedia(Book $book, DashboardService $dashboardService) {

        $viewName = $this->viewFolder . '.bookMultimedia';

        $viewModel = [
            'book'     => $book,
            'activities' => $dashboardService->getBookActivity($book->id)
                                ->take(3)
                                ->get(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi stranicu sa osnovnim detaljima konkretne knjige
     *
     * @param  Book $book
     * @param  DashboardService $dashboardService
     */
    public function showBookDetails(Book $book, DashboardService $dashboardService) {

        $viewName = $this->viewFolder . '.bookDetails';

        $viewModel = [
            'book'     => $book,
            'activities' => $dashboardService->getBookActivity($book->id)
                                                    ->take(3)
                                                    ->get(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi stranicu sa specifikacijama konkretne knjige
     *
     * @param  Book $book
     * @param  DashboardService $dashboardService
     */
    public function showBookSpecification(Book $book, DashboardService $dashboardService) {

        $viewName = $this->viewFolder . '.bookSpecification';

        $viewModel = [
            'book'     => $book,
            'activities' => $dashboardService->getBookActivity($book->id)
                                ->take(3)
                                ->get(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi stranicu za dodavanje knjige
     *
     * @param  AuthorService $authorService
     */
    public function showAddBook(AuthorService $authorService) {

        $viewName = $this->viewFolder . '.addBook';

        $viewModel = [
            'categories'   => DB::table('categories')->get(),
            'genres'       => DB::table('genres')->get(),
            'authors'      => $authorService->getAuthors()->get(),
            'publishers'   => DB::table('publishers')->get(),
            'scripts'      => DB::table('scripts')->get(),
            'bindings'     => DB::table('bindings')->get(),
            'formats'      => DB::table('formats')->get(),
            'languages'    => DB::table('languages')->get(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi stranicu za vracanje knjige
     *
     * @param  Book $book
     * @param  RentService $rentService
     */
    public function showReturnBook(Book $book, RentService $rentService) {

        $viewName = $this->viewFolder . '.returnBook';

        $rentedBooks = $rentService->getRentedBooks()
                            ->where('book_id', '=', $book->id)
                            ->paginate(7);

        $viewModel = [
            'book'      => $book,
            'rentedBooks' => $rentedBooks,
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi stranicu za otpis knjige
     *
     * @param  Book $book
     * @param  RentService $rentService
     */
    public function showWriteOffBook(Book $book, RentService $rentService) {

        $viewName = $this->viewFolder . '.writeOffBook';

        $overdueBooks = $rentService->getOverdueBooks()
                            ->where('book_id', '=', $book->id)
                            ->paginate(7);

        $viewModel = [
            'book'       => $book,
            'overdueBooks' => $overdueBooks
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi stranicu za rezervisanje knjige
     *
     * @param  Book $book
     * @param  UserService $userService
     * @param  RentService $rentService
     */
    public function showReserveBook(Book $book, UserService $userService, RentService $rentService) {

        $viewNameReserve = $this->viewFolder . '.reserveBook';
        $viewNameError = $this->viewFolder . '.rentBookError';

        $availableBooks = $book->quantity - $book->rentedBooks - $book->reservedBooks;

        $viewModelReserve = [
            'book'  => $book,
            'students' => $userService->getStudents()->get(),
        ];

        $viewModelError = [
            'book'         => $book,
            'overdueBooks' => $rentService->getOverdueBooks()
                                        ->where('book_id', '=', $book->id)
                                        ->get()
        ];

        if($availableBooks > 0) {
            return view($viewNameReserve, $viewModelReserve);
        } else {
            return view($viewNameError, $viewModelError);
        }
    }

    /**
     * Prikazi stranicu za izdavanje knjige
     *
     * @param  Book $book
     * @param  UserService $userService
     * @param  RentService $rentService
     */
    public function showRentBook(Book $book, UserService $userService, RentService $rentService) {

        $viewNameRent = $this->viewFolder . '.rentBook';
        $viewNameError = $this->viewFolder . '.rentBookError';

        $availableBooks = $book->quantity - $book->rentedBooks - $book->reservedBooks;

        $viewModelRent = [
            'book'          => $book,
            'students'      => $userService->getStudents()->get(),
            'returnDueDate' => GlobalVariable::find(1),
            'overdueBooks'  => $rentService->getOverdueBooks()
                                        ->where('book_id', '=', $book->id)
                                        ->get(),
        ];

        $viewModelError = [
            'book'         => $book,
            'overdueBooks' => $rentService->getOverdueBooks()
                                        ->where('book_id', '=', $book->id)
                                        ->get(),
        ];

        if($availableBooks > 0) {
            return view($viewNameRent, $viewModelRent);
        } else {
            return view($viewNameError, $viewModelError);
        }
    }

    /**
     * Izdaj knjigu
     *
     * @param  Book $book
     * @param  BookService $bookService
     * @param  RentService $rentService
     * @param  ReservationService $reservationService
     */
    public function rent(Book $book, BookService $bookService, RentService $rentService, ReservationService $reservationService) {

        $bookService->saveRent($book->id, $rentService, $reservationService);

        return back()->with('success', 'Knjiga je uspješno izdata!');
    }

    /**
     * Rezervisi knjigu
     *
     * @param  Book $book
     * @param  BookService $bookService
     * @param  ReservationService $reservationService
     * @param  GlobalVariableService $globalVariableService
     */
    public function reserve(Book $book, BookService $bookService, ReservationService $reservationService, GlobalVariableService $globalVariableService) {

        $bookService->saveReservation($book, $reservationService, $globalVariableService);

        return back()->with('success', 'Knjiga je uspješno rezervisana!');
    }

    /**
     * Prikazi izdate knjige kod konkretne knjige
     *
     * @param  Book $book
     * @param  DashboardService $dashboardService
     * @param  RentService $rentService
     */
    public function showRentingRented(Book $book, DashboardService $dashboardService, RentService $rentService) {

        $viewName = $this->viewFolder . '.rentingRented';

        $viewModel = [
            'book'                 => $book,
            'activities'           => $dashboardService->getBookActivity($book->id)
                                            ->take(3)
                                            ->get(),
            'rentingRented'         => $rentService->getRentedBooks()
                                            ->where('book_id', '=', $book->id)
                                            ->paginate(7),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi knjige u prekoracenju kod konkretne knjige
     *
     * @param  Book $book
     * @param  DashboardService $dashboardService
     * @param  RentService $rentService
     */
    public function showRentingOverdue(Book $book, DashboardService $dashboardService, RentService $rentService) {
        $viewName = $this->viewFolder . '.rentingOverdue';


        $viewModel = [
            'book'               => $book,
            'activities'         => $dashboardService->getBookActivity($book->id)
                                    ->take(3)
                                    ->get(),
            'rentingOverdued'     => $rentService->getOverdueBooks()
                                    ->where('book_id', '=', $book->id)
                                    ->paginate(7),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi vracene knjigekod konkretne knjige
     *
     * @param  Book $book
     * @param  DashboardService $dashboardService
     * @param  RentService $rentService
     */
    public function showRentingReturned(Book $book, DashboardService $dashboardService) {

        $viewName = $this->viewFolder . '.rentingReturned';

        $rentingR = Rent::where('book_id', '=', $book->id)
                                    ->where(function ($query) {
                                    $query->select('statusBook_id')
                                        ->from('rent_statuses')
                                        ->whereColumn('rent_statuses.rent_id', 'rents.id')
                                        ->orderByDesc('rent_statuses.date')
                                        ->limit(1);
                                    }, 1);
        $rentingReturned = Rent::where('book_id', '=', $book->id)
                                    ->where(function ($query) {
                                    $query->select('statusBook_id')
                                        ->from('rent_statuses')
                                        ->whereColumn('rent_statuses.rent_id', 'rents.id')
                                        ->orderByDesc('rent_statuses.date')
                                        ->limit(1);
                                    }, 3)->union($rentingR);
        $viewModel = [
            'book'                  => $book,
            'activities'            => $dashboardService->getBookActivity($book->id)
                                            ->take(3)
                                            ->get(),
            'rentingReturned' => $rentingReturned->paginate(7),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi aktivne rezervacije konkretne knjige
     *
     * @param  Book $book
     * @param  DashboardService $dashboardService
     * @param  ReservationService $reservationService
     */
    public function showRentingActive(Book $book, DashboardService $dashboardService, ReservationService $reservationService) {
        
        $viewName = $this->viewFolder . '.rentingActive';

        $viewModel = [
            'book'                  => $book,
            'activities'            => $dashboardService->getBookActivity($book->id)
                                            ->take(3)
                                            ->get(),

            'rentingActive' => $reservationService->getActiveReservations()
                                            ->where('book_id', '=', $book->id)
                                            ->paginate(7),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi arhivirane rezervacije konkretne knjige
     *
     * @param  Book $book
     * @param  DashboardService $dashboardService
     * @param  ReservationService $reservationService
     */
    public function showRentingArchived(Book $book, DashboardService $dashboardService, ReservationService $reservationService) {

        $viewName = $this->viewFolder . '.rentingArchived';

        $viewModel = [
            'book'                     => $book,
            'activities'               => $dashboardService->getBookActivity($book->id)
                                            ->take(3)
                                            ->get(),
            'rentingArchived' => $reservationService->getArchivedReservations()
                                            ->where('book_id', '=', $book->id)
                                            ->paginate(7),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Sacuvaj novu knjigu
     *
     * @param  Request $request
     * @param  BookService $bookService
     */
    public function saveBook(Request $request, BookService $bookService, DashboardService $dashboardService) {

        //request all data, validate and save book
        request()->validate([
            'bookTitle'        => 'required|max:256',
            'summary'          => 'max:4128',
            'valuesCategories' => 'required',
            'valuesGenres'     => 'required',
            'valuesAuthors'    => 'required',
            'bookPublisher'    => 'required',
            'publishYear'      => 'required',
            'quantity'         => 'required',
            'pages'            => 'required',
            'bookScript'       => 'required',
            'bookBinding'      => 'required',
            'bookFormat'       => 'required',
            'bookIsbn'         => 'required|unique:books,ISBN|regex:/^(\d{3})-(\d{1})-(\d{2})-(\d{6})-(\d{1})/',
            'bookLanguage'     => 'required',
            'movieImages'      => 'required',
            'movieImages.*'    => 'mimes:jpeg,png,jpg',
            'imageCover'       => 'required'
        ]);

        $book = $bookService->saveBook();
        $bookService->uploadBookImages($book->id, $request);

        $categoriesValues = $request->input('valuesCategories');
        $bookService->saveBookCategories($categoriesValues, $book->id);

        $genresValues = $request->input('valuesGenres');
        $bookService->saveBookGenres($genresValues, $book->id);

        $authorsValues = $request->input('valuesAuthors');
        $bookService->saveBookAuthors($authorsValues, $book->id);

        $viewModel = [
            'book'          => $book,
            'activities'    => $dashboardService->getBookActivity($book->id)
                                ->take(3)
                                ->get(),
        ];

        //redirect to all books
        return redirect('bookRecords')->with('success', 'Knjiga je uspješno unsesena!');
    }

    /**
     * Updateuj knjigu
     *
     * @param  Request $request
     * @param  BookService $bookService
     */
    public function updateBook(Request $request, Book $book, DashboardService $dashboardService, Galery $gallery) {

        //request all data, validate and update book
        request()->validate([
            'bookTitleEdit'         => 'required|max:256',
            'summary_edit'          => 'required|max:4128',
            'categoryValuesEdit'    => 'required',
            'genreValuesEdit'       => 'required',
            'authorsValuesEdit'     => 'required',
            'publisherEdit'         => 'required',
            'publishYearEdit'       => 'required',
            'quantityEdit'          => 'required',
            'pagesEdit'             => 'required',
            'scriptEdit'            => 'required',
            'bindingEdit'           => 'required',
            'formatEdit'            => 'required',
            'isbnEdit'              => 'nullable|unique:books,ISBN|regex:/^(\d{3})-(\d{1})-(\d{2})-(\d{6})-(\d{1})/',
            'languageEdit'          => 'required',
        ]);

        $book->title=request('bookTitleEdit');
        $book->pages=request('pagesEdit');
        $book->publishYear=request('publishYearEdit');
        $book->quantity=request('quantityEdit');
        $book->summary=request('summary_edit');
        $book->format_id=request('formatEdit');
        $book->binding_id=request('bindingEdit');
        $book->script_id=request('scriptEdit');
        $book->publisher_id=request('publisherEdit');
        $book->language_id=request('languageEdit');

        if(request('isbnEdit')) {
            $book->ISBN = request('isbnEdit');
        }

        $book->save();

        $categoriesValues = $request->input('categoryValuesEdit');
        $categories = explode(',', $categoriesValues);

        foreach($categories as $category) {
            $bookCategories = BookCategory::find($category);
            $bookCategories->book_id = $book->id;
            $bookCategories->category_id = $category;
            $bookCategories->save();
        }

        $genresValues = $request->input('genreValuesEdit');
        $genres = explode(',', $genresValues);

        foreach($genres as $genre) {
            $bookGenres = BookGenre::find($genre);
            $bookGenres->book_id = $book->id;
            $bookGenres->genre_id = $genre;
            $bookGenres->save();
        }

        $authorsValues = $request->input('authorsValuesEdit');
        $authors = explode(',', $authorsValues);

        foreach($authors as $author) {
            $bookAuthors = BookAuthor::find($author);
            $bookAuthors->book_id = $book->id;
            $bookAuthors->author_id = $author;
            $bookAuthors->save();
        }

        $viewModel = [
            'book'     => $book,
            'activities' => $dashboardService->getBookActivity($book->id)
                                ->take(3)
                                ->get(),
        ];

        return redirect('bookRecords')->with('success', 'Knjiga je uspješno izmijenjena.');
    }

    /**
     * Izbrisi konkretnu knjigu
     *
     * @param  Book $book
     */
    public function deleteBook(Book $book) {

        Book::destroy($book->id);

        return redirect('bookRecords')->with('success','Knjiga je uspješno obrisana!');
    }

    /**
     * Filter autora u tabeli
     *
     * @param  BookService $bookService
     * @param  AuthorService $authorService
     * @param  CategoryService $categoryService
     */
    public function filterAuthors(BookService $bookService, AuthorService $authorService, CategoryService $categoryService) {
        
        $viewName = $this->viewFolder . '.bookRecords';

        $books = $bookService->filterAuthors()
                        ->paginate(7)
                        ->appends([
                            'authorsFilter' => request('authorsFilter'),
                            'categoriesFilter' => request('categoriesFilter')
                        ]);

        $viewModel = [
            'books'     => $books,
            'authors'     => $authorService->getAuthors()->get(),
            'categories' => $categoryService->getCategories()->get(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Vrati knjige
     *
     * @param  BookService $bookService
     * @param  GlobalVariableService $globalVariableService
     */
    public function returnBooks(BookService $bookService, GlobalVariableService $globalVariableService) {

        $bookService->returnBooks($globalVariableService);

        return back()->with('success', 'Knjiga je uspješno vraćena!');
    }

    /**
     * Otpisi knjige
     *
     * @param  BookService $bookService
     */
    public function writeOffBooks(BookService $bookService){

        $bookService->writeOffBooks();

        return back()->with('success', 'Knjiga je uspješno otpisana!');
    }

    /**
     * Prikazi pretrazene knjige
     *
     * @param  BookService $bookService
     */
    public function searchBooks(BookService $bookService, Authorservice $authorService) {

        $viewName = $this->viewFolder . '.bookRecords';

        $books = $bookService->searchBooks();

        $viewModel = [
            'books'     => $books,
            'authors'     => $authorService->getAuthors()->get(),
            'categories' => Category::all()
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi pretrazene ucenike cije se knjige vracaju
     *
     * @param  Book $book
     * @param  BookService $bookService
     * @param  RentService $rentService
     */
    public function searchReturn(Book $book, BookService $bookService, RentService $rentService) {

        $viewName = $this->viewFolder . '.returnBook';

        $rentedBooks = $bookService->searchReturnBook($book, $rentService);

        $viewModel = [
            'rentedBooks'     => $rentedBooks,
            'book'           => $book
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi pretrazene ucenike cije se knjige otpisuju
     *
     * @param  Book $book
     * @param  BookService $bookService
     * @param  RentService $rentService
     */
    public function searchWriteOff(Book $book, BookService $bookService, RentService $rentService) {

        $viewName = $this->viewFolder . '.writeOffBook';

        $overdueBooks = $bookService->searchWriteOffBooks($book, $rentService);

        $viewModel = [
            'overdueBooks'     => $overdueBooks,
            'book'     => $book
        ];

        return view($viewName, $viewModel);
    }

}
