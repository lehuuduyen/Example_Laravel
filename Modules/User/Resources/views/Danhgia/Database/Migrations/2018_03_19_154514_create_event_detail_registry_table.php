<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateEventDetailRegistryTable extends Migration
    {
        /**
         * Run the migrations.
         *  Chua thong tin dang ky cua phong ban, hoac ma nguoi dung
         * @return void
         */
        public function up()
        {
            Schema::create('event_detail_registry', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('event_id')
                      ->nullable()
                      ->default(NULL);
                $table->integer('department_id')
                      ->nullable()
                      ->default(NULL);
                $table->integer('user_id_receiver')
                      ->nullable()
                      ->default(NULL);
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
