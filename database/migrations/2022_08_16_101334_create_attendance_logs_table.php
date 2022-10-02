<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('attendance_id')->unsigned();
            $table->bigInteger('student_id')->unsigned();
            $table->time('time_in');
            $table->time('time_out');
            $table->date('date_in');
            $table->date('date_out');
            $table->timestamps();

            $table->foreign('attendance_id')
            ->references('id')
            ->on('attendances')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('student_id')
            ->references('id')
            ->on('students')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_logs');
    }
}
