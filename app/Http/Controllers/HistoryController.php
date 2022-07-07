<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $histories = History::latest()->get();

        return view('histories.history', [
            'histories' => $histories,
        ]);
    }
}
