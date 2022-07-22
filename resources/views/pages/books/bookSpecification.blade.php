@extends('layouts.book')
@section('specificationBook')
    <div class="w-[80%]">
        <div class="border-b-[1px] py-4 text-gray-500 border-[#e4dfdf] pl-[30px]">
            <a href="{{route('bookDetails', ['book' => $book])}}" class="inline hover:text-blue-800">
                Osnovni detalji
            </a>
            <a href="{{route('bookSpecification', ['book' => $book])}}" class="inline ml-[70px] active-book-nav hover:text-blue-800">
                Specifikacija
            </a>
            <a href="{{route('rentingRented', ['book' => $book])}}" class="inline ml-[70px] hover:text-blue-800">
                Evidencija iznajmljivanja
            </a>
            <a href="{{route('bookMultimedia', ['book' => $book])}}" class="inline ml-[70px] hover:text-blue-800">
                Multimedija
            </a>
        </div>
        <div class="">
            <!-- Space for content -->
            <div class="pl-[30px] section- mt-[20px]">
                <div class="flex flex-row justify-between">
                    <div class="mr-[30px]">
                        <div class="mt-[20px]">
                            <span class="text-gray-500 text-[14px]">Broj strana</span>
                            <p class="font-medium">{{$book->pages}}</p>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500 text-[14px]">Pismo</span>
                            <p class="font-medium">{{$book->script->name}}</p>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500 text-[14px]">Jezik</span>
                            <p class="font-medium">{{$book->language->name}}</p>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500 text-[14px]">Povez</span>
                            <p class="font-medium">{{$book->binding->name}}</p>
                        </div>
                        <div class="mt-[40px]">
                            <span class="text-gray-500 text-[14px]">Format</span>
                            <p class="font-medium">{{$book->format->name}}</p>
                        </div>
                        <div class="mt-[40px]">
                                        <span class="text-gray-500 text-[14px]">Međunarodni standardni broj knjige
                                            (ISBN)</span>
                            <p class="font-medium">{{$book->ISBN}}</p>
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
@endsection
