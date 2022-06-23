<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $rate4L = Rate::find(1)->interest_rate * 100;
        $rate4G = Rate::find(2)->interest_rate * 100;

        return view('rates.index', [
            'rate4L' => $rate4L,
            'rate4G' => $rate4G,
        ]);
    }

    public function change()
    {
        $rate4L = request()->rate4L / 100;
        $rate4G = request()->rate4G / 100;

        //update rate
        Rate::where('id', 1)
            ->update(['interest_rate' => $rate4L]);
        Rate::where('id', 2)
            ->update(['interest_rate' => $rate4G]);

        return redirect("/");
    }
}
