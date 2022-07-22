@extends('layouts.layout')

@section('dashboard')
    <section class="w-screen h-screen pl-[80px] py-4 text-gray-700">
        <!-- Heading of content -->
        <div class="heading mt-[7px]">
            <h1 class="pl-[30px] pb-[21px]  border-b-[1px] border-[#e4dfdf] ">
                Dashboard
            </h1>
        </div>
        <!-- Space for content -->
        <div class="pl-[30px] scroll height-dashboard overflow-auto mt-[20px] pb-[30px]">
            <div class="flex flex-row justify-between">
                <div class="mr-[30px]">
                    <h3 class="uppercase mb-[20px]">Aktivnosti</h3>
                    <!-- Activity Cards -->
                    @if(count($activities) > 0)
                        @foreach($activities as $activity)
                            <div class="activity-card flex flex-row items-center mb-[30px]">
                                <div class="w-[60px] h-[60px]">
                                    <img class="rounded-full" src="/storage/image/{{$activity->librarian->photo}}" alt="">
                                </div>
                                <div class="ml-[16px] mt-[5px] flex flex-col">
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
                                                @if(count($activity->rentStatus) > 0)
                                                    {{$activity->rentStatus[0]->date}}.
                                                @endif
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
                            <a href="{{route('dashboardActivity')}}"
                            class="btn-animation block text-center w-full px-4 py-2 text-sm tracking-wider text-gray-600 transition duration-300 ease-in border-[1px] border-gray-400 rounded hover:bg-gray-200 focus:outline-none focus:ring-[1px] focus:ring-gray-300">
                                Prikaži
                            </a>
                        </div>
                    @else
                        <div>
                            <div class="w-[200px] flex items-center px-6 py-4 my-4 text-lg bg-red-200 rounded-lg">
                                <svg viewBox="0 0 24 24" class="w-5 h-5 mr-3 text-red-600 sm:w-5 sm:h-5">
                                    <path fill="currentColor"
                                            d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z">
                                    </path>
                                </svg>
                                <p class="font-medium text-red-600"> Nema aktivnosti. </p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="mr-[50px] ">
                    <h3 class="uppercase mb-[20px] text-left">
                        Rezervacije knjiga
                    </h3>
                    <div>
                        <table class="xl:w-[560px] w-[450px] table-auto">
                            <tbody class="bg-gray-200">
                                @foreach($reservations as $reservation)
                                    <tr class="bg-white border-b-[1px] border-[#e4dfdf]">
                                    <td class="flex flex-row items-center px-2 py-4 xl:max-w-[250px] max-w-[180px]">
                                        <img class="object-cover w-8 h-8 rounded-full "
                                             src="/storage/image/{{$reservation->student->photo}}" alt="" />
                                        <a href="{{route('studentProfile', ['user' => $reservation->student])}}" class="truncate ml-[16px] font-medium text-center">
                                            {{$reservation->student->name}}
                                        </a>
                                    <td>
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap">
                                        <a href="{{route('bookDetails', ['book' => $reservation->book])}}">
                                            {{$reservation->book->title}}
                                        </a>
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap">
                                        <span class="px-[10px] py-[3px] bg-gray-200 text-gray-800 rounded-[10px]">
                                            {{$reservation->reservation_date->toDateString()}}
                                        </span>
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap">
                                        <a href="#" class="hover:text-green-500 mr-[5px]">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="#" class="hover:text-red-500 ">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-right mt-[5px]">
                            <a href="{{route('activeReservations')}}" class="text-[#2196f3] hover:text-blue-600">
                                <i class="fas fa-calendar-alt mr-[4px]" aria-hidden="true"></i>
                                Prikaži sve
                            </a>
                        </div>
                    </div>
                    <div class="relative">
                        <h3 class="uppercase mb-[20px] text-left py-[30px]">
                            Statistika
                        </h3>
                        <div class="text-right">
                            <div class="flex pb-[30px]">
                                <a class="w-[145px] text-[#2196f3] hover:text-blue-600" href="{{route('rentedBooks')}}">
                                    Izdate knjige
                                </a>
                                <div class="ml-[30px] bg-green-600 transition duration-200 ease-in  hover:bg-green-900 stats-bar-green h-[26px]" style="width: {{$rentedNum}}px">

                                </div>
                                <p class="ml-[10px] number-green text-[#2196f3] hover:text-blue-600">
                                    {{$rentedNum}}
                                </p>
                            </div>
                            <div class="flex pb-[30px]">
                                <a class="w-[145px] text-[#2196f3] hover:text-blue-600" href="{{route('archivedReservations')}}">
                                    Rezervisane knjige
                                </a>
                                <div class="ml-[30px] bg-yellow-600 transition duration-200 ease-in  hover:bg-yellow-900 stats-bar-yellow  h-[26px]" style="width: {{$reservedNum}}px">

                                </div>
                                <p class="ml-[10px] text-[#2196f3] hover:text-blue-600 number-yellow">
                                    {{$reservedNum}}
                                </p>
                            </div>
                            <div class="flex pb-[30px]">
                                <a class="w-[145px] text-[#2196f3] hover:text-blue-600" href="{{route('overdueBooks')}}">
                                    Knjige u prekoračenju
                                </a>
                                <div class="ml-[30px] bg-red-600 transition duration-200 ease-in hover:bg-red-900 stats-bar-red h-[26px]" style="width: {{$overdueNum}}px">

                                </div>
                                <p class="ml-[10px] text-[#2196f3] hover:text-blue-600 number-red">
                                    {{$overdueNum}}
                                </p>
                            </div>
                        </div>
                        <div class="absolute h-[220px] w-[1px] bg-black top-[78px] left-[174px]">
                        </div>
                        <div class="absolute flex conte left-[175px] border-t-[1px] border-[#e4dfdf] top-[248px] pr-[40px]">
                            <p class="ml-[2px]">
                                0
                            </p>
                            <p class="ml-[38px]">
                                50
                            </p>
                            <p class="ml-[33px]">
                                100
                            </p>
                            <p class="ml-[26px]">
                                150
                            </p>
                            <p class="ml-[26px]">
                                200
                            </p>
                            <p class="ml-[26px]">
                                250
                            </p>
                            <p class="ml-[26px]">
                                300
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
