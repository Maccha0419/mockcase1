<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\Stamp;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class AttendanceController extends Controller
{
    public function index()
    {
        $date = Stamp::latest('stamp_date')->value('stamp_date');
        $users = User::select('*')->join('stamps','users.id','=','stamps.user_id')->orderByRaw("stamps.stamp_date desc,stamps.start_work asc")->where('stamp_date',$date)->paginate(5);
        return view('attendance', compact('users','date'));
    }


    public function next_date(Request $request)
    {
        $latest_date = Stamp::latest('stamp_date')->value('stamp_date');//2023-11-14
        $latest_date2 = Carbon::parse($latest_date)->addDay()->toDateString();//2023-11-15
        $current_date = $request->next_date;//2023-11-11

        $next_date = Carbon::parse($current_date)->addDay()->toDateString();//2023-11-12
        $save_date = Stamp::where('stamp_date',$next_date)->get();

        while($save_date->isEmpty()===true){
            $next_date = Carbon::parse($next_date)->addDay()->toDateString();//2023-11-13
            if($next_date=$latest_date2){
                $next_date = $latest_date;
                break ;
            }
            $save_date = Stamp::where('stamp_date',$next_date)->get();
        }
        $date = $next_date;
        $users = User::select('*')->join('stamps','users.id','=','stamps.user_id')->orderByRaw("stamps.stamp_date desc,stamps.start_work asc")->where('stamp_date',$date)->paginate(5);
        return view('attendance', compact('users','date'));
    }

    public function previous_date(Request $request)
    {
        $current_date = $request->previous_date;
        $previous_date = Carbon::parse($current_date)->subDay()->toDateString();
        $previous_date2 =Carbon::parse($current_date)->subYear(200)->toDateString();

        $save_date = Stamp::where('stamp_date',$previous_date)->get();
        while($save_date->isEmpty()===true){
            $previous_date = Carbon::parse($previous_date)->subDay()->toDateString();
            if($previous_date=$previous_date2){
                $previous_date = $current_date;
                break ;
            }
            $save_date = Stamp::where('stamp_date',$previous_date)->get();
        }
        $date = $previous_date;
        $users = User::select('*')->join('stamps','users.id','=','stamps.user_id')->orderByRaw("stamps.stamp_date desc,stamps.start_work asc")->where('stamp_date',$date)->paginate(5);
        return view('attendance', compact('users','date'));
    }
}
