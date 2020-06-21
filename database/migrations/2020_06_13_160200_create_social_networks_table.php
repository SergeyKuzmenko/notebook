<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialNetworksTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('social_networks', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('note_id');
      $table->foreign('note_id')
        ->references('id')->on('notes')
        ->onDelete('cascade');
      $table->string('name');
      $table->string('url');
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
    Schema::dropIfExists('social_networks');
  }
}
