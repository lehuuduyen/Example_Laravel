<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateEventDetailProcessTable extends Migration
    {
        /**
         * Run the migrations.
         *  Chi tiet danh sach nguoi dung duoc su ly de gui email
         * Chi tiet su kien danh cho dung 1 nguoi, moi nguoi se duoc gui mail va insert vao day
         * @return void
         */
        public function up()
        {
            Schema::create('event_detail_process', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('event_id');
                $table->string('code');//Ma code duoc tao ra nham phan biet nguoi dung
                $table->integer('user_id_receiver')
                      ->nullable()
                      ->default(NULL);//Ma nguoi nhan
                $table->integer('department_id')
                    ->nullable()
                    ->default(NULL);//Ma phòng nếu có
//                $table->integer('count_reply')
//                      ->default(0);//So lan tra loi
                $table->integer('count_send')
                      ->default(0);//So lan da gui
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
            Schema::dropIfExists('detail_event');
        }
    }
