<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigInteger('id','20');
            $table->string('employee_name','255');
            $table->string('email','255')->nullable();
            $table->date('dob')->nullable();
            $table->string('password','255');
            $table->integer('gender')->nullable()->default(1)->comment('1.Male 2.Female');
            $table->softDeletes()->nullable();//deleted_at
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
