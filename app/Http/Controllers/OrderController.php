<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HtetYu;
use App\Models\Interest;
use App\Models\Order;
use App\Models\OrderCategory;
use App\Models\Owner;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    //home page
    public function index()
    {
        $allOrders = Order::latest()->paginate(12);
        $villages = Village::all();
        $categories = Category::all();

        return view('orders.index', [
            'orders' => $allOrders,
            'villages' => $villages,
            'categories' => $categories,
        ]);
    }

    //filter
    public function filter(Request $request)
    {
        // $orders = Order::where('pawn_id', 1);
        // $orders = DB::table('orders');
        // $orders = new Order();
        $orders = Order::query();

        if ($request->category_id) {
            foreach ($request->category_id as $category_id) {
                $orders->leftjoin('order_categories', 'orders.id', '=', 'order_categories.order_id')
                    ->select('orders.*')
                    ->orWhere('order_categories.category_id', $category_id);
            }
        }

        if ($request->location) {
            $orders->where('village_id', $request->location);
        }

        // if ($request->has('gender')) {
        //     $orders-  >where('gender', $request->gender);
        // }

        // if ($request->has('created_at')) {
        //     $orders->where('created_at', '>=', $request->created_at);
        // }
        $allOrders = $orders->latest()->paginate(12);
        $villages = Village::all();
        $categories = Category::all();
        // dd($allOrders);

        return view('orders.index', [
            'orders' => $allOrders,
            'villages' => $villages,
            'categories' => $categories,
        ]);
    }

    //add page
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

    // public function searchByName()
    // {
    //     $name = request()->name;
    //     return view('orders.index', [
    //         print_r($name)
    //     ]);
    // }


    //create new order
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
            $order->note = $note;
            $order->created_at = $created_at;
            $order->updated_at = $created_at;
            $order->save();
        } else {
            $order = new Order();
            $order->name = $name;
            $order->village_id = $village_id;
            $order->owner_id = $owner_id;
            $order->weight = $totlaWeightInYwe;
            $order->created_at = $created_at;
            $order->updated_at = $created_at;
            $order->save();
        }

        $lastInsertId = DB::getPdo()->lastInsertId();
        //create order_product

        foreach ($category_id as $data) {
            $order_categories = new OrderCategory();
            $order_categories->order_id = $lastInsertId;
            $order_categories->category_id = $data;
            $order_categories->save();
        }

        //create htet_yu
        $htet_yus = new HtetYu();
        $htet_yus->name = $name;
        $htet_yus->order_id = $lastInsertId;
        $htet_yus->price = $price;
        $htet_yus->save();

        return redirect('/');
    }

    //detail page
    public function detail($id)
    {
        $order = Order::find($id);

        return view('orders.details', [
            'order' => $order,
        ]);
    }

    //htet yu page
    public function htetyu($id)
    {
        $order = Order::find($id);

        return view('orders.htetyu', [
            'order' => $order,
        ]);
    }

    //htet yu create
    public function htetyuCreate($id)
    {
        $id = $id;
        $name = request()->name;
        $price = request()->price;
        $date = request()->datetime_local;

        $htetyu = new HtetYu();
        $htetyu->name = $name;
        $htetyu->order_id = $id;
        $htetyu->price = $price;
        $htetyu->created_at = $date;
        $htetyu->save();

        return redirect("/orders/detail/$id");
    }

    //pay interest
    public function payInterest($id)
    {
        $order = Order::find($id);

        //finding rate
        $totalPrice = 0;
        foreach ($order->htetYus as $htetYu) {
            $totalPrice += $htetYu->price;
        }
        $totalPrice >= 500000 ? $rate = 0.02 : $rate = 0.05;

        //calculte interest
        $now = strtotime(date('Y-m-d H:i:s'));
        $now_Year = +date('Y', $now);
        $now_Month = +date('m', $now);
        $now_Day = +date('d', $now);

        //calcutate price
        $totalInterestForPawnId_1 = 0;
        $totalPriceForPawnId_2 = 0;
        foreach ($order->htetYus as $htetYu) {
            if ($htetYu->pawn_id == 1) {
                $priceForPawnId_1 = $htetYu->price;

                $totalMonthDifferenceForPawnId_1 = 0;
                $totalDayDifferenceForPawnId_1 = 0;
                $dateForPawnId_1 = HtetYu::where('order_id', $id)->where('pawn_id', 1)->firstOrFail();
                $dateForPawnId_1 = $dateForPawnId_1->updated_at;
                $dateForPawnId_1 = strtotime(date_format($dateForPawnId_1, 'Y-m-d H:i:s'));
                $dateForPawnId_1_Year = +date('Y', $dateForPawnId_1);
                $dateForPawnId_1_Month = +date('m', $dateForPawnId_1);
                $dateForPawnId_1_Day = +date('d', $dateForPawnId_1);

                if ($dateForPawnId_1_Day > $now_Day) {
                    $now_Day += 30;
                    $now_Month -= 1;
                    $totalMonthDifferenceForPawnId_1 += ($now_Day - $dateForPawnId_1_Day) / 30;
                } elseif ($dateForPawnId_1_Day < $now_Day) {
                    $totalMonthDifferenceForPawnId_1 += ($now_Day - $dateForPawnId_1_Day) / 30;
                }

                if ($dateForPawnId_1_Month > $now_Month) {
                    $now_Month += 12;
                    $now_Year -= 1;
                    $totalMonthDifferenceForPawnId_1 += ($now_Month - $dateForPawnId_1_Month);
                } elseif ($dateForPawnId_1_Month < $now_Month) {
                    $totalMonthDifferenceForPawnId_1 += ($now_Month - $dateForPawnId_1_Month);
                }

                $totalMonthDifferenceForPawnId_1 += ($now_Year - $dateForPawnId_1_Year) * 12;
                $totalDayDifferenceForPawnId_1 = $now_Day - $dateForPawnId_1_Day;
                //day difference or month difference
                if ($totalMonthDifferenceForPawnId_1 < 1) {
                    if ($totalDayDifferenceForPawnId_1 > 7) {
                        $totalInterestForPawnId_1 += $priceForPawnId_1 * $rate * 1;  //final result total interest for pawn id 1
                    } elseif ($totalDayDifferenceForPawnId_1 < 7) {
                        $totalInterestForPawnId_1 += $priceForPawnId_1 * $rate * 0.5;  //final result total interest for pawn id 1
                    }
                }
            } elseif ($htetYu->pawn_id == 2) {
                $totalPriceForPawnId_2 += $htetYu->price;
            }
        }
        $totalInterest = $totalInterestForPawnId_1;

        //calculate interest for pawin_id = 2
        foreach ($order->htetYus as $htetYu) {
            if ($htetYu->pawn_id == 2) {
                $totalMonthDifferenceForPawnId_2 = 0;
                $dateForPawnId_2 = HtetYu::where('order_id', $id)->where('pawn_id', 2)->firstOrFail();
                $dateForPawnId_2 = $dateForPawnId_2->updated_at;
                $dateForPawnId_2 = strtotime(date_format($dateForPawnId_2, 'Y-m-d H:i:s'));
                $dateForPawnId_2_Year = +date('Y', $dateForPawnId_2);
                $dateForPawnId_2_Month = +date('m', $dateForPawnId_2);
                $dateForPawnId_2_Day = +date('d', $dateForPawnId_2);

                if ($dateForPawnId_2_Day > $now_Day) {
                    $now_Day += 30;
                    $now_Month -= 1;
                    $totalMonthDifferenceForPawnId_2 += ($now_Day - $dateForPawnId_2_Day) / 30;
                } elseif ($dateForPawnId_2_Day < $now_Day) {
                    $totalMonthDifferenceForPawnId_2 += ($now_Day - $dateForPawnId_2_Day) / 30;
                }

                if ($dateForPawnId_2_Month > $now_Month) {
                    $now_Month += 12;
                    $now_Year -= 1;
                    $totalMonthDifferenceForPawnId_2 += ($now_Month - $dateForPawnId_2_Month);
                } elseif ($dateForPawnId_2_Month < $now_Month) {
                    $totalMonthDifferenceForPawnId_2 += ($now_Month - $dateForPawnId_2_Month);
                }
                $totalMonthDifferenceForPawnId_2 += ($now_Year - $dateForPawnId_2_Year) * 12;
                $totalDayDifferenceForPawnId_2 = $now_Day - $dateForPawnId_2_Day;
                // dd(gettype($totalMonthDifferenceForPawnId_2));
                if ($totalMonthDifferenceForPawnId_2 < 1) {
                    if ($totalDayDifferenceForPawnId_2 > 7) {
                        $totalMonthDifferenceForPawnId_2 = 1;
                    } elseif ($totalDayDifferenceForPawnId_2 < 7) {
                        $totalMonthDifferenceForPawnId_2 = 0.5;
                    }
                    $totalInterestForPawnId_2 = $totalPriceForPawnId_2 * $rate * $totalMonthDifferenceForPawnId_2;  //final result total interest for pawn id 2
                } else {
                    $totalInterestForPawnId_2 = $totalPriceForPawnId_2 * $rate * $totalMonthDifferenceForPawnId_2;  //final result total interest for pawn id 2
                }

                $totalInterest += $totalInterestForPawnId_2;
            }
        }
        $totalInterest = floor($totalInterest);

        return view('orders.payInterest', [
            'order' => $order,
            'totalInterest' => $totalInterest,
            'totalPrice' => $totalPrice,
        ]);
    }

    //paid interest
    public function paidInterest($id)
    {
        $order = Order::find($id);

        $name = request()->name;
        $totalPrice = request()->totalPrice;
        $totalInterest = request()->totalInterest;
        $paidInterest = request()->paidInterest;
        $changeMonth = request()->changeMonth;
        $paidMonth = request()->paidMonth;

        HtetYu::where('id', $id)
            ->where('pawn_id', 1)
            ->update(['pawn_id' => 2]);

        $interest = new Interest();
        $interest->order_id = $id;
        $interest->name = $name;
        $interest->total_price = $totalPrice;
        $interest->total_interest_price = $totalInterest;
        $interest->paid_interest_price = $paidInterest;
        $interest->created_at = $changeMonth;
        $interest->updated_at = $paidMonth;
        $interest->save();

        // return back();
        return redirect("/orders/detail/$id");
    }

    //edit page
    public function edit($id)
    {
        $order = Order::find($id);
        $villagesData = Village::all();
        $owners = Owner::all();
        $categories = Category::all();

        return view('orders.edit', [
            'order' => $order,
            'villages' => $villagesData,
            'owners' => $owners,
            'categories' => $categories,
        ]);
    }

    //edit updated
    public function update($id)
    {
        $order  = Order::find($id);
        $htet_yu = HtetYu::where('order_id', $id)->first();

        //get from form
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

        //update orders table
        $order->name = $name;
        $order->village_id = $village_id;
        $order->owner_id = $owner_id;
        $order->weight = $totlaWeightInYwe;
        $order->note = $note;
        $order->created_at = $created_at;
        $order->updated_at = $created_at;
        $order->save();

        //update htet_yus table
        $htet_yu->name = $name;
        $htet_yu->price = $price;
        $htet_yu->save();

        //delete order_category and create order_category
        $orderCategory = OrderCategory::where('order_id', $id);
        $orderCategory->delete();
        foreach ($category_id as $data) {
            $order_categories = new OrderCategory();
            $order_categories->order_id = $id;
            $order_categories->category_id = $data;
            $order_categories->save();
        }

        return redirect("/orders/detail/$id");
    }

    //eduction ရွေးမည်
    public function eduction($id)
    {
        $order = Order::find($id);
        $order->pawn_id = 2;

        return redirect('/');
    }
}
