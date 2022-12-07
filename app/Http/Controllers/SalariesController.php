<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryStoreRequest;
use App\Http\Requests\SalaryUpdateRequest;
use App\Http\Resources\SalaryResource;
use App\Models\Salary;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalariesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $year = request('year', date('Y'));

        return Salary::select('month')
            ->where('year', $year)
            ->groupBy('month')
            ->get();
    }

    public function getSalariesByMonth()
    {
        $paginate = request('paginate', 10);
        $term     = request('search', '');
        $month    = request('month');
        $year     = request('year', date('Y'));
        $sortOrder  = request('sortOrder', 'desc');
        $orderBy    = request('orderBy', 'paid_date');

        if (!$month) return [];

        $salaries =  Salary::search($term)->where('month', $month)
            ->where('year', $year)
            ->with('employee')
            ->orderBy($orderBy, $sortOrder)
            ->paginate($paginate);

        return SalaryResource::collection($salaries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryStoreRequest $request)
    {
        $attributes = $request->validated();

        $salary =  Salary::create($attributes);

        return (new SalaryResource($salary))
            ->additional([
                'message' => 'Salary added successfully.',
                'status' => 'success'
            ])->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        $salary->employee;
        return new SalaryResource($salary);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(SalaryUpdateRequest $request, Salary $salary)
    {
        $attributes = $request->validated();

        $salary->update($attributes);

        return (new SalaryResource($salary))
            ->additional([
                'message' => 'Salary updated successfully.',
                'status' => 'success'
            ])->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salary $salary)
    {
        //
    }
}
