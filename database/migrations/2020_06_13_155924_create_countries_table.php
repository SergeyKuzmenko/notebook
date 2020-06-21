<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCountriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('country', function (Blueprint $table) {
      $table->id();
      $table->string('name');
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
    DB::statement('SET FOREIGN_KEY_CHECKS = 0');
    Schema::dropIfExists('country');
    DB::statement('SET FOREIGN_KEY_CHECKS = 1');
  }
}
