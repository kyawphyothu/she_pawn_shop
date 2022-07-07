<?php

namespace App\Http\Controllers;

use App\Models\History;
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

        History::where('status', 2)
            ->where('related_id', $id)
            ->update(['cancled' => 1]);

        return back();
    }
}
