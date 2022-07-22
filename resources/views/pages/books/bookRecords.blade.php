@extends('layouts.layout')
@section('bookRecords')
    <section class="w-screen h-screen pl-[80px] py-4 text-gray-700">
        <!-- Heading of content -->
        <div class="heading mt-[7px]">
            <h1 class="pl-[30px] pb-[21px] border-b-[1px] border-[#e4dfdf] ">
                Knjige
            </h1>
            @if(Session::has('success'))
                <div class="fadeInOut absolute top-[91px] py-[15px] px-[30px] rounded-[15px] text-white bg-[#4CAF50] right-[20px]">
                    <i class="fa fa-check mr-[5px]" aria-hidden="true"></i> {{ Session::get('success') }}
                        @php
                            Session::forget('success');
                        @endphp
                </div>
            @endif
        </div>
        <!-- Space for content -->
        @if(count($books) > 0)
            <div class="scroll height-records">
                <div class="flex items-center justify-between px-[24px] py-4 space-x-3 rounded-lg">
                    <a href="{{route('addBook')}}"
                    class="btn-animation inline-flex items-center text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] tracking-wider text-white bg-[#3f51b5] hover:bg-[#4558BE] whitespace-nowrap">
                        <i class="fas fa-plus mr-[15px]"></i> Nova knjiga
                    </a>
                    <form action="searchBooks" method="GET">
                        <div class="flex items-center pl-6 py-4 space-x-3 rounded-lg ml-[292px]">
                            <div class="flex items-center">
                                <div class="relative text-gray-600 focus-within:text-gray-400">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                                            <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
                                                <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6">
                                                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>
                                            </button>
                                        </span>
                                    <input type="search" name="searchBooks"
                                        class="py-2 pl-10 text-sm text-white bg-white rounded-md focus:outline-none focus:bg-white focus:text-gray-900"
                                        placeholder="Pretraži knjige..." autocomplete="off">
                                </div>
                            </div>
                            <button
                                class="btn-animation inline-flex items-center text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] tracking-wider text-white bg-[#3f51b5] hover:bg-[#4558BE]">Pretraži
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Space for content -->
                <div class="px-[24px] pt-2 bg-white">
                    <div class="w-full mt-2">
                        <!-- Table -->
                        @if(count($books) > 0)
                        <table class="w-full shadow-lg" id="myTable">
                            <!-- Table head-->
                            <thead class="bg-[#EFF3F6]">
                                <tr class="border-b-[1px] border-[#e4dfdf]">
                                        <th class="px-2 py-4 leading-4 tracking-wider text-left text-blue-500 xl:px-4">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" class="form-checkbox checkAll">
                                            </label>
                                        </th>
                                        <th class="py-4 px-2 xl:px-4 text-[11px] xl:text-xs leading-4 tracking-wider text-left 2xl:text-sm whitespace-nowrap">
                                            Naziv knjige
                                            <a href="#"><i class="ml-2 fa-lg fas fa-long-arrow-alt-down"
                                                        onclick="sortTable()"></i>
                                            </a>
                                        </th>

                                            <!-- Autor + dropdown filter for autor -->
                                            <form action='/filterAuthors' method="GET">
                                                <th
                                                    class="relative py-4 px-2 xl:px-4 text-[11px] xl:text-xs leading-4 tracking-wider text-left cursor-pointer 2xl:text-sm whitespace-nowrap">
                                                        Autor<i class="ml-2 fas fa-filter" id="authorsMenu"></i>
                                                        <div id="authorsDropdown"
                                                            class="authorsMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md top-[42px] pin-t pin-l border-2 border-gray-300">
                                                            <ul class="border-b-2 border-gray-300 list-reset">
                                                                <li class="p-2 pb-[15px] border-b-[2px] relative border-gray-300">
                                                                    <input class="w-full h-10 px-2 border-2 rounded focus:outline-none"
                                                                        placeholder="Search"
                                                                        onkeyup="filterFunction('searchAuthors', 'authorsDropdown', 'dropdown-item-author')"
                                                                        id="searchAuthors"><br>
                                                                    <button
                                                                        class="absolute block text-xl text-center text-gray-400 transition-colors w-7 h-7 leading-0 top-[14px] right-4 focus:outline-none hover:text-gray-900">
                                                                        <i class="fas fa-search"></i>
                                                                    </button>
                                                                </li>
                                                                <div class="h-[200px] scroll font-normal">
                                                                    @foreach($authors as $author)
                                                                        <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-author">
                                                                            <label class="flex items-center justify-start">
                                                                                <div
                                                                                    class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">
                                                                                    <input type="checkbox" class="absolute opacity-0 authorsFilterCancel" name="authorsFilter[]" value="{{$author->id}}">
                                                                                    <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"
                                                                                        viewBox="0 0 20 20">
                                                                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                                                                    </svg>
                                                                                </div>
                                                                            </label>
                                                                            <p
                                                                                class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                                                {{$author->name}}
                                                                            </p>
                                                                        </li>
                                                                    @endforeach
                                                                </div>
                                                            </ul>
                                                            <div class="flex pt-[10px] text-white ">
                                                                <button href="#"
                                                                class="py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                                                <i class="fas fa-check mr-[7px]"></i> Sačuvaj 
                                                                </button>
                                                                <button type="reset" id="authorsFilterCancel"
                                                                class="ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                                                <i class="fas fa-times mr-[7px]"></i> Poništi 
                                                                </button>
                                                            </div>
                                                        </div>
                                                </th>

                                                <!-- Kategorija + dropdown filter for kategorija -->
                                                <th class="relative py-4 px-2 xl:px-4 text-[11px] xl:text-xs leading-4 tracking-wider text-left cursor-pointer 2xl:text-sm whitespace-nowrap">
                                                        Kategorija<i class="ml-2 fas fa-filter" id="categoriesMenu"></i>
                                                        <div id="categoriesDropdown"
                                                            class="categoriesMenu hidden absolute rounded bg-white min-w-[310px] p-[10px] shadow-md top-[42px] pin-t pin-l border-2 border-gray-300">
                                                            <ul class="border-b-2 border-gray-300 list-reset">
                                                                <li class="p-2 pb-[15px] border-b-[2px] relative border-gray-300">
                                                                    <input class="w-full h-10 px-2 border-2 rounded focus:outline-none"
                                                                        placeholder="Search"
                                                                        onkeyup="filterFunction('searchCategories', 'categoriesDropdown', 'dropdown-item-category')"
                                                                        id="searchCategories"><br>
                                                                    <button
                                                                        class="absolute block text-xl text-center text-gray-400 transition-colors w-7 h-7 leading-0 top-[14px] right-4 focus:outline-none hover:text-gray-900">
                                                                        <i class="fas fa-search"></i>
                                                                    </button>
                                                                </li>
                                                                <div class="h-[200px] scroll font-normal">
                                                                    @foreach($categories as $category)
                                                                        <li class="flex p-2 mt-[2px] pt-[15px] group hover:bg-gray-200 dropdown-item-category">
                                                                            <label class="flex items-center justify-start">
                                                                                <div
                                                                                    class="flex items-center justify-center flex-shrink-0 w-[16px] h-[16px] mr-2 bg-white border-2 border-gray-400 rounded focus-within:border-blue-500">
                                                                                    <input type="checkbox" class="absolute opacity-0 categoryFilterCancel" name="categoriesFilter[]" value="{{$category->id}}">
                                                                                    <svg class="hidden w-4 h-4 text-green-500 pointer-events-none fill-current"
                                                                                        viewBox="0 0 20 20">
                                                                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                                                                    </svg>
                                                                                </div>
                                                                            </label>
                                                                            <p
                                                                                class="block p-2 text-black cursor-pointer group-hover:text-blue-600">
                                                                                {{$category->name}}
                                                                            </p>
                                                                        </li>
                                                                    @endforeach
                                                                </div>
                                                            </ul>
                                                            <div class="flex pt-[10px] text-white ">
                                                                <button
                                                                class="py-2 px-[20px] transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                                                <i class="fas fa-check mr-[7px]"></i> Sačuvaj 
                                                                </button>
                                                                <button type="reset"
                                                                class="ml-[20px] py-2 px-[20px] transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                                                <i class="fas fa-times mr-[7px]"></i> Poništi 
                                                                </button>
                                                            </div>
                                                        </div>
                                                </th>
                                            </form>
                                            <th class="py-4 px-2 xl:px-4 text-[11px] xl:text-xs leading-4 tracking-wider text-left 2xl:text-sm whitespace-nowrap">Na raspolaganju
                                            </th>
                                            <th class="py-4 px-2 xl:px-4 text-[11px] xl:text-xs leading-4 tracking-wider text-left 2xl:text-sm whitespace-nowrap">Rezervisano</th>
                                            <th class="py-4 px-2 xl:px-4 text-[11px] xl:text-xs leading-4 tracking-wider text-left 2xl:text-sm whitespace-nowrap">Izdato</th>
                                            <th class="py-4 px-2 xl:px-4 text-[11px] xl:text-xs leading-4 tracking-wider text-left 2xl:text-sm whitespace-nowrap">U prekoračenju</th>
                                            <th class="py-4 px-2 xl:px-4 text-[11px] xl:text-xs leading-4 tracking-wider text-left 2xl:text-sm whitespace-nowrap">Ukupna količina
                                            </th>
                                            <th class="px-2 py-4 xl:px-4"> </th>
                                        </tr>

                                </thead>
                                <tbody class="bg-white" id="bookTable">
                                    @foreach($books as $book)
                                            <tr class="hover:bg-gray-200 hover:shadow-md border-b-[1px] border-[#e4dfdf]">
                                                <td class="px-2 py-4 xl:px-4">
                                                    <label class="inline-flex items-center">
                                                        <input type="checkbox" class="form-checkbox checkOthers">
                                                    </label>
                                                </td>
                                                <td class="flex flex-row items-center px-2 py-4 xl:px-4 whitespace-nowrap">
                                                    @if(count($book->coverImage) > 0 )
                                                        <img class="object-cover w-8 h-10 mr-4" src="/storage/image/{{$book->coverImage[0]->photo}}" alt="" />
                                                    @endif
                                                    <a href="{{route('bookDetails', ['book' => $book->id])}}">
                                                        <span class="text-[11px] xl:text-xs font-medium 2xl:text-center 2xl:text-sm">{{$book->title}}</span>
                                                    </a>
                                                </td>
                                                <td class="py-4 px-2 xl:px-4 text-[11px] xl:text-xs 2xl:text-sm leading-5 truncate max-w-[100px] 2xl:max-w-[200px]">
                                                    @foreach($book->author as $author)
                                                        {{ $author->author->name }}
                                                        {{ $loop->last ? '' : ',' }}
                                                    @endforeach
                                                </td>
                                                <td class="py-4 px-2 xl:px-4 text-[11px] xl:text-xs 2xl:text-sm leading-5 truncate max-w-[100px] 2xl:max-w-[200px]">
                                                    @foreach($book->category as $category)
                                                        {{$category->category->name}}
                                                        {{ $loop->last ? '' : ',' }}
                                                    @endforeach
                                                </td>
                                                <td class="py-4 px-2 xl:px-4 text-[11px] xl:text-xs leading-5 2xl:text-sm whitespace-nowrap">
                                                    {{$book->quantity - $book->reservedBooks - $book->rentedBooks}}
                                                </td>
                                                <td class="px-2 py-4 leading-5 text-blue-800 xl:px-4 whitespace-nowrap">
                                                    <a href="{{route('rentingArchived', ['book' => $book->id])}}" class="text-[11px] xl:text-xs 2xl:text-sm">
                                                        {{$book->reservedBooks}}
                                                    </a>
                                                </td>
                                                <td class="px-2 py-4 leading-5 text-blue-800 xl:px-4 whitespace-nowrap">
                                                    <a href="{{route('rentingRented', ['book' => $book->id])}}" class="text-[11px] xl:text-xs 2xl:text-sm">
                                                        {{$book->rentedBooks}}
                                                    </a>
                                                </td>
                                                <td class="px-2 py-4 leading-5 text-blue-800 xl:px-4 whitespace-nowrap">
                                                    <a href="{{route('rentingOverdue', ['book' => $book->id])}}" class="text-[11px] xl:text-xs 2xl:text-sm">
                                                        {{\App\Models\Rent::where('return_date', '<', Carbon\Carbon::now())->where('book_id', '=', $book->id)->count()}}
                                                    </a>
                                                </td>
                                                <td class="py-4 px-2 xl:px-4 text-[11px] xl:text-xs leading-5 2xl:text-sm whitespace-nowrap">
                                                    {{$book->quantity}}
                                                </td>
                                                <td class="px-2 py-4 leading-5 text-right xl:px-4">
                                                    <p class="inline cursor-pointer text-[20px] py-[10px] px-[5px] xl:px-[20px] 2xl:px-[30px] border-gray-300 dotsBooks hover:text-[#606FC7]">
                                                        <i
                                                            class="fas fa-ellipsis-v"></i>
                                                    </p>
                                                    <div
                                                        class="relative z-10 hidden transition-all duration-300 origin-top-right transform scale-95 -translate-y-2 dropdown-books">
                                                        <div class="absolute right-0 w-56 mt-2 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none"
                                                            aria-labelledby="headlessui-menu-button-1"
                                                            id="headlessui-menu-items-117" role="menu">
                                                            <div class="py-1">
                                                                <a href="{{route('bookDetails', ['book' => $book->id])}}" tabindex="0"
                                                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                                role="menuitem">
                                                                    <i class="far fa-file mr-[10px] ml-[5px] py-1"></i>
                                                                    <span class="px-4 py-0">Pogledaj detalje</span>
                                                                </a>

                                                                <a href="{{route('editBook', ['book' => $book->id])}}" tabindex="0"
                                                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                                role="menuitem">
                                                                    <i class="fas fa-edit mr-[6px] ml-[5px] py-1"></i>
                                                                    <span class="px-4 py-0">Izmijeni knjigu</span>
                                                                </a>

                                                                <a href="{{route('writeOffBook', ['book' => $book->id])}}" tabindex="0"
                                                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                                role="menuitem">
                                                                    <i class="fas fa-level-up-alt mr-[14px] ml-[5px] py-1"></i>
                                                                    <span class="px-4 py-0">Otpiši knjigu</span>
                                                                </a>

                                                                <a href="{{route('rentBook', ['book' => $book->id])}}" tabindex="0"
                                                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                                role="menuitem">
                                                                    <i class="far fa-hand-scissors mr-[10px] ml-[5px] py-1"></i>
                                                                    <span class="px-4 py-0">Izdaj knjigu</span>
                                                                </a>

                                                                <a href="{{route('returnBook', ['book' => $book->id])}}" tabindex="0"
                                                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                                role="menuitem">
                                                                    <i class="fas fa-redo-alt mr-[10px] ml-[5px] py-1"></i>
                                                                    <span class="px-4 py-0">Vrati knjigu</span>
                                                                </a>

                                                                <a href="{{route('reserveBook', ['book' => $book->id])}}" tabindex="0"
                                                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                                role="menuitem">
                                                                    <i class="far fa-calendar-check mr-[10px] ml-[5px] py-1"></i>
                                                                    <span class="px-4 py-0">Rezerviši knjigu</span>
                                                                </a>

                                                                <a href="#" tabindex="0" id="{{$book->id}}"
                                                                class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600 show-deleteModal"
                                                                role="menuitem">
                                                                    <i class="fa fa-trash mr-[10px] ml-[5px] py-1"></i>
                                                                    <span class="px-4 py-0">Izbriši knjigu</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
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
                                        @endforeach
                                </tbody>
                            </table>
                            <div class="pt-[20px]">
                                {{$books->links()}}
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
                                <a class="text-blue-500" href="{{route('bookRecords')}}">
                                    &#8592; Nazad
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="mx-[20px] mt-[20px]">
                    <a href="{{route('addBook')}}" class="btn-animation inline-flex items-center text-sm py-2.5 px-5 rounded-[5px] tracking-wider text-white bg-[#3f51b5] hover:bg-[#4558BE]">
                        <i class="fas fa-plus mr-[15px]"></i> Nova knjiga
                    </a>
                <div class="w-[360px] flex items-center px-6 py-4 my-4 text-lg bg-red-200 rounded-lg">
                    <svg viewBox="0 0 24 24" class="w-5 h-5 mr-3 text-red-600 sm:w-5 sm:h-5">
                        <path fill="currentColor"
                                d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                        </path>
                    </svg>
                    <p class="font-medium text-red-600"> Ne postoji nijedna knjiga u bazi podataka! </p>
                </div>
            </div>
        @endif
    </section>
@endsection
