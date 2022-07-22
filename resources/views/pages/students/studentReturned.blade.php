@extends('layouts.layout')

@section('studentReturned')
<section class="w-screen h-screen pl-[80px] pb-4 text-gray-700">
            <!-- Heading of content -->
            <div class="heading">
                <div class="flex flex-row justify-between border-b-[1px] border-[#e4dfdf]">
                    <div class="pl-[30px] py-[10px] flex flex-col">
                        <div>
                            <h1>
                            {{$user->name}}
                            </h1>
                        </div>
                        <div>
                            <nav class="w-full rounded">
                                <ol class="flex list-reset">
                                    <li>
                                        <a href="../students" class="text-[#2196f3] hover:text-blue-600">
                                            Svi učenici
                                        </a>
                                    </li>
                                    <li>
                                        <span class="mx-2">/</span>
                                    </li>
                                    <li>
                                        <a href="{{ route('studentProfile', ['user' => $user->id]) }}" class="text-gray-400 hover:text-blue-600">
                                            ID-{{$user->id}}
                                        </a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="pt-[24px] pr-[30px]">
                        @can('isMyAccount', $user)
                            <a href="#" class="inline hover:text-blue-600 show-modal">
                                <i class="fas fa-redo-alt mr-[3px]"></i>
                                Resetuj šifru
                            </a>
                        @endcan
                        <a href="{{ route('editStudent', ['user' => $user->id]) }}" class="hover:text-blue-600 inline ml-[20px] pr-[10px]">
                            <i class="fas fa-edit mr-[3px] "></i>
                            Izmijeni podatke
                        </a>
                        <p
                            class="inline cursor-pointer text-[25px] py-[10px] pl-[30px] border-l-[1px] border-gray-300 dotsStudentReturnedBooks hover:text-[#606FC7]">
                            <i class="fas fa-ellipsis-v"></i>
                        </p>
                        <div
                            class="z-10 hidden transition-all duration-300 origin-top-right transform scale-95 -translate-y-2 student-returned-books">
                            <div class="absolute right-0 w-56 mt-[10px] origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none"
                                aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
                                <div class="py-1">
                                    <a href="#" tabindex="0" id="{{$user->id}}"
                                        class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600 show-deleteModal"
                                        role="menuitem">
                                        <i class="fa fa-trash mr-[5px] ml-[5px] py-1"></i>
                                        <span class="px-4 py-0">Izbriši korisnika</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-b-[1px] py-4 text-gray-500 border-[#e4dfdf] pl-[30px]">
                <a href="{{ route('studentProfile', ['user' => $user->id]) }}" class="inline hover:text-blue-800">
                    Osnovni detalji
                </a>
                <a href="{{route('studentRented',['user'=> $user->id])}}" class="inline ml-[70px] active-book-nav">
                    Evidencija iznajmljivanja
                </a>
            </div>
            <!-- Space for content -->
            <div class="flex flex-col justify-start pt-3 bg-white xl:flex-row height-studentRented scroll">
                <div class="mt-[10px]">
                    <ul class="text-[#2D3B48] flex xl:block">
                        <li class="mb-[4px]">
                            <div class="w-[170px] xl:w-[210px] 2xl:w-[300px] pl-4 2xl:pl-[32px]">
                                <span class=" whitespace-nowrap w-full text-[25px]  flex justify-between fill-current">
                                    <div
                                        class="py-[15px] px-[10px] 2xl:px-[20px] w-[170px] xl:w-[190px] 2xl:w-[268px] cursor-pointer group hover:bg-[#EFF3F6] rounded-[10px]">
                                        <a href="{{route('studentRented', ['user' => $user])}}" aria-label="Sve knjige" class="flex items-center">
                                            <i
                                                class="text-[#707070] transition duration-300 ease-in group-hover:text-[#576cdf] far fa-copy text-[20px]"></i>
                                            <div>
                                                <p
                                                    class="transition duration-300 ease-in group-hover:text-[#576cdf]  text-xs 2xl:text-[15px] ml-[18px]">
                                                    Izdate knjige
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </span>
                            </div>
                        </li>
                        <li class="mb-[4px]">
                            <div class="w-[170px] xl:w-[210px] 2xl:w-[300px] pl-2 xl:pl-4 2xl:pl-[32px]">
                                <span class=" whitespace-nowrap w-full text-[25px] flex justify-between fill-current">
                                    <div
                                        class="group bg-[#EFF3F6] hover:bg-[#EFF3F6] py-[15px] px-[10px] 2xl:px-[20px] w-[170px] xl:w-[190px] 2xl:w-[268px] rounded-[10px] cursor-pointer">
                                        <a href="{{route('studentReturned', ['user' => $user])}}" aria-label="Vracene knjige"
                                            class="flex items-center">
                                            <i
                                                class="transition duration-300 ease-in text-[20px] fas fa-file text-[#576cdf]"></i>
                                            <div>
                                                <p
                                                    class="transition duration-300 ease-in  text-xs 2xl:text-[15px] ml-[21px] text-[#576cdf]">
                                                    Vraćene knjige
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </span>
                            </div>
                        </li>
                        <li class="mb-[4px]">
                            <div class="w-[190px] xl:w-[210px] 2xl:w-[300px] pl-2 xl:pl-4 2xl:pl-[32px]">
                                <span class=" whitespace-nowrap w-full text-[25px] flex justify-between fill-current">
                                    <div
                                        class="group hover:bg-[#EFF3F6] py-[15px] px-[10px] 2xl:px-[20px] w-[190px] 2xl:w-[268px] rounded-[10px] cursor-pointer">
                                        <a href="{{route('studentOverdue', ['user' => $user])}}" aria-label="Knjige u prekoracenju"
                                            class="flex items-center">
                                            <i
                                                class="text-[#707070] text-[20px] fas fa-exclamation-triangle transition duration-300 ease-in group-hover:text-[#576cdf]"></i>
                                            <div>
                                                <p
                                                    class="text-xs 2xl:text-[15px] ml-[17px] transition duration-300 ease-in group-hover:text-[#576cdf]">
                                                    Knjige u prekoračenju</p>
                                            </div>
                                        </a>
                                    </div>
                                </span>
                            </div>
                        </li>
                        <li class="pl-2 xl:pl-0 mb-[4px]">
                            <div class="w-[190px] xl:w-[210px] 2xl:w-[300px] border-l-[1px] xl:border-l-0 xl:border-t-[1px] border-[#e4dfdf] pl-2 xl:pl-4 2xl:pl-[32px]">
                                <span
                                    class=" whitespace-nowrap w-full text-[25px] flex justify-between fill-current">
                                    <div
                                        class="group hover:bg-[#EFF3F6] py-[15px] px-[10px] 2xl:px-[20px] w-[190px] 2xl:w-[268px] rounded-[10px] cursor-pointer">
                                        <a href="{{route('studentActive', ['user' => $user])}}" aria-label="Reservations" class="flex items-center">
                                            <i
                                                class="text-[#707070] text-[20px] far fa-calendar-check transition duration-300 ease-in group-hover:text-[#576cdf]"></i>
                                            <div>
                                                <p
                                                    class="text-xs 2xl:text-[15px] ml-[19px] transition duration-300 ease-in group-hover:text-[#576cdf]">
                                                    Aktivne rezervacije</p>
                                            </div>
                                        </a>
                                    </div>
                                </span>
                            </div>
                        </li>
                        <li class="mb-[4px]">
                            <div class="w-[190px] xl:w-[210px] 2xl:w-[300px] pl-2 xl:pl-4 2xl:pl-[32px]">
                                <span class=" whitespace-nowrap w-full text-[25px] flex justify-between fill-current">
                                    <div
                                        class="group hover:bg-[#EFF3F6] py-[15px] px-[10px] 2xl:px-[20px] w-[190px] 2xl:w-[268px] rounded-[10px] cursor-pointer">
                                        <a href="{{route('studentArchived', ['user' => $user])}}" aria-label="Reservations"
                                            class="flex items-center">
                                            <i
                                                class="text-[#707070] text-[20px] fas fa-calendar-alt transition duration-300 ease-in group-hover:text-[#576cdf]"></i>
                                            <div>
                                                <p
                                                    class="text-xs 2xl:text-[15px] ml-[19px] transition duration-300 ease-in group-hover:text-[#576cdf]">
                                                    Arhivirane rezervacije</p>
                                            </div>
                                        </a>
                                    </div>
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
                @if(count($returnedBooks) > 0)
                    <div class="w-full mt-[10px] xl:ml-2 pr-2 pl-4 xl:pl-2">
                        <table class="w-full shadow-lg" id="myTable">
                            <thead class="bg-[#EFF3F6]">
                                <tr class="border-b-[1px] border-[#e4dfdf]">
                                    <th class="px-2 py-4 leading-4 tracking-wider text-left text-blue-500 xl:px-3 2xl:px-4">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="form-checkbox">
                                        </label>
                                    </th>
                                    <th class="px-2 py-4 text-xs leading-4 tracking-wider text-left xl:px-3 2xl:px-4 whitespace-nowrap 2xl:text-sm">
                                        Naziv knjige
                                        <a href="#"><i class="ml-2 fa-lg fas fa-long-arrow-alt-down"
                                                onclick="sortTable()"></i>
                                        </a>
                                    </th>
                                    <th
                                        class="relative px-2 py-4 text-xs leading-4 tracking-wider text-left cursor-pointer xl:px-3 2xl:px-4 2xl:text-sm whitespace-nowrap">
                                        Datum izdavanja<i class="fas fa-filter dateDrop-toggle"></i>
                                        <div id="dateDropdown"
                                            class="dateMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md top-[42px] pin-l border-2 border-gray-300">
                                            <div
                                                class="flex justify-between flex-row p-2 pb-[15px] border-b-[2px] relative border-gray-300">
                                                <div>
                                                    <label class="font-medium text-gray-500">Period od:</label>
                                                    <input type="date"
                                                        class="border-[1px] border-[#e4dfdf]  cursor-pointer focus:outline-none">
                                                </div>
                                                <div class="ml-[50px]">
                                                    <label class="font-medium text-gray-500">Period do:</label>
                                                    <input type="date"
                                                        class="border-[1px] border-[#e4dfdf]  cursor-pointer focus:outline-none">
                                                </div>
                                            </div>
                                            <div class="flex pt-[10px] text-white ">
                                                <a href="#"
                                                    class="btn-animation py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                                    <i class="fas fa-check mr-[7px]"></i> Sačuvaj 
                                                </a>
                                                <a href="#"
                                                    class="btn-animation ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                                    <i class="fas fa-times mr-[7px]"></i> Poništi 
                                                </a>
                                            </div>
                                        </div>
                                    </th>
                                    <th
                                        class="relative px-2 py-4 text-xs leading-4 tracking-wider text-left cursor-pointer xl:px-3 2xl:px-4 2xl:text-sm whitespace-nowrap">
                                        Datum vraćanja<i class="fas fa-filter returningDrop-toggle"></i>
                                        <div id="returningDropdown"
                                            class="returningMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md top-[42px] right-0 border-2 border-gray-300">
                                            <div
                                                class="flex justify-between flex-row p-2 pb-[15px] border-b-[2px] relative border-gray-300">
                                                <div>
                                                    <label class="font-medium text-gray-500">Period od:</label>
                                                    <input type="date"
                                                        class="border-[1px] border-[#e4dfdf]  cursor-pointer focus:outline-none">
                                                </div>
                                                <div class="ml-[50px]">
                                                    <label class="font-medium text-gray-500">Period do:</label>
                                                    <input type="date"
                                                        class="border-[1px] border-[#e4dfdf]  cursor-pointer focus:outline-none">
                                                </div>
                                            </div>
                                            <div class="flex pt-[10px] text-white ">
                                                <a href="#"
                                                    class="btn-animation py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                                    <i class="fas fa-check mr-[7px]"></i> Sačuvaj 
                                                </a>
                                                <a href="#"
                                                    class="btn-animation ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                                    <i class="fas fa-times mr-[7px]"></i> Poništi 
                                                </a>
                                            </div>
                                        </div>
                                    </th>
                                    <th
                                        class="relative px-2 py-4 text-xs leading-4 tracking-wider text-left cursor-pointer xl:px-3 2xl:px-4 2xl:text-sm whitespace-nowrap">
                                        Zadržavanje knjige <i class="fas fa-filter delayDrop-toggle"></i>
                                        <div id="delayDropdown"
                                            class="delayMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md top-[42px] right-0 border-2 border-gray-300">
                                            <div
                                                class="flex justify-between flex-row p-2 pb-[15px] border-b-[2px] relative border-gray-300">
                                                <div>
                                                    <label class="font-medium text-gray-500">Period od:</label>
                                                    <input type="date"
                                                        class="border-[1px] border-[#e4dfdf]  cursor-pointer focus:outline-none">
                                                </div>
                                                <div class="ml-[50px]">
                                                    <label class="font-medium text-gray-500">Period do:</label>
                                                    <input type="date"
                                                        class="border-[1px] border-[#e4dfdf]  cursor-pointer focus:outline-none">
                                                </div>
                                            </div>
                                            <div class="flex pt-[10px] text-white ">
                                                <a href="#"
                                                    class="btn-animation py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                                    <i class="fas fa-check mr-[7px]"></i> Sačuvaj 
                                                </a>
                                                <a href="#"
                                                    class="btn-animation ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                                    <i class="fas fa-times mr-[7px]"></i> Poništi 
                                                </a>
                                            </div>
                                        </div>
                                    </th>
                                    <th
                                        class="relative px-2 py-4 text-xs leading-4 tracking-wider text-left cursor-pointer xl:px-3 2xl:px-4 2xl:text-sm whitespace-nowrap">
                                        Knjigu primio<i class="fas fa-filter librariansDrop-toggle"></i>
                                        <div id="librariansDropdown"
                                            class="librariansMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md top-[42px] right-0 border-2 border-gray-300">
                                            <ul class="border-b-2 border-gray-300 list-reset">
                                                <li class="p-2 pb-[15px] border-b-[2px] relative border-gray-300">
                                                    <input class="w-full h-10 px-2 border-2 rounded focus:outline-none"
                                                        placeholder="Search"
                                                        onkeyup="filterFunction('searchLibrarians', 'librariansDropdown', 'dropdown-item-librarian')"
                                                        id="searchLibrarians"><br>
                                                    <button
                                                        class="absolute block text-xl text-center text-gray-400 transition-colors w-7 h-7 leading-0 top-[14px] right-4 focus:outline-none hover:text-gray-900">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </li>
                                                <div class="h-[200px] scroll font-normal">
                                                    <li
                                                        class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-librarian">
                                                        <label class="flex items-center justify-start">
                                                            <div
                                                                class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">
                                                                <input type="checkbox" class="absolute opacity-0">
                                                                <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"
                                                                    viewBox="0 0 20 20">
                                                                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                                                </svg>
                                                            </div>
                                                        </label>
                                                        <img width="40px" height="30px" class="ml-[15px] rounded-full"
                                                            src="/storage/image/{{$user->photo}}">
                                                        <p
                                                            class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                            Bibliotekar Bulatovic
                                                        </p>
                                                    </li>
                                                    <li
                                                        class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-librarian">
                                                        <label class="flex items-center justify-start">
                                                            <div
                                                                class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">
                                                                <input type="checkbox" class="absolute opacity-0">
                                                                <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"
                                                                    viewBox="0 0 20 20">
                                                                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                                                </svg>
                                                            </div>
                                                        </label>
                                                        <img width="40px" height="30px" class="ml-[15px] rounded-full"
                                                            src="/storage/image/{{$user->photo}}">
                                                        <p
                                                            class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                            Pero Perovic
                                                        </p>
                                                    </li>
                                                    <li
                                                        class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-librarian">
                                                        <label class="flex items-center justify-start">
                                                            <div
                                                                class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">
                                                                <input type="checkbox" class="absolute opacity-0">
                                                                <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"
                                                                    viewBox="0 0 20 20">
                                                                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                                                </svg>
                                                            </div>
                                                        </label>
                                                        <img width="40px" height="30px" class="ml-[15px] rounded-full"
                                                            src="/storage/image/{{$user->photo}}">
                                                        <p
                                                            class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                            Marko Markovic
                                                        </p>
                                                    </li>
                                                    <li
                                                        class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-librarian">
                                                        <label class="flex items-center justify-start">
                                                            <div
                                                                class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">
                                                                <input type="checkbox" class="absolute opacity-0">
                                                                <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"
                                                                    viewBox="0 0 20 20">
                                                                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                                                </svg>
                                                            </div>
                                                        </label>
                                                        <img width="40px" height="30px" class="ml-[15px] rounded-full"
                                                            src="/storage/image/{{$user->photo}}">
                                                        <p
                                                            class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                            Nikola Nikolic
                                                        </p>
                                                    </li>
                                                    <li
                                                        class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-librarian">
                                                        <label class="flex items-center justify-start">
                                                            <div
                                                                class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">
                                                                <input type="checkbox" class="absolute opacity-0">
                                                                <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"
                                                                    viewBox="0 0 20 20">
                                                                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                                                </svg>
                                                            </div>
                                                        </label>
                                                        <img width="40px" height="30px" class="ml-[15px] rounded-full"
                                                            src="/storage/image/{{$user->photo}}">
                                                        <p
                                                            class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                            Zivko Zivkovic
                                                        </p>
                                                    </li>
                                                    <li
                                                        class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-librarian">
                                                        <label class="flex items-center justify-start">
                                                            <div
                                                                class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">
                                                                <input type="checkbox" class="absolute opacity-0">
                                                                <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"
                                                                    viewBox="0 0 20 20">
                                                                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                                                </svg>
                                                            </div>
                                                        </label>
                                                        <img width="40px" height="30px" class="ml-[15px] rounded-full"
                                                            src="/storage/image/{{$user->photo}}">
                                                        <p
                                                            class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                            Petar Petrovic
                                                        </p>
                                                    </li>
                                                </div>
                                            </ul>
                                            <div class="flex pt-[10px] text-white ">
                                                <a href="#"
                                                    class="btn-animation py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                                    <i class="fas fa-check mr-[7px]"></i> Sačuvaj 
                                                </a>
                                                <a href="#"
                                                    class="btn-animation ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                                    <i class="fas fa-times mr-[7px]"></i> Poništi 
                                                </a>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="px-2 py-4 xl:px-3 2xl:px-4"> </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($returnedBooks as $returnedBook)
                                <tr class="hover:bg-gray-200 hover:shadow-md border-b-[1px] border-[#e4dfdf]">
                                    <td class="px-2 py-4 xl:px-3 2xl:px-4">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="form-checkbox">
                                        </label>
                                    </td>
                                    <td class="flex flex-row items-center px-2 py-4 xl:px-3 2xl:px-4 whitespace-nowrap">
                                        @if(count($returnedBook->book->coverImage) > 0 )
                                            <img class="object-cover w-8 h-10 mr-4" src="/storage/image/{{$returnedBook->book->coverImage[0]->photo}}" alt="" />
                                        @endif
                                        <a href="{{route('rentDetails', ['book' => $returnedBook->book, 'student' => $returnedBook->student])}}">
                                            <span class="text-xs font-medium text-center 2xl:text-sm">{{$returnedBook->book->title}}</span>
                                        </a>
                                    </td>
                                    <td class="px-2 py-4 text-xs leading-5 xl:px-3 2xl:px-4 2xl:text-sm whitespace-nowrap">{{$returnedBook->rent_date}}</td>
                                    <td class="px-2 py-4 text-xs leading-5 xl:px-3 2xl:px-4 2xl:text-sm whitespace-nowrap">{{$returnedBook->rentStatus[0]->date}}</td>
                                    <td class="px-2 py-4 leading-5 xl:px-3 2xl:px-4 whitespace-nowrap">
                                        <div>
                                            <span class="text-xs 2xl:text-sm">{{ \Carbon\Carbon::parse($returnedBook->rent_date)->diffAsCarbonInterval($returnedBook->rentStatus[0]->date) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-2 py-4 text-xs leading-5 xl:px-3 2xl:px-4 2xl:text-sm whitespace-nowrap">{{$returnedBook->librarian->name}}</td>
                                    <td class="px-2 py-4 leading-5 text-right xl:px-3 2xl:px-4">
                                        <p
                                            class="inline cursor-pointer text-[20px] py-[10px] px-[10px] 2xl:px-[15px] border-gray-300 dotsStudentReturnedBooksTable hover:text-[#606FC7]">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </p>
                                        <div
                                            class="relative z-10 hidden transition-all duration-300 origin-top-right transform scale-95 -translate-y-2 student-returned-books-table">
                                            <div class="absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none"
                                                aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117"
                                                role="menu">
                                                <div class="py-1">
                                                    <a href="{{route('rentDetails', ['book' => $returnedBook->book, 'student' => $returnedBook->student])}}" tabindex="0"
                                                        class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                        role="menuitem">
                                                        <i class="far fa-file mr-[10px] ml-[5px] py-1"></i>
                                                        <span class="px-4 py-0">Pogledaj detalje</span>
                                                    </a>

                                                    <a href="{{route('rentBook', ['book' => $returnedBook->book])}}" tabindex="0"
                                                        class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                        role="menuitem">
                                                        <i class="far fa-hand-scissors mr-[10px] ml-[5px] py-1"></i>
                                                        <span class="px-4 py-0">Izdaj knjigu</span>
                                                    </a>

                                                    <a href="{{route('reserveBook', ['book' => $returnedBook->book])}}" tabindex="0"
                                                        class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                        role="menuitem">
                                                        <i class="far fa-calendar-check mr-[10px] ml-[5px] py-1"></i>
                                                        <span class="px-4 py-0">Rezerviši knjigu</span>
                                                    </a>

                                                    <a href="{{route('returnBook', ['book' => $returnedBook->book])}}" tabindex="0"
                                                        class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                        role="menuitem">
                                                        <i class="fas fa-redo-alt mr-[10px] ml-[5px] py-1"></i>
                                                        <span class="px-4 py-0">Vrati knjigu</span>
                                                    </a>

                                                    <a href="{{route('writeOffBook', ['book' => $returnedBook->book])}}" tabindex="0"
                                                        class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                        role="menuitem">
                                                        <i class="fas fa-level-up-alt mr-[14px] ml-[5px] py-1"></i>
                                                        <span class="px-4 py-0">Otpiši knjigu</span>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="pt-[20px]">
                            {{$returnedBooks->links()}}
                        </div>

                    </div>
                @else
                    <div class="mx-[40px] h-[60px] flex items-center px-6 py-4 my-4 text-lg bg-red-200 rounded-lg">
                        <svg viewBox="0 0 24 24" class="w-5 h-5 mr-3 text-red-600 sm:w-5 sm:h-5">
                            <path fill="currentColor"
                                d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                            </path>
                        </svg>
                        <p class="font-medium text-red-600"> Učenik {{$user->name}} nema vraćenih primjeraka! </p>
                    </div>
                @endif
            </div>
            <!--Modal-->
            <div
                class="absolute z-20 top-0 left-0 items-center justify-center hidden w-full h-screen bg-black bg-opacity-10 delete-modal_{{$user->id}}" id="{{$user->id}}">
                <!-- Modal -->
                <div class="w-[500px] bg-white rounded shadow-lg md:w-1/3">
                     <!-- Modal Header -->
                     <div class="flex items-center justify-between px-[30px] py-[20px] border-b">
                         <h3>Da li ste sigurni da želite da izbrišete korisnika?</h3>
                         <button class="text-black close cancel focus:outline-none" id="{{$user->id}}">
                             <span aria-hidden="true" class="text-[30px]">&times;</span>
                         </button>
                     </div>
                     <!-- Modal Body -->
                     <div class="flex items-center justify-center px-[30px] py-[20px] border-t w-100 text-white">
                         <a href="{{ route('deleteStudent', ['user' => $user->id]) }}}"
                             class=" text-center shadow-lg mr-[15px] w-[150px] focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                             <i class="fas fa-check mr-[7px]"></i> Izbriši
                         </a>
                         <a href="#" id="{{$user->id}}" class="cancel shadow-lg w-[150px] focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] bg-[#F44336] hover:bg-[#F55549] text-center">
                         <i class="fas fa-times mr-[7px]"></i> Poništi 
                         </a>
                     </div>
                </div>
            </div>
        </section>
        @endsection
