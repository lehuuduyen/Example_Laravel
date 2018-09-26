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
            $table->integer( 'department_id' );//phong ban nao
            $table->string( 'full_name' );//Ho va ten
            $table->string( 'avatar' )->nullable()->default( NULL );//Avatar
            $table->string( 'job_title' )->nullable()->default( NULL );//Chuc vu
            $table->tinyInteger( 'gender' )->default( 0 );//Goi tinh
            $table->string( 'phone' ); //So dien thoai
            $table->integer( 'office_id' )->nullable()->default( 1 );//Van phong nao
            $table->integer( 'position_id' )->default( '0' );//Cap bat, truong phong, pho phong..
            $table->integer( 'type' )->default( 0 );//Loai nhan vien, chinh thuc, thu viec
            //Ca nhan
            $table->string( "birth_place" )->nullable()->default( NULL );//Noi sinh
            $table->string( "origin_place" )->nullable()->default( NULL );//Que quan
            $table->string( "ethnic_group" )->nullable()->default( NULL );//Dan toc
            $table->string( "religious" )->nullable()->default( NULL );//Ton giao
            $table->string( "normal_address" )->nullable()->default( NULL );//Dia chi thuong tru
            $table->string( "temporary_address" )->nullable()->default( NULL );//Dia chi tam tru
            $table->date( "dob" )->nullable()->default( NULL );//Ngay sinh
            //Lien lac
            $table->string( "tax_number" )->nullable()->default( NULL );//Ma Thue
            $table->string( "social_number" )->nullable()->default( NULL );//Ma CMND
            $table->string( "social_number_address" )->nullable()->default( NULL );//Noi Cap
            $table->date( "social_date_create" )->nullable()->default( NULL );

            //Chuyen mon
            $table->string( "foreign_language" )->nullable()->default( NULL );//Ngoai ngu
            $table->string( "computer" )->nullable()->default( NULL );//Trinh do tin hoc
            $table->string( "education_level" )->nullable()->default( NULL );//Trinh do van hoa
            $table->string( "academic_level" )->nullable()->default( NULL );//Trinh do hoc van
            $table->string( "professional" )->nullable()->default( NULL );//Chuyen ngah
            //Suc khoe
            $table->string( "ensurance_number" )->nullable()->default( NULL );//So bao hiem
            $table->date( "ensurance_date_create" )->nullable()->default( NULL );//Ngay tham gia
            $table->string( "ensurance_address" )->nullable()->default( NULL );//Dia chi dang ky
            $table->string( "ensurance_hospital" )->nullable()->default( NULL );//Noi kham chua benh
            $table->string( "health" )->nullable()->default( NULL );//Suc kheo
            $table->string( "weight" )->nullable()->default( NULL );//Can nang
            $table->string( "height" )->nullable()->default( NULL );//Cao
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
