<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceDetailsTable extends Migration
{
    /**
     * 時刻、詳細の勤怠情報を持つテーブル
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attendance_id', 200)->comment('attendanceのID情報');
            $table->string('status', 200)->comment('状態');
            $table->time('start_time')->comment('開始時刻');
            $table->time('stop_time')->comment('終了時刻');
            $table->boolean('work_flg')->default(false)->comment('労働フラグ');
            $table->boolean('rest_flg')->default(false)->comment('休暇フラグ');
            $table->boolean('request_rest_flg')->default(false)->comment('有給休暇フラグ');

            //defalt_columns
            $table->boolean('DELETE_FLG')->default(false)->comment('削除フラグ');
            $table->string('CREATE_USER', 200)->comment('作成者');
            $table->string('UPDATE_USER', 200)->comment('更新者');
            $table->string('CREATE_USER_ID', 200)->comment('作成者ID');
            $table->string('UPDATE_USER_ID', 200)->comment('更新者ID');
            $table->timestamp('CREATED_AT')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('UPDATED_AT')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_details');
    }
}
