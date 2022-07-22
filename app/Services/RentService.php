<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Rent;
use App\Models\RentStatus;
use App\Services\GlobalVariableService;
use Carbon\Carbon;
use Auth;

/*
|--------------------------------------------------------------------------
| RentService
|--------------------------------------------------------------------------
|
| RentService je odgovaran za svu logiku koja se desava 
| unutar RentControllera. Ovdje je moguce definisati sve 
| pomocne metode koji su potrebni.
|
*/

class RentService 
{
    /**
     * Vrati trazenu transakciju
     *
     * @param  Book  $book
     * @param  User  $student
     */
    public function getTransaction($book, $student) {

        return Rent::with('book', 'student', 'librarian')
                    ->where('book_id', '=', $book)
                    ->where('student_id', '=', $student)
                    ->first();
    }

    /**
     * Vrati sve knjige u prekoracenju
     *
     */
    public function getOverdueBooks() {
        
        $globalVariable = new GlobalVariableService();
        $period = $globalVariable->getOverdraftPeriod();

        return Rent::whereRaw('return_date + interval '. $period .' day < ?', [Carbon::now()])
                    ->where(function ($query) {
                        $query->select('statusBook_id')
                            ->from('rent_statuses')
                            ->whereColumn('rent_statuses.rent_id', 'rents.id')
                            ->orderByDesc('rent_statuses.date')
                            ->limit(1);
                    }, 2);
    }

    /**
     * Vrati sve izdate knjige
     *
     */
    public function getRentedBooks() {

        return Rent::where(function ($query) {
                        $query->select('statusBook_id')
                            ->from('rent_statuses')
                            ->whereColumn('rent_statuses.rent_id', 'rents.id')
                            ->orderByDesc('rent_statuses.date')
                            ->limit(1);
                    }, 2);
    }

    /**
     * Vrati sve vracene knjige
     *
     */
    public function getReturnedBooks() {

        return Rent::where(function ($query) {
                        $query->select('statusBook_id')
                            ->from('rent_statuses')
                            ->whereColumn('rent_statuses.rent_id', 'rents.id')
                            ->orderByDesc('rent_statuses.date')
                            ->limit(1);
                    }, 1)->orWhere(function ($query) {
                            $query->select('statusBook_id')
                                ->from('rent_statuses')
                                ->whereColumn('rent_statuses.rent_id', 'rents.id')
                                ->orderByDesc('rent_statuses.date')
                                ->limit(1);
                    }, 3);
    }

    /**
     * Sacuvaj rent
     *
     * @param  Book  $book
     */
    public function saveRent($book) {

        $rent = new Rent();

        $rent->book_id = $book;
        $rent->librarian_id = Auth::id();
        $rent->student_id = request('student');
        $rent->rent_date = request('rentDate');
        $rent->return_date = request('returnDate');

        $rent->save();

        return $rent;
    }

    /**
     * Sacuvaj rent status
     *
     * @param  int $rentId
     * @param  date $rentDate
     */
    public function saveRentStatus($rentId, $rentDate) {

        $rentStatus = new RentStatus();

        $rentStatus->rent_id = $rentId;
        $rentStatus->statusBook_id = 2;
        $rentStatus->date = $rentDate;

        $rentStatus->save();
    }
    
    /**
     * Izbrisi transakciju
     *
     * @param  Book  $book
     * @param  User  $student
     */
    public function deleteTransaction($book, $student) {

        $transaction = $this->getTransaction($book, $student);
            
        Rent::destroy($transaction->id);
    }

    /**
     * Vrati filtrirane izdate knjige
     *
     */
    public function filtrateRentedBooks() {

        $rented = Rent::query();
        $rented = $rented->with('book', 'student', 'librarian')
                        ->where('return_date', '=', null);

        if(request('studentsFilter')) {
            $students = request('studentsFilter');
            $rented  = $rented->whereIn('student_id', $students);
        }

        if(request('librariansFilter')) {
            $librarians = request('librariansFilter');
            $rented       = $rented->whereIn('librarian_id', $librarians);
        }

        if(request('filterDateFrom') && request('filterDateTo')) {
            $dateFrom = request('filterDateFrom');
            $dateTo = request('filterDateTo');
            $rented  = $rented->whereBetween('rent_date', [$dateFrom, $dateTo]);
        }

        $rented = $rented->paginate(7);

        return $rented;
    }

    /**
     * Vrati filtrirane vracene knjige
     *
     */
    public function filtrateReturnedBooks() {

        $returned = Rent::query();
        $returned = $returned->with('book', 'student', 'librarian')
                        ->where('return_date', '!=', null)
                        ->where('librarian_received_id', '!=', null);

        if(request('studentsFilter')) {
            $students = request('studentsFilter');
            $returned = $returned->whereIn('student_id', $students);
        }

        if(request('librariansFilter')) {
            $librarians = request('librariansFilter');
            $returned      = $returned->whereIn('librarian_id', $librarians);
        }

        if(request('filterDateFrom') && request('filterDateTo')) {
            $dateFrom = request('filterDateFrom');
            $dateTo = request('filterDateTo');
            $returned = $returned->whereBetween('rent_date', [$dateFrom, $dateTo]);
        }

        if(request('filterReturnedFrom') && request('filterReturnedTo')) {
            $returnedFrom = request('filterReturnedFrom');
            $returnedTo = request('filterReturnedTo');
            $returned   = $returned->whereBetween('return_date', [$returnedFrom, $returnedTo]);
        }

        $returned = $returned->paginate(7);

        return $returned;
    }

    /**
     * Vrati filtrirane knjige u prekoracenju
     *
     */
    public function filtrateOverdueBooks() {

        $overdue = Rent::query();
        $overdue = $overdue->with('book', 'student', 'librarian')
                            ->where('return_date', '=', null)
                            ->where('rent_date', '<', Carbon::now()->subDays(30));

        if(request('studentsFilter')) {
            $students     = request('studentsFilter');
            $overdue = $overdue->whereIn('student_id', $students);
        }

        if(request('filterDateFrom') && request('filterDateTo')) {
            $dateFrom     = request('filterDateFrom');
            $dateTo     = request('filterDateTo');
            $overdue = $overdue->whereBetween('rent_date', [$dateFrom, $dateTo]);
        }

        $overdue = $overdue->paginate(7);

        return $overdue;
    }

    /**
     * Vrati pretrazene izdate knjige
     *
     */
    public function searchRentedBooks() {
        
        $rented = Rent::query();
        
        $rented = $this->getRentedBooks();

        if(request('searchRented')) {
            $book = request('searchRented');
            $rented = $rented->where(function ($query) {
                $query->select('title')
                    ->from('books')
                    ->whereColumn('books.id', 'rents.book_id');
            }, 'LIKE', '%'.$book.'%');
        }

        $rented = $rented->paginate(7);

        return $rented;
    }

    /**
     * Vrati pretrazene vracene knjige
     *
     */
    public function searchReturnedBooks() {



        if(request('searchReturned')&&request('searchReturned')!='') {
            $book = request('searchReturned');
            $returned = Rent::where(function ($query) {
                $query->select('title')
                    ->from('books')
                    ->whereColumn('books.id', 'rents.book_id');
            }, 'LIKE', '%'.$book.'%')
                ->where(function ($query) {
                $query->select('statusBook_id')
                    ->from('rent_statuses')
                    ->whereColumn('rent_statuses.rent_id', 'rents.id')
                    ->orderByDesc('rent_statuses.date')
                    ->limit(1);
            }, 1)->orWhere(function ($query) {
                $query->select('statusBook_id')
                    ->from('rent_statuses')
                    ->whereColumn('rent_statuses.rent_id', 'rents.id')
                    ->orderByDesc('rent_statuses.date')
                    ->limit(1);
            }, 3);
        }
        else{
            $returned = Rent::query();
            $returned = $this->getReturnedBooks();
        }

        $returned = $returned->paginate(7);

        return $returned;
    }

    /**
     * Vrati pretrazene knjige u prekoracenju
     *
     */
    public function searchOverdueBooks() {

        $overdue = Rent::query();
        
        $overdue = $this->getOverdueBooks();

        if(request('searchOverdue')) {
            $book = request('searchOverdue');
            $overdue = $overdue->where(function ($query) {
                $query->select('title')
                    ->from('books')
                    ->whereColumn('books.id', 'rents.book_id');
            }, 'LIKE', '%'.$book.'%');
        }

        $overdue = $overdue->paginate(7);

        return $overdue;
    }
}