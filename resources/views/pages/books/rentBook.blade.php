@extends('layouts.layout')

@section('rentBook')

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
                                            <a href="#"
                                                class="text-gray-400 hover:text-blue-600">
                                                Izdaj knjigu
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
                        <p class="inline cursor-pointer text-[25px] py-[10px] pl-[30px] border-l-[1px] border-[#e4dfdf] dotsRentBook hover:text-[#606FC7]">
                            <i
                                class="fas fa-ellipsis-v"></i>
                        </p>
                        <div
                            class="relative z-10 hidden transition-all duration-300 origin-top-right transform scale-95 -translate-y-2 dropdown-rent-book">
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

            <!-- Space for content -->
            <div class="scroll height-content section-content">
                <form action="{{route('rent', ['book' => $book->id])}}" method="POST"  class="text-gray-700">
                @csrf
                    <div class="flex flex-row ml-[30px]">
                        <div class="w-[50%] mb-[100px] mr-[100px]">
                            <h3 class="mt-[20px] mb-[10px]">Izdaj knjigu</h3>
                            <div class="mt-[20px]">
                                <p>Izaberi učenika koji zadužuje knjigu <span class="text-red-500">*</span></p>
                                <select
                                    class="flex w-[90%] mt-2 px-2 py-2 border bg-white border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#576cdf]"
                                    name="student" id="student">
                                    <option disabled selected></option>
                                    @foreach($students as $student)
                                        <option value="{{$student->id}}">{{$student->name}}</option>
                                    @endforeach
                                </select>
                                @error('student')
                                <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-[20px] flex justify-between w-[90%]">
                                <div class="w-[50%]">
                                    <p>Datum izdavanja <span class="text-red-500">*</span></p>
                                    <label class="text-gray-700" for="date">
                                        <input type="date" name="rentDate" id="rentDate" max="{{Carbon\Carbon::now()->format('Y-m-d')}}"
                                            class="flex w-[90%] mt-2 px-4 py-2 text-base placeholder-gray-400 bg-white border border-gray-300 appearance-none focus:outline-none focus:ring-2 focus:ring-[#576cdf]"
                                            onchange="returnDateFunction({{$returnDueDate->value}});" />
                                    </label>
                                    @error('rentDate')
                                        <div class="text-red-500">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="w-[50%]">
                                    <p>Datum vraćanja</p>
                                    <label class="text-gray-700" for="date">
                                        <input type="date" id="returnDate" name="returnDate"
                                            class="flex w-[90%] mt-2 px-2 py-2 text-base text-gray-400 bg-white border border-gray-300 shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-[#576cdf]"
                                            readonly="readonly" />
                                    </label>
                                    <div>
                                        <p>Rok vraćanja: {{$returnDueDate->value}} dana</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-[50%] mb-[100px]">
                            <div class="border-[1px] border-[#e4dfdf] w-[360px] mt-[75px]">
                                <h2 class="mt-[20px] ml-[30px]">KOLIČINE</h2>
                                <div class="ml-[30px] mr-[70px] mt-[20px] flex flex-row justify-between">
                                    <div class="text-gray-500 ">
                                        <p>Na raspolaganju:</p>
                                        <p class="mt-[20px]">Rezervisano:</p>
                                        <p class="mt-[20px]">Izdato:</p>
                                        <p class="mt-[20px]">U prekoračenju:</p>
                                        <p class="mt-[20px]">Ukupna količina:</p>
                                    </div>
                                    <div class="text-center pb-[30px]">
                                        <p
                                            class=" bg-green-200 text-green-700 rounded-[10px] px-[6px] py-[2px] text-[14px]">
                                            {{$book -> quantity- $book->reservedBooks - $book->rentedBooks}}
                                            primjeraka</p>
                                        <a href="{{route('rentingActive', ['book' => $book])}}">
                                            <p
                                                class=" mt-[16px] bg-yellow-200 text-yellow-700 rounded-[10px] px-[6px] py-[2px] text-[14px]">
                                                {{$book -> reservedBooks}} primjeraka</p>
                                        </a>
                                        <a href="{{route('rentingRented', ['book' => $book])}}">
                                            <p
                                                class=" mt-[16px] bg-blue-200 text-blue-800 rounded-[10px] px-[6px] py-[2px] text-[14px]">
                                                {{$book -> rentedBooks}} primjeraka</p>
                                        </a>
                                        <a href="{{route('rentingOverdue', ['book' => $book])}}">
                                            <p
                                                class=" mt-[16px] bg-red-200 text-red-800 rounded-[10px] px-[6px] py-[2px] text-[14px]">
                                                {{count($overdueBooks)}} primjeraka</p>
                                        </a>
                                        <p
                                            class=" mt-[16px] bg-purple-200 text-purple-700 rounded-[10px] px-[6px] py-[2px] text-[14px]">
                                            {{$book -> quantity}} primjeraka</p>
                                    </div>
                                </div>
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
                                <button id="rentBook" type="submit"
                                    class="btn-animation shadow-lg w-[150px] disabled:opacity-50 focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] hover:bg-[#46A149] bg-[#4CAF50]">
                                    <i class="fas fa-check mr-[7px]"></i> Izdaj knjigu 
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
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
        </section>

@endsection
