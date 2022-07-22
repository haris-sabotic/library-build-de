<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| UserService
|--------------------------------------------------------------------------
|
| UserService je odgovaran za svu logiku koja se desava
| unutar UserControllera. Ovdje je moguce definisati sve
| pomocne metode koji su potrebne.
|
*/

class UserService {

    /**
     * Vrati sve bibliotekare iz baze podataka
     *
     */
    public function getLibrarians() {

        return $librarians = User::with('userType')
                            ->where('userType_id', '=', 2);
    }

    /**
     * Izvrsi validaciju podataka i edituj bibliotekara
     *
     * @param  User  $bibliotekar
     */
    public function editLibrarian($librarian, $request) {

        //request all data, validate and update librarian
        request()->validate([
            'librarianNameEdit'       => 'nullable|string|max:128|regex:/^([^0-9]*)$/',
            'librarianJmbgEdit'       => 'nullable|digits:14|unique:users,jmbg',
            'librarianEmailEdit'      => 'nullable|string|unique:users,email|max:128',
            'librarianUsernameEdit'   => 'nullable|string|max:64',
            'librarianPasswordEdit'   => 'nullable|max:256|min:8|same:librarianPassword2Edit',
            'librarianPassword2Edit'  => 'nullable|max:256|min:8|same:librarianPasswordEdit',
            'userImage'               => 'nullable|mimes:jpeg,png,jpg'
        ]);

        if(request('librarianNameEdit')) {
            $librarian->name     = request('librarianNameEdit');
        }
        if(request('librarianJmbgEdit')) {
            $librarian->jmbg     = request('librarianJmbgEdit');
        }
        if(request('librarianEmailEdit')) {
            $librarian->email    = request('librarianEmailEdit');
        }
        if(request('librarianUsernameEdit')) {
            $librarian->username = request('librarianUsernameEdit');
        }

        $this->uploadEditPhoto($librarian, $request);

        if(request('librarianPasswordEdit')) {
            $password = request('librarianPasswordEdit');
            $librarian->password=Hash::make($password);
        }

        $librarian->save();
    }

    /**
     * Kreiraj novog bibliotekara i sacuvaj ga u bazu
     *
     */
    public function saveLibrarian($request) {

        //request all data, validate and add librarian
        request()->validate([
            'librarianName'       => 'required|max:128|regex:/^([^0-9]*)$/',
            'librarianJmbg'       => 'required|digits:14|unique:users,jmbg',
            'librarianEmail'      => 'required|string|unique:users,email|max:128',
            'librarianUsername'   => 'required|string|max:64',
            'librarianPassword'   => 'required|max:256|min:8|same:librarianPassword2',
            'librarianPassword2'  => 'required|max:256|min:8|same:librarianPassword',
            'userImage'           => 'nullable|mimes:jpeg,png,jpg'
        ]);

        $librarian = new User();

        $librarian->userType_id = 2;

        $librarian->name              = request('librarianName');
        $librarian->jmbg              = request('librarianJmbg');
        $librarian->email_verified_at = now();
        $librarian->email             = request('librarianEmail');
        $librarian->username          = request('librarianUsername');
        $librarian->remember_token    = Str::random(10);

        $this->uploadPhoto($librarian, $request);

        $password = request('librarianPassword');
        $passwordRepeat = request('librarianPassword2');

        $librarian->password=Hash::make($password);

        $librarian->save();

        return $librarian;
    }

    /**
     * Vrati pretrazene bibliotekare
     *
     */
    public function searchLibrarians() {

        $librarians = User::query();

        $librarians = $this->getLibrarians();

        if(request('searchLibrarians')) {
            $searchedLibrarians = request('searchLibrarians');
            $librarians = $librarians->where('name', 'LIKE', '%'.$searchedLibrarians.'%');
        }

        $librarians = $librarians->paginate(7);

        return $librarians;
    }

    /**
     * Uploaduj sliku ili postavi default sliku
     *
     * @param User $user
     * @param Request $request
     */
    public function uploadPhoto($user, $request) {

        if ($request->hasFile('userImage')) {
            $this->uploadEditPhoto($user, $request);
        } else {
            $user->photo = 'default.jpg';
        }
    }

    /**
     * Upload/edit slike
     *
     * @param User $user
     * @param Request $request
     */
    public function uploadEditPhoto($user, $request) {

        if ($request->hasFile('userImage')) {
            $filenameWithExt = $request->file('userImage')->getClientOriginalName();
            // Get Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just Extension
            $extension = $request->file('userImage')->getClientOriginalExtension();
            // Filename To store
            $fileNameToStore = $filename. '_'. time().'.'.$extension;
            // Upload Image
            $path = $request->file('userImage')->storeAs('public/image', $fileNameToStore);

            $user->photo = $fileNameToStore;
        }
    }

    /**
     * Vrati sve ucenike iz baze podataka
     *
     */
    public function getStudents() {

        return $students = User::with('userType')
                        ->where('userType_id', '=', 3);
    }

    /**
     * Izvrsi validaciju podataka i edituj ucenika
     *
     * @param  User  $student
     */
    public function editStudent($student, $request) {

        //request all data, validate and update student
        request()->validate([
            'studentNameEdit'      => 'nullable|string|max:128|regex:/^([^0-9]*)$/',
            'studentJmbgEdit'      => 'nullable|digits:14|unique:users,jmbg',
            'studentEmailEdit'     => 'nullable|string|unique:users,email|max:128',
            'studentUsernameEdit'  => 'nullable|string|max:64',
            'studentPasswordEdit'  => 'nullable|max:256|min:8|same:studentPassword2Edit',
            'studentPassword2Edit' => 'nullable|max:256|min:8|same:studentPasswordEdit',
            'userImage'            => 'nullable|mimes:jpeg,png,jpg'
        ]);

        if(request('studentNameEdit')) {
            $student->name = request('studentNameEdit');
        }
        if(request('studentJmbgEdit')) {
            $student->jmbg = request('studentJmbgEdit');
        }
        if(request('studentEmailEdit')) {
            $student->email = request('studentEmailEdit');
        }
        if(request('studentUsernameEdit')) {
            $student->username = request('studentUsernameEdit');
        }

        $this->uploadEditPhoto($student, $request);

        if(request('studentPasswordEdit')) {
            $password = request('studentPasswordEdit');
            $student->password=Hash::make($password);
        }

        $student->save();
    }

    /**
     * Kreiraj novog ucenika i sacuvaj ga u bazu
     *
     */
    public function saveStudent($request) {

        //request all data, validate and update student
        request()->validate([
            'studentName'       => 'required|string|max:128|regex:/^([^0-9]*)$/',
            'studentJmbg'       => 'required|digits:14|unique:users,jmbg',
            'studentEmail'      => 'required|string|unique:users,email|max:128',
            'studentUsername'   => 'required|string|max:64',
            'studentPassword'   => 'required|max:256|min:8|same:studentPassword2',
            'studentPassword2'  => 'required|max:256|min:8|same:studentPassword',
            'userImage'         => 'nullable|mimes:jpeg,png,jpg'
        ]);

        $student = new User();

        $student->userType_id = 3;

        $student->name              = request('studentName');
        $student->jmbg              = request('studentJmbg');
        $student->email_verified_at = now();
        $student->email             = request('studentEmail');
        $student->username          = request('studentUsername');
        $student->remember_token    = Str::random(10);

        $this->uploadPhoto($student, $request);

        $password = request('studentPassword');
        $passwordRepeat = request('studentPassword2');

        $student->password=Hash::make($password);

        $student->save();

        return $student;
    }

    /**
     * Vrati pretrazene ucenike
     *
     */
    public function searchStudents() {

        $students = User::query();

        $students = $this->getStudents();

        if(request('searchStudents')) {
            $searchedStudents = request('searchStudents');
            $students = $students->where('name', 'LIKE', '%'.$searchedStudents.'%');
        }

        $students = $students->paginate(7);

        return $students;
    }

    /**
     * Resetuj sifru korisnika
     *
     * @param  User  $user
     */
    public function resetPassword($user) {
        
        //request all data, validate and reset password
        request()->validate([
            'pwReset'  => 'required|min:8|max:256|same:pw2Reset',
            'pw2Reset' => 'required|min:8|max:256|same:pwReset',
        ]);

        $password = request('pwReset');
        $passwordRepeat = request('pw2Reset');

        $user->password=Hash::make($password);

        $user->save();
    }

}
