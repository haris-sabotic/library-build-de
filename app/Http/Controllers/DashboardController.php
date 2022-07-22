<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\Rent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Services\BookService;
use App\Services\RentService;
use App\Services\ReservationService;
use App\Services\UserService;
use Illuminate\Http\Response;
use Symfony\Component\Console\Input\Input;

/*
|--------------------------------------------------------------------------
| DashboardController
|--------------------------------------------------------------------------
|
| DashboardController je odgovaran za povezivanje logike
| izmedju dashboard view-a i neophodnih Modela
|
*/

class DashboardController extends Controller
{
    private $viewFolder = 'pages/dashboard';

    /**
     * Prikazi dashboard
     *
     * @param  DashboardService $dashboardService
     */
    public function showDashboard(DashboardService $dashboardService, ReservationService $reservationService, RentService $rentService) {
        
        $viewName = $this->viewFolder . '.dashboard';

        $viewModel = [
            'reservations'    => $dashboardService->getLatestReservation(),
            'activities'     => $dashboardService->getLatestActivities(),
            'overdueNum' => $rentService->getOverdueBooks()->count(),
            'rentedNum'      => $rentService->getRentedBooks()->count(),
            'reservedNum' => $reservationService->getReservedBooks()->count(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi sve aktivnosti
     *
     * @param  DashboardService $dashboardService
     * @param  BookService $bookService
     * @param  UserService $userService
     */
    public function showDashboardActivity(DashboardService $dashboardService, BookService $bookService, UserService $userService) {

        $viewName = $this->viewFolder . '.dashboardActivity';

        $viewModel = [
            'activities'   => $dashboardService->getActivities(),
            'book'       => null,
            'students'      => $userService->getStudents()->get(),
            'librarians' => $userService->getLibrarians()->get(),
            'books'       => $bookService->getBooks()->get(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi sve aktivnosti kod konkretne knjige
     *
     * @param  Book $book
     * @param  DashboardService $dashboardService
     * @param  BookService $bookService
     * @param  UserService $userService
     */
    public function showDashboardActivitySpecificBook(Book $book, DashboardService $dashboardService, BookService $bookService, UserService $userService) {
        
        $viewName = $this->viewFolder . '.dashboardActivity';

        $viewModel = [
            'activities'   => $dashboardService->getBookActivity($book->id)->get(),
            'book'       => $book,
            'students'      => $userService->getStudents()->get(),
            'librarians' => $userService->getLibrarians()->get(),
            'books'       => $bookService->getBooks()->get(),
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Filtriraj sve aktivnosti
     *
     * @param  Request $request
     * @param  DashboardService $dashboardService
     * @param  BookService $bookService
     * @param  UserService $userService
     */
    public function filterActivities(Request $request, DashboardService $dashboardService, BookService $bookService, UserService $userService) {
        
        $activities = $dashboardService->filterActivities(
            $request->students, 
            $request->librarians, 
            $request->books,
            $request->dateFrom, 
            $request->dateTo
        );

        $responseJson = [
            "activities"   => $activities,
            'book'       => null,
            'students'      => $userService->getStudents()->get(),
            'librarians' => $userService->getLibrarians()->get(),
            'books'       => $bookService->getBooks(),
        ];

        return response()->json($responseJson);
    }
}
