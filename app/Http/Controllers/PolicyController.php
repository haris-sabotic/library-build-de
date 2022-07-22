<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GlobalVariable;

class PolicyController extends Controller
{

    private $viewFolder = 'pages/settings/policy';

    /**
     * Prikazi sve polise
     *
     */
    public function index() {

        $viewName = $this->viewFolder . '.policy';

        $viewModel=[
            'returnDueDate' => GlobalVariable::find(1),
            'reservationPeriod' => GlobalVariable::find(2),
            'overdraftPeriod' => GlobalVariable::find(3)
        ];

        return view($viewName, $viewModel);
    }

    public function changeDeadline(){

         //request all data, validate and update RESERVATION_PERIOD, OVERDRAFT_PERIOD, RETURN_DUE_DATE
         request()->validate([
            'reservationPeriod' => 'numeric|nullable|max:256',
            'returnDueDate' => 'numeric|nullable|max:256',
            'overdraftPeriod' => 'numeric|nullable|max:256',
        ]);

        $returnDueDate = GlobalVariable::find(1);
        $reservationPeriod = GlobalVariable::find(2);
        $overdraftPeriod = GlobalVariable::find(3);

        if(request('returnDueDate')) {
            $returnDueDate->value = request('returnDueDate');
        }

        if(request('reservationPeriod')) {
            $reservationPeriod->value = request('reservationPeriod');
        }

        if(request('overdraftPeriod')) {
            $overdraftPeriod->value = request('overdraftPeriod');
        }

        $returnDueDate->save();
        $reservationPeriod->save();
        $overdraftPeriod->save();

        return back()->with('success', 'Rok je uspješno izmijenjen!');
    }

}
