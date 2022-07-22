@extends('layouts.layout')

@section('librarianProfile')
    <section class="w-screen h-screen pl-[80px] pb-2 text-gray-700">
        <!-- Heading of content -->
        <div class="heading">
                <div class="flex flex-row justify-between border-b-[1px] border-[#e4dfdf]">
                    <div class="pl-[30px] py-[10px] flex flex-col">
                        <div>
                            <h1>
                                {{$user -> name}}
                            </h1>
                        </div>
                        <div>
                            <nav class="w-full rounded">
                                <ol class="flex list-reset">
                                    <li>
                                        <a href="../librarians" class="text-[#2196f3] hover:text-blue-600">
                                            Svi bibliotekari
                                        </a>
                                    </li>
                                    <li>
                                        <span class="mx-2">/</span>
                                    </li>
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-blue-600">
                                            ID-{{$user -> id}}
                                        </a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        @if(Session::has('success'))
                            <div class="fadeInOut absolute top-[91px] py-[15px] px-[30px] rounded-[15px] text-white bg-[#4CAF50] right-[20px]">
                                <i class="fa fa-check mr-[5px]" aria-hidden="true"></i> {{ Session::get('success') }}
                                @php
                                    Session::forget('success');
                                @endphp
                            </div>
                        @endif
                        @error('pwReset')
                            <div class="fadeInOut absolute top-[91px] py-[15px] px-[30px] rounded-[15px] text-white bg-red-600 right-[20px]">
                                <p class="text-red-200">Password nije uspjesno resetovan!</p>
                            </div>
                        @enderror
                    </div>
                    <div class="pt-[24px] pr-[30px]">
                        @can('isMyAccount', $user)
                        <a href="#" class="inline hover:text-blue-600 show-modal">
                            <i class="fas fa-redo-alt mr-[3px]"></i>
                            Resetuj sifru
                        </a>
                        @endcan
                        <a href="{{ route('editLibrarian', ['user' => $user->id]) }}" class="hover:text-blue-600 inline ml-[20px] pr-[10px]">
                            <i class="fas fa-edit mr-[3px] "></i>
                            Izmjeni podatke
                        </a>
                        <p class="inline cursor-pointer text-[25px] py-[10px] pl-[30px] border-l-[1px] border-gray-300 dotsLibrarianProfile hover:text-[#606FC7]"
                        id="dropdownStudent">
                            <i
                                class="fas fa-ellipsis-v"></i>
                        </p>
                        <div
                            class="z-10 hidden transition-all duration-300 origin-top-right transform scale-95 -translate-y-2 dropdown-librarian-profile">
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
        <!-- Space for content -->
        <div class="pl-[30px] height-profile pb-[30px] scroll mt-[20px]">
                <div class="flex flex-row">
                    <div class="mr-[30px]">
                        <div class="mt-[20px]">
                            <span class="text-gray-500">Ime i prezime</span>
                            <p class="font-medium">{{$user -> name}}</p>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500">Tip korisnika</span>
                            <p class="font-medium">Bibliotekar</p>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500">JMBG</span>
                            <p class="font-medium">{{$user -> jmbg}}</p>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500">E-mail</span>
                            <a
                                class="cursor-pointer block font-medium text-[#2196f3] hover:text-blue-600">{{$user -> email}}</a>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500">Korisničko ime</span>
                            <p class="font-medium">{{$user -> username}}</p>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500">Broj logovanja</span>
                            <p class="font-medium">{{$user->login_count}}</p>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500">Poslednji put logovan/a</span>
                            <p class="font-medium">
                                @if ($user->login_count == 0)
                                    Nije logovan
                                @else
                                    {{$user->last_login_at}}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="ml-[100px] mt-[20px] w-48 h-48">
                        <img class="border-2 border-gray-300" width="300px" src="/storage/image/{{$user->photo}}" alt="">
                    </div>
                </div>
        </div>
          <!--Modal-->
        <div
            class="absolute z-20 top-0 left-0 items-center justify-center hidden w-full h-screen bg-black bg-opacity-10 delete-modal_{{$user->id}}" id="{{$user->id}}">
            <!-- Modal -->
            <div class="w-[500px] bg-white rounded shadow-lg md:w-1/3">
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-[30px] py-[20px] border-b">
                    <h3>Da li ste sigurni da želite da izbrišete bibliotekara?</h3>
                    <button class="text-black close cancel focus:outline-none" id="{{$user->id}}">
                        <span aria-hidden="true" class="text-[30px]">&times;</span>
                    </button>
                </div>
                <!-- Modal Body -->
                <div class="flex items-center justify-center px-[30px] py-[20px] border-t w-100 text-white">
                    <a href="{{ route('deleteLibrarian', ['user' => $user->id]) }}"
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
