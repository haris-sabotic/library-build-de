<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\Rent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| DashboardService
|--------------------------------------------------------------------------
|
| DashboardService je odgovaran za svu logiku koja se desava
| unutar DashboardControllera. Ovdje je moguce definisati sve
| pomocne metode koji su potrebni.
|
*/

class DashboardService
{
    /**
     * Vrati poslednje 4 rezervacije iz baze
     *
     */
    public function getLatestReservation() {

        return Reservation::with('book', 'student')
                    ->latest()
                    ->take(4)
                    ->get();
    }

    /**
     * Vrati sve aktivnosti
     *
     */
    public function getActivities() {

        return Rent::with('book', 'student', 'librarian')
                    ->orderBy('rent_date', 'DESC')
                    ->get();

    }

    /**
     * Vrati ooslednjih 10 aktivnosti
     *
     */
    public function getLatestActivities() {

        return Rent::with('book', 'student', 'librarian')
                    ->orderBy('rent_date', 'DESC')
                    ->take(10)
                    ->get();
    }

    /**
     * Vrati aktivnosti za konkretnu knjigu
     *
     * @param  Book  $book
     */
    public function getBookActivity($book) {

        return Rent::with('book', 'student', 'librarian')
                        ->where('book_id', 'LIKE', $book)
                        ->orderBy('rent_date', 'DESC');
    }

    /**
     * Filtiraj aktivnosti po trazenim uslovima
     *
     * @param  Request  $studentsRequest
     * @param  Request  $librariansRequest
     * @param  Request  $booksRequest
     * @param  Request  $dateFromRequest
     * @param  Request  $dateToRequest
     */
    public function filterActivities($studentsRequest, $librariansRequest, $booksRequest, $dateFromRequest, $dateToRequest) {
        
        $activities = Rent::query();
        $activities = $activities->with('book', 'student', 'librarian');

        if($studentsRequest) {
            $students    = $studentsRequest;
            $activities = $activities->whereIn('student_id', $students);
        }

        if($librariansRequest) {
            $librarians = $librariansRequest;
            $activities   = $activities->whereIn('librarian_id', $librarians);
        }

        if($booksRequest) {
            $books     = $booksRequest;
            $activities = $activities->whereIn('book_id', $books);
        }

        if($dateFromRequest && $dateToRequest) {
            $dateFrom    = $dateFromRequest;
            $dateTo    = $dateToRequest;
            $activities = $activities->whereBetween('rent_date', [$dateFrom, $dateTo]);
        }

        return $activities->orderBy('rent_date', 'DESC')->get();
    }

}
