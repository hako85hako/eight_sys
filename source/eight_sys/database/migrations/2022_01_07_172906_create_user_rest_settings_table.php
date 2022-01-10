<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUserRestSettingsTable extends Migration
{
    /**
     * 
     * 個人ごとの休日に関する規定設定
     * 
     * 現状使用していない
     * 今後給与計算に必要になりそうなものを列挙して作成
     * 格納する型は基本string200にしているので注意
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('user_rest_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id', 200)->comment('ユーザーID情報');
            $table->boolean('active_flg')->default(false)->comment('有効フラグ');//作成時無効
            $table->string('rest_setting_1', 200)->nullable()->comment('法定外休日：曜日指定');
            $table->string('rest_setting_2', 200)->nullable()->comment('法定内休日：曜日指定');
            $table->string('magnification_1', 200)->nullable()->comment('法定外休日の倍率');
            $table->string('magnification_2', 200)->nullable()->comment('法定内休日の倍率');

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
        Schema::dropIfExists('user_rest_settings');
    }
}
