<?php

namespace App\Http\Controllers;

use App\Models\HtetYu;
use Illuminate\Http\Request;

class HtetYuController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function delete($id)
    {
        $htetyu = HtetYu::find($id);
        $htetyu->delete();

        return back();
    }
}
