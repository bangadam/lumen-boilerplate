<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('dateCreated')->nullable();
            $table->dateTime('dateUpdated')->nullable();
            $table->dateTime('dateDeleted')->nullable();

            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('set null');

            $table->string('firstName');
            $table->string('lastName');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
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
