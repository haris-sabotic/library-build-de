<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Binding;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BindingService {
    
    /**
     * Vrati sve poveze iz baze podataka
     *
     */
    public function getBindings(){
        
        return $bindings = DB::table('bindings');
    }

    /**
     * Izvrsi validaciju podataka i edituj povez
     *
     * @param  Binding  $binding
     */
    public function editBinding($binding){

        //request all data, validate and update binding
        request()->validate([
          'bindingNameEdit' => 'string|max:256',
        ]);

        $binding->name = request('bindingNameEdit');

        $binding->save();

   }

    /**
     * Kreiraj novi povez i sacuvaj ga u bazi
     *
     */
    public function saveBinding(){
        
        //request all data, validate and update binding
        request()->validate([
            'bindingName'=>'required|string|max:256',
        ]);
        
        $binding = new Binding();
        
        $binding->name=request('bindingName');
        
        $binding->save();

    }

}