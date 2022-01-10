<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRequestRestLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_requestRest_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_detail_id', 200)->comment('ユーザーID情報');
            $table->date('get_date')->comment('付与日');
            $table->string('leave_time',200)->default('8')->comment('残時間');
            $table->boolean('request_flg')->default(false)->comment('申請フラグ');//申請中はon,申請前はoff
            $table->boolean('used_flg')->default(false)->comment('使用済みフラグ');

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
        Schema::dropIfExists('user_requestRest_logs');
    }
}
