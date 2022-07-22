<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function() {

    //DASHBOARD - ROUTES
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('/dashboardActivity', [\App\Http\Controllers\DashboardController::class, 'showDashboardActivity'])->name('dashboardActivity');
    Route::get('/dashboardActivitySpecificBook/{book}', [\App\Http\Controllers\DashboardController::class, 'showDashboardActivitySpecificBook'])->name('dashboardActivitySpecificBook');
    Route::post('/filterActivities', [\App\Http\Controllers\DashboardController::class, 'filterActivities'])->name('filterActivities');

    //LIBRARIAN - ROUTES
    Route::get('/librarianProfile/{user}', [\App\Http\Controllers\UserController::class, 'showLibrarian'])->name('librarianProfile');
    Route::get('/librarians', [\App\Http\Controllers\UserController::class, 'showLibrarians']);
    Route::get('/editLibrarian/{user}', [\App\Http\Controllers\UserController::class, 'showEditLibrarian'])->name('editLibrarian');
    Route::post('/editLibrarian/{user}/update', [\App\Http\Controllers\UserController::class, 'updateLibrarian'])->name('updateLibrarian');
    Route::get('/deleteLibrarian/{user}', [\App\Http\Controllers\UserController::class, 'deleteLibrarian'])->name('deleteLibrarian');
    Route::get('/addLibrarian', [\App\Http\Controllers\UserController::class, 'showAddLibrarian'])->name('addLibrarian');
    Route::post('/saveLibrarian', [\App\Http\Controllers\UserController::class, 'saveLibrarian'])->name('saveLibrarian');
    Route::get('/searchLibrarians', [\App\Http\Controllers\UserController::class, 'searchLibrarians'])->name('searchLibrarians');
    Route::post('/resetPassword/{user}', [\App\Http\Controllers\UserController::class, 'resetPassword'])->name('resetPassword');

    //STUDENT - ROUTES
    Route::get('/students', [\App\Http\Controllers\UserController::class, 'showStudents']);
    Route::get('/studentProfile/{user}', [\App\Http\Controllers\UserController::class, 'showStudentProfile'])->name('studentProfile');
    Route::get('/editStudent/{user}', [\App\Http\Controllers\UserController::class, 'showEditStudent'])->name('editStudent');
    Route::post('/editStudent/{user}/update', [\App\Http\Controllers\UserController::class, 'updateStudent'])->name('updateStudent');
    Route::get('/addStudent', [\App\Http\Controllers\UserController::class, 'showAddStudent'])->name('addStudent');
    Route::post('/saveStudent', [\App\Http\Controllers\UserController::class, 'saveStudent'])->name('saveStudent');
    Route::get('/deleteStudent/{user}', [\App\Http\Controllers\UserController::class, 'deleteStudent'])->name('deleteStudent');
    Route::get('/searchStudents', [\App\Http\Controllers\UserController::class, 'searchStudents'])->name('searchStudents');
    Route::get('/studentRented/{user}', [\App\Http\Controllers\UserController::class, 'showStudentRented'])->name('studentRented');
    Route::get('/studentReturned/{user}', [\App\Http\Controllers\UserController::class, 'showStudentReturned'])->name('studentReturned');
    Route::get('/studentOverdue/{user}', [\App\Http\Controllers\UserController::class, 'showStudentOverdue'])->name('studentOverdue');
    Route::get('/studentActive/{user}', [\App\Http\Controllers\UserController::class, 'showStudentActive'])->name('studentActive');
    Route::get('/studentArchived/{user}', [\App\Http\Controllers\UserController::class, 'showStudentArchived'])->name('studentArchived');


    //BOOK - ROUTES
    Route::get('/editBook/{book}', [\App\Http\Controllers\BookController::class, 'showEditBook'])->name('editBook');
    Route::get('/editBookMultimedia', [\App\Http\Controllers\BookController::class, 'showEditBookMultimedia']);
    Route::get('/editBookSpecification', [\App\Http\Controllers\BookController::class, 'showEditBookSpecification']);
    Route::get('/bookRecords', [\App\Http\Controllers\BookController::class, 'showBookRecords'])->name('bookRecords');
    Route::get('/bookMultimedia/{book}', [\App\Http\Controllers\BookController::class, 'showBookMultimedia'])->name('bookMultimedia');
    Route::get('/bookDetails/{book}', [\App\Http\Controllers\BookController::class, 'showBookDetails'])->name('bookDetails');
    Route::get('/bookSpecification/{book}', [\App\Http\Controllers\BookController::class, 'showBookSpecification'])->name('bookSpecification');
    Route::get('/addBook', [\App\Http\Controllers\BookController::class, 'showAddBook'])->name('addBook');
    Route::get('/addBookMultimedia', [\App\Http\Controllers\BookController::class, 'showAddBookMultimedia']);
    Route::get('/addBookSpecification', [\App\Http\Controllers\BookController::class, 'showaAddBookSpecification']);
    Route::get('/writeOffBook/{book}', [\App\Http\Controllers\BookController::class, 'showWriteOffBook'])->name('writeOffBook');
    Route::get('/writeOffBooks', [\App\Http\Controllers\BookController::class, 'writeOffBooks'])->name('writeOffBooks');
    Route::get('/reserveBook/{book}', [\App\Http\Controllers\BookController::class, 'showReserveBook'])->name('reserveBook');
    Route::post('/reserveBook/{book}/reserve', [\App\Http\Controllers\BookController::class, 'reserve'])->name('reserve');
    Route::get('/rentBook/{book}', [\App\Http\Controllers\BookController::class, 'showRentBook'])->name('rentBook');
    Route::post('/rentBook/{book}/rent', [\App\Http\Controllers\BookController::class, 'rent'])->name('rent');
    Route::get('/returnBook/{book}', [\App\Http\Controllers\BookController::class, 'showReturnBook'])->name('returnBook');
    Route::get('/returnBooks', [\App\Http\Controllers\BookController::class, 'returnBooks'])->name('returnBooks');
    Route::get('/rentingRented/{book}', [\App\Http\Controllers\BookController::class, 'showRentingRented'])->name('rentingRented');
    Route::get('/rentingOverdue/{book}', [\App\Http\Controllers\BookController::class, 'showRentingOverdue'])->name('rentingOverdue');
    Route::get('/rentingReturned/{book}', [\App\Http\Controllers\BookController::class, 'showRentingReturned'])->name('rentingReturned');
    Route::get('/rentingActive/{book}', [\App\Http\Controllers\BookController::class, 'showRentingActive'])->name('rentingActive');
    Route::get('/rentingArchived/{book}', [\App\Http\Controllers\BookController::class, 'showRentingArchived'])->name('rentingArchived');
    Route::post('/saveBook', [\App\Http\Controllers\BookController::class, 'saveBook'])->name('saveBook');
    Route::get('/deleteBook/{book}', [\App\Http\Controllers\BookController::class, 'deleteBook'])->name('deleteBook');
    Route::post('/editBook/{book}/update', [\App\Http\Controllers\BookController::class, 'updateBook'])->name('updateBook');
    Route::get('/filterAuthors', [\App\Http\Controllers\BookController::class, 'filterAuthors'])->name('filterAuthors');
    Route::get('/searchBooks', [\App\Http\Controllers\BookController::class, 'searchBooks'])->name('searchBooks');
    Route::get('/searchReturn/{book}', [\App\Http\Controllers\BookController::class, 'searchReturn'])->name('searchReturn');
    Route::get('/searchWriteOff/{book}', [\App\Http\Controllers\BookController::class, 'searchWriteOff'])->name('searchWriteOff');

    //RESERVATION - ROUTES

    //RENT - ROUTES
    Route::get('/rentDetails/{book}/{student}', [\App\Http\Controllers\RentController::class, 'showRentDetails'])->name('rentDetails');
    Route::get('/overdueBooks', [\App\Http\Controllers\RentController::class, 'showOverdueBooks'])->name('overdueBooks');
    Route::get('/rentedBooks', [\App\Http\Controllers\RentController::class, 'showRentedBooks'])->name('rentedBooks');
    Route::get('/returnedBooks', [\App\Http\Controllers\RentController::class, 'showReturnedBooks'])->name('returnedBooks');
    Route::get('/activeReservations', [\App\Http\Controllers\RentController::class, 'showActiveReservations'])->name('activeReservations');
    Route::get('/archivedReservations', [\App\Http\Controllers\RentController::class, 'showarchivedReservations'])->name('archivedReservations');
    Route::get('/deleteTransaction/{book}/{student}', [\App\Http\Controllers\RentController::class, 'deleteTransaction'])->name('deleteTransaction');
    Route::get('/filterRentedBooks', [\App\Http\Controllers\RentController::class, 'filterRentedBooks'])->name('filterRentedBooks');
    Route::get('/filterReturnedBooks', [\App\Http\Controllers\RentController::class, 'filterReturnedBooks'])->name('filterReturnedBooks');
    Route::get('/filterOverdueBooks', [\App\Http\Controllers\RentController::class, 'filterOverdueBooks'])->name('filterOverdueBooks');
    Route::get('/searchRentedBooks', [\App\Http\Controllers\RentController::class, 'searchRentedBooks'])->name('searchRentedBooks');
    Route::get('/searchReturnedBooks', [\App\Http\Controllers\RentController::class, 'searchReturnedBooks'])->name('searchReturnedBooks');
    Route::get('/searchOverdueBooks', [\App\Http\Controllers\RentController::class, 'searchOverdueBooks'])->name('searchOverdueBooks');
    Route::get('/searchActiveReservations', [\App\Http\Controllers\RentController::class, 'searchActiveReservations'])->name('searchActiveReservations');
    Route::get('/searchArchivedReservations', [\App\Http\Controllers\RentController::class, 'searchArchivedReservations'])->name('searchArchivedReservations');

    //SCRIPT - ROUTES
    Route::get('/editScript/{script}', [\App\Http\Controllers\ScriptController::class, 'showEdit'])->name('editScript');
    Route::get('/addScript', [\App\Http\Controllers\ScriptController::class, 'showAdd'])->name('addScript');
    Route::get('/scripts', [\App\Http\Controllers\ScriptController::class, 'index'])->name('scripts');
    Route::post('/saveScript', [\App\Http\Controllers\ScriptController::class, 'save'])->name('saveScript');
    Route::post('/updateScript/{script}', [\App\Http\Controllers\ScriptController::class, 'update'])->name('updateScript');
    Route::get('/deleteScript/{script}', [\App\Http\Controllers\ScriptController::class, 'delete'])->name('deleteScript');


    //FORMAT - ROUTES
    Route::get('/editFormat/{format}', [\App\Http\Controllers\FormatController::class, 'showEdit'])->name('editFormat');
    Route::get('/addFormat', [\App\Http\Controllers\FormatController::class, 'showAdd'])->name('addFormat');
    Route::get('/formats', [\App\Http\Controllers\FormatController::class, 'index'])->name('formats');
    Route::post('/saveFormat', [\App\Http\Controllers\FormatController::class, 'save'])->name('saveFormat');
    Route::post('/updateFormat/{format}', [\App\Http\Controllers\FormatController::class, 'update'])->name('updateFormat');
    Route::get('/deleteFormat/{format}', [\App\Http\Controllers\FormatController::class, 'delete'])->name('deleteFormat');


    //LANGUAGE - ROUTES


    //BINDING - ROUTES
    Route::get('/editBinding/{binding}', [\App\Http\Controllers\BindingController::class, 'showEdit'])->name('editBinding');
    Route::get('/addBinding', [\App\Http\Controllers\BindingController::class, 'showAdd'])->name('addBinding');
    Route::get('/bindings', [\App\Http\Controllers\BindingController::class, 'index'])->name('bindings');
    Route::post('/saveBinding', [\App\Http\Controllers\BindingController::class, 'save'])->name('saveBinding');
    Route::post('/updateBinding/{binding}', [\App\Http\Controllers\BindingController::class, 'update'])->name('updateBinding');
    Route::get('/deleteBinding/{binding}', [\App\Http\Controllers\BindingController::class, 'delete'])->name('deleteBinding');


    //PUBLISHER - ROUTES
    Route::get('/editPublisher/{publisher}', [\App\Http\Controllers\PublisherController::class, 'showEdit'])->name('editPublisher');
    Route::get('/addPublisher', [\App\Http\Controllers\PublisherController::class, 'showAdd'])->name('addPublisher');
    Route::get('/publishers', [\App\Http\Controllers\PublisherController::class, 'index'])->name('publishers');
    Route::post('/updatePublisher/{publisher}', [\App\Http\Controllers\PublisherController::class, 'update'])->name('updatePublisher');
    Route::get('/deletePublisher/{publisher}', [\App\Http\Controllers\PublisherController::class, 'delete'])->name('deletePublisher');
    Route::post('/savePublisher}', [\App\Http\Controllers\PublisherController::class, 'save'])->name('savePublisher');


    //CATEGORY - ROUTES
    Route::get('/editCategory/{category}', [\App\Http\Controllers\CategoryController::class, 'showEdit'])->name('editCategory');
    Route::get('/addCategory', [\App\Http\Controllers\CategoryController::class, 'showAdd'])->name('addCategory');
    Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
    Route::post('/saveCategory', [\App\Http\Controllers\CategoryController::class, 'save'])->name('saveCategory');
    Route::post('/updateCategory/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('updateCategory');
    Route::get('/deleteCategory/{category}', [\App\Http\Controllers\CategoryController::class, 'delete'])->name('deleteCategory');


    //AUTHOR - ROUTES
    Route::get('/authorProfile/{author}', [\App\Http\Controllers\AuthorController::class, 'show'])->name('authorProfile');
    Route::get('/authors', [\App\Http\Controllers\AuthorController::class, 'index']);
    Route::get('/editAuthor/{author}', [\App\Http\Controllers\AuthorController::class, 'showEdit'])->name('editAuthor');
    Route::post('/editAuthor/{author}/update', [\App\Http\Controllers\AuthorController::class, 'update'])->name('updateAuthor');
    Route::get('/addAuthor', [\App\Http\Controllers\AuthorController::class, 'showAdd'])->name('addAuthor');
    Route::get('/deleteAuthor/{author}', [\App\Http\Controllers\AuthorController::class, 'delete'])->name('deleteAuthor');
    Route::post('/saveAuthor', [\App\Http\Controllers\AuthorController::class, 'save'])->name('saveAuthor');
    Route::get('/searchAuthors', [\App\Http\Controllers\AuthorController::class, 'search'])->name('searchAuthors');


    //GALLERY - ROUTES
    Route::post('/deleteImage/{photo}', [\App\Http\Controllers\GaleryController::class, 'deleteImage'])->name('deleteImage');
    Route::post('/updateImage', [\App\Http\Controllers\GaleryController::class, 'update'])->name('updateImage');

    //GENRE - ROUTES
    Route::get('/editGenre{genre}', [\App\Http\Controllers\GenreController::class, 'showEdit'])->name('editGenre');
    Route::get('/addGenre', [\App\Http\Controllers\GenreController::class, 'showAdd'])->name('addGenre');
    Route::get('/genres', [\App\Http\Controllers\GenreController::class, 'index'])->name('genres');
    Route::post('/saveGenre', [\App\Http\Controllers\GenreController::class, 'save'])->name('saveGenre');
    Route::post('/updateGenre/{genre}', [\App\Http\Controllers\GenreController::class, 'update'])->name('updateGenre');
    Route::get('/deleteGenre/{genre}', [\App\Http\Controllers\GenreController::class, 'delete'])->name('deleteGenre');


    //POLICY - ROUTES
    Route::get('/policy', [\App\Http\Controllers\PolicyController::class, 'index'])->name('policy');
    Route::post('/changeDeadline', [\App\Http\Controllers\PolicyController::class, 'changeDeadline'])->name('changeDeadline');

});

require __DIR__.'/auth.php';
