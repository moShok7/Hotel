@php
    $startDate = request()->get('start_date', \Carbon\Carbon::now()->format('Y-m-d'));
    $endDate = request()->get('end_date', \Carbon\Carbon::now()->addDay()->format('Y-m-d'));
@endphp

<x-app-layout>
    <div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
        <div class="flex flex-wrap mb-12">
            <div class="w-full flex justify-start md:w-1/3 mb-8 md:mb-0">
                <img class="h-full rounded-l-sm" src="{{ asset('storage/' . $hotel->poster_url) }}" alt="Room Image">
            </div>
            <div class="w-full md:w-2/3 px-4">
                <div class="text-2xl font-bold">{{ $hotel->title }}</div>
                <div class="flex items-center">
                  <x-heroicon-o-map-pin class="w-5 h-5 text-blue-700"/>
                    {{ $hotel->address }}
                </div>
                <div>{{ $hotel->description }}</div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="text-2xl text-center md:text-start font-bold">Забронировать комнату</div>

           <form method="get" action="{{ url()->current() }}" class="flex flex-wrap gap-4 my-6 items-end">

    {{-- Даты заезда и выезда --}}
    <div class="flex items-center gap-2">
        <input name="start_date" type="date" min="{{ date('Y-m-d') }}"
               value="{{ request('start_date', $startDate ?? now()->toDateString()) }}"
               class="bg-gray-50 border border-gray-300 rounded-lg p-2.5">
        <span class="text-gray-500">по</span>
        <input name="end_date" type="date" min="{{ date('Y-m-d') }}"
               value="{{ request('end_date', $endDate ?? now()->addDay()->toDateString()) }}"
               class="bg-gray-50 border border-gray-300 rounded-lg p-2.5">
    </div>

    {{-- Цена --}}
    <input type="number" name="price_from" placeholder="Цена от"
           value="{{ request('price_from') }}"
           class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-24">
    <input type="number" name="price_to" placeholder="Цена до"
           value="{{ request('price_to') }}"
           class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-24">

    {{-- Удобства (Select2) --}}
  <select name="facilities[]" multiple="multiple" class="select2" style="width: 100%">
    @foreach($facilities as $facility)
        <option value="{{ $facility->id }}"
            @selected(in_array($facility->id, request('facilities', [])))>
            {{ $facility->title }}
        </option>
    @endforeach
</select>

<select name="category" class="select2" style="width: 100%">
    <option value="">Выберите категорию</option>
    @foreach($types as $type)
        <option value="{{ $type }}" @selected(request('category') == $type)>
            {{ $type }}
        </option>
    @endforeach
</select>




    <x-the-button type="submit">Показать</x-the-button>
</form>
           @if($startDate && $endDate)
                <div class="flex flex-col w-full lg:w-4/5">
                    @foreach($rooms as $room)
                        <x-rooms.room-list-item :room="$room" class="mb-4"/>
                    @endforeach
                </div>
            @else
                <div></div>
            @endif
        </div>
    </div>
</x-app-layout>
