<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Class CreateNotesTable
 */
class CreateNotesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('notes', function (Blueprint $table) {
      $table->id();
      $table->string('last_name');
      $table->string('first_name');
      $table->string('patronymic')->nullable();
      $table->string('photo')->nullable();
      $table->string('birthday')->nullable();
      $table->integer('country')->nullable();
      $table->integer('city')->nullable();
      $table->string('email')->nullable();
      $table->string('phone')->nullable();
      $table->string('link_facebook')->nullable();
      $table->string('contact_note')->nullable();
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
    Schema::dropIfExists('notes');
    DB::statement('SET FOREIGN_KEY_CHECKS = 1');
  }
}
