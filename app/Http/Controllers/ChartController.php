<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
    }

    public function add(Request $request)
    {
        $chart = new Chart;
        $chart->user = $request->user;
        $chart->product = $request->product;
        $chart->qty = $request->qty;
        $chart->save();
        return $chart;
    }

    public function show($id)
    {
        $chart = DB::table('charts as a')
            ->where('a.user', $id)
            ->join('products as b', 'a.product', '=', 'b.id')
            ->select('a.product as product_id', 'b.name', 'b.description', 'a.qty', 'b.price')
            ->get();
        return $chart;
    }

    public function totalPrice($id)
    {
        $chart = DB::table('charts as a')
            ->where('a.user', $id)
            ->join('products as b', 'a.product', '=', 'b.id')
            ->join('promotions as c', 'c.id', '=', 'b.promotion')
            ->select('*')
            ->select('b.id as product_id', 'a.qty', 'b.price', 'c.*', 'b.promotion as promotion_id')
            ->get();
        // return $chart;
        $total_price = 0;
        $mark1 = 0;
        $mark2 = 0;

        foreach ($chart as $key => $value) {
            // Start ALL Promotions Pre-Conditon Logics
            if($value->promotion_id == 1 AND $value->product_id == $value->param1){
                $mark1++;
            }
            if($value->promotion_id == 1 AND $value->product_id == $value->param2){
                $mark2 = 1;
                $value2 = $value->price;
            }
            // End ALL Promotions Pre-Conditon Logics
    
            // Start Core Calculation
            $sub_price = $value->price*$value->qty;
            $total_price = $total_price + $sub_price;
            // End Core Calculation

            // Start ALL Promotions Logics
            if($mark1 > 0 AND $mark2 == 1)
            for ($i=0; $i <= $mark1; $i++){
                $total_price = $total_price - $value2;
                $discounted_price = $value2/2;
                $total_price =  $total_price+$discounted_price;
            }
            
            // End ALL Promotions Logics
        }

        return $total_price;
    }

    public function destroy(Chart $chart)
    {
    }
}
