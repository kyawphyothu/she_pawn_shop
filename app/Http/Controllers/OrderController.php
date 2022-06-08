<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderCategory;
use App\Models\Owner;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $allOrders = Order::latest()->paginate(12);;

        return view('orders.index', [
            'allOrders' => $allOrders,
        ]);
    }

    public function add()
    {
        $villagesData = Village::all();
        $owners = Owner::all();
        $categories = Category::all();

        return view('orders.add', [
            'villages' => $villagesData,
            'owners' => $owners,
            'categories' => $categories,
        ]);
    }

    public function searchByName()
    {
        $name = request()->name;
        return view('orders.index', [
            print_r($name)
        ]);
    }

    public function create()
    {
        $name = request()->name;
        $village_id = request()->village_id;
        $category_id = request()->category_id;
        $price = request()->price;
        $owner_id = request()->owner_id;
        $created_at = request()->datetime_local;
        $note = request()->note;

        $weightKyat = request()->weightKyat;
        $weightPae = request()->weightPae;
        $weightYwe = request()->weightYwe;
        $totlaWeightInYwe = ($weightKyat * 128) + ($weightPae * 8) + $weightYwe;

        //create order
        if ($note) {
            $order = new Order();
            $order->name = $name;
            $order->village_id = $village_id;
            $order->owner_id = $owner_id;
            $order->weight = $totlaWeightInYwe;
            $order->price = $price;
            $order->note = $note;
            $order->created_at = $created_at;
            $order->save();
        } else {
            $order = new Order();
            $order->name = $name;
            $order->village_id = $village_id;
            $order->owner_id = $owner_id;
            $order->weight = $totlaWeightInYwe;
            $order->price = $price;
            $order->created_at = $created_at;
            $order->save();
        }

        //create order_product
        $lastInsertId = DB::getPdo()->lastInsertId();

        foreach ($category_id as $data) {
            $order_categories = new OrderCategory();
            $order_categories->order_id = $lastInsertId;
            $order_categories->category_id = $data;
            $order_categories->save();
        }

        return redirect('/');
    }

    public function detail()
    {
        return view('orders.details');
    }
}
