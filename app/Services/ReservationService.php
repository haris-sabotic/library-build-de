<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\ReservationStatus;
use Carbon\Carbon;
use Auth;

/*
|--------------------------------------------------------------------------
| ReservationService
|--------------------------------------------------------------------------
|
| ReservationService je odgovaran za svu logiku koja se desava
| unutar ReservationControllera. Ovdje je moguce definisati sve
| pomocne metode koji su potrebni.
|
*/

class ReservationService
{
    /**
     * Vrati sve aktivne rezervacije
     *
     */
    public function getActiveReservations() {

        return Reservation::with('book', 'student')
                    ->where('closeReservation_id', '=', null);
    }

    /**
     * Vrati sve arhivirane rezervacije
     *
     */
    public function getArchivedReservations() {

        return Reservation::with('book', 'student', 'reservationStatus')
                    ->where('closeReservation_id', '!=', null);
    }

    /**
     * Vrati sve rezervisane knjige
     *
     */
    public function getReservedBooks() {

        return Reservation::with('book', 'student', 'reservationStatus')
                    ->where('closeReservation_id', '=', 5);
    }

    /**
     * Vrati konkretnu rezervaciju
     *
     */
    public function getReservation($book, $student) {

        return Reservation::where('book_id', '=', $book)
                                ->where('student_id', '=', $student)
                                ->where('closeReservation_id', '=', 5)
                                ->first();
    }

    /**
     * Updateuj status rezervacije za konkretnu rezervaciju
     *
     * @param  Book  $knjiga
     */
    public function updateReservationStatus($reservation) {

        $reservationStatus = ReservationStatus::find($reservation);
        $reservationStatus->statusReservation_id = 2;
        $reservationStatus->save();
    }

    /**
     * Sacuvaj rezervaciju
     *
     * @param  Book  $book
     * @param  GlobalVariableService  $globalVariableService
     */
    public function saveReservation($book, $globalVariableService) {

        $reservation = new Reservation();

        $reservation->book_id             = $book;
        $reservation->librarian_id        = Auth::id();
        $reservation->student_id          = request('student');
        $reservation->reservation_date    = request('reservationDate');
        $reservation->close_date          = $reservation->reservation_date->addDays($globalVariableService->getReservationPeriod());
        $reservation->request_date        = now();
        $reservation->closeReservation_id = 5;

        $reservation->save();

        return $reservation;
    }

    /**
     * Sacuvaj status rezervacije
     *
     * @param  int $reservationId
     * @param  date $reservationDate
     */
    public function saveReservationStatus($reservationId, $reservationDate) {

        $reservationStatus = new ReservationStatus();

        $reservationStatus->reservation_id       = $reservationId;
        $reservationStatus->statusReservation_id = 1;
        $reservationStatus->date                 = $reservationDate;

        $reservationStatus->save();
    }

    /**
     * Vrati pretrazene aktivne rezervacije / Nije testirano!
     *
     */
    public function searchActiveReservations() {

        $active = Reservation::query();

        $active = $this->getActiveReservations();

        if(request('searchActive')) {
            $book = request('searchActive');
            $active = $active->where(function ($query) {
                $query->select('title')
                    ->from('books')
                    ->whereColumn('books.id', 'reservations.book_id');
            }, 'LIKE', '%'.$book.'%');
        }

        $active = $active->paginate(7);

        return $active;
    }

    /**
     * Vrati pretrazene arhivirane rezervacije
     *
     */
    public function searchArchivedReservations() {

        $archived = Reservation::query();

        $archived = $this->getArchivedReservations();

        if(request('searchArchived')) {
            $book = request('searchArchived');
            $archived = $archived->where(function ($query) {
                $query->select('title')
                    ->from('books')
                    ->whereColumn('books.id', 'reservations.book_id');
            }, 'LIKE', '%'.$book.'%');
        }

        $archived = $archived->paginate(7);

        return $archived;
    }

    public function getTransaction($book, $student) {
        
        return Reservation::with('book', 'student', 'librarian')
            ->where('book_id', '=', $book)
            ->where('student_id', '=', $student)
            ->first();
    }
}
