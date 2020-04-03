<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filings', function (Blueprint $table) {
            $table->id();
            $table->string('case_status');
            $table->string('employer');
            $table->string('job_category');
            $table->string('job_title');
            $table->float('salary');
            $table->year('year');
            $table->string('city');
            $table->string('state');
            $table->float('longitude');
            $table->float('latitude');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filings');
    }
}
