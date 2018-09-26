<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateQuestionTable extends Migration
    {
        /**
         * Run the migrations.
         * Luu danh sach cac cau hoi
         * @return void
         */
        public function up()
        {
            Schema::create('question', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')
                      ->nullable()
                      ->default(NULL);//Ma nguoi tao
                $table->string('name');
                $table->tinyInteger('type')
                      ->default(0);//Ma loai: Cau hoi tra  loi text, select...
                $table->string('description')
                      ->nullable()
                      ->default(NULL);
                $table->text('data')
                      ->nullable()
                      ->default(NULL);//Du lieu tra loi, danh cho select
                $table->timestamps();
                $table->tinyInteger('status')
                      ->default(0);//Trang thai, dang mo hoac dang khoa
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('question');
        }
    }
