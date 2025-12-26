<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('character_name');
            $table->string('character_tag');
            $table->text('short_description');
            $table->text('full_biography');
            $table->string('image_path')->nullable();
            $table->date('release_date')->nullable();
            // Добавили связь с юзером сюда
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->softDeletes(); // Если используешь мягкое удаление
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
        Schema::dropIfExists('characters');
    }
}
