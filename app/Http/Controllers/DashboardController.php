<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $totalSales = DB::table('sales')->whereDate('created_at', Carbon::today())->sum('grand_total');
        $totalIncome = DB::table('sales')->whereDate('created_at', Carbon::today())->sum('pay');
        $totalDue = DB::table('sales')->whereDate('created_at', Carbon::today())->sum('due');
        $totalExpense = DB::table('expenses')->whereDate('created_at', Carbon::today())->sum('amount');
        $outOfStockProducts = Product::where('quantity', '<', 1)->with('category')->get();

        return [ 
            'totalSales' => $totalSales, 
            'totalIncome' => $totalIncome, 
            'totalDue' => $totalDue, 
            'totalExpense' => $totalExpense, 
            'outOfStockProducts' => ProductResource::collection($outOfStockProducts) 
        ];
    }
}
