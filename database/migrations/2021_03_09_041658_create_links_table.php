<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->enum('type_pixel',['Lead', 'AddToCart'])->nullable();
            $table->string('pixel')->nullable();
            $table->text('pesan');
            $table->string('link')->unique();
            $table->boolean('link_type')->default(0)->comment('0: single, 1: urut, 2: random');
            $table->integer('jumlah_rotator')->default(1);
            $table->integer('count_link')->default(1);
            $table->string('email');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('links');
    }
}
