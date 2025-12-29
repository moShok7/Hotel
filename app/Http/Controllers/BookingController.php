<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\BookingConfirmed;
use Illuminate\Support\Facades\Mail;
class BookingController extends Controller
{
   public function store(Request $request)
{
    
    $data = $request->validate([
        'room_id'     => 'required|exists:rooms,id',
        'started_at'  => 'required|date|after_or_equal:today',
        'finished_at' => 'required|date|after:started_at',
    ]);

    
    $start = Carbon::parse($data['started_at']);
    $end   = Carbon::parse($data['finished_at']);
    $days  = $start->diffInDays($end);


    $room = Room::findOrFail($data['room_id']);

   
    $isBooked = Booking::where('room_id', $room->id)
        ->where('started_at', '<', $end)
        ->where('finished_at', '>', $start)
        ->exists();

    if ($isBooked) {
        return back()->withErrors(['room' => 'Этот номер уже занят на выбранные даты']);
    }

   
    $booking = Booking::create([
        'room_id'     => $room->id,
        'user_id'     => Auth::id(),
        'started_at'  => $start,
        'finished_at' => $end,
        'days'        => $days,
        'price'       => $room->price * $days, 
    ]);


     Mail::to($booking->user->email)->send(new BookingConfirmed($booking));
  
    return redirect()->route('bookings.show', $booking)
                     ->with('success', 'Бронирование успешно создано!');
}


    public function show(Booking $booking){
        return view('bookings.show', compact('booking'));
    }

    
    public function index(){
        $bookings = Booking::where('user_id' , auth()->id())->get();
        return view('bookings.index', compact('bookings'));
    }

    public function destroy(Booking $booking){
if($booking->user_id !== auth()->id()){
     abort(403);
}
$booking->delete();
return redirect()->route('bookings.index')->with('success', 'Бронирование отменено.');
    }
}
