<?php

namespace App\Http\Controllers;

use App\Models\AppTicket;
use App\Models\AppUser;
use App\Models\PMOWorkTable;
use App\Models\Ticket;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userNum = AppUser::select(DB::raw("COUNT(id) as userNum"))->first();

        $userActiveNum = AppTicket::query()
            ->select(DB::raw("COUNT(id) as userActiveNum"))
            ->whereHas("appUser")
            ->orderBy("app_user_id")
            ->first();

        if($userNum["userNum"] == 0){
            $userNum["userNum"] =1;
        }
        if($userActiveNum["userActiveNum"] == 0){
            $userActiveNum["userActiveNum"] =1;
        }
        $userActiveNum["percent"] = 100/(doubleval($userNum["userNum"])*doubleval($userActiveNum["userActiveNum"]));
        $userNum["percent"] = 100 - doubleval($userActiveNum["percent"]);

        $appTickets = Ticket::select(DB::raw("COUNT(id) as tickets"))->first();


        if($appTickets["tickets"] == 0){
            $appTickets["tickets"] =1;
        }

        $attendedTickets = Ticket::select(DB::raw("COUNT(id) as attendedTickets"))
            ->where("status","=","Atendido")->first();

        $orderWorks = PMOWorkTable::select(DB::raw("COUNT(id) AS orderWorks"))->whereHas("ticketit")->first();

        return view('home')
            ->with("userNum", $userNum)
            ->with("userActiveNum", $userActiveNum)
            ->with("attendedTickets", $attendedTickets)
            ->with("orderWorks", $orderWorks)
            ->with("appTickets", $appTickets);
    }

    public function welcome()
    {
        return view('welcome');
    }


    public function getChartTicket()
    {

        $users = AppUser::select('id', 'created_at')
            ->get()
            ->groupBy(function($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });

        $users_ticket = AppUser::select('id', 'created_at')
            ->whereHas("appTicket")
            ->get()
            ->groupBy(function($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });

        $usermcount = [];
        $userArr = [];

        foreach ($users as $key => $value) {
            $usermcount["x"]= $key;
            $usermcount["y"]= count($value);
            $usermcount["z"]= count($users_ticket[$key]);
        }

        return response()->json(array($usermcount));
    }
}
