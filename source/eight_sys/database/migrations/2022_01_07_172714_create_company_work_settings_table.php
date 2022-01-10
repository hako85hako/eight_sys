<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCompanyWorkSettingsTable extends Migration
{
    /**
     * 
     * 企業ごとの労働時間及び残業に関する規定設定
     * 
     * 現状使用していない
     * 今後給与計算に必要になりそうなものを列挙して作成
     * 格納する型は基本string200にしているので注意
     * @return void
     */
    public function up()
    {
        Schema::create('company_work_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_id', 200)->comment('企業ID情報');
            $table->boolean('active_flg')->default(true)->comment('有効フラグ');//作成時有効
            $table->string('work_setting_day', 200)->nullable()->comment('基本労働時間：day');
            $table->string('work_setting_week', 200)->nullable()->comment('基本労働時間：week');
            $table->string('magnification_1', 200)->nullable()->comment('法定時間内残業の倍率');
            $table->string('magnification_2', 200)->nullable()->comment('法定時間外残業の倍率');

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
        Schema::dropIfExists('company_work_settings');
    }
}
