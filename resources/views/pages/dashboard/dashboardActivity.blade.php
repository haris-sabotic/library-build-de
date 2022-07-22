@extends('layouts.layout')
@section('dashboardActivity')
    <section class="w-screen h-screen pl-[80px] py-4 text-gray-700">
        <!-- Heading of content -->
        <div class="heading mt-[7px]">
            <h1 class="pl-[30px] pb-[21px]  border-b-[1px] border-[#e4dfdf] ">
                Prikaz aktivnosti
            </h1>
        </div>
        <!-- Space for content -->
        <div class="pl-[30px] overflow-auto scroll height-dashboard pb-[30px] mt-[20px]">
            <div class="flex flex-row justify-between">
                <div class="mr-[30px]">
                    <form>
                        @csrf
                        <div class="text-[14px] flex flex-row mb-[30px]">
                        <div class="">
                            <div class="rounded">
                                <div class="relative">
                                    <a class="w-auto rounded cursor-pointer focus:outline-none studentsDrop-toggle">
                                                <span id="studentsAll" class="float-left">Učenici: Svi </span>
                                                <i
                                                        class="px-[7px] fas fa-angle-down"></i>
                                    </a>
                                    <div id="studentsDropdown"
                                         class="studentsMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md top-[42px] pin-l border-2 border-gray-300">
                                        <ul class="border-b-2 border-gray-300 list-reset">
                                            <li class="p-2 pb-[15px] border-b-[2px] relative border-gray-300">
                                                <input class="w-full h-10 px-2 border-2 rounded focus:outline-none"
                                                       placeholder="Search"
                                                       onkeyup="filterFunction('searchStudents', 'studentsDropdown', 'dropdown-item-rented')"
                                                       id="searchStudents"><br>
                                                <button
                                                    class="absolute block text-xl text-center text-gray-400 transition-colors w-7 h-7 leading-0 top-[14px] right-4 focus:outline-none hover:text-gray-900">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </li>
                                            <div class="h-[200px] scroll">
                                                @foreach($students as $student)
                                                <li
                                                    class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-rented">
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
                                                    <img width="40px" height="30px" class="ml-[15px] rounded-full"
                                                         src="img/profileStudent.jpg">
                                                    <p
                                                        class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                        {{$student->name}}
                                                    </p>
                                                </li>
                                                @endforeach
                                            </div>
                                        </ul>
                                        <div class="flex pt-[10px] text-white ">
                                            <a href="#" id="studentsFilter"
                                               class="btn-animation py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                               <i class="fas fa-check mr-[7px]"></i> Sačuvaj 
                                            </a>
                                            <a href="#" id="studentsFilterCancel"
                                               class="btn-animation ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                               <i class="fas fa-times mr-[7px]"></i> Poništi 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ml-[25px]">
                            <div class="rounded">
                                <div class="relative">
                                    <a class="inline-block w-auto rounded cursor-pointer focus:outline-none librariansDrop-toggle">
                                                <span id="librariansAll" class="float-left">Bibliotekari: Svi </span><i
                                                        class="px-[7px] fas fa-angle-down"></i>
                                    </a>
                                    <div id="librariansDropdown"
                                         class="librariansMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md pin-t pin-l border-2 border-gray-300">
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
                                            <div class="h-[200px] scroll">
                                                @foreach($librarians as $librarian)
                                                    <li
                                                        class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-librarian">
                                                        <label class="flex items-center justify-start">
                                                            <div
                                                                class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">
                                                                <input type="checkbox" class="absolute opacity-0 librariansFilterCancel" name="librariansFilter[]" value="{{$librarian->id}}">
                                                                <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"
                                                                     viewBox="0 0 20 20">
                                                                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                                                </svg>
                                                            </div>
                                                        </label>
                                                        <img width="40px" height="30px" class="ml-[15px] rounded-full"
                                                             src="img/profileExample.jpg">
                                                        <p id="librariansFilter"
                                                            class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                            {{$librarian->name}}
                                                        </p>
                                                    </li>
                                                @endforeach
                                            </div>
                                        </ul>
                                        <div class="flex pt-[10px] text-white ">
                                            <a href="#" id="librariansFilter"
                                               class="btn-animation py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                               <i class="fas fa-check mr-[7px]"></i> Sačuvaj 
                                            </a>
                                            <a href="#" id="librariansFilterCancel"
                                               class="btn-animation ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                               <i class="fas fa-times mr-[7px]"></i> Poništi 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ml-[25px]">
                            <div class="rounded">
                                <div class="relative">
                                    <a class="inline-block w-auto rounded cursor-pointer focus:outline-none" id="booksMenu">
                                        @if($book != null)
                                            <span id="booksAll" class='float-left bg-blue-200 text-blue-800 px-[5px]'>
                                                Knjige:  {{$book->title}}
                                            </span>
                                            <i class="px-[7px] fas fa-angle-down"></i>

                                        @else
                                            <span id="booksAll" class='float-left'>
                                                Knjiga:  Sve
                                            </span>
                                            <i class="px-[7px] fas fa-angle-down"></i>
                                        @endif

                                    </a>
                                    <div id="booksDropdown"
                                         class="booksMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md pin-t pin-l border-2 border-gray-300">
                                        <ul class="border-b-2 border-gray-300 list-reset">
                                            <li class="p-2 pb-[15px] border-b-[2px] relative border-gray-300">
                                                <input class="w-full h-10 px-2 border-2 rounded focus:outline-none"
                                                       placeholder="Search"
                                                       onkeyup="filterFunction('searchBooks', 'booksDropdown', 'dropdown-item-book')"
                                                       id="searchBooks"><br>
                                                <button
                                                    class="absolute block text-xl text-center text-gray-400 transition-colors w-7 h-7 leading-0 top-[14px] right-4 focus:outline-none hover:text-gray-900">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </li>
                                            <div class="h-[200px] scroll">
                                                @foreach($books as $b)
                                                    <li
                                                        class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-book">
                                                        <label class="flex items-center justify-start">
                                                            <div
                                                                class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">
                                                                <input type="checkbox" class="absolute opacity-0 booksFilterCancel" name="booksFilter[]" value="{{$b->id}}">
                                                                <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"
                                                                     viewBox="0 0 20 20">
                                                                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                                                </svg>
                                                            </div>
                                                        </label>
                                                        <img width="30px" height="30px" class="ml-[15px]"
                                                             src="img/tomsojer.jpg">
                                                        <p id="booksFilter"
                                                            class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                            {{$b->title}}
                                                        </p>
                                                    </li>
                                                @endforeach
                                            </div>
                                        </ul>
                                        <div class="flex pt-[10px] text-white ">
                                            <a href="#" id="booksFilter"
                                               class="btn-animation py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                               <i class="fas fa-check ml-[4px]"></i> Sačuvaj 
                                            </a>
                                            <a href="#" id="booksFilterCancel"
                                               class="btn-animation ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                               <i class="fas fa-times ml-[4px]"></i> Poništi 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ml-[25px]">
                            <div class="rounded">
                                <div class="relative">
                                    <a class="inline-block w-auto rounded cursor-pointer focus:outline-none" id="transactionsMenu">
                                                <span class="float-left">Transakcije: Sve <i
                                                        class="px-[7px] fas fa-angle-down"></i></span>
                                    </a>
                                    <div id="transactionsDropdown"
                                         class="transactionsMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md pin-t pin-l border-2 border-gray-300">
                                        <ul class="border-b-2 border-gray-300 list-reset">
                                            <li class="p-2 pb-[15px] border-b-[2px] relative border-gray-300">
                                                <input class="w-full h-10 px-2 border-2 rounded focus:outline-none"
                                                       placeholder="Search"
                                                       onkeyup="filterFunction('searchTransactions', 'transactionsDropdown', 'dropdown-item-transactions')"
                                                       id="searchTransactions"><br>
                                                <button
                                                    class="absolute block text-xl text-center text-gray-400 transition-colors w-7 h-7 leading-0 top-[14px] right-4 focus:outline-none hover:text-gray-900">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </li>
                                            <div class="h-[200px] scroll">
                                                <li
                                                    class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-transactions">
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
                                                    <p
                                                        class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                        Izdavanje knjiga
                                                    </p>
                                                </li>
                                                <li
                                                    class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-transactions">
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
                                                    <p
                                                        class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                        Vraćanje knjiga
                                                    </p>
                                                </li>
                                                <li
                                                    class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-transactions">
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
                                                    <p
                                                        class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                        Unos nove knjige
                                                    </p>
                                                </li>
                                                <li
                                                    class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-transactions">
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
                                                    <p
                                                        class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                        Brisanje knjige
                                                    </p>
                                                </li>
                                            </div>
                                        </ul>
                                        <div class="flex pt-[10px] text-white ">
                                            <a href="#"
                                               class="btn-animation py-2 px-[20px] transition duration-300 ease-in hover:bg-[#009688] bg-[#46A149] rounded-[5px]">
                                               <i class="fas fa-check mr-[7px]"></i> Sačuvaj 
                                            </a>
                                            <a href="#"
                                               class="btn-animation ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                               <i class="fas fa-times mr-[7px]"></i> Poništi 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ml-[25px]">
                            <div class="rounded">
                                <div class="relative">
                                    <a class="inline-block w-auto rounded cursor-pointer focus:outline-none dateDrop-toggle">
                                                <span id="dateAll" class="float-left">
                                                    Datum: Svi
                                                </span>
                                                <i class="px-[7px] fas fa-angle-down"></i>
                                    </a>
                                    <div id="dateDropdown"
                                         class="dateMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md pin-t pin-l border-2 border-gray-300">
                                        <div
                                            class="flex justify-between flex-row p-2 pb-[15px] border-b-[2px] relative border-gray-300">
                                            <div>
                                                <label class="font-medium text-gray-500">Period od:</label>
                                                <input type="date"
                                                       class="border-[1px] border-[#e4dfdf]  cursor-pointer focus:outline-none dateFilterCancel" id="dateFromFilter">
                                            </div>
                                            <div class="ml-[50px]">
                                                <label class="font-medium text-gray-500">Period do:</label>
                                                <input type="date"
                                                       class="border-[1px] border-[#e4dfdf]  cursor-pointer focus:outline-none dateFilterCancel" id="dateToFilter">
                                            </div>
                                        </div>
                                        <div class="flex pt-[10px] text-white ">
                                            <a href="#" id="dateFilter"
                                               class="btn-animation py-2 px-[20px] transition duration-300 ease-in hover:bg-[#009688] bg-[#46A149] rounded-[5px]">
                                               <i class="fas fa-check mr-[7px]"></i> Sačuvaj 
                                            </a>
                                            <a href="#" id="dateFilterCancel"
                                               class="btn-animation ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                               <i class="fas fa-times mr-[7px]"></i> Poništi 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('dashboardActivity')}}" class="ml-[35px] cursor-pointer hover:text-blue-600">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                    </form>
                    <!-- Activity Cards -->
                    <div id="activityCards">
                        @foreach($activities as $activity)
                            <div class="activity-card hidden flex-row mb-[30px]">
                                <div class="w-[60px] h-[60px]">
                                    <img class="rounded-full" src="/storage/image/{{$activity->librarian->photo}}" alt="">
                                </div>
                                <div class="ml-[15px] mt-[5px] flex flex-col">

                                    <div class="text-gray-500 mb-[5px]">
                                        @if(count($activity->rentStatus) > 0)
                                            @if($activity->rentStatus[0]->statusBook_id == 2)
                                                <p class="uppercase">
                                                    Izdavanje knjige
                                                    <span class="inline lowercase">
                                                    - {{$activity->rentStatus[0]->date->diffForHumans()}}
                                                    </span>
                                                </p>
                                            @else
                                                <p class="uppercase">
                                                    Vraćanje knjige
                                                    <span class="inline lowercase">
                                                    - {{$activity->rentStatus[0]->date->diffForHumans()}}
                                                    </span>
                                                </p>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="">
                                        <p>
                                            <a href="{{route('librarianProfile', ['user' => $activity->librarian])}}" class="text-[#2196f3] hover:text-blue-600">
                                                {{$activity->librarian->name}}
                                            </a>
                                            @if(count($activity->rentStatus) > 0)
                                                @if($activity->rentStatus[0]->statusBook_id == 2)
                                                    izdao/la knjigu
                                                @else
                                                    vratio/la knjigu
                                                @endif
                                            @endif
                                            <a  href="{{route('bookDetails', ['book' => $activity->book])}}" class="font-medium">
                                                {{$activity->book->title}}
                                            </a>
                                            @if(count($activity->rentStatus) > 0)
                                                @if($activity->rentStatus[0]->statusBook_id == 2)
                                                    učeniku
                                                @else
                                                    od učenika
                                                @endif
                                            @endif
                                            <a href="{{route('studentProfile', ['user' => $activity->student])}}" class="text-[#2196f3] hover:text-blue-600">
                                                {{$activity->student->name}}
                                            </a>
                                            dana
                                            <span class="font-medium">
                                        {{$activity->rent_date}}.
                                    </span>
                                            <a href="{{route('rentDetails', ['book' => $activity->book, 'student' => $activity->student])}}" class="text-[#2196f3] hover:text-blue-600">
                                                više detalja >>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="inline-block w-full mt-4">
                        <button type="button"
                                class="btn-animation w-full px-4 py-2 text-sm tracking-wider text-gray-600 transition duration-300 ease-in border-[1px] border-gray-400 rounded activity-showMore hover:bg-gray-200 focus:outline-none focus:ring-[1px] focus:ring-gray-300">
                            Prikaži više
                        </button>
                    </div>
                    </div>
                    <div id="activityCards2" style="display: none">

                    </div>
                    <div id="activityCards3" style="display: none">
                        Ne postoje rezultati za tražene kriterijume!
                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection
