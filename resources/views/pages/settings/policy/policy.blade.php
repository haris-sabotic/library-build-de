@extends('layouts.layout')

@section('policy')
    @can('isAdmin')
        <section class="w-screen h-screen pl-[80px] py-4 text-gray-700">
            <!-- Heading of content -->
            <div class="heading mt-[7px]">
                <div class="border-b-[1px] border-[#e4dfdf]">
                    <div class="pl-[30px] pb-[21px]">
                        <h1>
                            Podešavanja
                        </h1>
                    </div>
                </div>
                @if(Session::has('success'))
                    <div class="fadeInOut absolute top-[91px] py-[15px] px-[30px] rounded-[15px] text-white bg-[#4CAF50] right-[20px] fadeIn">
                        <i class="fa fa-check mr-[5px]" aria-hidden="true"></i> {{ Session::get('success') }}
                        @php
                            Session::forget('success');
                        @endphp
                    </div>
                @endif
            </div>
            <div class="py-4 text-gray-500 border-b-[1px] border-[#e4dfdf] pl-[30px]">
                <a href="{{route('policy')}}" class="inline hover:text-blue-800 active-book-nav">
                    Polisa
                </a>
                <a href="{{route('categories')}}" class="inline ml-[70px] hover:text-blue-800">
                    Kategorija
                </a>
                <a href="{{route('genres')}}" class="inline ml-[70px] hover:text-blue-800">
                    Žanr
                </a>
                <a href="{{route('publishers')}}" class="inline ml-[70px] hover:text-blue-800">
                    Izdavač
                </a>
                <a href="{{route('bindings')}}" class="inline ml-[70px] hover:text-blue-800">
                    Povez
                </a>
                <a href="{{route('formats')}}" class="inline ml-[70px] hover:text-blue-800">
                    Format
                </a>
                <a href="{{route('scripts')}}" class="inline ml-[70px] hover:text-blue-800">
                    Pismo
                </a>
            </div>
            <div class="height-studentProfile pb-[30px] scroll">
                <!-- Space for content -->
                <div class="section- mt-[20px]">
                    <div class="flex flex-col">
                        <div class="pl-[30px] flex border-b-[1px] border-[#e4dfdf]  pb-[20px]">
                            <div>
                                <h3>
                                    Rok za rezervaciju
                                </h3>
                                <p class="pt-[15px] max-w-[400px]">
                                    Ovdje se definiše rok za rezervaciju u danima. Po isteku tog roka, rezervacija ističe i dobija status zatvaranja 'Rezervacija istekla'.
                                </p>
                                <p class="pt-[15px] max-w-[400px]">
                                    Trenutni rok: {{$reservationPeriod->value}} dana
                                </p>
                            </div>
                            <div class="relative flex ml-[60px] mt-[20px]">
                                <form action="{{route('changeDeadline')}}" method="POST">
                                @csrf
                                    <div class="flex items-center w-[245px]">
                                        <input type="text" name="reservationPeriod"
                                            class="h-[50px] flex-1 w-full px-4 py-2 text-sm text-gray-700 placeholder-gray-400 bg-white border-[1px]  border-[#e4dfdf]  rounded-lg shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                            placeholder="{{$reservationPeriod->value}}" />
                                        <p class="ml-[10px]">dana</p>
                                    </div>
                                    @error('reservationPeriod')
                                    <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>
                        <div class="pl-[30px] flex border-b-[1px] border-[#e4dfdf]  py-[20px]">
                            <div>
                                <h3>
                                    Rok pozajmljivanja
                                </h3>
                                <p class="pt-[15px] max-w-[400px]">
                                    Ovdje se definiše rok za vraćanje u danima. Po isteku tog roka + rok prekoračenja, izdata knjiga ulazi u prekoračenje i moguće je otpisati primjerak.
                                </p>
                                <p class="pt-[15px] max-w-[400px]">
                                    Trenutni rok: {{$returnDueDate->value}} dana
                                </p>
                            </div>
                            <div class="relative flex flex-col ml-[60px] mt-[20px]">
                                    <div class="flex items-center w-[245px]">
                                        <input type="text" name="returnDueDate"
                                            class="h-[50px] flex-1 w-full px-4 py-2 text-sm text-gray-700 placeholder-gray-400 bg-white border-[1px]  border-[#e4dfdf]  rounded-lg shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                            placeholder="{{$returnDueDate->value}}" />
                                        <p class="ml-[10px]">dana</p>
                                    </div>
                                    @error('returnDueDate')
                                    <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>
                        <div class="pl-[30px] flex border-b-[1px] border-[#e4dfdf]  py-[20px]">
                            <div>
                                <h3>
                                    Rok prekoračenja
                                </h3>
                                <p class="pt-[15px] max-w-[400px]">
                                    Ovdje se definiše rok za prekoračenje u danima. Nakon isteka roka za vraćanje student može vratiti knjigu u roku prekoračenja, nakon čega izdati primjerak ulazi u knjige u prekoračenju.
                                </p>
                                <p class="pt-[15px] max-w-[400px]">
                                    Trenutni rok: {{$overdraftPeriod->value}} dana
                                </p>
                            </div>
                            <div class="relative flex flex-col ml-[60px] mt-[20px]">
                                    <div class="flex items-center w-[245px]">
                                        <input type="text" name="overdraftPeriod"
                                            class="h-[50px] flex-1 w-full px-4 py-2 text-sm text-gray-700 placeholder-gray-400 bg-white border-[1px]  border-[#e4dfdf]  rounded-lg shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                                            placeholder="{{$overdraftPeriod->value}}" />
                                        <p class="ml-[10px]">dana</p>
                                    </div>
                                    @error('overdraftPeriod')
                                    <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>
                        <div class="py-[20px] pl-[30px]">
                            <button class="btn-animation mt-[10px] text-white shadow-lg w-[150px] disabled:opacity-50 focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] hover:bg-[#46A149] bg-[#4CAF50]">
                            <i class="fas fa-check mr-[7px]"></i> Sačuvaj
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @elsecan('isLibrarian', 'isStudent')
        <div class="pl-[110px] section- mt-[35px]">
            <div class="flex items-center px-6 py-4 my-4 text-lg bg-red-200 rounded-lg">
                <svg viewBox="0 0 24 24" class="w-5 h-5 mr-3 text-red-600 sm:w-5 sm:h-5">
                    <path fill="currentColor"
                          d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                    </path>
                </svg>
                <p class="font-medium text-red-600"> Niste autorizovani da otvorite ovu stranicu! </p>
            </div>
        </div>
    @endcan
@endsection
