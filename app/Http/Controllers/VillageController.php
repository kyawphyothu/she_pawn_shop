<?php

namespace App\Http\Controllers;

use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public function index ()
    {
        $villages = Village::paginate(10);
        return view('villages.index', [
            'villages' => $villages,
            'i' => 1,
        ])->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function store (Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $name = $request->name;
        $village = new Village();
        $village->name = $name;
        $village->save();

        return back()->with('success', 'New Village successfully Created!')->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function destory ($id)
    {
        Village::where('id', $id)->delete();

        return back()->with('danger', 'Village Successfully Deleted!');
    }
}
