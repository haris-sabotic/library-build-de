@extends('layouts.book')

@section('multimediaBook')
    <div class="w-[80%]">
        <div class="border-b-[1px] border-[#e4dfdf] py-4 text-gray-500 pl-[30px]">
            <a href="{{route('bookDetails', ['book' => $book])}}" class="inline hover:text-blue-800">
                Osnovni detalji
            </a>
            <a href="{{route('bookSpecification', ['book' => $book])}}" class="inline ml-[70px]  hover:text-blue-800">
                Specifikacija
            </a>
            <a href="{{route('rentingRented', ['book' => $book])}}" class="inline ml-[70px] hover:text-blue-800">
                Evidencija iznajmljivanja
            </a>
            <a href="{{route('bookMultimedia', ['book' => $book])}}" class="inline ml-[70px] active-book-nav hover:text-blue-800">
                Multimedija
            </a>
        </div>
        <div class="">
            <!-- Space for content -->
            @if(count($book->galery) > 0)
            <div class="mt-[20px] mx-0 w-[100%]">
                <div class="flex flex-row">
                    <div class="w-[100%]">
                        <div class="w-[90%] flex flex-row flex-wrap mx-auto bg-white rounded p7 mt-[20px]">
                            @foreach($book->galery as $image) 
                            <div class="p-[15px] w-[430px] h-[300px]">
                                <img class="w-full h-full" src="/storage/image/{{$image->photo}}" alt="">
                            </div>
                            @endforeach
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
            @else
            <div class="mx-[40px] flex items-center px-6 py-4 my-4 text-lg bg-red-200 rounded-lg">
                <p class="font-medium text-red-600"> Knjiga {{$book->title}} nema slike! </p>
            </div>
        @endif
        </div>
    </div>
@endsection
