@extends('layouts.layout')
@section('editBook')
    <section class="w-screen h-screen pl-[80px] pb-4 text-gray-700" xmlns:x-bind="http://www.w3.org/1999/xhtml">
        <!-- Heading of content -->
        <div class="heading">
            <div class="flex border-b-[1px] border-[#e4dfdf]">
                <div class="pl-[30px] py-[10px] flex flex-col">
                    <div>
                        <h1>
                            Izmijeni podatke
                        </h1>
                    </div>
                    <div>
                        <nav class="w-full rounded">
                            <ol class="flex list-reset">
                                <li>
                                    <a href="../bookRecords" class="text-[#2196f3] hover:text-blue-600">
                                        Evidencija knjiga
                                    </a>
                                </li>
                                <li>
                                    <span class="mx-2">/</span>
                                </li>
                                <li>
                                    <a href="#" class="text-gray-400 hover:text-blue-600">
                                        Izmijeni podatke
                                    </a>
                                </li>
                            </ol>
                        </nav>
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
            <div id="successBookEdit"></div>
        </div>
        <div class="py-4 text-gray-500 border-b-[1px] border-[#e4dfdf] pl-[30px]">
            <p onclick="openTab(event, 'editDetails')" class="inline cursor-pointer active-book-nav tablinks hover:text-blue-800">
                Osnovni detalji
            </p>
            <p  onclick="openTab(event, 'editSpecification')" class="cursor-pointer tablinks inline ml-[70px] hover:text-blue-800">
                Specifikacija
            </p>
            <p onclick="openTab(event, 'editMultimedia')" class="cursor-pointer tablinks inline ml-[70px] hover:text-blue-800">
                Multimedija
            </p>
        </div>
        <!-- Space for content -->
        <form action="{{route('updateBook', ['book' => $book->id])}}" method="POST" class="text-gray-700 scroll height-content" id="editBookForm">
            @csrf
            <input type="hidden" name="editBookId" value="{{$book->id}}"/>
            <div id="editDetails" class="block tabcontent">
                <div>

                    <div class="flex flex-row ml-[30px] mb-[150px]">
                        <div class="w-[50%]">
                            <div class="mt-[20px]">
                                <p>Naziv knjige <span class="text-red-500">*</span></p>
                                <input type="text" name="bookTitleEdit" id="bookTitleEdit" value="{{$book->title}}"
                                       class="flex w-[90%] mt-2 px-2 py-2 text-base bg-white border border-gray-300 shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-[#576cdf]"
                                       onkeydown="clearErrorsNazivKnjigaEdit()" />
                                @error('bookTitleEdit')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-[20px]">
                                <p class="inline-block mb-2">Kratki sadržaj</p>
                                <textarea name="summary_edit"
                                          class="flex w-[90%] mt-2 px-2 py-2 text-base bg-white border border-gray-300 shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-[#576cdf]">
                                    {{$book->summary}}
                                </textarea>
                            </div>

                            <div class="mt-[20px]">
                                <p>Izaberite kategorije <span class="text-red-500">*</span></p>
                                <select x-cloak id="categoryEdit">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>

                                <div x-data="dropdown()" x-init="loadOptionsEdit()" class="flex flex-col w-[90%]">
                                    <input name="categoryValuesEdit" id="categoryInputEdit" type="hidden"
                                           x-bind:value="selectedValuesCategoryEdit()">
                                    <div class="relative inline-block w-[100%]">
                                        <div class="relative flex flex-col items-center">
                                            <div x-on:click="open" class="w-full svelte-1l8159u">
                                                <div class="flex p-1 my-2 bg-white border border-gray-300 shadow-sm svelte-1l8159u focus-within:ring-2 focus-within:ring-[#576cdf]"
                                                     onclick="clearErrorsKategorijaEdit()">
                                                    <div class="flex flex-wrap flex-auto">
                                                        <template x-for="(option,index) in selected"
                                                                  :key="options[option].value">
                                                            <div
                                                                class="flex items-center justify-center px-[6px] py-[2px] m-1 text-blue-800 bg-blue-200 rounded-[10px] ">
                                                                <div class="text-xs font-normal leading-none max-w-full flex-initial x-model="
                                                                     options[option] x-text="options[option].text">
                                                                </div>
                                                                <div class="flex flex-row-reverse flex-auto">
                                                                    <div x-on:click="remove(index,option)">
                                                                        <svg class="w-6 h-6 fill-current " role="button"
                                                                             viewBox="0 0 20 20">
                                                                            <path
                                                                                d="M14.348,14.849c-0.469,0.469-1.229,0.469-1.697,0L10,11.819l-2.651,3.029c-0.469,0.469-1.229,0.469-1.697,0
                                                                                                    c-0.469-0.469-0.469-1.229,0-1.697l2.758-3.15L5.651,6.849c-0.469-0.469-0.469-1.228,0-1.697s1.228-0.469,1.697,0L10,8.183
                                                                                                    l2.651-3.031c0.469-0.469,1.228-0.469,1.697,0s0.469,1.229,0,1.697l-2.758,3.152l2.758,3.15
                                                                                                    C14.817,13.62,14.817,14.38,14.348,14.849z" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- </div> -->
                                                        </template>
                                                    
                                                        <div x-show="selected.length    == 0" class="flex-1">
                                                            <input
                                                                class="w-full h-full p-1 px-2 text-gray-800 bg-transparent outline-none appearance-none"
                                                                x-bind:value="selectedValuesCategoryEdit()">
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="flex items-center w-8 py-1 pl-2 pr-1 text-gray-300 svelte-1l8159u">
                                                        <button type="button" x-show="isOpen() === true" x-on:click="open"
                                                                class="w-6 h-6 text-gray-600 outline-none cursor-pointer focus:outline-none">
                                                            <svg version="1.1" class="w-[10px] h-[9px] ml-[15px]"
                                                                viewBox="0 0 20 20" stroke="#374151" stroke-width="3">
                                                                <path d="M17.418,6.109c0.272-0.268,0.709-0.268,0.979,0s0.271,0.701,0,0.969l-7.908,7.83
                                                                                        c-0.27,0.268-0.707,0.268-0.979,0l-7.908-7.83c-0.27-0.268-0.27-0.701,0-0.969c0.271-0.268,0.709-0.268,0.979,0L10,13.25
                                                                                        L17.418,6.109z" />
                                                            </svg>
                                                        </button>
                                                        <button type="button" x-show="isOpen() === false" @click="close"
                                                                class="w-6 h-6 text-gray-600 outline-none cursor-pointer focus:outline-none">
                                                            <svg version="1.1" class="w-[10px] h-[9px] ml-[15px]"
                                                                viewBox="0 0 20 20" stroke="#374151" stroke-width="3">
                                                                <path d="M17.418,6.109c0.272-0.268,0.709-0.268,0.979,0s0.271,0.701,0,0.969l-7.908,7.83
                                                                                        c-0.27,0.268-0.707,0.268-0.979,0l-7.908-7.83c-0.27-0.268-0.27-0.701,0-0.969c0.271-0.268,0.709-0.268,0.979,0L10,13.25
                                                                                        L17.418,6.109z" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="w-full">
                                                <div x-show.transition.origin.top="isOpen()"
                                                    class="z-40 w-full overflow-y-auto bg-white rounded shadow max-h-select svelte-5uyqqj"
                                                    x-on:click.away="close">
                                                    <div class="flex flex-col w-full">
                                                        <template x-for="(option,index) in options" :key="option">
                                                            <div>
                                                                <div class="w-full border-b border-gray-100 rounded-t cursor-pointer hover:bg-teal-100"
                                                                    @click="select(index,$event)">
                                                                    <div x-bind:class="option.selected ? 'border-teal-600' : ''"
                                                                        class="relative flex items-center w-full p-2 pl-2 border-l-2 border-transparent">
                                                                        <div class="flex items-center w-full">
                                                                            <div class="mx-2 leading-6" x-model="option"
                                                                                x-text="option.text">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('categoryValuesEdit')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-[20px]">
                                <p>Izaberite žanrove <span class="text-red-500">*</span></p>
                                <select x-cloak id="genreEdit">
                                    @foreach($genres as $genre)
                                        <option value="{{$genre->id}}">{{$genre->name}}</option>
                                    @endforeach
                                </select>

                                <div x-data="dropdown()" x-init="loadOptionsGenresEdit()" class="flex flex-col w-[90%]">
                                    <input name="genreValuesEdit" id="genresInputEdit" type="hidden" x-bind:value="selectedValuesGenreEdit()">
                                    <div class="relative inline-block w-[100%]">
                                        <div class="relative flex flex-col items-center">
                                            <div x-on:click="open" class="w-full svelte-1l8159u">
                                                <div class="flex p-1 my-2 bg-white border border-gray-300 shadow-sm svelte-1l8159u focus-within:ring-2 focus-within:ring-[#576cdf]"
                                                    onclick="clearErrorsZanrEdit()">
                                                    <div class="flex flex-wrap flex-auto">
                                                        <template x-for="(option,index) in selected"
                                                                :key="options[option].value">
                                                            <div
                                                                class="flex items-center justify-center px-[6px] py-[2px] m-1 text-blue-800 bg-blue-200 rounded-[10px] ">
                                                                <div class="text-xs font-normal leading-none max-w-full flex-initial x-model="
                                                                    options[option] x-text="options[option].text">
                                                                </div>
                                                                <div class="flex flex-row-reverse flex-auto">
                                                                    <div x-on:click="remove(index,option)">
                                                                        <svg class="w-6 h-6 fill-current " role="button"
                                                                            viewBox="0 0 20 20">
                                                                            <path
                                                                                d="M14.348,14.849c-0.469,0.469-1.229,0.469-1.697,0L10,11.819l-2.651,3.029c-0.469,0.469-1.229,0.469-1.697,0
                                                                                                        c-0.469-0.469-0.469-1.229,0-1.697l2.758-3.15L5.651,6.849c-0.469-0.469-0.469-1.228,0-1.697s1.228-0.469,1.697,0L10,8.183
                                                                                                        l2.651-3.031c0.469-0.469,1.228-0.469,1.697,0s0.469,1.229,0,1.697l-2.758,3.152l2.758,3.15
                                                                                                        C14.817,13.62,14.817,14.38,14.348,14.849z" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>
                                                        <div x-show="selected.length    == 0" class="flex-1">
                                                            <input
                                                                class="w-full h-full p-1 px-2 text-gray-800 bg-transparent outline-none appearance-none"
                                                                x-bind:value="selectedValuesGenreEdit()">
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="flex items-center w-8 py-1 pl-2 pr-1 text-gray-300 svelte-1l8159u">
                                                        <button type="button" x-show="isOpen() === true" x-on:click="open"
                                                                class="w-6 h-6 text-gray-600 outline-none cursor-pointer focus:outline-none">
                                                            <svg version="1.1" class="w-[10px] h-[9px] ml-[15px]"
                                                                viewBox="0 0 20 20" stroke="#374151" stroke-width="3">
                                                                <path d="M17.418,6.109c0.272-0.268,0.709-0.268,0.979,0s0.271,0.701,0,0.969l-7.908,7.83
                                                                                            c-0.27,0.268-0.707,0.268-0.979,0l-7.908-7.83c-0.27-0.268-0.27-0.701,0-0.969c0.271-0.268,0.709-0.268,0.979,0L10,13.25
                                                                                            L17.418,6.109z" />
                                                            </svg>
                                                        </button>
                                                        <button type="button" x-show="isOpen() === false" @click="close"
                                                                class="w-6 h-6 text-gray-600 outline-none cursor-pointer focus:outline-none">
                                                            <svg version="1.1" class="w-[10px] h-[9px] ml-[15px]"
                                                                viewBox="0 0 20 20" stroke="#374151" stroke-width="3">
                                                                <path d="M17.418,6.109c0.272-0.268,0.709-0.268,0.979,0s0.271,0.701,0,0.969l-7.908,7.83
                                                                                            c-0.27,0.268-0.707,0.268-0.979,0l-7.908-7.83c-0.27-0.268-0.27-0.701,0-0.969c0.271-0.268,0.709-0.268,0.979,0L10,13.25
                                                                                            L17.418,6.109z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-full">
                                                <div x-show.transition.origin.top="isOpen()"
                                                    class="z-40 w-full overflow-y-auto bg-white rounded shadow max-h-select svelte-5uyqqj"
                                                    x-on:click.away="close">
                                                    <div class="flex flex-col w-full">
                                                        <template x-for="(option,index) in options" :key="option">
                                                            <div>
                                                                <div class="w-full border-b border-gray-100 rounded-t cursor-pointer hover:bg-teal-100"
                                                                    @click="select(index,$event)">
                                                                    <div x-bind:class="option.selected ? 'border-teal-600' : ''"
                                                                        class="relative flex items-center w-full p-2 pl-2 border-l-2 border-transparent">
                                                                        <div class="flex items-center w-full">
                                                                            <div class="mx-2 leading-6" x-model="option"
                                                                                x-text="option.text">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('genreValuesEdit')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="w-[50%]">
                            <div class="mt-[20px]">
                                <p>Izaberite autore <span class="text-red-500">*</span></p>
                                <select x-cloak id="authorsEdit">
                                    @foreach($authors as $author)
                                        <option value="{{$author->id}}">{{$author->name}}</option>
                                    @endforeach
                                </select>

                                <div x-data="dropdown()" x-init="loadOptionsAuthorsEdit()" class="flex flex-col w-[90%]">
                                    <input name="authorsValuesEdit" id="authorsInputEdit" type="hidden" x-bind:value="selectedValuesAuthorsEdit()">
                                    <div class="relative inline-block w-[100%]">
                                        <div class="relative flex flex-col items-center">
                                            <div x-on:click="open" class="w-full svelte-1l8159u">
                                                <div class="flex p-1 my-2 bg-white border border-gray-300 shadow-sm svelte-1l8159u focus-within:ring-2 focus-within:ring-[#576cdf]"
                                                    onclick="clearErrorsAutoriEdit()">
                                                    <div class="flex flex-wrap flex-auto">
                                                        <template x-for="(option,index) in selected" :key="options[option].value">
                                                            <div
                                                                class="flex items-center justify-center px-[6px] py-[2px] m-1 text-blue-800 bg-blue-200 rounded-[10px] ">
                                                                <div class="text-xs font-normal leading-none max-w-full flex-initial x-model="
                                                                    options[option] x-text="options[option].text">
                                                                </div>
                                                                <div class="flex flex-row-reverse flex-auto">
                                                                    <div x-on:click="remove(index,option)">
                                                                        <svg class="w-6 h-6 fill-current " role="button"
                                                                            viewBox="0 0 20 20">
                                                                            <path
                                                                                d="M14.348,14.849c-0.469,0.469-1.229,0.469-1.697,0L10,11.819l-2.651,3.029c-0.469,0.469-1.229,0.469-1.697,0
                                                                                                            c-0.469-0.469-0.469-1.229,0-1.697l2.758-3.15L5.651,6.849c-0.469-0.469-0.469-1.228,0-1.697s1.228-0.469,1.697,0L10,8.183
                                                                                                            l2.651-3.031c0.469-0.469,1.228-0.469,1.697,0s0.469,1.229,0,1.697l-2.758,3.152l2.758,3.15
                                                                                                            C14.817,13.62,14.817,14.38,14.348,14.849z" />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>
                                                        <div x-show="selected.length    == 0" class="flex-1">
                                                            <input
                                                                class="w-full h-full p-1 px-2 text-gray-800 bg-transparent outline-none appearance-none"
                                                                x-bind:value="selectedValuesAuthorsEdit()">
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center w-8 py-1 pl-2 pr-1 text-gray-300 svelte-1l8159u">
                                                        <button type="button" x-show="isOpen() === true" x-on:click="open"
                                                                class="w-6 h-6 text-gray-600 outline-none cursor-pointer focus:outline-none">
                                                            <svg version="1.1" class="w-[10px] h-[9px] ml-[15px]" viewBox="0 0 20 20"
                                                                stroke="#374151" stroke-width="3">
                                                                <path d="M17.418,6.109c0.272-0.268,0.709-0.268,0.979,0s0.271,0.701,0,0.969l-7.908,7.83
                                                                                                c-0.27,0.268-0.707,0.268-0.979,0l-7.908-7.83c-0.27-0.268-0.27-0.701,0-0.969c0.271-0.268,0.709-0.268,0.979,0L10,13.25
                                                                                                L17.418,6.109z" />
                                                            </svg>
                                                        </button>
                                                        <button type="button" x-show="isOpen() === false" @click="close"
                                                                class="w-6 h-6 text-gray-600 outline-none cursor-pointer focus:outline-none">
                                                            <svg version="1.1" class="w-[10px] h-[9px] ml-[15px]" viewBox="0 0 20 20"
                                                                stroke="#374151" stroke-width="3">
                                                                <path d="M17.418,6.109c0.272-0.268,0.709-0.268,0.979,0s0.271,0.701,0,0.969l-7.908,7.83
                                                                                                c-0.27,0.268-0.707,0.268-0.979,0l-7.908-7.83c-0.27-0.268-0.27-0.701,0-0.969c0.271-0.268,0.709-0.268,0.979,0L10,13.25
                                                                                                L17.418,6.109z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-full">
                                                <div x-show.transition.origin.top="isOpen()"
                                                    class="z-40 w-full overflow-y-auto bg-white rounded shadow max-h-select svelte-5uyqqj"
                                                    x-on:click.away="close">
                                                    <div class="flex flex-col w-full">
                                                        <template x-for="(option,index) in options" :key="option">
                                                            <div>
                                                                <div class="w-full border-b border-gray-100 rounded-t cursor-pointer hover:bg-teal-100"
                                                                    @click="select(index,$event)">
                                                                    <div x-bind:class="option.selected ? 'border-teal-600' : ''"
                                                                        class="relative flex items-center w-full p-2 pl-2 border-l-2 border-transparent">
                                                                        <div class="flex items-center w-full">
                                                                            <div class="mx-2 leading-6" x-model="option"
                                                                                x-text="option.text">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('authorsValuesEdit')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-[20px]">
                                <p>Izdavač <span class="text-red-500">*</span></p>
                                <select placeholder="{{$book->publisher->name}}"
                                    class="flex w-[45%] mt-2 px-2 py-2 border bg-white border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#576cdf]"
                                    name="publisherEdit" id="publisherEdit" onclick="clearErrorsIzdavacEdit()">
                                    <option disabled></option>
                                    <option value="{{$book->publisher->id}}">{{$book->publisher->name}}</option>
                                    @foreach($publishers as $publisher)
                                        @if($publisher->name == $book->publisher->name)
                                            <option class="hidden" value="{{$publisher->id}}"></option>
                                        @else
                                            <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('publisherEdit')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-[20px]">
                                <p>Godina izdavanja <span class="text-red-500">*</span></p>
                                <select
                                    class="flex w-[45%] mt-2 px-2 py-2 border bg-white border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#576cdf]"
                                    name="publishYearEdit" id="publishYearEdit" onclick="clearErrorsGodinaIzdavanjaEdit()">
                                    <option disabled></option>
                                    @for($i=1500; $i<=2021; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                                @error('publishYearEdit')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-[20px]">
                                <p>Količina <span class="text-red-500">*</span></p>
                                <input type="text" name="quantityEdit" id="quantityEdit" value="{{$book->quantity}}"
                                    class="flex w-[45%] mt-2 px-2 py-2 text-base bg-white border border-gray-300 shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-[#576cdf]"
                                    onkeydown="clearErrorsKnjigaKolicinaEdit()" />
                                @error('quantityEdit')
                                    <div class="text-red-500">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                    </div>

                </div>

            </div>
            
            <div id="editSpecification" class="tabcontent hidden ml-[30px]">
                <div class="w-[50%] mb-[150px]">
                    <div class="mt-[20px]">
                        <p>Broj strana <span class="text-red-500">*</span></p>
                        <input type="text" name="pagesEdit" id="pagesEdit" value="{{$book->pages}}" class="flex w-[45%] mt-2 px-2 py-2 text-base bg-white border border-gray-300 shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-[#576cdf]" onkeydown="clearErrorsBrStranaEdit()"/>
                        @error('pagesEdit')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-[20px]">
                        <p>Pismo <span class="text-red-500">*</span></p>
                        <select class="flex w-[45%] mt-2 px-2 py-2 border bg-white border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#576cdf]" name="scriptEdit" id="scriptEdit" onclick="clearErrorsPismoEdit()">
                            <option disabled></option>
                            @foreach($scripts as $script)
                                <option value="{{$script->id}}">{{$script->name}}</option>
                            @endforeach
                        </select>
                        @error('scriptEdit')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-[20px]">
                        <p>Jezik <span class="text-red-500">*</span></p>
                        <select class="flex w-[45%] mt-2 px-2 py-2 border bg-white border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#576cdf]" name="languageEdit" id="languageEdit">
                            <option disabled></option>
                            @foreach($languages as $language)
                                <option value="{{$language->id}}">{{$language->name}}</option>
                            @endforeach
                        </select>
                        @error('languageEdit')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-[20px]">
                        <p>Povez <span class="text-red-500">*</span></p>
                        <select class="flex w-[45%] mt-2 px-2 py-2 border bg-white border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#576cdf]" name="bindingEdit" id="bindingEdit" onclick="clearErrorsPovezEdit()">
                            <option disabled></option>
                            @foreach($bindings as $binding)
                                <option value="{{$binding->id}}">{{$binding->name}}</option>
                            @endforeach
                        </select>
                        @error('bindingEdit')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-[20px]">
                        <p>Format <span class="text-red-500">*</span></p>
                        <select class="flex w-[45%] mt-2 px-2 py-2 border bg-white border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#576cdf]" name="formatEdit" id="formatEdit" onclick="clearErrorsFormatEdit()">
                            <option disabled></option>
                            @foreach($formats as $format)
                                <option value="{{$format->id}}">{{$format->name}}</option>
                            @endforeach
                        </select>
                        @error('formatEdit')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-[20px]">
                        <p>Međunarodni standardni broj knjige <span class="text-red-500">*</span></p>
                        <input type="text" name="isbnEdit" id="isbnEdit" placeholder="{{$book->ISBN}}" class="flex w-[45%] mt-2 px-2 py-2 text-base bg-white border border-gray-300 shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-[#576cdf]" onkeydown="clearErrorsIsbnEdit()"/>
                        @error('isbnEdit')
                            <div class="text-red-500">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="editMultimedia" class="tabcontent hidden w-9/12 mx-auto bg-white rounded p7 mt-[40px] mb-[150px]">
                <div x-data="dataFileDnD()"
                     class="relative flex flex-col p-4 text-gray-400 border border-gray-200 rounded">
                    <div x-ref="dnd"
                         class="relative flex flex-col text-gray-400 border border-gray-200 border-dashed rounded cursor-pointer">
                        <input accept="image/*" type="file" multiple id="imageUpload"
                               name="movieImages[]"
                               class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer"
                               onchange="addFiles()"
                               @dragover="$refs.dnd.classList.add('border-blue-400'); $refs.dnd.classList.add('ring-4'); $refs.dnd.classList.add('ring-inset');"
                               @dragleave="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                               @drop="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                               title="" />

                        <div
                            class="flex flex-col items-center justify-center py-10 text-center">
                            <svg class="w-6 h-6 mr-1 text-current-50"
                                 xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="m-0">Prevucite slike ovdje ili kliknite na ovo polje.</p>
                        </div>
                    </div>

                    <!-- <template x-if="files.length > 0"> -->
                    <div class="grid grid-cols-3 gap-4 mt-4 2xl:grid-cols-4"
                        @drop.prevent="drop($event)"
                        @dragover.prevent="$event.dataTransfer.dropEffect = 'move'">
                        @foreach($book->galery as $photo)
                            <div  class="relative flex flex-col text-xs bg-white bg-opacity-50 hiddenImage1"
                                @dragstart="dragstart($event)"
                                @dragend="fileDragging = null"
                                :class="{'border-blue-600': fileDragging == index}"
                                draggable="true" :data-index="index">
                                <img src="/storage/image/{{$photo->photo}}" alt="" class="h-[322px]">
                                <!-- Checkbox (checked if image is cover photo of book)-->
                                <input
                                    class="absolute top-[10px] right-[10px] z-[1] p-1 bg-white rounded-bl focus:outline-none"
                                    type="radio" name="imageCoverEdit" {{ $photo->cover == 1 ? 'checked' : '' }} />
                                <!-- End checkbox -->
                                <a id="{{$photo->id}}"
                                    class="absolute bottom-0 right-0 z-40 p-1 bg-white cursor-pointer focus:outline-none show-deleteModal"
                                    type="button" id="hide-image1">
                                    <svg class="w-[25px] h-[25px] text-gray-700"
                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                        nviewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                                <div
                                    class="absolute bottom-0 left-0 right-0 flex flex-col p-2 text-xs text-center bg-white bg-opacity-50">
                                    <span  class="w-full font-bold text-gray-900 truncate">{{$photo->photo}}</span>
                                    <span class="text-xs text-gray-900">89kB</span>
                                </div>
                            </div>
                            <!--Modal-->
                            <div
                                class="absolute z-20 top-[-232px] left-0 items-center justify-center hidden w-full h-screen bg-transparent delete-modal_{{$photo->id}}" id="{{$photo->id}}">
                                <!-- Modal -->
                                <div class="w-[600px] bg-white rounded shadow-lg">
                                    <!-- Modal Header -->
                                    <div class="flex items-center justify-between px-[30px] py-[20px] border-b">
                                        <h3 class="text-gray-700">Da li ste sigurni da želite da izbrišete sliku?</h3>
                                        <a href="#" class="text-black close cancel focus:outline-none" id="{{$photo->id}}">
                                            <span aria-hidden="true" class="text-[30px]">&times;</span>
                                        </a>
                                    </div>
                                    <!-- Modal Body -->
                                    <div class="flex items-center justify-center px-[30px] py-[20px] border-t w-100 text-white">
                                        <a href="#" onclick="removeImage({{$photo}})"
                                            class=" text-center shadow-lg mr-[15px] w-[150px] focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in hover:bg-[#46A149] bg-[#4CAF50] rounded-[5px]">
                                            <i class="fas fa-check mr-[7px]"></i> Izbriši
                                        </a>
                                        <a href="#" id="{{$photo->id}}" class="cancel shadow-lg w-[150px] focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] bg-[#F44336] hover:bg-[#F55549] text-center">
                                        <i class="fas fa-times mr-[7px]"></i> Poništi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <template x-for="(_, index) in Array.from({ length: files.length })">
                            <div class="relative flex flex-col items-center overflow-hidden text-center bg-gray-100 border rounded cursor-move select-none"
                                 style="padding-top: 100%;" @dragstart="dragstart($event)"
                                 @dragend="fileDragging = null"
                                 :class="{'border-blue-600': fileDragging == index}"
                                 draggable="true" :data-index="index">
                                <!-- Checkbox -->
                                <input
                                    class="absolute top-0 right-0 z-50 p-1 bg-white rounded-bl focus:outline-none"
                                    type="radio" name="chosen_image" />
                                <!-- End checkbox -->
                                <button
                                    class="absolute bottom-0 right-0 z-[1] p-1 bg-white rounded-bl focus:outline-none"
                                    type="button" @click="remove(index)">
                                    <svg class="w-[25px] h-[25px] text-gray-700"
                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                         nviewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <template x-if="files[index].type.includes('audio/')">
                                    <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                </template>
                                <template
                                    x-if="files[index].type.includes('application/') || files[index].type === ''">
                                    <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </template>
                                <template x-if="files[index].type.includes('image/')">
                                    <img class="absolute inset-0 z-0 object-cover w-full h-full border-4 border-white preview"
                                         x-bind:src="loadFile(files[index])" />
                                </template>
                                <template x-if="files[index].type.includes('video/')">
                                    <video
                                        class="absolute inset-0 object-cover w-full h-full border-4 border-white pointer-events-none preview">
                                        <fileDragging x-bind:src="loadFile(files[index])"
                                                      type="video/mp4">
                                    </video>
                                </template>

                                <div
                                    class="absolute bottom-0 left-0 right-0 flex flex-col p-2 text-xs bg-white bg-opacity-50">
                                    <span class="w-full font-bold text-gray-900 truncate"
                                          x-text="files[index].name">Loading</span>
                                    <span class="text-xs text-gray-900"
                                          x-text="humanFileSize(files[index].size)">...</span>
                                </div>

                                <div class="absolute inset-0 z-40 transition-colors duration-300"
                                     @dragenter="dragenter($event)"
                                     @dragleave="fileDropping = null"
                                     :class="{'bg-blue-200 bg-opacity-80': fileDropping == index && fileDragging != index}">
                                </div>

                            </div>
                        </template>
                    </div>
                    <!-- </template> -->
                </div>
            </div>

            <div class="absolute bottom-0 z-50 w-full">
                <div class="flex flex-row">
                    <div class="inline-block w-full text-white text-right py-[7px] mr-[100px]">
                        <button type="reset"
                                class="btn-animation shadow-lg mr-[15px] w-[150px] focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in bg-[#F44336] hover:bg-[#F55549] rounded-[5px]">
                                <i class="fas fa-times mr-[7px]"></i> Poništi
                        </button>
                        <button id="saveBookEdit" type="submit"
                                class="btn-animation shadow-lg w-[150px] disabled:opacity-50 focus:outline-none text-sm py-2.5 px-5 transition duration-300 ease-in rounded-[5px] hover:bg-[#46A149] bg-[#4CAF50]"
                                onclick="validacijaKnjigaEdit()">
                                <i class="fas fa-check mr-[7px]"></i> Sačuvaj
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script>
        CKEDITOR.replace('summary_edit', {
            width: "90%",
            height: "150px"
        });
    </script>
@endsection
