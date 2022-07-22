@extends('layouts.layout')

@section('publishers')
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
                <a href="{{route('policy')}}" class="inline hover:text-blue-800">
                    Polisa
                </a>
                <a href="{{route('categories')}}" class="inline ml-[70px] hover:text-blue-800">
                    Kategorija
                </a>
                <a href="{{route('genres')}}" class="inline ml-[70px] hover:text-blue-800">
                    Žanr
                </a>
                <a href="{{route('publishers')}}" class="inline ml-[70px] hover:text-blue-800 active-book-nav">
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
            <div class="height-categories pb-[30px] scroll">
                <div class="flex items-center px-[50px] py-8 space-x-3 rounded-lg">
                    <a href="{{route('addPublisher')}}"
                        class="btn-animation inline-flex items-center text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] tracking-wider text-white bg-[#3f51b5] hover:bg-[#4558BE] whitespace-nowrap">
                        <i class="fas fa-plus mr-[15px]"></i> Novi izdavač
                    </a>
                </div>
                @if(count($publishers) > 0)
                    <div
                        class="inline-block min-w-full px-[50px] pt-3 align-middle bg-white rounded-bl-lg rounded-br-lg shadow-dashboard">
                        <table class="min-w-full shadow-lg" id="myTable">
                            <thead class="bg-[#EFF3F6]">
                                <tr class="border-b-[1px] border-[#e4dfdf]">
                                    <th class="p-4 leading-4 tracking-wider text-left text-blue-500">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="form-checkbox">
                                        </label>
                                    </th>
                                    <th class="p-4 leading-4 tracking-wider text-left whitespace-nowrap">Naziv izdavača<a href="#"><i
                                                class="ml-3 fa-lg fas fa-long-arrow-alt-down" onclick="sortTable()"></i></a>
                                    </th>
                                    <th class="p-4"> </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($publishers as $publisher)
                                <tr class="hover:bg-gray-200 hover:shadow-md border-b-[1px] border-[#e4dfdf]">
                                    <td class="p-4">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" class="form-checkbox">
                                        </label>
                                    </td>
                                    <td class="flex flex-row items-center p-4 whitespace-nowrap">
                                        <p>{{$publisher->name}}</p>
                                    </td>
                                    <td class="p-4 text-sm leading-5 text-right">
                                        <p class="inline cursor-pointer text-[20px] py-[10px] px-[30px] border-gray-300 dotsPublisher hover:text-[#606FC7]">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </p>
                                        <div
                                            class="relative z-10 hidden transition-all duration-300 origin-top-right transform scale-95 -translate-y-2 dropdown-publisher">
                                            <div class="absolute right-[25px] w-56 mt-[7px] origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none"
                                                aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
                                                <div class="py-1">
                                                    <a href="{{route('editPublisher', ['publisher' => $publisher->id])}}" tabindex="0"
                                                        class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600"
                                                        role="menuitem">
                                                        <i class="fas fa-edit mr-[1px] ml-[5px] py-1"></i>
                                                        <span class="px-4 py-0">Izmijeni izdavača</span>
                                                    </a>
                                                    <a href="#" tabindex="0" id="{{$publisher->id}}"
                                                        class="flex w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 outline-none hover:text-blue-600 show-deleteModal"
                                                        role="menuitem">
                                                        <i class="fa fa-trash mr-[5px] ml-[5px] py-1"></i>
                                                        <span class="px-4 py-0">Izbriši izdavača</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!--Modal-->
                                <div
                                    class="absolute z-20 top-0 left-0 items-center justify-center hidden w-full h-screen bg-black bg-opacity-10 delete-modal_{{$publisher->id}}" id="{{$publisher->id}}">
                                    <!-- Modal -->
                                    <div class="w-[500px] bg-white rounded shadow-lg md:w-1/3">
                                        <!-- Modal Header -->
                                        <div class="flex items-center justify-between px-[30px] py-[20px] border-b">
                                            <h3>Da li ste sigurni da želite da izbrišete izdavača?</h3>
                                            <button class="text-black close cancel focus:outline-none" id="{{$publisher->id}}">
                                                <span aria-hidden="true" class="text-[30px]">&times;</span>
                                            </button>
                                        </div>
                                        <!-- Modal Body -->
                                        <div class="flex items-center justify-center px-[30px] py-[20px] border-t w-100 text-white">
                                            <a href="{{route('deletePublisher', ['publisher' => $publisher->id])}}"
                                                class=" text-center shadow-lg mr-[15px] w-[150px] focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                                <i class="fas fa-check mr-[7px]"></i> Izbriši
                                            </a>
                                            <a href="#" id="{{$publisher->id}}" class="cancel shadow-lg w-[150px] focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] bg-[#F44336] hover:bg-[#F55549] text-center">
                                            <i class="fas fa-times mr-[7px]"></i> Poništi 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>

                        {{$publishers->links()}}

                    </div>
                @else
                    <div class="mx-[50px]">
                        <div class="w-[400px] flex items-center px-6 py-4 my-4 text-lg bg-red-200 rounded-lg">                       
                            <svg viewBox="0 0 24 24" class="w-5 h-5 mr-3 text-red-600 sm:w-5 sm:h-5">
                                <path fill="currentColor"
                                        d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                                </path>
                            </svg>
                            <p class="font-medium text-red-600"> Ne postoji nijedan izdavač u bazi podataka! </p>
                        </div>
                    </div>   
                @endif
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
