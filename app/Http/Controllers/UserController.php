<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Rent;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Models\Book;
use Illuminate\Support\Facades\Gate;
use Auth;
use App\Services\UserService;
use App\Services\RentService;
use App\Services\ReservationService;

/*
|--------------------------------------------------------------------------
| UserController
|--------------------------------------------------------------------------
|
| UserController je odgovaran za povezivanje logike
| izmedju bibliotekar/ucenik view-a i neophodnih Modela
|
*/

class UserController extends Controller
{

    private $viewFolderLibrarian = 'pages/librarians';
    private $viewFolderStudent = 'pages/students';

    /**
     * Prikazi konkretnog bibliotekara
     *
     * @param  User $user
     */
    public function showLibrarian(User $user) {

        $viewName = $this->viewFolderLibrarian . '.librarianProfile';

        $viewModel = [
            'user' => $user
        ];

        if ($user->userType->name != 'student' && (Gate::allows('isMyAccount', $user) || Gate::allows('isAdmin'))) {
            return view($viewName, $viewModel);
        }
        return abort(403, trans('Sorry, not sorry!'));
    }

    /**
     * Prikazi sve bibliotekare
     *
     * @param  UserService $userService
     */
    public function showLibrarians(UserService $userService) {

        $viewName = $this->viewFolderLibrarian . '.librarians';

        $viewModel = [
            'librarians' => $userService->getLibrarians()->paginate(7)
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi stranicu za editovanje bibliotekara
     *
     * @param  User $user
     */
    public function showEditLibrarian(User $user) {

        $viewName = $this->viewFolderLibrarian . '.editLibrarian';

        $viewModel = [
            'user' => $user
        ];

        if ($user->userType->name != 'student' && (Gate::allows('isMyAccount', $user) || Gate::allows('isAdmin'))) {
            return view($viewName, $viewModel);
        }
        return abort(403, trans('Sorry, not sorry!'));
    }

    /**
     * Prikazi stranicu za unos novog bibliotekara
     *
     */
    public function showAddLibrarian() {

        $viewName = $this->viewFolderLibrarian . '.addLibrarian';

        return view($viewName);
    }

    /**
     * Izmijeni podatke o bibliotekaru
     *
     * @param  User $user
     * @param  UserService $userService
     * @param  Request $request
     */
    public function updateLibrarian(User $user, UserService $userService, Request $request) {

        $userService->editLibrarian($user, $request);

        //return back to all librarians
        return redirect('librarians')->with('success', 'Bibliotekar je uspješno izmijenjen!');
    }

    /**
     * Izbrisi bibliotekara
     *
     * @param  User $user
     */
    public function deleteLibrarian(User $user) {

        $viewModel = [
            'librarians' => User::with('userType')
                    ->where('userType_id', '=', 2)
                    ->paginate(7)
        ];

        if ($user->userType->name != 'student' && (Gate::allows('isMyAccount', $user) || Gate::allows('isAdmin'))) {
            User::destroy($user->id);
            return redirect('librarians')->with('success', 'Bibliotekar je uspješno izbrisan!');
        } else {
            return abort(403, trans('Sorry, not sorry!'));
        }
    }

    /**
     * Resetuj sifru korisnika
     *
     * @param User  $user
     * @param UserService $userService
     */
    public function resetPassword(User $user, UserService $userService) {

        $userService->resetPassword($user);

        return back()->with('success', 'Šifra je uspješno resetovana!');
    }

    /**
     * Kreiraj i sacuvaj novog bibliotekara
     *
     * @param  UserService $userService
     * @param  Request $request
     */
    public function saveLibrarian(UserService $userService, Request $request) {

        $user = $userService->saveLibrarian($request);

        $viewModel = [
            'user' => $user
        ];

        //return back to all librarians
        return redirect('librarians')->with('success', 'Bibliotekar je uspješno unesen!');
    }

    /**
     * Prikazi pretrazene bibliotekare
     *
     * @param  UserService $userService
     */
    public function searchLibrarians(UserService $userService) {

        $viewName = $this->viewFolderLibrarian . '.librarians';

        $librarians = $userService->searchLibrarians();

        $viewModel = [
            'librarians' => $librarians
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi sve ucenike
     *
     * @param  UserService $userService
     */
    public function showStudents(UserService $userService) {

        $viewName = $this->viewFolderStudent . '.students';

        $viewModel = [
            'students' => $userService->getStudents()->paginate(7)
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi konkretnog ucenika
     *
     * @param  User $user
     */
    public function showStudentProfile(User $user) {

        $viewName = $this->viewFolderStudent . '.studentProfile';

        $viewModel = [
            'user' => $user
        ];

        if($user->userType->name != 'student') {
            return abort(403, trans('Sorry, not sorry!'));
        } else {
            return view($viewName, $viewModel);
        }
    }

    /**
     * Prikazi stranicu za unos novog ucenika
     *
     */
    public function showAddStudent() {

        $viewName = $this->viewFolderStudent . '.addStudent';

        return view($viewName);
    }

    /**
     * Prikazi stranicu za editovanje ucenika
     *
     * @param  User $user
     */
    public function showEditStudent(User $user) {

        $viewName = $this->viewFolderStudent . '.editStudent';

        $viewModel = [
            'user' => $user
        ];

        if($user->userType->name != 'student') {
            return abort(403, trans('Sorry, not sorry!'));
        } else {
            return view($viewName, $viewModel);
        }
    }

    /**
     * Izmijeni podatke o uceniku
     *
     * @param  User $user
     * @param  UserService $userService
     * @param  Request $request
     */
    public function updateStudent(User $user, UserService $userService, Request $request) {

        $viewModel = [
            'user' => $user
        ];

        $userService->editStudent($user, $request);

        //return back to all students
        return redirect('students')->with('success', 'Učenik je uspješno izmijenjen!');
    }

    /**
     * Izbrisi ucenika
     *
     * @param  User $user
     */
    public function deleteStudent(User $user) {

        $viewModel = [
            'students' => User::with('userType')
                    ->where('userType_id', '=', 3)
                    ->paginate(7),
        ];

        if($user->userType->name != 'student') {
            return abort(403, trans('Sorry, not sorry!'));
        } else {
           
            User::destroy($user->id);
            return redirect('students')->with('success', 'Učenik je uspješno izbrisan!');
        }
    }

    /**
     * Kreiraj i sacuvaj novog ucenika
     *
     * @param  UserService $userService
     * @param  Request $request
     */
    public function saveStudent(UserService $userService, Request $request) {

        $user = $userService->saveStudent($request);

        $viewModel = [
            'user' => $user
        ];

        //return back to all students
        return redirect('students')->with('success', 'Učenik je uspješno unesen!');
    }

    /**
     * Prikazi pretrazene ucenike
     *
     * @param  UserService $userService
     */
    public function searchStudents(UserService $userService) {

        $viewName = $this->viewFolderStudent . '.students';

        $students = $userService->searchStudents();

        $viewModel = [
            'students' => $students
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi knjige izdate konkretnom uceniku
     *
     * @param  User $user
     * @param  RentService $rentService
     * @param  UserService $userService
     */
    public function showStudentRented(User $user, RentService $rentService, UserService $userService) {

        $viewName = $this->viewFolderStudent . '.studentRented';

        // pokupi samo knjige sa statusom izdata za konkretnog ucenika
        $rentedBooks = $rentService->getRentedBooks()->where('student_id', '=', $user->id)->paginate(7);

        $viewModel = [
            'user' => $user,
            'rentedBooks'=> $rentedBooks
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi knjige koje je konkretni ucenik vratio
     *
     * @param  User $user
     * @param  RentService $rentService
     * @param  UserService $userService
     */
    public function showStudentReturned(User $user, RentService $rentService, UserService $userService) {

        $viewName = $this->viewFolderStudent . '.studentReturned';

        $studentReturnedBooks = Rent::where('student_id', '=', $user->id)
            ->where(function ($query) {
                $query->select('statusBook_id')
                    ->from('rent_statuses')
                    ->whereColumn('rent_statuses.rent_id', 'rents.id')
                    ->orderByDesc('rent_statuses.date')
                    ->limit(1);
            }, 1);

        $returnedBooks = Rent::where('student_id', '=', $user->id)
            ->where(function ($query) {
                $query->select('statusBook_id')
                    ->from('rent_statuses')
                    ->whereColumn('rent_statuses.rent_id', 'rents.id')
                    ->orderByDesc('rent_statuses.date')
                    ->limit(1);
            }, 3)->union($studentReturnedBooks);

        $viewModel = [
            'user' => $user,
            'returnedBooks' => $returnedBooks->paginate(7)
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi knjige izdate konkretnom uceniku koje su u prekoracenju
     *
     * @param  User $user
     * @param  RentService $rentService
     * @param  UserService $userService
     */
    public function showStudentOverdue(User $user, RentService $rentService, UserService $userService) {

        $viewName = $this->viewFolderStudent . '.studentOverdue';

        $overdueBooks = $rentService->getOverdueBooks()->where('student_id', '=', $user->id)->paginate(7);

        $viewModel = [
            'user' => $user,
            'overdueBooks' => $overdueBooks
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi aktivne rezervacije konkretnog ucenika
     *
     * @param  User $user
     * @param  ReservationService $reservationService
     */
    public function showStudentActive(User $user, ReservationService $reservationService) {

        $viewName = $this->viewFolderStudent . '.studentActive';

        $viewModel = [
            'user' => $user,
            'activeReservations' => $reservationService->getActiveReservations()->where('student_id', '=', $user->id)->paginate(7)
        ];

        return view($viewName, $viewModel);
    }

    /**
     * Prikazi arhivirane rezervacije konkretnog ucenika
     *
     * @param  User $user
     * @param  ReservationService $reservationService
     */
    public function showStudentArchived(User $user, ReservationService $reservationService) {

        $viewName = $this->viewFolderStudent . '.studentArchived';

        $viewModel = [
            'user' => $user,
            'archivedReservations' => $reservationService->getArchivedReservations()->where('student_id', '=', $user->id)->paginate(7)
        ];

        return view($viewName, $viewModel);
    }
}
