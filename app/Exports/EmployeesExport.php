<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;
/** * This class is called by EmployeeController to export all the employee data as excel * *
    *  @author HZ
* * * @create date 28/08/2020 * */
class EmployeesExport implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle,WithEvents
{
    
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //get specific fields from employees table
        //return Employee::all('id','employee_name','email','dob','gender');
        return Employee::with('departments','positions')->get();
        

    }
    //excel sheet title
    public function title(): string
    {
        return 'Employees';
    }
    //excel coloumn headings
    public function headings(): array
    {
        return [
            '#',
            'Employee Name',
            'Email',
            'Date of Birth',
            'Gender',
            'Department Name',
            'Position Name'
        ];
    }
    // export all employees data
    public function map($employee) : array {
         return [
            
            $employee->id,
            $employee->employee_name,
            $employee->email,
            $employee->dob,
            $employee->gender,
            $employee->departments->map(function ($departments){              
                                      return 
                                        [
                                            $departments->department_name
                                        ];
                                   }),
            $employee->positions->map(function ($positions){              
                                    return 
                                    [
                                        $positions->position_name
                                    ];
                                }),

        
         ];
 
 
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '0600ff'],
                        ],
                    ],
                    
                ];
                
                $event->sheet->getStyle('B2:G8')->applyFromArray($styleArray);
                
            },
           
        ];
    }
}
