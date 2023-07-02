<?php

namespace App\Http\Controllers;

use App\Models\Inout;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        $tdy_tot_income = 0;
        $tdy_tot_outcome = 0;

        $tdy_date = date("Y-m-d");
        $inoutData = Inout::whereDate('date',$tdy_date)->get();
        foreach ($inoutData as $sinoutData) {
            if ($sinoutData->type == 'in') {
                $tdy_tot_income += $sinoutData->amount;
            }
            if($sinoutData->type == 'out'){
                $tdy_tot_outcome += $sinoutData->amount;
            }
        }

        $day_arr = [date("D")];
        $date_arr = [
            [
                'year' => date("Y"),
                'month' => date("m"),
                'day' => date("d"),
            ],
        ];
        for ($i=1; $i <= 6 ; $i++) {
            $day_arr[] = date("D",strtotime("-$i day"));
            $new_date = [
                'year' => date("Y",strtotime("-$i day")),
                'month' => date("m",strtotime("-$i day")),
                'day' => date("d",strtotime("-$i day"))
            ];
            $date_arr[] = $new_date;
        }

        $incomeAmount = [];
        $outcomeAmount = [];

        foreach ($date_arr as $d) {
            $incomeAmount[] = Inout::whereYear('date',$d['year'])
                ->whereMonth('date',$d['month'])
                ->whereDay('date',$d['day'])
                ->where('type','in')
                ->sum('amount');

            $outcomeAmount[] = Inout::whereYear('date',$d['year'])
            ->whereMonth('date',$d['month'])
            ->whereDay('date',$d['day'])
            ->where('type','out')
            ->sum('amount');
        }

        $data = Inout::orderBy("id",'desc')->get();
        return view("welcome",compact('data','tdy_tot_income','tdy_tot_outcome','day_arr','incomeAmount','outcomeAmount'));
    }
    public function store(Request $request){
        Inout::create([
            'about' => $request->about,
            'amount' => $request->amount,
            'date' => $request->date,
            'type' => $request->type,
        ]);
        return redirect()->back()->with("success","Data Stored Success!");
    }
}
