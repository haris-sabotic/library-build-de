<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Format;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FormatService {

    /**
     * Vrati sve formate iz baze podataka
     *
     */
    public function getFormats(){
        
        return $formats = DB::table('formats');
    }
       
    /**
     * Kreiraj novi format i sacuvaj ga u bazi
     *
     */
    public function saveFormat(){

        //request all data, validate and add format
        request()->validate([
            'formatName'=>'required|string|max:256',
        ]);

        $format = new Format();

        $format->name=request('formatName');

        $format->save();
    
    }

    /**
     * Izvrsi validaciju podataka i edituj format
     *
     * @param  Format $format
     */
    public function editFormat($format){

        //request all data, validate and update genre
        request()->validate([
            'formatNameEdit'=>'string|max:256',
        ]);

        $format->name=request('formatNameEdit');

        $format->save();
    
    }
    
}