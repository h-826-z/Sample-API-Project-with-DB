<?php

namespace App\Exports;

use App\Employee;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;

/** * This class is called by EmployeeController to export all the employee data as excel * *
 *  @author HZ
 * * * @create date 28/08/2020 * */

// create custom macro to set cell style by using `phpspreadsheet library` that are not available in laravel-excel package
Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});
class EmployeesExport implements FromCollection, WithHeadings, WithStrictNullComparison,WithEvents
{
    use RegistersEventListeners;//register event
    protected $data;
    

    /** *parameter passing
     * @author HZ
     * @param $_REQUEST
     * @return id
     * @create date 01/09/2020
     */
    function __construct($data)
    {
        $this->data = $data;
    }

    /** *retrieve data from employee join by departments and positions
     * @author HZ
     * @param 
     * @return employee collection
     * @create date 01/09/2020
     */
    public function collection()
    {

        //return Employee::all('id','employee_name','email','dob','gender');
        //return Employee::with('departments','positions')->get();
        // if ($this->id != "") { //check input request id is null or not
        //     return Employee::with('departments', 'positions')->get()->where('id', $this->id);
        // } else {
        //     return Employee::with('departments', 'positions')->get();
        // }
      
        // SELECT id,if(gender=1,'male','female') as gender FROM db_sample.employees


            //search with query builder
            $sql = DB::table('employees')
            ->join('emp_dep_positions', 'employees.id', '=', 'emp_dep_positions.employee_id')
            ->join('departments', 'departments.id', '=', 'emp_dep_positions.department_id')
            ->join('positions', 'positions.id', '=', 'emp_dep_positions.position_id')
            ->where($this->data)
            ->select('employees.id' ,'employees.employee_name' , 'employees.email' , 'employees.dob' , 'employees.gender' ,  'departments.department_name', 'positions.position_name')
            ->get();
            return $sql;
    }
 

    /** *Sheet Column Headings
     * @author HZ
     * @return excel coloumn headings
     * @create date 01/09/2020
     */
    public function headings(): array
    {
        return [
            [
                'Employees List'
            ],
            [
                'No',
                'Employee Name',
                'Email',
                'Date of Birth',
                'Gender',
                'Department Name',
                'Position Name'
            ]         
        ];
    }

    /** *export all employees data with mapping
     * @author HZ
     * @param $employee
     * @return employee Data Array
     * @create date 01/09/2020
     */


   /*public function map($employee): array
    {
        return [
            //get specific fields from employees table
            $employee->id,
            $employee->employee_name,
            $employee->email,
            $employee->dob,
            $employee->gender,
            //$employee->departments->department_name
            //get specific fields from departments table with related employees Id
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
    */

    /**
     * @author HZ
     * @param AfterSheet $event
     * @return array
     * @create date 01/9/2020
     */
    public static function afterSheet(AfterSheet $event)
    {
        
        // style array
        $styleArray = [
            'headerFont' => [
                'bold' => true,
                'size' => 14
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => '6af0b6']
                
            ],
            'borderSyle' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ]
            ]
        ];


        // set column width
        self::setColumnWidth($event);

        // set worksheet title name
        self::setTitleAndStyle($event, $styleArray);

        // set header style and merge
        self::setHeaderStyle($event, $styleArray);

        // set dynamic data row style
        self::setDynamicDataRowStyle($event, $styleArray);
    }
     /**
     * Set Column Width
     * 
     * @author  HZ
     * @return $event
     * @create  01/09/2020
     */
    public static function setColumnWidth($event)
    {
        $event->sheet->getColumnDimension('A')->setWidth(20);
        $event->sheet->getColumnDimension('B')->setWidth(30);
        $event->sheet->getColumnDimension('C')->setWidth(20);
        $event->sheet->getColumnDimension('D')->setWidth(20);
        $event->sheet->getColumnDimension('E')->setWidth(20);
        $event->sheet->getColumnDimension('F')->setWidth(20);
        $event->sheet->getColumnDimension('G')->setWidth(20);
    }
    /**
     * Set title and style
     * 
     * @author  HZ
     * @return $event,Array
     * @create  01/09/2020
     */
    public static function setTitleAndStyle($event, $styleArray) 
    {
        // set sheet tab title
        $event->sheet->setTitle('Employees List');

        // Set Title style
        $event->sheet->styleCells(
            'A1', 
            [
                'font' => $styleArray['headerFont'],
                'alignment' => $styleArray['alignment']
            ]
        );
        // merge title cells
        $event->sheet->mergeCells('A1:G1');
    }

    /**
     * Set header style and merge
     * 
     * @author  HZ
     * @return $event,array
     * @create  01/09/2020
     * 
     */
    public static function setHeaderStyle($event, $styleArray)
    {
        // Change header background color
        $event->sheet->styleCells(
            'A2:G2',
            [
                'alignment' => $styleArray['alignment'],
                'fill' => $styleArray['fill'],
                'borders' => $styleArray['borderSyle']
            ]
        );

        // set header row height
        $event->sheet->getRowDimension(2)->setRowHeight(25);
    }

    /**
     * Set dynamic data rows style and merge
     * 
     * @author  HZ
     * @return event,array
     * @create  01/09/2020
     */
    public static function setDynamicDataRowStyle($event, $styleArray)
    {
        // get highest row
        $highestRow = $event->sheet->getHighestRow();
        // set border style to data rows
        $cellRange = 'A2:G'.$highestRow;
        $event->sheet->styleCells(
            $cellRange,
            [
                'borders' => $styleArray['borderSyle'],
                'alignment' => $styleArray['alignment']
            ]
        );
    }
}
