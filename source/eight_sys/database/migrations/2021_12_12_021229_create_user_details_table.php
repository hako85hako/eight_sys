<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * ユーザー情報の追加情報
     * 基本的にユーザー関連の操作、参照はこちらのテーブルを使用する
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id', 200)->comment('ユーザーID情報');
            $table->string('company_id', 200)->comment('企業ID情報');
            $table->string('department_id', 200)->comment('所属ID情報');
            $table->string('before_requestRest_id', 200)->nullable()->comment('前回付与有給休暇ID');
            $table->string('role', 200)->comment('権限情報');
            $table->string('name', 200)->comment('ユーザー名');
            $table->date('hire_date')->nullable()->comment('入社年月日情報');
            
            $table->date('date_inf')->comment('表示月日情報');

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
        Schema::dropIfExists('user_details');
    }
}
