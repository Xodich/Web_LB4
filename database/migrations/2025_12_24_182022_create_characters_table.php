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
            $table->string('character_name'); // Имя
            $table->string('character_tag');  // Тег (напр. Ближний бой)
            $table->text('short_description'); // Краткое описание для карточки
            $table->text('full_biography');    // Полное описание для модалки
            $table->string('image_path')->nullable(); // Путь к фото
            $table->date('release_date')->nullable(); // Дата (для теста мутатора)
            $table->softDeletes(); // Расширенный уровень (мягкое удаление)
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
