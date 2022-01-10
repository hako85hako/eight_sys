<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBaseRestSettingsTable extends Migration
{
    /**
     * 
     * 基本休日設定
     * 全企業共通設定
     * 
     * 現状使用していない
     * 今後給与計算に必要になりそうなものを列挙して作成
     * 格納する型は基本string200にしているので注意
     * @return void
     */
    public function up()
    {
        Schema::create('base_rest_settings', function (Blueprint $table) {
            $table->increments('id');
            //法定休日に関する情報
            $table->string('rest_setting_1', 200)->defalt('日')->comment('法定内休日');
            $table->string('rest_setting_2', 200)->defalt('土')->comment('法定外休日');
            $table->string('magnification_1', 200)->defalt('1.35')->comment('法定時間内残業の倍率');
            $table->string('magnification_2', 200)->defalt('1.0')->comment('法定時間外残業の倍率');

            //defalt_columns
            //$table->boolean('DELETE_FLG')->default(false)->comment('削除フラグ');
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
        Schema::dropIfExists('base_rest_settings');
    }
}
