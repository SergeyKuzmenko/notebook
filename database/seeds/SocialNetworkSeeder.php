<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialNetworkSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('social_networks')->insert([
      'note_id' => 1,
      'name' => 'ВКонтакте',
      'url' => 'https://vk.com/sergey__kuzmenko'
    ]);
    DB::table('social_networks')->insert([
      'note_id' => 1,
      'name' => 'Web-Site',
      'url' => 'https://kuzmenko.tk'
    ]);
    DB::table('social_networks')->insert([
      'note_id' => 3,
      'name' => 'PornHub',
      'url' => 'https://pornhub.com/two_minets'
    ]);
  }
}
