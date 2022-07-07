<?php

namespace App\Http\Controllers;

use App\Models\Eduction;
use App\Models\HtetYu;
use App\Models\Interest;
use App\Models\Order;
use App\Models\Summary;
use Illuminate\Http\Request;

class SummaryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //daily page
    public function daily()
    {
        $home = Summary::where('owner_id', 1)
            ->where('dmyearly', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
        $aye = Summary::where('owner_id', 2)
            ->where('dmyearly', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
        $san = Summary::where('owner_id', 3)
            ->where('dmyearly', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
        $ohmar = Summary::where('owner_id', 4)
            ->where('dmyearly', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('summaries.dailysummary', [
            'home' => $home,
            'aye' => $aye,
            'san' => $san,
            'ohmar' => $ohmar,
        ]);
    }
    //daily create
    public function dailyCreate()
    {
        $date = request()->date;
        $staDate = $date . " 00:00:00";
        $endDate = $date . " 23:59:59";

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////အိမ်အတွက်
        $dailySummary = new Summary();
        $htet_yus1 = HtetYu::select('price')->where('owner_id', 1)->whereBetween('created_at', [$staDate, $endDate])->get();
        $interests1 = Interest::select('paid_interest_price')->where('owner_id', 1)->whereBetween('updated_at', [$staDate, $endDate])->get();
        $educts1 = Eduction::select('paid')->where('owner_id', 1)->whereBetween('created_at', [$staDate, $endDate])->get();
        $total_income1 = 0;
        $total_outflow1 = 0;

        foreach ($htet_yus1 as $htet_yu) {
            $total_outflow1 += $htet_yu->price;
        }
        foreach ($interests1 as $interest) {
            $total_income1 += $interest->paid_interest_price;
        }
        foreach ($educts1 as $educt) {
            $total_income1 += $educt->paid;
        }
        //diff price
        if ($total_income1 >= $total_outflow1) {
            $diff_price1 = $total_income1 - $total_outflow1;
        } elseif ($total_income1 < $total_outflow1) {
            $diff_price1 = $total_outflow1 - $total_income1;
        }

        //calculate profit or lose
        if ($total_income1 > $total_outflow1) {
            $profi_loss1 = 2;
        } elseif ($total_income1 == $total_outflow1) {
            $profi_loss1 = 1;
        } else {
            $profi_loss1 = 0;
        }

        //create daily summary for အိမ်
        $dailySummary->owner_id = 1;            //အိမ်အတွက်မလို့ 1
        $dailySummary->in_price = $total_income1;
        $dailySummary->out_price = $total_outflow1;
        $dailySummary->diff_price = $diff_price1;
        $dailySummary->profi_loss = $profi_loss1;
        $dailySummary->dmyearly = 0;            //daily အတွက်ဖြစ်လို့ 0
        $dailySummary->created_at = $date;
        $dailySummary->updated_at = $date;
        $dailySummary->save();

        /////////////////////////////////////////////////////////////////////////////////////////////////////////// အေးအေးခိုင်အတွက်
        $dailySummary = new Summary();
        $htet_yus2 = HtetYu::select('price')->where('owner_id', 2)->whereBetween('created_at', [$staDate, $endDate])->get();
        $interests2 = Interest::select('paid_interest_price')->where('owner_id', 2)->whereBetween('updated_at', [$staDate, $endDate])->get();
        $educts2 = Eduction::select('paid')->where('owner_id', 2)->whereBetween('created_at', [$staDate, $endDate])->get();
        $total_income2 = 0;
        $total_outflow2 = 0;

        foreach ($htet_yus2 as $htet_yu) {
            $total_outflow2 += $htet_yu->price;
        }
        foreach ($interests2 as $interest) {
            $total_income2 += $interest->paid_interest_price;
        }
        foreach ($educts2 as $educt) {
            $total_income2 += $educt->paid;
        }
        //diff price
        if ($total_income2 >= $total_outflow2) {
            $diff_price2 = $total_income2 - $total_outflow2;
        } elseif ($total_income2 < $total_outflow2) {
            $diff_price2 = $total_outflow2 - $total_income2;
        }

        //calculate profit or lose
        if ($total_income2 > $total_outflow2) {
            $profi_loss2 = 2;
        } elseif ($total_income2 == $total_outflow2) {
            $profi_loss2 = 1;
        } else {
            $profi_loss2 = 0;
        }

        //create daily summary for အေးအေးခိုင်
        $dailySummary->owner_id = 2;            //အေးအေးခိုင်အတွက်မလို့ 2
        $dailySummary->in_price = $total_income2;
        $dailySummary->out_price = $total_outflow2;
        $dailySummary->diff_price = $diff_price2;
        $dailySummary->profi_loss = $profi_loss2;
        $dailySummary->dmyearly = 0;            //daily အတွက်ဖြစ်လို့ 0
        $dailySummary->created_at = $date;
        $dailySummary->updated_at = $date;
        $dailySummary->save();

        ///////////////////////////////////////////////////////////////////////////////////////////////////စန်းစန်းထွေးအတွက်
        $dailySummary = new Summary();
        $htet_yus3 = HtetYu::select('price')->where('owner_id', 3)->whereBetween('created_at', [$staDate, $endDate])->get();
        $interests3 = Interest::select('paid_interest_price')->where('owner_id', 3)->whereBetween('updated_at', [$staDate, $endDate])->get();
        $educts3 = Eduction::select('paid')->where('owner_id', 3)->whereBetween('created_at', [$staDate, $endDate])->get();
        $total_income3 = 0;
        $total_outflow3 = 0;

        foreach ($htet_yus3 as $htet_yu) {
            $total_outflow3 += $htet_yu->price;
        }
        foreach ($interests3 as $interest) {
            $total_income3 += $interest->paid_interest_price;
        }
        foreach ($educts3 as $educt) {
            $total_income3 += $educt->paid;
        }
        //diff price
        if ($total_income3 >= $total_outflow3) {
            $diff_price3 = $total_income3 - $total_outflow3;
        } elseif ($total_income3 < $total_outflow3) {
            $diff_price3 = $total_outflow3 - $total_income3;
        }

        //calculate profit or lose
        if ($total_income3 > $total_outflow3) {
            $profi_loss3 = 2;
        } elseif ($total_income3 == $total_outflow3) {
            $profi_loss3 = 1;
        } else {
            $profi_loss3 = 0;
        }

        //create daily summary for စန်းစန်းထွေး
        $dailySummary->owner_id = 3;            //စန်းစန်းထွေးအတွက်မလို့ 3
        $dailySummary->in_price = $total_income3;
        $dailySummary->out_price = $total_outflow3;
        $dailySummary->diff_price = $diff_price3;
        $dailySummary->profi_loss = $profi_loss3;
        $dailySummary->dmyearly = 0;            //daily အတွက်ဖြစ်လို့ 0
        $dailySummary->created_at = $date;
        $dailySummary->updated_at = $date;
        $dailySummary->save();

        ///////////////////////////////////////////////////////////////////////////////////////ဥမ္မာဝင်းအတွက်
        $dailySummary = new Summary();
        $htet_yus4 = HtetYu::select('price')->where('owner_id', 4)->whereBetween('created_at', [$staDate, $endDate])->get();
        $interests4 = Interest::select('paid_interest_price')->where('owner_id', 4)->whereBetween('updated_at', [$staDate, $endDate])->get();
        $educts4 = Eduction::select('paid')->where('owner_id', 4)->whereBetween('created_at', [$staDate, $endDate])->get();
        $total_income4 = 0;
        $total_outflow4 = 0;

        foreach ($htet_yus4 as $htet_yu) {
            $total_outflow4 += $htet_yu->price;
        }
        foreach ($interests4 as $interest) {
            $total_income4 += $interest->paid_interest_price;
        }
        foreach ($educts4 as $educt) {
            $total_income4 += $educt->paid;
        }
        //diff price
        if ($total_income4 >= $total_outflow4) {
            $diff_price4 = $total_income4 - $total_outflow4;
        } elseif ($total_income4 < $total_outflow4) {
            $diff_price4 = $total_outflow4 - $total_income4;
        }

        //calculate profit or lose
        if ($total_income4 > $total_outflow4) {
            $profi_loss4 = 2;
        } elseif ($total_income4 == $total_outflow4) {
            $profi_loss4 = 1;
        } else {
            $profi_loss4 = 0;
        }

        //create daily summary for ဉမ္မာဝင်း
        $dailySummary->owner_id = 4;            //ဥမ္မာဝင်းအတွက်မလို့ 4
        $dailySummary->in_price = $total_income4;
        $dailySummary->out_price = $total_outflow4;
        $dailySummary->diff_price = $diff_price4;
        $dailySummary->profi_loss = $profi_loss4;
        $dailySummary->dmyearly = 0;            //daily အတွက်ဖြစ်လို့ 0
        $dailySummary->created_at = $date;
        $dailySummary->updated_at = $date;
        $dailySummary->save();

        return back();
    }

    //monthly page
    public function monthly()
    {
        $home = Summary::where('owner_id', 1)
            ->where('dmyearly', 1)
            ->orderBy('created_at', "DESC")
            ->get();
        $aye = Summary::where('owner_id', 2)
            ->where('dmyearly', 1)
            ->orderBy('created_at', "DESC")
            ->get();
        $san = Summary::where('owner_id', 3)
            ->where('dmyearly', 1)
            ->orderBy('created_at', "DESC")
            ->get();
        $ohmar = Summary::where('owner_id', 4)
            ->where('dmyearly', 1)
            ->orderBy('created_at', "DESC")
            ->get();

        return view('summaries.monthlysummary', [
            'aye' => $aye,
            'home' => $home,
            'san' => $san,
            'ohmar' => $ohmar,
        ]);
    }
    //monthly create
    public function monthlyCreate()
    {
        $date = request()->date;
        $staDate = $date . "-01 00:00:00";                      //first day of the month
        $endDate = $date . "-01 23:59:59";
        $endDate = strtotime('+1 month', strtotime($endDate));  //plus one month
        $endDate = strtotime('-1 day', $endDate);               //minus one day
        $endDate = date('Y-m-d H:i:s', $endDate);               //result, last day of the month


        /////////////////////////////////////////////////////////////////////////////////////////////////အိမ်အတွက်
        $dailySummary1 = Summary::where('dmyearly', 0)
            ->where("owner_id", 1)
            ->whereBetween("created_at", [$staDate, $endDate])
            ->get();

        $in_price1 = 0;
        $out_price1 = 0;
        $diff_price_profi1 = 0;
        $diff_price_loss1 = 0;
        $diff_price_total1 = 0;
        $profitOrLoss = null;

        foreach ($dailySummary1 as $dailySummary) {
            $in_price1 += $dailySummary->in_price;
            $out_price1 += $dailySummary->out_price;
            if ($dailySummary->profi_loss == 0) {
                $diff_price_loss1 += $dailySummary->diff_price;
            } elseif ($dailySummary->profi_loss == 2) {
                $diff_price_profi1 += $dailySummary->diff_price;
            }
        }

        //total difference price lose or profit or equal
        if ($diff_price_profi1 > $diff_price_loss1) {                   //profit
            $diff_price_total1 = $diff_price_profi1 - $diff_price_loss1;
            $profitOrLoss = 2;
        } elseif ($diff_price_profi1 < $diff_price_loss1) {             //lose
            $diff_price_total1 = $diff_price_loss1 - $diff_price_profi1;
            $profitOrLoss = 0;
        } elseif ($diff_price_profi1 == $diff_price_loss1) {            //equal
            $diff_price_total1 = 0;
            $profitOrLoss = 1;
        }

        //create monthly summary
        $monthlySummary = new Summary();
        $monthlySummary->owner_id = 1;                                 //for home
        $monthlySummary->in_price = $in_price1;
        $monthlySummary->out_price = $out_price1;
        $monthlySummary->diff_price = $diff_price_total1;
        $monthlySummary->profi_loss = $profitOrLoss;
        $monthlySummary->dmyearly = 1;                                 //for monthly
        $monthlySummary->created_at = $endDate;
        $monthlySummary->updated_at = $endDate;
        $monthlySummary->save();
        ///////////////////////////////////////////////////////////////////////////////////////////////////////

        /////////////////////////////////////////////////////////////////////////////////////////////////အေးအေးခိုင်အတွက်
        $dailySummary2 = Summary::where('dmyearly', 0)
            ->where("owner_id", 2)
            ->whereBetween("created_at", [$staDate, $endDate])
            ->get();

        $in_price2 = 0;
        $out_price2 = 0;
        $diff_price_profi2 = 0;
        $diff_price_loss2 = 0;
        $diff_price_total2 = 0;
        $profitOrLoss = null;

        foreach ($dailySummary2 as $dailySummary) {
            $in_price2 += $dailySummary->in_price;
            $out_price2 += $dailySummary->out_price;
            if ($dailySummary->profi_loss == 0) {
                $diff_price_loss2 += $dailySummary->diff_price;
            } elseif ($dailySummary->profi_loss == 2) {
                $diff_price_profi2 += $dailySummary->diff_price;
            }
        }

        //total difference price lose or profit or equal
        if ($diff_price_profi2 > $diff_price_loss2) {                   //profit
            $diff_price_total2 = $diff_price_profi2 - $diff_price_loss2;
            $profitOrLoss = 2;
        } elseif ($diff_price_profi2 < $diff_price_loss2) {             //lose
            $diff_price_total2 = $diff_price_loss2 - $diff_price_profi2;
            $profitOrLoss = 0;
        } elseif ($diff_price_profi2 == $diff_price_loss2) {            //equal
            $diff_price_total2 = 0;
            $profitOrLoss = 1;
        }

        //create monthly summary
        $monthlySummary = new Summary();
        $monthlySummary->owner_id = 2;                                 //for aye aye khaing
        $monthlySummary->in_price = $in_price2;
        $monthlySummary->out_price = $out_price2;
        $monthlySummary->diff_price = $diff_price_total2;
        $monthlySummary->profi_loss = $profitOrLoss;
        $monthlySummary->dmyearly = 1;                                 //for monthly
        $monthlySummary->created_at = $endDate;
        $monthlySummary->updated_at = $endDate;
        $monthlySummary->save();

        /////////////////////////////////////////////////////////////////////////////////////////////////စန်စန်ထွေးအတွက်
        $dailySummary3 = Summary::where('dmyearly', 0)
            ->where("owner_id", 3)
            ->whereBetween("created_at", [$staDate, $endDate])
            ->get();

        $in_price3 = 0;
        $out_price3 = 0;
        $diff_price_profi3 = 0;
        $diff_price_loss3 = 0;
        $diff_price_total3 = 0;
        $profitOrLoss = null;

        foreach ($dailySummary3 as $dailySummary) {
            $in_price3 += $dailySummary->in_price;
            $out_price3 += $dailySummary->out_price;
            if ($dailySummary->profi_loss == 0) {
                $diff_price_loss3 += $dailySummary->diff_price;
            } elseif ($dailySummary->profi_loss == 2) {
                $diff_price_profi3 += $dailySummary->diff_price;
            }
        }

        //total difference price lose or profit or equal
        if ($diff_price_profi3 > $diff_price_loss3) {                   //profit
            $diff_price_total3 = $diff_price_profi3 - $diff_price_loss3;
            $profitOrLoss = 2;
        } elseif ($diff_price_profi3 < $diff_price_loss3) {             //lose
            $diff_price_total3 = $diff_price_loss3 - $diff_price_profi3;
            $profitOrLoss = 0;
        } elseif ($diff_price_profi3 == $diff_price_loss3) {            //equal
            $diff_price_total3 = 0;
            $profitOrLoss = 1;
        }

        //create monthly summary
        $monthlySummary = new Summary();
        $monthlySummary->owner_id = 3;                                 //for san san htwe
        $monthlySummary->in_price = $in_price3;
        $monthlySummary->out_price = $out_price3;
        $monthlySummary->diff_price = $diff_price_total3;
        $monthlySummary->profi_loss = $profitOrLoss;
        $monthlySummary->dmyearly = 1;                                 //for monthly
        $monthlySummary->created_at = $endDate;
        $monthlySummary->updated_at = $endDate;
        $monthlySummary->save();

        /////////////////////////////////////////////////////////////////////////////////////////////////ဥမ္မာဝင်းအတွက်
        $dailySummary4 = Summary::where('dmyearly', 0)
            ->where("owner_id", 4)
            ->whereBetween("created_at", [$staDate, $endDate])
            ->get();

        $in_price4 = 0;
        $out_price4 = 0;
        $diff_price_profi4 = 0;
        $diff_price_loss4 = 0;
        $diff_price_total4 = 0;
        $profitOrLoss = null;

        foreach ($dailySummary4 as $dailySummary) {
            $in_price4 += $dailySummary->in_price;
            $out_price4 += $dailySummary->out_price;
            if ($dailySummary->profi_loss == 0) {
                $diff_price_loss4 += $dailySummary->diff_price;
            } elseif ($dailySummary->profi_loss == 2) {
                $diff_price_profi4 += $dailySummary->diff_price;
            }
        }

        //total difference price lose or profit or equal
        if ($diff_price_profi4 > $diff_price_loss4) {                   //profit
            $diff_price_total4 = $diff_price_profi4 - $diff_price_loss4;
            $profitOrLoss = 2;
        } elseif ($diff_price_profi4 < $diff_price_loss4) {             //lose
            $diff_price_total4 = $diff_price_loss4 - $diff_price_profi4;
            $profitOrLoss = 0;
        } elseif ($diff_price_profi4 == $diff_price_loss4) {            //equal
            $diff_price_total4 = 0;
            $profitOrLoss = 1;
        }

        //create monthly summary
        $monthlySummary = new Summary();
        $monthlySummary->owner_id = 4;                                 //for ohmarwin
        $monthlySummary->in_price = $in_price4;
        $monthlySummary->out_price = $out_price4;
        $monthlySummary->diff_price = $diff_price_total4;
        $monthlySummary->profi_loss = $profitOrLoss;
        $monthlySummary->dmyearly = 1;                                 //for monthly
        $monthlySummary->created_at = $endDate;
        $monthlySummary->updated_at = $endDate;
        $monthlySummary->save();

        //redirect
        return back();
    }

    //yearly page
    public function yearly()
    {
        $home = Summary::where('owner_id', 1)
            ->where('dmyearly', 2)
            ->get();
        $aye = Summary::where('owner_id', 2)
            ->where('dmyearly', 2)
            ->get();
        $san = Summary::where('owner_id', 3)
            ->where('dmyearly', 2)
            ->get();
        $ohmar = Summary::where('owner_id', 4)
            ->where('dmyearly', 2)
            ->get();

        return view('summaries.yearlysummary', [
            'home' => $home,
            'aye' => $aye,
            'san' => $san,
            'ohmar' => $ohmar,
        ]);
    }
    //yearly create
    public function yearlyCreate()
    {
        $date = request()->date;
        $staDate = $date . "-1-1 00:00:00";
        $endDate = $date . "-12-31 23:59:59";

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////yearly summary for home
        $monthlySummary1 = Summary::where('owner_id', 1) //for home
            ->where('dmyearly', 1)      //select month
            ->whereBetween('created_at', [$staDate, $endDate]);

        $in_price1 = 0;
        $out_price1 = 0;
        $diff_price1 = 0;
        $profi_loss1 = null;

        foreach ($monthlySummary1 as $monthlySummary) {
            $in_price1 += $monthlySummary->in_price;
            $out_price1 += $monthlySummary->out_price;
        }

        //find prifit or lose or equal
        if ($in_price1 > $out_price1) {
            $diff_price1 = $in_price1 - $out_price1;
            $profi_loss1 = 2;
        } elseif ($in_price1 < $out_price1) {
            $diff_price1 = $out_price1 - $in_price1;
            $profi_loss1 = 0;
        } elseif ($in_price1 == $out_price1) {
            $diff_price1 = 0;
            $profi_loss1 = 1;
        }

        //create yearly summary
        $yearlySummary = new Summary();
        $yearlySummary->owner_id = 1;       //for home
        $yearlySummary->in_price = $in_price1;
        $yearlySummary->out_price = $out_price1;
        $yearlySummary->diff_price = $diff_price1;
        $yearlySummary->profi_loss = $profi_loss1;
        $yearlySummary->dmyearly = 2;           //for yearly
        $yearlySummary->created_at = $endDate;
        $yearlySummary->updated_at = $endDate;
        $yearlySummary->save();

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////yearly summary for aye aye khaing
        $monthlySummary2 = Summary::where('owner_id', 2) //for aye aye khaing
            ->where('dmyearly', 1)      //select month
            ->whereBetween('created_at', [$staDate, $endDate]);

        $in_price2 = 0;
        $out_price2 = 0;
        $diff_price2 = 0;
        $profi_loss2 = null;

        foreach ($monthlySummary2 as $monthlySummary) {
            $in_price2 += $monthlySummary->in_price;
            $out_price2 += $monthlySummary->out_price;
        }

        //find prifit or lose or equal
        if ($in_price2 > $out_price2) {
            $diff_price2 = $in_price2 - $out_price2;
            $profi_loss2 = 2;
        } elseif ($in_price2 < $out_price2) {
            $diff_price2 = $out_price2 - $in_price2;
            $profi_loss2 = 0;
        } elseif ($in_price2 == $out_price2) {
            $diff_price2 = 0;
            $profi_loss2 = 1;
        }

        //create yearly summary
        $yearlySummary = new Summary();
        $yearlySummary->owner_id = 2;       //for aye aye khaing
        $yearlySummary->in_price = $in_price2;
        $yearlySummary->out_price = $out_price2;
        $yearlySummary->diff_price = $diff_price2;
        $yearlySummary->profi_loss = $profi_loss2;
        $yearlySummary->dmyearly = 2;           //for yearly
        $yearlySummary->created_at = $endDate;
        $yearlySummary->updated_at = $endDate;
        $yearlySummary->save();

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////yearly summary for san san htwe
        $monthlySummary3 = Summary::where('owner_id', 3) //for san san htwe
            ->where('dmyearly', 1)      //select month
            ->whereBetween('created_at', [$staDate, $endDate]);

        $in_price3 = 0;
        $out_price3 = 0;
        $diff_price3 = 0;
        $profi_loss3 = null;

        foreach ($monthlySummary3 as $monthlySummary) {
            $in_price3 += $monthlySummary->in_price;
            $out_price3 += $monthlySummary->out_price;
        }

        //find prifit or lose or equal
        if ($in_price3 > $out_price3) {
            $diff_price3 = $in_price3 - $out_price3;
            $profi_loss3 = 2;
        } elseif ($in_price3 < $out_price3) {
            $diff_price3 = $out_price3 - $in_price3;
            $profi_loss3 = 0;
        } elseif ($in_price3 == $out_price3) {
            $diff_price3 = 0;
            $profi_loss3 = 1;
        }

        //create yearly summary
        $yearlySummary = new Summary();
        $yearlySummary->owner_id = 3;       //for san san htwe
        $yearlySummary->in_price = $in_price3;
        $yearlySummary->out_price = $out_price3;
        $yearlySummary->diff_price = $diff_price3;
        $yearlySummary->profi_loss = $profi_loss3;
        $yearlySummary->dmyearly = 2;           //for yearly
        $yearlySummary->created_at = $endDate;
        $yearlySummary->updated_at = $endDate;
        $yearlySummary->save();

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////yearly summary for ohmar win
        $monthlySummary4 = Summary::where('owner_id', 4) //for home
            ->where('dmyearly', 1)      //select month
            ->whereBetween('created_at', [$staDate, $endDate]);

        $in_price4 = 0;
        $out_price4 = 0;
        $diff_price4 = 0;
        $profi_loss4 = null;

        foreach ($monthlySummary4 as $monthlySummary) {
            $in_price4 += $monthlySummary->in_price;
            $out_price4 += $monthlySummary->out_price;
        }

        //find prifit or lose or equal
        if ($in_price4 > $out_price4) {
            $diff_price4 = $in_price4 - $out_price4;
            $profi_loss4 = 2;
        } elseif ($in_price4 < $out_price4) {
            $diff_price4 = $out_price4 - $in_price4;
            $profi_loss4 = 0;
        } elseif ($in_price4 == $out_price4) {
            $diff_price4 = 0;
            $profi_loss4 = 1;
        }

        //create yearly summary
        $yearlySummary = new Summary();
        $yearlySummary->owner_id = 4;       //for ohmar win
        $yearlySummary->in_price = $in_price4;
        $yearlySummary->out_price = $out_price4;
        $yearlySummary->diff_price = $diff_price4;
        $yearlySummary->profi_loss = $profi_loss4;
        $yearlySummary->dmyearly = 2;           //for yearly
        $yearlySummary->created_at = $endDate;
        $yearlySummary->updated_at = $endDate;
        $yearlySummary->save();

        //redirect
        return back();
    }
}
