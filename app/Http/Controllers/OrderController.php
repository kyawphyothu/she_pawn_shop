<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Eduction;
use App\Models\History;
use App\Models\HtetYu;
use App\Models\Interest;
use App\Models\Order;
use App\Models\OrderCategory;
use App\Models\Owner;
use App\Models\Rate;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function test($order_id)
    // {

    //     $interest = Interest::where('order_id', $order_id)
    //         ->select('created_at')
    //         ->orderBy('created_at', 'desc')
    //         ->first();
    //     dd($interest);
    // }

    //home page
    public function index()
    {
        $allOrders = Order::latest()->paginate(9);
        $villages = Village::all();
        $categories = Category::all();
        $rate4L = Rate::find(1)->interest_rate * 100;
        $rate4G = Rate::find(2)->interest_rate * 100;

        return view('orders.index', [
            'orders' => $allOrders,
            'villages' => $villages,
            'categories' => $categories,
            'rate4L' => $rate4L,
            'rate4G' => $rate4G,
        ]);
    }

    public function searchByName()
    {
        $name = request()->q;
        $order = Order::where('name', 'like', "%$name%")->latest()->paginate(9);
        $villages = Village::all();
        $categories = Category::all();
        $rate4L = Rate::find(1)->interest_rate * 100;
        $rate4G = Rate::find(2)->interest_rate * 100;

        return view('orders.index', [
            'orders' => $order,
            'villages' => $villages,
            'categories' => $categories,
            'name' => $name,
            'rate4L' => $rate4L,
            'rate4G' => $rate4G,
        ]);
    }


    //filter
    public function filter(Request $request)
    {
        $orders = Order::query();

        if ($request->name) {
            $orders->where('name', "like", "%$request->name%");
        }
        if ($request->category_id) {
            $orders->select('orders.*')
                ->leftJoin('order_categories', 'orders.id', '=', 'order_categories.order_id')
                ->whereIn('order_categories.category_id', $request->category_id);
        }

        if ($request->location && $request->location > 0) {
            $orders->where('village_id', $request->location);
        }
        if($request->allOrNot){
            if($request->allOrNot == 'အားလုံး'){
                $orders->whereBetween('pawn_id',[1,2]);
            }elseif($request->allOrNot == 'မရွေးရသေး'){
                $orders->where('pawn_id', 1);
            }elseif($request->allOrNot == 'ရွေးပြီး'){
                $orders->where('pawn_id', 2);
            }
            $SearchAllOrNot = $request->allOrNot;
        }else{
            $SearchAllOrNot = 'အားလုံး';
        }

        //ဈေးနဲ့ရှာတာမထည့်ထားသေးဘူး
        // if($request->price){
        //     $orders->where('')
        // }

        $allOrders = $orders->distinct()->latest()->paginate(9);
        $villages = Village::all();
        $categories = Category::all();
        $rate4L = Rate::find(1)->interest_rate * 100;
        $rate4G = Rate::find(2)->interest_rate * 100;


        return view('orders.index', [
            'orders' => $allOrders,
            'villages' => $villages,
            'categories' => $categories,
            'name' => $request->name,
            'location' => $request->location,
            'category_id_arr' => $request->category_id,
            'rate4L' => $rate4L,
            'rate4G' => $rate4G,
            'SearchAllOrNot' => $SearchAllOrNot,
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

    //create new order
    public function create()
    {

        $validator = validator(request()->all(), [
            'name' => 'required',
            'village_id' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'owner_id' => 'required',
            'datetime_local' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

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
        $htet_yus->owner_id = $owner_id;
        $htet_yus->price = $price;
        $htet_yus->created_at = $created_at;
        $htet_yus->updated_at = $created_at;
        $htet_yus->save();

        //create history
        $history = new History();
        $history->status = 1;
        $history->order_id = $lastInsertId;
        $history->cancled = 0;
        $history->village_id = $village_id;
        $history->name = $name;
        $history->price = $price;
        $history->owner_id = $owner_id;
        $history->related_id = $lastInsertId;
        $history->created_at = $created_at;
        $history->updated_at = $created_at;
        $history->save();

        if(request()->action == 'အပေါင်လက်ခံမည်'){
            return redirect('/')->with('info', "စာရင်းသွင်းခြင်းအောင်မြင်ပါသည်။");
        }else if(request()->action == 'ဆက်တိုက်အပေါင်လက်ခံမည်'){
            return back()->with('info', "စာရင်းသွင်းခြင်းအောင်မြင်ပါသည်။")->with('continuous_order_owner', $owner_id);
        }
    }

    //detail page
    public function detail($id)
    {
        $id = $id;
        $order = Order::find($id);
        $eduction = Eduction::where('order_id', $id)->first();

        return view('orders.details', [
            'order' => $order,
            'eduction' => $eduction,
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

        $validator = validator(request()->all(), [
            'name' => "required",
            'price' => 'required',
            'datetime_local' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $id = $id;
        $name = request()->name;
        $price = request()->price;
        $date = request()->datetime_local;
        $village = Order::find($id)->village_id;
        $owner = Order::find($id)->owner_id;

        //htet yu
        $htetyu = new HtetYu();
        $htetyu->name = $name;
        $htetyu->order_id = $id;
        $htetyu->owner_id = $owner;
        $htetyu->price = $price;
        $htetyu->created_at = $date;
        $htetyu->updated_at = $date;
        $htetyu->save();

        $lastInsertId = DB::getPdo()->lastInsertId();

        //history
        $history = new History();
        $history->status = 2;
        $history->order_id = $id;
        $history->cancled = 0;
        $history->village_id = $village;
        $history->name = $name;
        $history->price = $price;
        $history->owner_id = $owner;
        $history->related_id = $lastInsertId;
        $history->created_at = $date;
        $history->updated_at = $date;
        $history->save();

        return redirect("/orders/detail/$id");
    }

    //pay interest
    public function payInterest($id)
    {
        $order = Order::find($id);

        //rate
        $rate4L = Rate::find(1)->interest_rate;
        $rate4G = Rate::find(2)->interest_rate;

        //finding rate
        $totalPrice = 0;
        foreach ($order->htetYus as $htetYu) {
            $totalPrice += $htetYu->price;
        }
        $totalPrice >= 500000 ? $rate = $rate4G : $rate = $rate4L;

        //calculte interest
        $now = strtotime(date('Y-m-d H:i:s'));
        $now_Year = +date('Y', $now);
        $now_Month = +date('m', $now);
        $now_Day = +date('d', $now);

        //calcutate price
        $totalInterest = 0;
        $totalInterestForPawnId_1 = 0;
        $totalInterestForPawnId_2 = 0;
        $priceMonth = "အရင်း ";
        // dd($priceMonth);
        foreach ($order->htetYus as $htetYu) {
            if ($htetYu->pawn_id == 1) {
                $priceForPawnId_1 = $htetYu->price;

                $totalMonthDifferenceForPawnId_1 = 0;
                $totalDayDifferenceForPawnId_1 = 0;
                // $dateForPawnId_1 = HtetYu::where('order_id', $id)->where('pawn_id', 1)->get();
                // dd($dateForPawnId_1);
                $dateForPawnId_1 = $htetYu->updated_at;
                // $dateForPawnId_1 = $dateForPawnId_1->updated_at;
                $formatedDate = date_format($dateForPawnId_1, 'Y-m-d H:i:s');
                $dateForPawnId_1 = strtotime($formatedDate);
                $dateForPawnId_1_Year = +date('Y', $dateForPawnId_1);
                $dateForPawnId_1_Month = +date('m', $dateForPawnId_1);
                $dateForPawnId_1_Day = +date('d', $dateForPawnId_1);
                // dd($now_Month);
                // dd($dateForPawnId_1_Month);

                if ($dateForPawnId_1_Day > $now_Day) {
                    $now_Day += 30;
                    $now_Month -= 1;
                    $totalDayDifferenceForPawnId_1 = $now_Day - $dateForPawnId_1_Day;
                    $totalMonthDifferenceForPawnId_1 += ($now_Day - $dateForPawnId_1_Day) / 30;
                } elseif ($dateForPawnId_1_Day < $now_Day) {
                    $totalDayDifferenceForPawnId_1 = $now_Day - $dateForPawnId_1_Day;
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
                // dd($totalMonthDifferenceForPawnId_1);
                // dd($totalDayDifferenceForPawnId_1);
                // $totalDayDifferenceForPawnId_1 = $now_Day - $dateForPawnId_1_Day;
                //day difference or month difference
                if ($totalMonthDifferenceForPawnId_1 < 1) {
                    if ($totalDayDifferenceForPawnId_1 > 7) {
                        $totalInterestForPawnId_1 += $priceForPawnId_1 * $rate * 1;  //final result total interest for pawn id 1
                    } elseif ($totalDayDifferenceForPawnId_1 < 7) {
                        $totalInterestForPawnId_1 += $priceForPawnId_1 * $rate * 0.5;  //final result total interest for pawn id 1
                    }
                } else {
                    $totalInterestForPawnId_1 += $priceForPawnId_1 * $rate * $totalMonthDifferenceForPawnId_1;  //final result total interest for pawn id 1
                }
                $totalInterest += $totalInterestForPawnId_1;    //interest တန်ဖိုး စုစုပေါင်း
                $priceMonth .= " $priceForPawnId_1 ($formatedDate)|";
                // dd($priceMonth);
                // dd($totalInterest);
            } elseif ($htetYu->pawn_id == 2) {
                $priceForPawnId_2 = $htetYu->price;
                $totalInterestForPawnId_2 = 0;
                $totalDayDifferenceForPawnId_2 = 0;
                $totalMonthDifferenceForPawnId_2 = 0;

                $totalMonthDifferenceForPawnId_2 = 0;
                $totalDayDifferenceForPawnId_2 = 0;
                $dateForPawnId_2 = HtetYu::where('order_id', $id)->where('pawn_id', 2)->firstOrFail();
                $dateForPawnId_2 = $dateForPawnId_2->updated_at;
                $formatedDate = date_format($dateForPawnId_2, 'Y-m-d H:i:s');
                $dateForPawnId_2 = strtotime($formatedDate);
                $dateForPawnId_2_Year = +date('Y', $dateForPawnId_2);
                $dateForPawnId_2_Month = +date('m', $dateForPawnId_2);
                $dateForPawnId_2_Day = +date('d', $dateForPawnId_2);

                if ($dateForPawnId_2_Day > $now_Day) {
                    $now_Day += 30;
                    $now_Month -= 1;
                    $totalDayDifferenceForPawnId_2 = $now_Day - $dateForPawnId_2_Day;
                    $totalMonthDifferenceForPawnId_2 += ($now_Day - $dateForPawnId_2_Day) / 30;
                } elseif ($dateForPawnId_2_Day < $now_Day) {
                    $totalDayDifferenceForPawnId_2 = $now_Day - $dateForPawnId_2_Day;
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
                // $totalDayDifferenceForPawnId_2 = $now_Day - $dateForPawnId_2_Day;
                //day difference or month difference
                if ($totalMonthDifferenceForPawnId_2 < 1) {
                    if ($totalDayDifferenceForPawnId_2 > 7) {
                        $totalInterestForPawnId_2 += $priceForPawnId_2 * $rate * 1;  //final result total interest for pawn id 1
                    } elseif ($totalDayDifferenceForPawnId_2 < 7) {
                        $totalInterestForPawnId_2 += $priceForPawnId_2 * $rate * 0.5;  //final result total interest for pawn id 1
                    }
                } else {
                    $totalInterestForPawnId_2 += $priceForPawnId_2 * $rate * $totalMonthDifferenceForPawnId_2;  //final result total interest for pawn id 1
                }
                $totalInterest += $totalInterestForPawnId_2;
                $priceMonth .= " $priceForPawnId_2 ($formatedDate)|";
                // dd($totalInterest);
            }
        }

        $totalInterest = floor($totalInterest);

        return view('orders.payInterest', [
            'order' => $order,
            'totalInterest' => $totalInterest,
            'priceMonth' => $priceMonth,
            'totalPrice' => $totalPrice,
        ]);
    }

    //paid interest
    public function paidInterest($id)
    {

        $validator = validator(request()->all(), [
            'name' => 'required',
            'totalInterest' => 'required',
            'paidInterest' => 'required',
            'changeMonth' => 'required',
            'paidMonth' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $order = Order::find($id);

        $name = request()->name;
        $totalPrice = request()->totalPrice;
        $priceMonth = request()->priceMonth;
        $totalInterest = request()->totalInterest;
        $paidInterest = request()->paidInterest;
        $changeMonth = request()->changeMonth;
        $paidMonth = request()->paidMonth;
        $village = $order->village_id;
        $owner = $order->owner_id;

        HtetYu::where('order_id', $id)
            ->where('pawn_id', 1)
            ->update(['pawn_id' => 2, 'updated_at' => $changeMonth]);

        HtetYu::where('order_id', $id)
            ->where('pawn_id', 2)
            ->update(['updated_at' => $changeMonth]);

        // $htet_yu = HtetYu::where('order_id', $id);
        // $htet_yu->pawn_id = 2;
        // $htet_yu->updated_at = $changeMonth;
        // $htet_yu->save();

        $interest = new Interest();
        $interest->order_id = $id;
        $interest->owner_id = $owner;
        $interest->name = $name;
        $interest->total_price = $totalPrice;
        $interest->price_month = $priceMonth;   //price_month is ဆပ်မည့်အတိုးရဲ့ အရင်းတွေနဲ့ အရင်းတွေရဲ့ ယူထာားတဲဲ့လတွေကိုစုပေါင်းရေးထာတဲ့ logn text ဖြစ်ပါတယ်
        $interest->total_interest_price = $totalInterest;
        $interest->paid_interest_price = $paidInterest;
        $interest->created_at = $changeMonth;
        $interest->updated_at = $paidMonth;
        $interest->save();

        $lastInsertId = DB::getPdo()->lastInsertId();

        //created history
        $history = new History();
        $history->status = 3;
        $history->order_id = $id;
        $history->cancled = 0;
        $history->village_id = $village;
        $history->name = $name;
        $history->price = $paidInterest;
        $history->owner_id = $owner;
        $history->related_id = $lastInsertId;
        $history->created_at = $paidMonth;
        $history->updated_at = $paidMonth;
        $history->save();

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

        $validator = validator(request()->all(), [
            'name' => 'required',
            'village_id' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'owner_id' => 'required',
            'datetime_local' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

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
        // $order->pawn_id = 2;

        //finding rate
        $totalPrice = 0;
        foreach ($order->htetYus as $htetYu) {
            $totalPrice += $htetYu->price;
        }
        $totalPrice >= 500000 ? $rate = 0.02 : $rate = 0.03;

        //calculte interest
        $now = strtotime(date('Y-m-d H:i:s'));
        $now_Year = +date('Y', $now);
        $now_Month = +date('m', $now);
        $now_Day = +date('d', $now);

        //calcutate price
        $totalInterest = 0;
        $totalInterestForPawnId_1 = 0;
        $totalInterestForPawnId_2 = 0;
        // $totalPriceForPawnId_2 = 0;
        foreach ($order->htetYus as $htetYu) {
            if ($htetYu->pawn_id == 1) {
                $priceForPawnId_1 = $htetYu->price;
                $totalInterestForPawnId_1 = 0;
                $totalDayDifferenceForPawnId_1 = 0;
                $totalMonthDifferenceForPawnId_1 = 0;

                $totalMonthDifferenceForPawnId_1 = 0;
                $totalDayDifferenceForPawnId_1 = 0;
                // $dateForPawnId_1 = HtetYu::where('order_id', $id)->where('pawn_id', 1)->firstOrFail();
                $dateForPawnId_1 = $htetYu->updated_at;
                // $dateForPawnId_1 = $dateForPawnId_1->updated_at;
                $dateForPawnId_1 = strtotime(date_format($dateForPawnId_1, 'Y-m-d H:i:s'));
                $dateForPawnId_1_Year = +date('Y', $dateForPawnId_1);
                $dateForPawnId_1_Month = +date('m', $dateForPawnId_1);
                $dateForPawnId_1_Day = +date('d', $dateForPawnId_1);

                if ($dateForPawnId_1_Day > $now_Day) {
                    $now_Day += 30;
                    $now_Month -= 1;
                    $totalDayDifferenceForPawnId_1 = $now_Day - $dateForPawnId_1_Day;
                    $totalMonthDifferenceForPawnId_1 += ($now_Day - $dateForPawnId_1_Day) / 30;
                } elseif ($dateForPawnId_1_Day < $now_Day) {
                    $totalDayDifferenceForPawnId_1 = $now_Day - $dateForPawnId_1_Day;
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
                // $totalDayDifferenceForPawnId_1 = $now_Day - $dateForPawnId_1_Day;
                //day difference or month difference
                if ($totalMonthDifferenceForPawnId_1 < 1) {
                    if ($totalDayDifferenceForPawnId_1 > 7) {
                        $totalInterestForPawnId_1 += $priceForPawnId_1 * $rate * 1;  //final result total interest for pawn id 1
                    } elseif ($totalDayDifferenceForPawnId_1 < 7) {
                        $totalInterestForPawnId_1 += $priceForPawnId_1 * $rate * 0.5;  //final result total interest for pawn id 1
                    }
                } else {
                    $totalInterestForPawnId_1 += $priceForPawnId_1 * $rate * $totalMonthDifferenceForPawnId_1;  //final result total interest for pawn id 1
                }
                $totalInterest += $totalInterestForPawnId_1;
            } elseif ($htetYu->pawn_id == 2) {
                $priceForPawnId_2 = $htetYu->price;
                $totalInterestForPawnId_2 = 0;
                $totalDayDifferenceForPawnId_2 = 0;
                $totalMonthDifferenceForPawnId_2 = 0;

                $totalMonthDifferenceForPawnId_2 = 0;
                $totalDayDifferenceForPawnId_2 = 0;
                $dateForPawnId_2 = HtetYu::where('order_id', $id)->where('pawn_id', 2)->firstOrFail();
                $dateForPawnId_2 = $dateForPawnId_2->updated_at;
                $dateForPawnId_2 = strtotime(date_format($dateForPawnId_2, 'Y-m-d H:i:s'));
                $dateForPawnId_2_Year = +date('Y', $dateForPawnId_2);
                $dateForPawnId_2_Month = +date('m', $dateForPawnId_2);
                $dateForPawnId_2_Day = +date('d', $dateForPawnId_2);

                if ($dateForPawnId_2_Day > $now_Day) {
                    $now_Day += 30;
                    $now_Month -= 1;
                    $totalDayDifferenceForPawnId_2 = $now_Day - $dateForPawnId_2_Day;
                    $totalMonthDifferenceForPawnId_2 += ($now_Day - $dateForPawnId_2_Day) / 30;
                } elseif ($dateForPawnId_2_Day < $now_Day) {
                    $totalDayDifferenceForPawnId_2 = $now_Day - $dateForPawnId_2_Day;
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
                // $totalDayDifferenceForPawnId_2 = $now_Day - $dateForPawnId_2_Day;
                //day difference or month difference
                if ($totalMonthDifferenceForPawnId_2 < 1) {
                    if ($totalDayDifferenceForPawnId_2 > 7) {
                        $totalInterestForPawnId_2 += $priceForPawnId_2 * $rate * 1;  //final result total interest for pawn id 1
                    } elseif ($totalDayDifferenceForPawnId_2 < 7) {
                        $totalInterestForPawnId_2 += $priceForPawnId_2 * $rate * 0.5;  //final result total interest for pawn id 1
                    }
                } else {
                    $totalInterestForPawnId_2 += $priceForPawnId_2 * $rate * $totalMonthDifferenceForPawnId_2;  //final result total interest for pawn id 1
                }
                $totalInterest += $totalInterestForPawnId_2;
            }
        }

        // dd($totalInterest);
        $totalInterest = round($totalInterest);

        return view('orders.eduction', [
            'order' => $order,
            'totalInterest' => $totalInterest,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function educt($id)
    {

        $validator = validator(request()->all(), [
            'name' => 'required',
            'price' => 'required',
            'interest' => 'required',
            'total' => 'required',
            'paid' => 'required',
            'day' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $name = request()->name;
        $price = request()->price;
        $interest = request()->interest;
        $total = request()->total;
        $paid = request()->paid;
        $day = request()->day;
        $note = request()->note;

        $order = Order::find($id);
        //pawn_id to 2
        $order->pawn_id = 2;
        $order->save();
        //owner_id
        $owner_id = $order->owner_id;



        //create eduction table
        $eduction = new Eduction();
        if ($note) {
            $eduction->order_id = $id;
            $eduction->owner_id = $owner_id;
            $eduction->name = $name;
            $eduction->price = $price;
            $eduction->interest = $interest;
            $eduction->total = $total;
            $eduction->paid = $paid;
            $eduction->created_at = $day;
            $eduction->note = $note;
            $eduction->save();
        } else {
            $eduction->order_id = $id;
            $eduction->owner_id = $owner_id;
            $eduction->name = $name;
            $eduction->price = $price;
            $eduction->interest = $interest;
            $eduction->total = $total;
            $eduction->paid = $paid;
            $eduction->created_at = $day;
            $eduction->save();
        }

        $lastInsertId = DB::getPdo()->lastInsertId();

        $history = new History();
        $history->status = 4;
        $history->order_id = $id;
        $history->cancled = 0;
        $history->village_id = $order->village_id;
        $history->name = $name;
        $history->price = $paid;
        $history->owner_id = $order->owner_id;
        $history->related_id = $lastInsertId;
        $history->created_at = $day;
        $history->updated_at = $day;
        $history->save();


        return redirect("/orders/detail/$id");
    }

    public function delete($id)
    {
        Order::where('id', $id)->delete();
        Eduction::where('order_id', $id)->delete();
        History::where('order_id', $id)->delete();
        HtetYu::where('order_id', $id)->delete();
        Interest::where('order_id', $id)->delete();
        OrderCategory::where('order_id', $id)->delete();

        return redirect('/')->with('info', "အပေါင်စာရင်းအား ဖျက်သိမ်ခြင်း အောင်မြင်ပါသည်။");
    }
}
