@extends('layouts.layout')

@section('rentDetailsError')
    <div class="pl-[110px] section- mt-[35px]">
        <div class="flex items-center px-6 py-4 my-4 text-lg bg-red-200 rounded-lg">
            <svg viewBox="0 0 24 24" class="w-5 h-5 mr-3 text-red-600 sm:w-5 sm:h-5">
                <path fill="currentColor"
                      d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                </path>
            </svg>
            <p class="font-medium text-red-600"> Ne postoje informacije o izdavanju za knjigu {{$book->title}} i učenika {{$student->name}}! </p>
        </div>
    </div>

@endsection
