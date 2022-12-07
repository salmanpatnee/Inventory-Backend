<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpensesController extends Controller
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

        $expenses = Expense::search($term)
            ->orderBy($orderBy, $sortOrder)
            ->paginate($paginate);

        return ExpenseResource::collection($expenses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseStoreRequest $request)
    {
        $attributes = $request->validated();

        $expense =  Expense::create($attributes);

        return (new ExpenseResource($expense))
            ->additional([
                'message' => 'Expense added successfully.',
                'status' => 'success'
            ])->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        return new ExpenseResource($expense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseUpdateRequest $request, Expense $expense)
    {
        $attributes = $request->validated();

        $expense->update($attributes);

        return (new ExpenseResource($expense))
            ->additional([
                'message' => 'Expense updated successfully.',
                'status' => 'success'
            ])->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return response([
            'message' => 'Expense deleted successfully.',
            'status'  => 'success'
        ], Response::HTTP_OK);
    }
}
