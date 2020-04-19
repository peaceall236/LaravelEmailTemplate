<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaravelEmailTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laravel_email_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('template_index');
            $table->string('entry_file');
            $table->text('storage_location');
            $table->enum("status", ["pending", "processing", "completed", "failed"]);
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
        Schema::dropIfExists('laravel_email_templates');
    }
}
