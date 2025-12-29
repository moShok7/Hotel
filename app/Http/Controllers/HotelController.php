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

    /*
    каоче это даты автоматом ставять сегодняшнюю дату
    */
    $startDate = Carbon::parse(
        request('start_date', now()->toDateString())
    );
    $endDate = Carbon::parse(
        request('end_date', now()->addDay()->toDateString())
    );

/*
тут беру удобстава присабачиваю и еще обробатываю даут чтобы была проверка и заодно убираю 
whereDoesntHave уже забронированные 

*/
    $roomsQuery  = $hotel->rooms()
        ->with('facilities')
        ->whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
            $query->where('started_at', '<', $endDate)
                  ->where('finished_at', '>', $startDate);
        });


        /*
        ну тут цена
        */
if(request('price_from')){
    $roomsQuery->where('price', '>=', request('price_from'));
}
if(request('price_to')){
    $roomsQuery->where('price', '<=', request('price_to'));
}

/*
проверяю type или категорию там люкс не люкс)
*/
$types = $hotel->rooms()
    ->select('type') // выбираю клону type
    ->distinct() // уникальны езначения
    ->get() // сортировка
    ->pluck('type'); // коллекция

/*

ищем че хорошего есть и какие удобстава бере все а не одно 
*/
if (request()->filled('facilities')) {
        $roomsQuery->whereHas('facilities', function ($q) {
            $q->whereIn('facilities.id', request('facilities'));
        }, '=', count(request('facilities')));
    }

/*
ну тут сортировка по буыванию
*/
$facilities = Facility::whereHas('rooms', function ($q) use ($hotel) {
    $q->where('hotel_id', $hotel->id);
})->get();

 $rooms = $roomsQuery->latest()->get();
    return view('hotels.show', compact('hotel', 'rooms', 'facilities', 'startDate', 'endDate' , 'types'));
}
}

