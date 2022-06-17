<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    public function delete($id)
    {
        $interest = Interest::find($id);
        $interest->delete();

        return back();
    }
}
