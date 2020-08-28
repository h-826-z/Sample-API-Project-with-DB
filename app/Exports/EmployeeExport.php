<?php

namespace App\Exports;

use App\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\MttRegistration;
class EmployeeExport implements FromCollection
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
        return Employee::get()->where('id',$this->id);

    }
}
