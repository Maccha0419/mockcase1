<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stamp;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name', 'DESC')->paginate(10);
        return view('user', compact('users'));
    }

    public function information(Request $request)
    {
        $user_name = $request->name;
        $user_dates = Stamp::where('user_id', $request->id)->orderByRaw("stamp_date desc,start_work asc")->paginate(5);
        return view('user_information', compact('user_name','user_dates'));
    }
}
