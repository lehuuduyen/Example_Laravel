<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments( 'id' );
            $table->integer( 'user_id' )->nullable()->default( NULL );//Ma user
            $table->string( 'full_name' );//Ho va ten
            $table->string( 'avatar' )->nullable()->default( NULL );//Avatar
            $table->tinyInteger( 'gender' )->default( 0 );//Goi tinh
            $table->string( 'phone' ); //So dien thoai
            //Ca nhan
            $table->string( "address" )->nullable()->default( NULL );//Dia chi tam tru
            $table->date( "birthday" )->nullable()->default( NULL );//Ngay sinh
            $table->integer( 'count' )->nullable()->default( 0 );// so luong may dang muon
            $table->tinyInteger( 'type' )->default( 1 );//1 nhan vien 2 khach hang
            //
            $table->timestamps();
            $table->integer( "state" )->default( 1 );
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
