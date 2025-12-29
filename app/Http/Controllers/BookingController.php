<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookingController extends Controller
{
   public function store(Request $request)
{
    // 1. Валидация данных из формы
    $data = $request->validate([
        'room_id'     => 'required|exists:rooms,id',
        'started_at'  => 'required|date|after_or_equal:today',
        'finished_at' => 'required|date|after:started_at',
    ]);

    // 2. Работа с датами
    $start = Carbon::parse($data['started_at']);
    $end   = Carbon::parse($data['finished_at']);
    $days  = $start->diffInDays($end);

    // 3. Получаем комнату
    $room = Room::findOrFail($data['room_id']);

    // 4. Проверяем занятость номера
    $isBooked = Booking::where('room_id', $room->id)
        ->where('started_at', '<', $end)
        ->where('finished_at', '>', $start)
        ->exists();

    if ($isBooked) {
        return back()->withErrors(['room' => 'Этот номер уже занят на выбранные даты']);
    }

    // 5. Создаём бронирование
    $booking = Booking::create([
        'room_id'     => $room->id,
        'user_id'     => Auth::id(),
        'started_at'  => $start,
        'finished_at' => $end,
        'days'        => $days,
        'price'       => $room->price * $days, // или $room->price_per_night
    ]);

    // 6. Редирект на страницу бронирования с флеш-сообщением
    return redirect()->route('bookings.show', $booking)
                     ->with('success', 'Бронирование успешно создано!');
}


    public function show(Booking $booking){

        return view('bookings.show', compact('booking'));
    }

    
    public function index(){
        $bookings = Booking::all();
        return view('bookings.index', compact('bookings'));
    }
}
