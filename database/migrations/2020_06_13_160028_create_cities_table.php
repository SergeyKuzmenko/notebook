<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateCitiesTable
 */
class CreateCitiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('city', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('country_id');
      $table->foreign('country_id')
        ->references('id')->on('country')
        ->onDelete('cascade');
      $table->string('text');
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
    Schema::dropIfExists('city');
  }
}
