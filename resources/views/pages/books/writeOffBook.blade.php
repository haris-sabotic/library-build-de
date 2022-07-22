@extends('layouts.layout')

@section('writeOffBook')
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
                                {{$book->title}}
                                </h1>
                            </div>
                            <div>
                                <nav class="w-full rounded">
                                    <ol class="flex list-reset">
                                        <li>
                                            <a href="../bookRecords" class="text-[#2196f3] hover:text-blue-600">
                                                Evidencija knjiga
                                            </a>
                                        </li>
                                        <li>
                                            <span class="mx-2">/</span>
                                        </li>
                                        <li>
                                            <a href="{{route('bookDetails', ['book' => $book->id])}}"
                                                class="text-[#2196f3] hover:text-blue-600">
                                                KNJIGA-{{$book->id}}
                                            </a>
                                        </li>
                                        <li>
                                            <span class="mx-2">/</span>
                                        </li>
                                        <li>
                                            <a href="#" class="text-gray-400 hover:text-blue-600">
                                                Otpiši knjigu
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
                        <a href="{{route('rentBook', ['book' => $book->id])}}" class="inline hover:text-blue-600 ml-[20px] pr-[10px]">
                            <i class="far fa-hand-scissors mr-[3px]"></i>
                            Izdaj knjigu
                        </a>
                        <a href="{{route('returnBook', ['book' => $book->id])}}" class="hover:text-blue-600 inline ml-[20px] pr-[10px]">
                            <i class="fas fa-redo-alt mr-[3px] "></i>
                            Vrati knjigu
                        </a>
                        <a href="{{route('reserveBook', ['book' => $book->id])}}" class="hover:text-blue-600 inline ml-[20px] pr-[10px]">
                            <i class="far fa-calendar-check mr-[3px] "></i>
                            Rezerviši knjigu
                        </a>
                        <p class="inline cursor-pointer text-[25px] py-[10px] pl-[30px] border-l-[1px] border-[#e4dfdf] dotsWriteOffBook hover:text-[#606FC7]">
                            <i
                                class="fas fa-ellipsis-v"></i>
                        </p>
                        <div
                            class="relative z-10 hidden transition-all duration-300 origin-top-right transform scale-95 -translate-y-2 dropdown-writeoff-book">
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
                @if(Session::has('success'))
                    <div class="fadeInOut absolute top-[91px] py-[15px] px-[30px] rounded-[15px] text-white bg-[#4CAF50] right-[20px] fadeIn">
                        <i class="fa fa-check mr-[5px]" aria-hidden="true"></i> {{ Session::get('success') }}
                        @php
                            Session::forget('success');
                        @endphp
                    </div>
                @endif
            </div>
            @if(count($overdueBooks) > 0)
                    <div class="scroll height-dashboard px-[30px]">
                    <div class="flex items-center justify-between py-4 pt-[20px] space-x-3 rounded-lg">
                        <h3>
                            Otpiši knjigu
                        </h3>
                        <form action="{{ route('searchWriteOff', ['book' => $book->id]) }}" method="GET">
                                <div class="flex items-center pl-6 py-4 space-x-3 rounded-lg ml-[292px]">
                                    <div class="flex items-center">
                                        <div class="relative text-gray-600 focus-within:text-gray-400">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                                                <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
                                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6">
                                                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </button>
                                            </span>
                                            <input type="search" name="searchWriteOff"
                                                class="py-2 pl-10 border-[#e4dfdf] text-sm text-white border-[1px] bg-white rounded-md focus:outline-none focus:bg-white focus:text-gray-900"
                                                placeholder="Pretraži učenike..." autocomplete="off">
                                        </div>
                                    </div>
                                    <button name="buttonSearchWriteOff"
                                        class="btn-animation inline-flex items-center text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] tracking-wider text-white bg-[#3f51b5] hover:bg-[#4558BE]">Pretraži
                                    </button>
                                </div>
                        </form>
                    </div>
                <form action="{{route('writeOffBooks')}}" method="GET">
                    <div
                        class="inline-block min-w-full pt-3 align-middle bg-white rounded-bl-lg rounded-br-lg shadow-dashboard">
                        <table class="min-w-full shadow-lg">
                            <thead class="bg-[#EFF3F6]">
                                <tr class="border-b-[1px] border-[#e4dfdf]">
                                    <th class="px-2 py-4 leading-4 tracking-wider text-left text-blue-500 xl:px-4">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="select-all form-checkbox">
                                        </label>
                                    </th>
                                    <th class="px-2 py-4 text-xs leading-4 tracking-wider text-left xl:px-4 whitespace-nowrap 2xl:text-sm">
                                        Izdato učeniku
                                    </th>
                                    <th class="px-2 py-4 text-xs leading-4 tracking-wider text-left xl:px-4 whitespace-nowrap 2xl:text-sm">
                                        Datum izdavanja
                                    </th>
                                    <th class="px-2 py-4 text-xs leading-4 tracking-wider text-left xl:px-4 whitespace-nowrap 2xl:text-sm">
                                        Trenutno zadržavanje knjige
                                    </th>
                                    <th class="px-2 py-4 text-xs leading-4 tracking-wider text-left xl:px-4 whitespace-nowrap 2xl:text-sm">
                                        Prekoračenje u danima
                                    </th>
                                    <th class="px-2 py-4 text-xs leading-4 tracking-wider text-left xl:px-4 whitespace-nowrap 2xl:text-sm">
                                        Knjigu izdao
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($overdueBooks as $overdueBook)
                                <tr class="hover:bg-gray-200 hover:shadow-md border-b-[1px] border-[#e4dfdf]">
                                    <td class="px-2 py-4 xl:px-4">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="form-checkbox" name="writeOffBook[]" value="{{$overdueBook->id}}">
                                        </label>
                                    </td>
                                    <td class="flex flex-row items-center px-2 py-4 xl:px-4 whitespace-nowrap">
                                        <img class="object-cover w-8 h-10 mr-2 rounded-full" src="/storage/image/{{$overdueBook->student->photo}}"
                                            alt="" />
                                        <a href="{{route('studentProfile', ['user' => $overdueBook->student])}}">
                                            <span class="text-xs font-medium text-center 2xl:text-sm">{{$overdueBook->student->name}}</span>
                                        </a>
                                    </td>
                                    <td class="px-2 py-4 text-xs leading-5 2xl:text-sm xl:px-4 whitespace-nowrap">{{$overdueBook->rent_date}}</td>
                                    <td class="px-2 py-4 text-xs leading-5 2xl:text-sm xl:px-4 truncate max-w-[150px] xl:max-w-full">{{ \Carbon\Carbon::parse($overdueBook->rent_date)->diffAsCarbonInterval() }}</td>
                                    <td class="px-2 py-4 leading-5 xl:px-4 whitespace-nowrap">
                                        <span class="px-[6px] py-[2px] bg-red-200 text-red-800 rounded-[10px] text-xs 2xl:text-sm">
                                            {{ \Carbon\Carbon::parse($overdueBook->return_date)->diffInDays(\Carbon\Carbon::now()) }} dan/a
                                        </span>
                                    </td>
                                    <td class="px-2 py-4 text-xs leading-5 2xl:text-sm xl:px-4 whitespace-nowrap">{{$overdueBook->librarian->name}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="pt-[20px]">
                            {{$overdueBooks->links()}}
                        </div>

                    </div>
                    </div>
                    <div class="absolute bottom-0 w-full">
                    <div class="flex flex-row">
                        <div class="inline-block w-full text-right py-[7px] mr-[100px] text-white">
                            <button type="reset"
                                class="btn-animation shadow-lg mr-[15px] w-[150px] focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                <i class="fas fa-times mr-[7px]"></i> Poništi
                            </button>
                            <button type="submit"
                                class="btn-animation disabled-btn shadow-lg w-[150px] disabled:opacity-50 focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] hover:bg-[#46A149] bg-[#4CAF50]"
                                disabled>
                                <i class="fas fa-check mr-[7px]"></i> Otpiši knjigu 
                            </button>
                        </div>
                    </div>
                    </div>
                </form>
            @elseif(count($overdueBooks) == 0 && isset($_GET['buttonSearchWriteOff']))
                <div class="w-[320px] mx-[20px] flex items-center px-6 py-4 my-4 text-lg bg-red-200 rounded-lg">
                    <svg viewBox="0 0 24 24" class="w-5 h-5 mr-3 text-red-600 sm:w-5 sm:h-5">
                        <path fill="currentColor"
                                d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                        </path>
                    </svg>
                    <p class="font-medium text-red-600"> Ne postoje traženi rezultati! </p>
                </div>
            @else
                <div class="w-[380px] mx-[20px] flex items-center px-6 py-4 my-4 text-lg bg-red-200 rounded-lg">
                    <svg viewBox="0 0 24 24" class="w-5 h-5 mr-3 text-red-600 sm:w-5 sm:h-5">
                        <path fill="currentColor"
                                d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                        </path>
                    </svg>
                    <p class="font-medium text-red-600"> Nijedan primjerak knjige nije u prekoračenju! </p>
                </div>
            @endif
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
        </section>
        @endsection
