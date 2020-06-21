<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('notes')->insert([
        'last_name' => 'Кузьменко',
        'first_name' => 'Сергей',
        'patronymic' => 'Александрович',
        'photo' => 'admin.jpg',
        'birthday' => '11/02/1997',
        'country' => 1,
        'city' => 1,
        'email' => 'kuzmenko.sergey@ukr.net',
        'phone' => '+38(050)12-34-567',
        'link_facebook' => 'https://facebook.com/kuzmenko.tk',
        'contact_note' => 'Администратор сайта'
      ]);

      DB::table('notes')->insert([
        'last_name' => 'Шевченко',
        'first_name' => 'Григорий',
        'patronymic' => 'Савич',
        'photo' => 'savich.jpg',
        'birthday' => '20/05/1990',
        'country' => 2,
        'city' => 4,
        'email' => 'savich@batya.com',
        'phone' => '+38(111)11-22-333',
        'link_facebook' => 'https://facebook.com/savich',
        'contact_note' => 'Должен $500'
      ]);

      DB::table('notes')->insert([
        'last_name' => 'Green',
        'first_name' => 'Sveta',
        'patronymic' => 'Olegovna',
        'photo' => 'green.jpg',
        'birthday' => '11/02/2001',
        'country' => 3,
        'city' => 7,
        'email' => 'green@mail.com',
        'phone' => '+38(000)00-00-000',
        'link_facebook' => 'https://facebook.com/green.sveta',
        'contact_note' => null
      ]);
    }
}
