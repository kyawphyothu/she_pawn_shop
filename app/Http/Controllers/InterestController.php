<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\HtetYu;
use App\Models\History;

class InterestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //htet_yus
    //created_at ထပ်ယူသောရက်
    //updated_at အတိုးဆပ်လပောင်းထားသောနောက်ဆုံးရင်

    //interests
    //created_at => change month လပြောင်းသော date
    //updated_at => paid month လာရာက်ဆပ်သောရက်


    public function delete($id)
    {
        $interest = Interest::find($id);
        $order_id = $interest->order_id;
        $interest->delete();                //delete interest record

        // $interests = Interest::where('order_id', $id)->get();
        //ပြောင်လဲခဲ့သောလ
        $changeMonth = Interest::where('order_id', $order_id)
            ->orderBy('created_at', 'desc')
            ->first();
        if (isset($changeMonth->created_at)) {
            $changeMonth = $changeMonth->created_at;
            $changeMonth_date_format = date_format($changeMonth, 'Y-m-d H:i:s');
            $changeMonth_strtotime = strtotime($changeMonth_date_format);
            // dd($changeMonth);

            //change htetyu
            $htetYus = HtetYu::where('order_id', $order_id)->get();
            // dd($htetYus);
            foreach ($htetYus as $htetYu) {
                if ($htetYu->pawn_id == 2) {
                    $created_at = $htetYu->created_at;
                    $created_at_date_format = date_format($created_at, 'Y-m-d H:i:s');
                    $created_at_strtotime = strtotime($created_at_date_format);
                    if ($created_at_strtotime < $changeMonth_strtotime) {
                        $htetYu->where('pawn_id', 2)
                            ->where('created_at', '<', $changeMonth)
                            ->update(['updated_at' => $changeMonth]);
                    } elseif ($created_at_strtotime > $changeMonth_strtotime) {
                        $htetYu->where('pawn_id', 2)
                            ->where('created_at', '>', $changeMonth)
                            ->update(['updated_at' => $created_at, 'pawn_id' => 1]);
                    }
                }
            }
        } else {
            //
            //change htetyu
            $htetYus = HtetYu::where('order_id', $order_id)->get();
            foreach ($htetYus as $htetYu) {
                $created_at = $htetYu->created_at;
                $htetYu->where('pawn_id', 2)
                    ->update(['updated_at' => $created_at, 'pawn_id' => 1]);
            }
        }

        //history ကို ဖျကလိုက်ပြီလို့ အကြောင်းကြား
        History::where('status', 3)
            ->where('related_id', $id)
            ->update(['cancled' => 1]);



        return back();
    }
}
