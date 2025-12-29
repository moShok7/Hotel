<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Hotel;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    // 📃 список
    public function index()
    {
        $hotels = Hotel::with('facilities')->latest()->get();
        return view('hotels.index', compact('hotels'));
    }

    // 👁 просмотр одного
  public function show(Hotel $hotel)
{
    $startDate = Carbon::parse(
        request('start_date', now()->toDateString())
    );

    $endDate = Carbon::parse(
        request('end_date', now()->addDay()->toDateString())
    );

    $rooms = $hotel->rooms()
        ->with('facilities')
        ->whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
            $query->where('started_at', '<', $endDate)
                  ->where('finished_at', '>', $startDate);
        })
        ->latest()
        ->get();

    return view('hotels.show', compact('hotel', 'rooms'));
}
}

