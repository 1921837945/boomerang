<?php
use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->increments('id')->comment('分类id');
            $table->string('name')->comment('分类名称');
            $table->string('icon')->nullable()->comment('分类图标地址');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
    {    public function down()
     *
     * @return void
     */

}

