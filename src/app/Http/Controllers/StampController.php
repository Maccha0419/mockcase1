<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rest;
use App\Models\Stamp;
use App\Models\User;
use Auth;
use Carbon\Carbon;

class StampController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stamp_date = Stamp::where('user_id', $user->id)->latest()->value('stamp_date');
        $start_work = Stamp::where('user_id', $user->id)->latest()->value('start_work');
        $end_work = Stamp::where('user_id', $user->id)->latest()->value('end_work');
        $start_rest = Rest::where('stamp_id', $user->id)->latest()->value('start_rest');
        $end_rest = Rest::where('stamp_id', $user->id)->latest()->value('end_rest');

        if ($stamp_date!==Carbon::now()->toDateString()) {
            $disabled_start_work =false;
            $disabled_end_work =true;
            $disabled_start_rest =true;
            $disabled_end_rest =true;
        }elseif ($stamp_date===Carbon::now()->toDateString() and $end_work === null and $start_work!==null and $start_rest===null) {
            $disabled_start_work =true;
            $disabled_end_work =false;
            $disabled_start_rest =false;
            $disabled_end_rest =true;
        }elseif ($stamp_date===Carbon::now()->toDateString() and $end_work === null and $start_work !== null and $start_rest!==null and $end_rest===null) {
            $disabled_start_work =true;
            $disabled_end_work =true;
            $disabled_start_rest =true;
            $disabled_end_rest =false;
        }elseif ($stamp_date===Carbon::now()->toDateString() and $end_work === null and $start_work !== null and $start_rest!==null and $end_rest!==null) {
            $disabled_start_work =true;
            $disabled_end_work =false;
            $disabled_start_rest =false;
            $disabled_end_rest =true;
        }elseif ($stamp_date===Carbon::now()->toDateString() and $end_work !== null) {
            $disabled_start_work =true;
            $disabled_end_work =true;
            $disabled_start_rest =true;
            $disabled_end_rest =true;
        }
        return view('index', compact('user','disabled_start_work','disabled_end_work','disabled_start_rest','disabled_end_rest'));
    }


    public function start_work(Request $request)
    {
        $user = Auth::user();//ログインしているユーザー情報の取得
        $stamp_date = Stamp::where('user_id', $user->id)->latest()->value('stamp_date');

        if ($stamp_date===Carbon::now()->toDateString()) {
            $disabled_start_work =true;
            $disabled_end_work =true;
            $disabled_start_rest =true;
            $disabled_end_rest =true;
        }else {
            Stamp::create([
                'user_id' => $user->id,
                'start_work' => Carbon::now(),
                'stamp_date' => Carbon::now()->toDateString(),
            ]);

            $disabled_start_work =true;
            $disabled_end_work =false;
            $disabled_start_rest =false;
            $disabled_end_rest =true;
        }

        return view('index', compact('user','disabled_start_work','disabled_end_work','disabled_start_rest','disabled_end_rest'));
    }


    public function end_work(Request $request)
    {
        $user = Auth::user();
        $Stamp = Stamp::where('user_id', $user->id)->latest()->first();
        $stamp_date = Stamp::where('user_id', $user->id)->latest()->value('stamp_date');
        $start_work = Stamp::where('user_id', $user->id)->latest()->value('start_work');
        $end_work = Stamp::where('user_id', $user->id)->latest()->value('end_work');
        $rest_time = Rest::where('stamp_id', $user->id)->latest()->value('rest_time');

        $Stamp->update([
            'end_work' => Carbon::now(),
        ]);
        //getだと配列になる？、get()でも値を取り出す関数でできそう

        $diffInSeconds = Carbon::parse($start_work)->diffInSeconds($end_work);//parseで文字列を時間型に？
        $total_work = \Hoge::Time($diffInSeconds);//エイリアス登録したクラスからTime関数を呼び出し

        $total_rest = Rest::where('stamp_id', $user->id)->selectRaw('SEC_TO_TIME(SUM(TIME_TO_SEC(rest_time))) as total_rest')->value('total_rest');//合計を時間型で取得
        if ($total_rest === null) {
            $total_rest = "00:00:00";
        };

        $Stamp->update([
            'total_rest' => $total_rest,
            'total_work' => $total_work,
        ]);

        $disabled_start_work =true;
        $disabled_end_work =true;
        $disabled_start_rest =true;
        $disabled_end_rest =true;

        return view('index', compact('user','disabled_start_work','disabled_end_work','disabled_start_rest','disabled_end_rest'));
    }


    public function start_rest(Request $request)
    {
        $user = Auth::user();//ログインしているユーザー情報の取得
        $stamp_date = Stamp::where('user_id', $user->id)->latest()->value('stamp_date');
        $end_work = Stamp::where('user_id', $user->id)->latest()->value('end_work');

        if ($stamp_date===Carbon::now()->toDateString() and $end_work===null)//勤務開始を押していないと
            Rest::create([
                'stamp_id' => $user->id,
                'start_rest' => Carbon::now(),
            ]);

        $disabled_start_work =true;
        $disabled_end_work =true;
        $disabled_start_rest =true;
        $disabled_end_rest =false;

        return view('index', compact('user','disabled_start_work','disabled_end_work','disabled_start_rest','disabled_end_rest'));
    }


    public function end_rest(Request $request)
    {
        $user = Auth::user();
        $Rest = Rest::where('stamp_id', $user->id)->latest()->first();
        $stamp_date = Stamp::where('user_id', $user->id)->latest()->value('stamp_date');
        $end_work = Stamp::where('user_id', $user->id)->latest()->value('end_work');
        $end_rest = Rest::where('stamp_id', $user->id)->latest()->value('end_rest');

        if ($stamp_date===Carbon::now()->toDateString() and $end_work===null and $end_rest===null) {
            $Rest->update([
                'end_rest' => Carbon::now(),
            ]);
            $start_rest = Rest::where('stamp_id', $user->id)->latest()->value('start_rest');
            $diffInSeconds = Carbon::parse($start_rest)->diffInSeconds($end_rest);

            $rest_time = \Hoge::Time($diffInSeconds);//エイリアス登録したクラスからTime関数を呼び出し

            $Rest->update([
                'rest_time' => $rest_time,
            ]);
        }

        $disabled_start_work =true;
        $disabled_end_work =false;
        $disabled_start_rest =false;
        $disabled_end_rest =true;

        return view('index', compact('user','disabled_start_work','disabled_end_work','disabled_start_rest','disabled_end_rest'));
    }
}