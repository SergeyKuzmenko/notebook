<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('country')->insert([
      'name' => 'Украина'
    ]);
    DB::table('country')->insert([
      'name' => 'США'
    ]);
    DB::table('country')->insert([
      'name' => 'Германия'
    ]);
  }
}
