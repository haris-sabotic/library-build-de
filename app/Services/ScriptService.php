<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Script;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ScriptService {
    
    /**
     * Vrati sva pisma iz baze podataka
     *
     */
    public function getScripts(){
        
        return $scripts = DB::table('scripts');
    }

    /**
     * Izvrsi validaciju podataka i edituj pismo
     *
     * @param  Script $script
     */
    public function editScript($script){

        //request all data, validate and update script
        request()->validate([
            'scriptNameEdit' => 'string|max:256',
        ]);

        $script->name = request('scriptNameEdit');

        $script->save();
   }

   /**
     * Kreiraj novo pismo i sacuvaj ga u bazi
     *
     */
    public function saveScript(){

        //request all data, validate and update script
        request()->validate([
            'scriptName'=>'required|string|max:256',
        ]);

        $script = new Script();

        $script->name=request('scriptName');

        $script->save();
    }

}