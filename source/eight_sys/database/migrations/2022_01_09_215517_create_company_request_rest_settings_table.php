<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyRequestRestSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_requestRest_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_id', 200)->comment('企業ID情報');
            $table->boolean('active_flg')->default(true)->comment('有効フラグ');//作成時有効
            $table->string('pass_date', 200)->nullable()->comment('就職後経過日数');
            $table->string('give_date', 200)->nullable()->comment('付与休暇日数');

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
        Schema::dropIfExists('company_requestRest_settings');
    }
}
