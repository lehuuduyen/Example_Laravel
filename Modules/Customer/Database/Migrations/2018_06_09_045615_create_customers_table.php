<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer( 'user_id' )->nullable()->default( NULL );//Ma user
            $table->string( 'full_name' );//Ho va ten
            $table->string( 'phone' ); //So dien thoai
            $table->string( 'avatar' )->nullable()->default( NULL );//Avatar
            $table->string( 'address' )->nullable()->default( NULL );//dia chi
            $table->tinyInteger( 'gender' )->default( 0 );//Goi tinh
            $table->tinyInteger('status' )->nullable()->default( 1 );//tinh trang
            $table->integer( 'count' )->nullable()->default( 0 );// so luong may dang muon
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
