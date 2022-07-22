@extends('layouts.layout')

@section('bookDetails')

    <section class="w-screen h-screen pl-[80px] pb-2 text-gray-700">
        <!-- Heading of content -->
        <div class="heading">
            <div class="flex flex-row justify-between border-b-[1px] border-[#e4dfdf]">
                <div class="py-[10px] flex flex-row">
                    <div class="w-[77px] h-[72px] pl-[30px] flex items-center">
                        @if(count($book->coverImage) > 0 )
                            <img class="w-[77px]" src="/storage/image/{{$book->coverImage[0]->photo}}" alt="">
                        @endif
                    </div>
                    <div class="pl-[16px]  flex flex-col">
                        <div>
                            <h1>
                                {{$book->title}}
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
                                           class="text-gray-400 hover:text-blue-600">
                                            KNJIGA-{{$book->id}}
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
                    <a href="{{route('rentBook', ['book' => $book])}}" class="inline hover:text-blue-600 ml-[20px] pr-[10px]">
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
                    <p class="inline cursor-pointer text-[25px] py-[10px] pl-[30px] border-l-[1px] border-[#e4dfdf] dotsBookDetails hover:text-[#606FC7]">
                        <i
                            class="fas fa-ellipsis-v"></i>
                    </p>
                    <div
                        class="z-10 hidden transition-all duration-300 origin-top-right transform scale-95 -translate-y-2 dropdown-book-details">
                        <div class="absolute right-0 w-56 mt-[7px] origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg outline-none"
                             aria-labelledby="headlessui-menu-button-1" id="headlessui-menu-items-117" role="menu">
                            <div class="py-1">
                                <a href="{{route('editBook', ['book' => $book])}}" tabindex="0"
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
        </div>
        <div class="flex flex-row overflow-auto height-bookDetails">
            <!-- PLACE FOR YIELDING BOOK SECTIONS -->
            @yield('detailsBook')
            @yield('specificationBook')
            @yield('multimediaBook')
            @yield('rentedRenting')
            @yield('overdueRenting')
            @yield('returnedRenting')
            @yield('activeRenting')
            @yield('archivedRenting')
            <div class="min-w-[20%] border-l-[1px] border-[#e4dfdf] ">
                <div class="border-b-[1px] border-[#e4dfdf]">
                    <div class="mx-[30px] mt-[20px] flex flex-row">
                        <div class="text-gray-500 mr-[30px]">
                            <p>Na raspolaganju:</p>
                            <p class="mt-[20px]">Rezervisano:</p>
                            <p class="mt-[20px]">Izdato:</p>
                            <p class="mt-[20px]">U prekoračenju:</p>
                            <p class="mt-[20px]">Ukupna količina:</p>
                        </div>
                        <div class="text-center pb-[30px]">
                            <p class=" bg-green-200 text-green-700 rounded-[10px] px-[6px] py-[2px] text-[14px]">
                                {{$book->quantity - $book->reservedBooks - $book->rentedBooks}} primjeraka
                            </p>
                            <a href="{{route('rentingArchived', ['book' => $book->id])}}"><p
                                    class=" mt-[16px] bg-yellow-200 text-yellow-700 rounded-[10px] px-[6px] py-[2px] text-[14px]">
                                    {{$book->reservedBooks}} primjeraka</p></a>
                            <a href="{{route('rentingRented', ['book' => $book->id])}}"><p
                                    class=" mt-[16px] bg-blue-200 text-blue-800 rounded-[10px] px-[6px] py-[2px] text-[14px]">
                                    {{$book->rentedBooks}} primjeraka</p></a>
                            <a href="{{route('rentingOverdue', ['book' => $book->id])}}">
                                <p class=" mt-[16px] bg-red-200 text-red-800 rounded-[10px] px-[6px] py-[2px] text-[14px]">
                                    @php
                                        $service = new \App\Services\RentService;
                                    @endphp
                                    {{count($service->getOverdueBooks()->where('book_id', '=', $book->id)->get())}} primjeraka
                                </p>
                            </a>
                            <p
                                class=" mt-[16px] bg-purple-200 text-purple-700 rounded-[10px] px-[6px] py-[2px] text-[14px]">
                                {{$book->quantity}} primjeraka
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mx-[30px]">
                    @foreach($activities as $activity)

                        <div class="mt-[40px] flex flex-col max-w-[304px]">
                            <div class="text-gray-500 ">
                                @if(count($activity->rentStatus) > 0)
                                    @if($activity->rentStatus[0]->statusBook_id == 2)
                                        <p class="inline uppercase">
                                            Izdavanje knjige
                                            <span class="inline lowercase">
                                                    - {{$activity->rentStatus[0]->date->diffForHumans()}}
                                                    </span>
                                        </p>
                                    @else
                                        <p class="inline uppercase">
                                            Vraćanje knjige
                                            <span class="inline lowercase">
                                                    - {{$activity->rentStatus[0]->date->diffForHumans()}}
                                                    </span>
                                        </p>
                                    @endif
                                @endif
                            </div>
                            <div>
                                <p>
                                    <a href="{{route('librarianProfile', ['user' => $activity->librarian])}}" class="text-[#2196f3] hover:text-blue-600">
                                        {{$activity->librarian->name}}
                                    </a>
                                    @if(count($activity->rentStatus) > 0)
                                        @if($activity->rentStatus[0]->statusBook_id == 2)
                                            izdao/la knjigu učeniku
                                        @else
                                            vratio/la knjigu od učenika
                                        @endif
                                    @endif
                                    <a href="{{route('studentProfile', ['user' => $activity->student])}}" class="text-[#2196f3] hover:text-blue-600">
                                        {{$activity->student->name}}
                                    </a>
                                    dana
                                    <span class="font-medium">
                                        @if(count($activity->rentStatus) > 0)
                                            {{$activity->rentStatus[0]->date}}.
                                        @endif
                                    </span>
                                </p>
                            </div>
                            <div>
                                <a href="{{route('rentDetails', ['book' => $activity->book, 'student' => $activity->student])}}" class="text-[#2196f3] hover:text-blue-600">
                                    više detalja >>
                                </a>
                            </div>
                        </div>
                    @endforeach
                    @if($activities->count() > 0 )
                            <div class="mt-[40px]">
                                <a href="{{route('dashboardActivitySpecificBook', ['book' => $book])}}" class="text-[#2196f3] hover:text-blue-600">
                                    <i class="fas fa-history"></i> Prikaži sve
                                </a>
                            </div>
                        @else
                            <div class="mt-[40px] flex flex-col max-w-[304px]">
                                <div class="text-gray-500 ">
                                    <p class="inline uppercase">
                                        NEMA INFORMACIJA O AKTIVNOSTIMA
                                    </p>
                                </div>
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </section>

@endsection
