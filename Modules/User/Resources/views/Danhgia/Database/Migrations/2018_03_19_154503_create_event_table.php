<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateEventTable extends Migration
    {
        /**
         * Run the migrations.
         * Su kien gui ra template email cho nguoi dung
         * @return void
         */
        public function up()
        {
            Schema::create('event', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')
                      ->nullable()
                      ->default(NULL);//Ma nguoi tao
                $table->integer('qroup_question_id')
                      ->nullable();// Su kien su dung template cau hoi nao
                $table->string('description')
                      ->default('');//Mo ta ve su kien
                $table->timestamps();
                $table->tinyInteger('status')
                      ->default(0);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('event');
        }
    }
