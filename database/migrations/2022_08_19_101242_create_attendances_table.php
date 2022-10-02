<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('classroom_id')->unsigned();
            $table->time('signin_start');
            $table->time('signin_end');
            $table->time('signout_start');
            $table->time('signout_end');
            $table->smallInteger('late_minute');
            $table->date('attendance_date');
            $table->bigInteger('venue_id')->unsigned();
            $table->smallInteger('active')->default(1);
            $table->timestamps();

            $table->foreign('classroom_id')
            ->references('id')
            ->on('classrooms')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('venue_id')
            ->references('id')
            ->on('venues')
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
        Schema::dropIfExists('attendances');
    }
}
