<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateEventDetailReplyTable extends Migration
    {
        /**
         * Run the migrations.
         *  Chi tiet tra loi event va cau tra loi cho tung cau hoi cu the
         * @return void
         */
        public function up()
        {
            Schema::create('event_detail_reply', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('event_detail_id');
                $table->integer('user_id');
                $table->integer('question_id');
                $table->string('data')
                      ->default('');//Du lieu cau tra loi
                $table->timestamps();
                $table->tinyInteger('status')
                      ->default(1);
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('reply');
        }
    }
