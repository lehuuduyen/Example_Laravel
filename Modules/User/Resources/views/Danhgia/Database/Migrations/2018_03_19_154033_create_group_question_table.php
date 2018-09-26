<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateGroupQuestionTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('group_question', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')
                      ->nullable()
                      ->default(NULL);//Ma nguoi tao
                $table->string('name');
                $table->string('descrtiption');
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
            Schema::dropIfExists('group_question');
        }
    }
