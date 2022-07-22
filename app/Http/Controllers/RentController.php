<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\RentStatus;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Book;
use App\Services\RentService;
use App\Services\UserService;
use App\Services\ReservationService;
use App\Services\GlobalVariableService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| RentController
|--------------------------------------------------------------------------
|
| RentController je odgovaran za povezivanje logike
| izmedju rent view-a i neophodnih Modela
|
*/

class RentController extends Controller
{

    private $viewFolder = 'pages/rents';

    /**
     * Prikazi detalje o transakciji
     *
     * @param  Book $book
     * @param  User $student
     * @param  RentService $rentService
     */
    public function showRentDetails(Book $book, User $student, ReservationService $reservationService, RentService $rentService) {

        $viewName      = $this->viewFolder . '.rentDetails';
        $viewNameError = $this->viewFolder . '.rentDetailsError';


        $transaction = $rentService->getTransaction($book->id, $student->id);

        $viewModel = [
            'transaction' => $transaction,
        ];

        $viewModelError = [
            'book' => $book,
            'student' => $student,
        ];

        if($transaction != null) {
            return view($viewName, $viewModel);
        } else {
            return view($viewNameError, $viewModelError);
        }
    }

    /**
     * Prikazi knjige u prekoracenju
     *
     * @param  RentService $rentService
     * @param  UserService $userService
     */
    public function showOverdueBooks(RentService $rentService, UserService $userService, GlobalVariableService $globalVariableService) {

        $viewName = $this->viewFolder . '.overdueBooks';

        $overdued = $rentService->getOverdueBooks($globalVariableService)->paginate(7);

        $viewModel = [
            'overdued'  => $overdued,
            'students'      => $userService->getStudents()->get(),
            'librarians' => $userService->getLibrarians()->get(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi izdate knjige
     *
     * @param  RentService $rentService
     * @param  UserService $userService
     */
    public function showRentedBooks(RentService $rentService, UserService $userService) {

        $viewName = $this->viewFolder . '.rentedBooks';

        // pokupi samo knjige sa statusom izdatata
        $rented = $rentService->getRentedBooks()->paginate(7);

        $viewModel = [
            'rented'       => $rented,
            'students'      => $userService->getStudents()->get(),
            'librarians' => $userService->getLibrarians()->get(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi vracene knjige
     *
     * @param  RentService $rentService
     * @param  UserService $userService
     */
    public function showReturnedBooks(RentService $rentService, UserService $userService) {

        $viewName = $this->viewFolder . '.returnedBooks';

        // pokupi samo knjige sa statusom izdatata
        $returned = $rentService->getReturnedBooks()->paginate(7);

        $viewModel = [
            'returned'      => $returned,
            'students'      => $userService->getStudents()->get(),
            'librarians' => $userService->getLibrarians()->get(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi aktivne rezervacije
     *
     * @param  ReservationService $reservationService
     */
    public function showActiveReservations(ReservationService $reservationService) {

        $viewName = $this->viewFolder . '.activeReservations';

        $viewModel = [
            'active' => $reservationService->getActiveReservations()->paginate(7),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi arhivirane rezervacije
     *
     * @param  ReservationService $reservationService
     */
    public function showArchivedReservations(ReservationService $reservationService) {

        $viewName = $this->viewFolder . '.archivedReservations';

        $viewModel = [
            'archived' => $reservationService->getArchivedReservations()->paginate(7)
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Izbrisi transakciju
     *
     * @param  Book $book
     * @param  User $student
     * @param  RentService $rentService
     * @param  UserService $userService
     */
    public function deleteTransaction(Book $book, User $student, RentService $rentService, UserService $userService) {

        $rentService->deleteTransaction($book->id, $student->id);
        $rented = $rentService->getRentedBooks()->paginate(7);

        $viewModel = [
            'rented'       => $rented,
            'students'      => $userService->getStudents()->get(),
            'librarians' => $userService->getLibrarians()->get(),
        ];

        return redirect('rentedBooks')->with('success','Zapis je uspješno izbrisan!');
    }

    /**
     * Prikazi filtrirane izdate knjige
     *
     * @param  RentService $rentService
     * @param  UserService $userService
     */
    public function filterRentedBooks(RentService $rentService, UserService $userService) {

        $viewName = $this->viewFolder . '.rentedBooks';

        $rented = $rentService->filtrateRentedBooks();

        $viewModel = [
            'rented'       => $rented,
            'students'      => $userService->getStudents()->get(),
            'librarians' => $userService->getLibrarians()->get(),
        ];

        return view($viewName, $viewModel);

    }

    /**
     * Prikazi pretrazene izdate knjige
     *
     * @param  RentService $rentService
     * @param  UserService $userService
     */
    public function searchRentedBooks(RentService $rentService, UserService $userService) {

        $viewName = $this->viewFolder . '.rentedBooks';

        $rented = $rentService->searchRentedBooks();

        $viewModel = [
            'rented'       => $rented,
            'students'      => $userService->getStudents()->get(),
            'librarians' => $userService->getLibrarians()->get(),
        ];

        return view($viewName, $viewModel);

    }

    /**
     * Prikazi filtirirane vracene knjige
     *
     * @param  RentService $rentService
     * @param  UserService $userService
     */
    public function filterReturnedBooks(RentService $rentService, UserService $userService) {

        $viewName = $this->viewFolder . '.returnedBooks';

        $returned = $rentService->filtrateReturnedBooks();

        $viewModel = [
            'returned'      => $returned,
            'students'      => $userService->getStudents()->get(),
            'librarians' => $userService->getLibrarians()->get(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi pretrazene vracene knjige
     *
     * @param  RentService $rentService
     * @param  UserService $userService
     */
    public function searchReturnedBooks(RentService $rentService, UserService $userService) {

        $viewName = $this->viewFolder . '.returnedBooks';

        $returned = $rentService->searchReturnedBooks();

        $viewModel = [
            'returned'       => $returned,
            'students'      => $userService->getStudents()->get(),
            'librarians' => $userService->getLibrarians()->get(),
        ];

        return view($viewName, $viewModel);

    }

    /**
     * Prikazi filtrirane u prekoracenju
     *
     * @param  RentService $rentService
     * @param  UserService $userService
     */
    public function filterOverdueBooks(RentService $rentService, UserService $userService) {
        
        $viewName = $this->viewFolder . '.overdueBooks';

        $overdued = $rentService->filtrateOverdueBooks();

        $viewModel = [
            'overdued'  => $overdued,
            'students'      => $userService->getStudents()->get(),
            'librarians' => $userService->getLibrarians()->get(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi pretrazene knjige u prekoracenju
     *
     * @param  RentService $rentService
     * @param  UserService $userService
     */
    public function searchOverdueBooks(RentService $rentService, UserService $userService) {

        $viewName = $this->viewFolder . '.overdueBooks';

        $overdued = $rentService->searchOverdueBooks();

        $viewModel = [
            'overdued'       => $overdued,
            'students'      => $userService->getStudents()->get(),
            'librarians' => $userService->getLibrarians()->get(),
        ];

        return view($viewName, $viewModel);

    }

    /**
     * Prikazi pretrazene aktivne rezervacije / Nije testirano!
     *
     * @param  ReservationService $reservationService
     * @param  UserService $userService
     */
    public function searchActiveReservations(ReservationService $reservationService, UserService $userService) {

        $viewName = $this->viewFolder . '.activeReservations';

        $active = $reservationService->searchActiveReservations();

        $viewModel = [
            'active' => $active
        ];

        return view($viewName, $viewModel);

    }

    /**
     * Prikazi pretrazene arhivirane rezervacije
     *
     * @param  ReservationService $reservationService
     * @param  UserService $userService
     */
    public function searchArchivedReservations(ReservationService $reservationService, UserService $userService) {

        $viewName = $this->viewFolder . '.archivedReservations';

        $archived = $reservationService->searchArchivedReservations();

        $viewModel = [
            'archived' => $archived
        ];

        return view($viewName, $viewModel);

    }

}
