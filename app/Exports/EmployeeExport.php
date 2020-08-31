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

/** * This class is called by EmployeeController to export specific employee data as excel * *
    *  @author HZ
* * * @create date 28/08/2020 * */
class EmployeeExport implements FromCollection,WithHeadings,ShouldAutoSize,WithMapping,WithTitle,WithEvents
{
    protected $id;
    //parameter passing 
    function __construct($id) {
        $this->id = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Employee::with('departments','positions')->get()->where('id',$this->id);

        
    }
    /** * Data mapping data from model or database with excel 
     * * @author HZ
     * @create date 31/08/2020  
     * @param employee model * @return employee data * */
    public function map($employee) : array {
         return [
            
             $this->id,
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
    /** *Here is Excel column headings 
     * * @author HZ
     * @create date 31/08/2020
     * @param non @return HeadingsArray * */
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
    public function title(): string
    {
        return 'Employee';
    }
    /** *Here is Excel styling
     * * @author HZ
     * @create date 31/08/2020
     * @param non @return Array * */
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
                //set border color to #0600ff
                $event->sheet->getStyle('B2:G2')->applyFromArray($styleArray);
                
            },
           
        ];
    }
    
}
