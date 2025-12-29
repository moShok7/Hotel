<div {{ $attributes->merge(['class' => 'flex flex-col md:flex-row shadow-md']) }}>
    <!-- Левая часть: картинка -->
    <div class="h-full w-full md:w-2/5">
        <img class="h-full rounded-l-sm" src="{{ asset('storage/' . $room->poster_url) }}" alt="Room Image">
    </div>

    <!-- Правая часть: текст, тип, цена, кнопка -->
    <div class="p-4 w-full md:w-3/5 flex flex-col justify-between">
        <div class="pb-2">
            <div class="text-xl font-bold">{{ $room->title }}</div>
            <div class="text-lg font-semibold">{{ $room->type }}</div>
            <div><span>•</span> {{ $room->floor_area }} м²</div>
            <div>
                @foreach($room->facilities as $facility)
                    <span>• {{ $facility->title }}</span>
                @endforeach
            </div><br>
            <div>{{$room->description}}</div>
        </div>

        <hr class="my-2">

        <div class="flex justify-between items-center">
            <div class="flex flex-col">
                <span class="text-lg font-bold">{{ $room->price }} руб.</span>
                <span>за {{ $room->total_days }}-й</span>
            </div>
@auth
            <form method="POST" action="{{ route('bookings.store') }}">
                @csrf
                <input type="hidden" name="started_at" value="{{ request()->get('start_date') }}">
                <input type="hidden" name="finished_at" value="{{ request()->get('end_date') }}">
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <x-the-button type="submit">Book</x-the-button>
            </form>
            @endauth
        </div>
    </div>
</div>
