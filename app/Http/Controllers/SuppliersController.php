<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Http\Resources\SuppliersResource;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuppliersController extends Controller
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
        $orderBy    = request('orderBy', 'name');

        $suppliers = Supplier::search($term)
            ->orderBy($orderBy, $sortOrder)
            ->paginate($paginate);

        return SuppliersResource::collection($suppliers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierStoreRequest $request)
    {
        $attributes = $request->validated();

        $supplier =  Supplier::create($attributes);

        return (new SuppliersResource($supplier))
            ->additional([
                'message' => 'Supplier added successfully.',
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
    public function show(Supplier $supplier)
    {
        return new SuppliersResource($supplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierUpdateRequest $request, Supplier $supplier)
    {
        $attributes = $request->validated();

        $supplier->update($attributes);

        return (new SuppliersResource($supplier))
            ->additional([
                'message' => 'Supplier updated successfully.',
                'status' => 'success'
            ])->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response([
            'message' => 'Supplier deleted successfully.',
            'status'  => 'success'
        ], Response::HTTP_OK);
    }
}
