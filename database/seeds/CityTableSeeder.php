<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('city')->insert([
      'country_id' => 1,
      'text' => 'Кропивницкий'
    ]);
    DB::table('city')->insert([
      'country_id' => 1,
      'text' => 'Львов'
    ]);
    DB::table('city')->insert([
      'country_id' => 1,
      'text' => 'Одесса'
    ]);

    DB::table('city')->insert([
      'country_id' => 2,
      'text' => 'Вашингтон'
    ]);
    DB::table('city')->insert([
      'country_id' => 2,
      'text' => 'Майами'
    ]);
    DB::table('city')->insert([
      'country_id' => 2,
      'text' => 'Лос-Анджелес'
    ]);
    DB::table('city')->insert([
      'country_id' => 3,
      'text' => 'Берлин'
    ]);
    DB::table('city')->insert([
      'country_id' => 3,
      'text' => 'Мюнхен'
    ]);
    DB::table('city')->insert([
      'country_id' => 3,
      'text' => 'Гамбург'
    ]);
  }
}
