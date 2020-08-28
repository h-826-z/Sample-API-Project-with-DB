<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployeesExport implements FromCollection,WithHeadings,ShouldAutoSize,WithTitle, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //get specific fields from employees table
        //return Employee::all('id','employee_name','email','dob','gender');

        return Employee::with(["departments", "positions" => function($q){
            $q->where('positions.id', '=', 'employees.id');
            
        }])->get();
        

    }
    public function title(): string
    {
        return 'Employees';
    }
    public function headings(): array
    {
        return [
            '#',
            'Employee Name',
            'Email',
            'Date of Birth',
            'Gender',
        ];
    }
    // ...

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class=> function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18);
               
                
            },
            
            
        ];
    }
}
