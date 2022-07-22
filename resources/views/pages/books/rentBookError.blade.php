@extends('layouts.layout')

@section('rentBookError')

<section class="w-screen h-screen pl-[80px] pb-2 text-gray-700">
            <!-- Heading of content -->
            <div class="heading">
                <div class="flex flex-row justify-between border-b-[1px] border-[#e4dfdf]">
                    <div class="py-[10px] flex flex-row">
                        <div class="w-[77px] h-[72px] pl-[30px] flex items-center">
                            @if(count($book->coverImage) > 0 ) 
                                <img src="/storage/image/{{$book->coverImage[0]->photo}}" alt="">
                            @endif
                        </div>
                        <div class="pl-[15px]  flex flex-col">
                            <div>
                                <h1>
                                    {{$book -> title}}
                                </h1>
                            </div>
                            <div>
                                <nav class="w-full rounded">
                                    <ol class="flex list-reset">
                                        <li>
                                            <a href="{{route('bookRecords')}}" class="text-[#2196f3] hover:text-blue-600">
                                                Evidencija knjiga
                                            </a>
                                        </li>
                                        <li>
                                            <span class="mx-2">/</span>
                                        </li>
                                        <li>
                                            <a href="{{route('bookDetails', ['book' => $book])}}"
                                                class="text-[#2196f3] hover:text-blue-600">
                                                KNJIGA-{{$book -> id}}
                                            </a>
                                        </li>
                                        <li>
                                            <span class="mx-2">/</span>
                                        </li>
                                        <li>
                                            <a href="#" class="text-gray-400 hover:text-blue-600">
                                                Greška
                                            </a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="pt-[24px] mr-[30px]">
                        <a href="{{route('writeOffBook', ['book' => $book->id])}}" class="inline hover:text-blue-600">
                            <i class="fas fa-level-up-alt mr-[3px]"></i>
                            Otpiši knjigu
                        </a>
                        <a href="#" class="inline hover:text-blue-600 ml-[20px] pr-[10px]">
                            <i class="far fa-hand-scissors mr-[3px]"></i>
                            Izdaj knjigu
                        </a>
                        <a href="{{route('returnBook', ['book' => $book->id])}}" class="hover:text-blue-600 inline ml-[20px] pr-[10px]">
                            <i class="fas fa-redo-alt mr-[3px] "></i>
                            Vrati knjigu
                        </a>
                        <a href="{{route('reserveBook', ['book' => $book])}}" class="hover:text-blue-600 inline ml-[20px] pr-[10px]">
                            <i class="far fa-calendar-check mr-[3px] "></i>
                            Rezerviši knjigu
                        </a>
                        <p class="inline cursor-pointer text-[25px] py-[10px] pl-[30px] border-l-[1px] border-[#e4dfdf] dotsRentBookError hover:text-[#606FC7]">
                            <i
                                class="fas fa-ellipsis-v"></i>
                        </p>
                        <div
                            class="relative z-10 hidden transition-all duration-300 origin-top-right transform scale-95 -translate-y-2 dropdown-rent-book-error">
                            <div class="absolute right-0 w-56 mt-[7px] origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none"
                                aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
                                <div class="py-1">
                                    <a href="{{route('editBook', ['book' => $book->id])}}" tabindex="0"
                                        class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                        role="menuitem">
                                        <i class="fas fa-edit mr-[1px] ml-[5px] py-1"></i>
                                        <span class="px-4 py-0">Izmijeni knjigu</span>
                                    </a>
                                    <a href="#" tabindex="0" id="{{$book->id}}"
                                        class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600 show-deleteModal"
                                        role="menuitem">
                                        <i class="fa fa-trash mr-[5px] ml-[5px] py-1"></i>
                                        <span class="px-4 py-0">Izbriši knjigu</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-row overflow-auto scroll height-studentProfile">
                <div class="">
                    <!-- Space for content -->
                    <div class="pl-[30px] section- mt-[20px]">
                        <div class="flex flex-row justify-between">
                            <div class="mr-[30px]">
                                <!-- Alert Error -->
                                <div class="flex items-center px-6 py-4 my-4 text-lg bg-red-200 rounded-lg">
                                    <svg viewBox="0 0 24 24" class="w-5 h-5 mr-3 text-red-600 sm:w-5 sm:h-5">
                                        <path fill="currentColor"
                                            d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                                        </path>
                                    </svg>
                                    <p class="font-medium text-red-600"> Sve knjige su izdate ili rezervisane </p>
                                </div>
                                <!-- End Alert Error -->
                                <div class="px-6 py-4 bg-gray-200 rounded-lg">
                                    <p class="font-medium">
                                        Da bi izdali knjigu korisnik koji ju je zadužio prvo mora vratiti. U nastavku su
                                        detalji o poslednjem izdavanju.
                                    </p>
                                    <div class="mt-[20px] flex-row flex">
                                        <div class="flex flex-col text-gray-500">
                                            <span class="mt-[20px]">Na raspolaganju:</span>
                                            <span class="mt-[20px]">Rezervisano:</span>
                                            <span class="mt-[20px]">Izdato:</span>
                                            <span class="mt-[20px]">U prekoračenju:</span>
                                            <span class="mt-[20px]">Ukupna količina:</span>
                                        </div>
                                        <div class="flex flex-col text-center ml-[30px]">
                                            <p
                                                class="mt-[20px] block ml-[30px] bg-green-200 text-green-800 rounded-[10px] px-[6px] py-[2px]">
                                                {{$book -> quantity- $book->reservedBooks - $book->rentedBooks}} primjeraka
                                            </p>
                                            <a href="{{route('rentingActive', ['book' => $book])}}"
                                                class="mt-[19px] block ml-[30px] bg-yellow-200 text-yellow-700 rounded-[10px] px-[6px] py-[2px]">
                                                {{$book -> reservedBooks}} primjeraka
                                            </a>
                                            <a href="{{route('rentingRented', ['book' => $book])}}"
                                                class="mt-[19px] block ml-[30px] bg-blue-200 text-blue-800 rounded-[10px] px-[6px] py-[2px]">
                                                {{$book -> rentedBooks}} primjeraka
                                            </a>
                                            <a href="{{route('rentingOverdue', ['book' => $book])}}"
                                                class="mt-[19px] block ml-[30px] bg-red-200 text-red-800 rounded-[10px] px-[6px] py-[2px]">
                                                {{count($overdueBooks)}} primjeraka
                                            </a>
                                            <p
                                                class="mt-[19px] block ml-[30px] bg-purple-200 text-purple-700 rounded-[10px] px-[6px] py-[2px]">
                                                {{$book -> quantity}} primjeraka
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Modal-->
                    <div
                        class="absolute z-20 top-0 left-0 items-center justify-center hidden w-full h-screen bg-black bg-opacity-10 delete-modal_{{$book->id}}" id="{{$book->id}}">
                        <!-- Modal -->
                        <div class="w-[500px] bg-white rounded shadow-lg md:w-1/3">
                            <!-- Modal Header -->
                            <div class="flex items-center justify-between px-[30px] py-[20px] border-b">
                                <h3>Da li ste sigurni da želite da izbrišete knjigu?</h3>
                                <button class="text-black close cancel focus:outline-none" id="{{$book->id}}">
                                    <span aria-hidden="true" class="text-[30px]">&times;</span>
                                </button>
                            </div>
                            <!-- Modal Body -->
                            <div class="flex items-center justify-center px-[30px] py-[20px] border-t w-100 text-white">
                                <a href="{{route('deleteBook', ['book' => $book->id])}}"
                                    class=" text-center shadow-lg mr-[15px] w-[150px] focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                    <i class="fas fa-check mr-[7px]"></i> Izbriši
                                </a>
                                <a href="#" id="{{$book->id}}" class="cancel shadow-lg w-[150px] focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] bg-[#F44336] hover:bg-[#F55549] text-center">
                                <i class="fas fa-times mr-[7px]"></i> Poništi 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection