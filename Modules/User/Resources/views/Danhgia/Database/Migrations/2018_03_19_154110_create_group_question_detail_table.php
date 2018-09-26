<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateGroupQuestionDetailTable extends Migration
    {
        /**
         * Run the migrations.
         *  Chi tiet cua 1 group question
         * @return void
         */
        public function up()
        {
            Schema::create('group_question_detail', function (Blueprint $table) {
                $table->integer('question_id')
                      ->nullable()
                      ->default(NULL);
                $table->integer('group_question_id')
                      ->nullable()
                      ->default(NULL);
                $table->tinyInteger('status')
                      ->default(1);//Hien thi, khong hien thi
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('detail_group_question');
        }
    }
