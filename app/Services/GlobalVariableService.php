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
use Carbon\Carbon;
use Auth;

/*
|--------------------------------------------------------------------------
| GlobalVariableService
|--------------------------------------------------------------------------
|
| GlobalVariableService sadrzi sve globalne varijable
|
*/

class GlobalVariableService {

    /**
     * Vrati rok izdavanja
     *
     */
    public function getReturnDueDate() {

        $dueDate =  DB::table('global_variables')->where('id', '=', 1)->first();

        return $dueDate->value;
    }

    /**
     * Vrati rok rezervacije
     *
     */
    public function getReservationPeriod() {

        $period = DB::table('global_variables')->where('id', '=', 2)->first();

        return $period->value;
    }

    /**
     * Vrati rok prekoracenja
     *
     */
    public function getOverdraftPeriod() {
        
        $period = DB::table('global_variables')->where('id', '=', 3)->first();

        return $period->value;
    }

}
