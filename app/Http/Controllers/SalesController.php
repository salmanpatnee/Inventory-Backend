<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleStoreRequest;
use App\Http\Resources\SaleResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = request('paginate', 10);
        $term     = request('search', '');
        $sortOrder  = request('sortOrder', 'desc');
        $orderBy    = request('orderBy', 'created_at');

        $sales = Sale::search($term)
            ->with('customer')
            ->orderBy($orderBy, $sortOrder)
            ->paginate($paginate);

        return SaleResource::collection($sales);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleStoreRequest $request)
    {

        $attributes = $request->validated();

        $sale =  Sale::create($attributes);

        // Inset sale details
        if ($sale) {
            $saleDetails = Cart::all();

            foreach ($saleDetails as $saleDetail) {

                $saleDetailsData['sale_id'] = $sale->id;
                $saleDetailsData['product_id'] = $saleDetail->product_id;
                $saleDetailsData['quantity'] = $saleDetail->quantity;
                $saleDetailsData['unit_price'] = $saleDetail->unit_price;
                $saleDetailsData['sub_total'] = $saleDetail->sub_total;
                SaleDetail::create($saleDetailsData);

                // Manage stock
                $product = Product::find($saleDetail->product_id);
                $product->update(['quantity' => $product->quantity - $saleDetail->quantity]);
            }

            //Delete cart contents.
            Cart::truncate();
        }

        return (new SaleResource($sale))
            ->additional([
                'message' => 'Sale added successfully.',
                'status' => 'success'
            ])->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        $sale->customer;
        $sale->sale_details;

        return new SaleResource($sale);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return response([
            'message' => 'Sale deleted successfully.',
            'status'  => 'success'
        ], Response::HTTP_OK);
    }
}
