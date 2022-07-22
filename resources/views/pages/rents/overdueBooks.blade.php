@extends('layouts.layout')

@section('overdueBooks')

<section class="w-screen h-screen pl-[80px] py-4 text-gray-700">
            <!-- Heading of content -->
            <div class="heading mt-[7px]">
                <h1 class="pl-[30px] pb-[21px] border-b-[1px] border-[#e4dfdf] ">
                    Izdavanje knjiga
                </h1>
            </div>
            <!-- Space for content -->
            <div class="scroll height-dashboard">
                <form action="searchOverdueBooks" method="GET">
                    <div class="flex items-center justify-center xl:justify-start px-6 py-4 space-x-3 rounded-lg xl:ml-[200px] 2xl:ml-[292px]">
                        <div class="flex items-center">
                            <div class="relative text-gray-600 focus-within:text-gray-400">
                                <input type="search" name="searchOverdue"
                                    class="py-2 pl-2 text-sm text-white bg-white border-2 border-gray-200 rounded-md focus:outline-none focus:bg-white focus:text-gray-900 w-[600px]"
                                    placeholder="Pretraži knjige..." autocomplete="off">
                            </div>
                        </div>
                        <button
                            class="btn-animation inline-flex items-center text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] tracking-wider text-white bg-[#3f51b5] hover:bg-[#4558BE]">Pretraži
                        </button>
                    </div>
                </form>
                <div>
                    <!-- Space for content -->
                    <div class="flex flex-col justify-start pt-3 bg-white xl:flex-row">
                        <div class="mt-[10px]">
                            <ul class="text-[#2D3B48] flex xl:block">
                                <li class="mb-[4px]">
                                    <div class="w-[170px] xl:w-[210px] 2xl:w-[300px] pl-4 2xl:pl-[32px]">
                                        <span
                                            class=" whitespace-nowrap w-full text-[25px]  flex justify-between fill-current">
                                            <div
                                                class="py-[15px] px-[10px] 2xl:px-[20px] w-[170px] xl:w-[190px] 2xl:w-[268px] cursor-pointer group hover:bg-[#EFF3F6] rounded-[10px]">
                                                <a href="{{route('rentedBooks')}}" aria-label="Sve knjige"
                                                    class="flex items-center">
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
                                        <span
                                            class=" whitespace-nowrap w-full text-[25px] flex justify-between fill-current">
                                            <div
                                                class="group hover:bg-[#EFF3F6] py-[15px] px-[10px] 2xl:px-[20px] w-[170px] xl:w-[190px] 2xl:w-[268px] rounded-[10px] cursor-pointer">
                                                <a href="{{route('returnedBooks')}}" aria-label="Vracene knjige"
                                                    class="flex items-center">
                                                    <i
                                                        class="transition duration-300 ease-in  text-[#707070] text-[20px] fas fa-file group-hover:text-[#576cdf]"></i>
                                                    <div>
                                                        <p
                                                            class="transition duration-300 ease-in  text-xs 2xl:text-[15px] ml-[21px] group-hover:text-[#576cdf]">
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
                                        <span
                                            class=" whitespace-nowrap w-full text-[25px] flex justify-between fill-current">
                                            <div
                                                class="group bg-[#EFF3F6] hover:bg-[#EFF3F6] py-[15px] px-[10px] 2xl:px-[20px] w-[190px] 2xl:w-[268px] rounded-[10px] cursor-pointer">
                                                <a href="{{route('overdueBooks')}}" aria-label="Knjige na raspolaganju"
                                                    class="flex items-center">
                                                    <i
                                                        class="text-[#576cdf] text-[20px] fas fa-exclamation-triangle transition duration-300 ease-in "></i>
                                                    <div>
                                                        <p
                                                            class="text-xs 2xl:text-[15px] ml-[17px] transition duration-300 ease-in text-[#576cdf]">
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
                                            class="whitespace-nowrap w-full text-[25px] flex justify-between fill-current">
                                            <div
                                                class="group hover:bg-[#EFF3F6] py-[15px] px-[10px] 2xl:px-[20px] w-[190px] 2xl:w-[268px] rounded-[10px] cursor-pointer">
                                                <a href="{{route('activeReservations')}}" aria-label="Reservations"
                                                    class="flex items-center">
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
                                        <span
                                            class=" whitespace-nowrap w-full text-[25px] flex justify-between fill-current">
                                            <div
                                                class="group hover:bg-[#EFF3F6] py-[15px] px-[10px] 2xl:px-[20px] w-[190px] 2xl:w-[268px] rounded-[10px] cursor-pointer">
                                                <a href="{{route('archivedReservations')}}" aria-label="Reservations"
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

                        <div class="w-full mt-[10px] xl:ml-2 pr-2 pl-4 xl:pl-2">
                            @if(count($overdued) > 0)
                                <table class="w-full shadow-lg" id="myTable">
                                    <thead class="bg-[#EFF3F6]">
                                        <form action="/filterOverdueBooks" method="GET">
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
                                                <!-- Datum izdavanja + dropdown filter for date -->
                                                <th
                                                    class="relative px-2 py-4 text-xs leading-4 tracking-wider text-left cursor-pointer 2xl:text-sm xl:px-3 2xl:px-4 whitespace-nowrap">
                                                    Datum izdavanja<i class="ml-2 fas fa-filter dateDrop-toggle"></i>
                                                    <div id="dateDropdown"
                                                        class="dateMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md top-[42px] pin-l border-2 border-gray-300">
                                                        <div
                                                            class="flex justify-between flex-row p-2 pb-[15px] border-b-[2px] relative border-gray-300">
                                                            <div>
                                                                <label class="font-medium text-gray-500">Period od:</label>
                                                                <input type="date"
                                                                    class="dateFilterCancel border-[1px] border-[#e4dfdf]  cursor-pointer focus:outline-none" name="filterDateFrom">
                                                            </div>
                                                            <div class="ml-[50px]">
                                                                <label class="font-medium text-gray-500">Period do:</label>
                                                                <input type="date"
                                                                    class="dateFilterCancel border-[1px] border-[#e4dfdf]  cursor-pointer focus:outline-none" name="filterDateTo">
                                                            </div>
                                                        </div>
                                                        <div class="flex pt-[10px] text-white ">
                                                            <button
                                                                class="btn-animation py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                                                <i class="fas fa-check mr-[7px]"></i> Sačuvaj 
                                                            </button>
                                                            <a id="dateFilterCancel"
                                                                class="btn-animation ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                                                <i class="fas fa-times mr-[7px]"></i> Poništi 
                                                            </a>
                                                        </div>
                                                    </div>
                                                </th>
                                                <!-- Izdato uceniku + dropdown filter for ucenik -->
                                                <th
                                                    class="relative px-2 py-4 text-xs leading-4 tracking-wider text-left cursor-pointer 2xl:text-sm xl:px-3 2xl:px-4 whitespace-nowrap">
                                                    Izdato učeniku<i class="fas fa-filter studentsDrop-toggle"></i>
                                                    <div id="studentsDropdown"
                                                        class="studentsMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md top-[42px] pin-t pin-l border-2 border-gray-300">
                                                        <ul class="border-b-2 border-gray-300 list-reset">
                                                            <li class="p-2 pb-[15px] border-b-[2px] relative border-gray-300">
                                                                <input
                                                                    class="w-full h-10 px-2 border-2 rounded focus:outline-none"
                                                                    placeholder="Search"
                                                                    onkeyup="filterFunction('searchStudents', 'studentsDropdown', 'dropdown-item-student')"
                                                                    id="searchStudents"><br>
                                                                <button
                                                                    class="absolute block text-xl text-center text-gray-400 transition-colors w-7 h-7 leading-0 top-[14px] right-4 focus:outline-none hover:text-gray-900">
                                                                    <i class="fas fa-search"></i>
                                                                </button>
                                                            </li>
                                                            <div class="h-[200px] scroll font-normal">
                                                                @foreach($students as $student)
                                                                            <li
                                                                                class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-student">
                                                                                <label class="flex items-center justify-start">
                                                                                    <div
                                                                                        class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">
                                                                                        <input type="checkbox" class="absolute opacity-0 studentsFilterCancel" name="studentsFilter[]" value="{{$student->id}}">
                                                                                        <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"
                                                                                            viewBox="0 0 20 20">
                                                                                            <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                                                                        </svg>
                                                                                    </div>
                                                                                </label>
                                                                                <img width="40px" height="30px"
                                                                                    class="ml-[15px] rounded-full"
                                                                                    src="/storage/image/{{$student->photo}}">
                                                                                <p
                                                                                    class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                                                    {{$student->name}}
                                                                                </p>
                                                                            </li>
                                                                    @endforeach
                                                            </div>
                                                        </ul>
                                                        <div class="flex pt-[10px] text-white ">
                                                            <button 
                                                                class="btn-animation py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                                                <i class="fas fa-check mr-[7px]"></i> Sačuvaj 
                                                            </button>
                                                            <a id="studentsFilterCancel"
                                                                class="btn-animation ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                                                <i class="fas fa-times mr-[7px]"></i> Poništi 
                                                            </a>
                                                        </div>
                                                    </div>
                                                </th>
                                                <!-- Prekoracenje u danima -->
                                                <th class="px-2 py-4 text-xs leading-4 tracking-wider text-left 2xl:text-sm xl:px-3 2xl:px-4 whitespace-nowrap">
                                                    Prekoračenje u danima
                                                </th>
                                                <!-- Trenutno zadrzavanje knjige + dropdown filter for date -->
                                                <th
                                                    class="relative px-2 py-4 text-xs leading-4 tracking-wider text-left cursor-pointer 2xl:text-sm xl:px-3 2xl:px-4 whitespace-nowrap">
                                                    Trenutno zadržavanje knjige
                                                </th>
                                                <th class="px-2 py-4 xl:px-3 2xl:px-4"> </th>
                                            </tr>
                                        </form>

                                    </thead>
                                    <tbody class="bg-white">
                                    @foreach($overdued as $overdue)
                                        <tr class="hover:bg-gray-200 hover:shadow-md border-b-[1px] border-[#e4dfdf]">
                                            <td class="px-2 py-4 xl:px-3 2xl:px-4">
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" class="form-checkbox">
                                                </label>
                                            </td>
                                            <td class="flex flex-row items-center px-2 py-4 xl:px-3 2xl:px-4 whitespace-nowrap">
                                                @if(count($overdue->book->coverImage) > 0 ) 
                                                    <img class="object-cover w-8 h-10 mr-4" src="/storage/image/{{$overdue->book->coverImage[0]->photo}}" alt="" />
                                                @endif
                                                <a href="{{route('rentDetails', ['book' => $overdue->book, 'student' => $overdue->student])}}">
                                                    <span class="text-xs font-medium text-center 2xl:text-sm">{{$overdue->book->title}}</span>
                                                </a>
                                            </td>
                                            <td class="px-2 py-4 text-xs leading-5 2xl:text-sm xl:px-3 2xl:px-4 whitespace-nowrap">{{$overdue->rent_date}}</td>
                                            <td class="px-2 py-4 leading-5 xl:px-3 2xl:px-4 whitespace-nowrap">
                                                <a href="{{route('studentProfile', ['user' => $overdue->student])}}" class="text-xs 2xl:text-sm">
                                                    {{$overdue->student->name}}
                                                </a>
                                            </td>
                                            <td class="px-2 py-4 leading-5 xl:px-3 2xl:px-4 whitespace-nowrap">
                                                <div
                                            
                                                    class="inline-block px-[6px] py-[2px] font-medium bg-red-200 rounded-[10px]">
                                                    <span class="text-xs text-red-800 2xl:text-sm">
                                                        {{ \Carbon\Carbon::parse($overdue->return_date)->diffInDays(\Carbon\Carbon::now()) }} dan/a
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-2 py-4 leading-5 xl:px-3 2xl:px-4 truncate max-w-[150px] 2xl:max-w-full">
                                                <div>
                                                    <span class="text-xs 2xl:text-sm">{{ \Carbon\Carbon::parse($overdue->rent_date)->diffAsCarbonInterval() }}</span>
                                                </div>
                                            </td>
                                            <td class="px-2 py-4 leading-5 text-right xl:px-3 2xl:px-4">
                                                <p
                                                    class="inline cursor-pointer text-[20px] py-[10px] px-[10px] 2xl:px-[30px] border-gray-300 dotsOverdueBooks hover:text-[#606FC7]">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </p>
                                                <div
                                                    class="relative z-10 hidden transition-all duration-300 origin-top-right transform scale-95 -translate-y-2 overdue-books">
                                                    <div class="absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none"
                                                        aria-labelledby="headlessui-menu-button-1"
                                                        id="headlessui-menu-items-117" role="menu">
                                                        <div class="py-1">
                                                            <a href="{{route('rentDetails', ['book' => $overdue->book, 'student' => $overdue->student])}}" tabindex="0"
                                                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                                role="menuitem">
                                                                <i class="far fa-file mr-[10px] ml-[5px] py-1"></i>
                                                                <span class="px-4 py-0">Pogledaj detalje</span>
                                                            </a>

                                                            <a href="{{route('rentBook', ['book' => $overdue->book->id])}}" tabindex="0"
                                                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                                role="menuitem">
                                                                <i class="far fa-hand-scissors mr-[10px] ml-[5px] py-1"></i>
                                                                <span class="px-4 py-0">Izdaj knjigu</span>
                                                            </a>

                                                            <a href="{{route('returnBook', ['book' => $overdue->book->id])}}" tabindex="0"
                                                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                                role="menuitem">
                                                                <i class="fas fa-redo-alt mr-[10px] ml-[5px] py-1"></i>
                                                                <span class="px-4 py-0">Vrati knjigu</span>
                                                            </a>

                                                            <a href="{{route('reserveBook', ['book' => $overdue->book->id])}}" tabindex="0"
                                                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                                role="menuitem">
                                                                <i
                                                                    class="far fa-calendar-check mr-[10px] ml-[5px] py-1"></i>
                                                                <span class="px-4 py-0">Rezerviši knjigu</span>
                                                            </a>

                                                            <a href="{{route('writeOffBook', ['book' => $overdue->book->id])}}" tabindex="0"
                                                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                                role="menuitem">
                                                                <i class="fas fa-level-up-alt mr-[14px] ml-[5px] py-1"></i>
                                                                <span class="px-4 py-0">Otpiši knjigu</span>
                                                            </a>

                                                            <!-- <a href="#" tabindex="0" id="{{$overdue->book->id}}"
                                                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600 show-izbrisiModal"
                                                                role="menuitem">
                                                                <i class="fa fa-trash mr-[10px] ml-[5px] py-1"></i>
                                                                <span class="px-4 py-0">Izbriši knjigu</span>
                                                            </a> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="pt-[20px]">
                                    {{$overdued->links()}}
                                </div>
                            @else 
                                <div class="flex items-center px-6 py-4 my-4 text-lg bg-red-200 rounded-lg">
                                    <svg viewBox="0 0 24 24" class="w-5 h-5 mr-3 text-red-600 sm:w-5 sm:h-5">
                                        <path fill="currentColor"
                                            d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                                        </path>
                                    </svg>
                                    <p class="font-medium text-red-600"> Nisu pronađeni traženi rezultati! </p>
                                </div>
                                <div>
                                    <a class="text-blue-500" href="{{route('rentedBooks')}}">
                                        &#8592; Nazad 
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </section>

@endsection
