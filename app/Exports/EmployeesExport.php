<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeesExport implements Responsable, WithHeadings, WithMapping, FromCollection
{
    use Exportable;

    private $fileName = 'Employees.xlsx';

    protected $employees;

    public function __construct(array $employees)
    {
        $this->employees = $employees;
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->id,
            $employee->name,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Employee::all();
    }
    
    // public function query()
    // {
    //     return Employee::query()->whereKey($this->employees);
    // }

    
}
