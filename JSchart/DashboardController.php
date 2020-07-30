<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Create an instance of controller.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show dashboard view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }

    /**
     * Get all the dates between date range from database
     * 
     * @param date $startDate
     * @param date $endDate
     * @return array $datesArray
     */
    private function getAllDates($startDate , $endDate)
    {
        $datesArray = [];
        $bookingDates = Booking::select('created_at')
            ->whereBetween(
                'created_at',
                [$startDate, $endDate]
            )->orderBy('created_at', 'ASC')
            ->get();
        
        foreach ($bookingDates as $bookingDate) {
            $day = $bookingDate->created_at->format('Y-m-d');
            $datesArray[$day] = $bookingDate->created_at->format('d-m-Y');
        }

        return $datesArray;
    }

    /**
     * count number of bookings of specified date 
     * 
     * @param date $date
     * @return int $DailyBookingCount
     */
    private function getDailyBookingCount($date)
    {
        $DailyBookingCount = Booking::whereDate('created_at', $date)->get()->count();
        return $DailyBookingCount;
    }

    /**
     * get chart data between the requested (from ajax) date ranges
     * 
     * @param \Illuminate\Http\Request  $request
     * @return array $monthlyBookingData
     */
    public function getChartData(Request $request)
    {
        $startDate = $request->start_date;
        $endDate   = $request->end_date; 
        
        $dailyPostCountArray = array();
        $allDatesArray = $this->getAllDates($startDate , $endDate);
        
        $datesArray = array();
        if (!empty($allDatesArray)) {
            foreach ($allDatesArray as $day => $date) {
                $dailyPostCount = $this->getDailyBookingCount($day);
                array_push($dailyPostCountArray, $dailyPostCount);
                array_push($datesArray, $date);
            }
        }

        $max = $dailyPostCountArray ?  round(max($dailyPostCountArray)) : 3;
        $monthlyBookingData = array(
            'dates' => $datesArray,
            'booking_counts' => $dailyPostCountArray,
            'max' => $max,
        );

        return $monthlyBookingData;
    }
}