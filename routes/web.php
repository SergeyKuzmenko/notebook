<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MainController@index')->name('index');

Route::prefix('note')->group(function () {

  Route::get('/new', 'NoteController@index')->name('note.new.get');
  Route::post('/new', 'NoteController@newNote')->name('note.new.post');

  Route::get('/update/{id}', 'NoteController@updateGet')->name('note.update.get');
  Route::post('/update/{id}', 'NoteController@updatePost')->name('note.update.post');

  Route::get('/delete/{id}', 'NoteController@delete')->name('note.delete');
  Route::get('/delete/photo/{id}', 'NoteController@deletePhoto')->name('note.delete.photo.get');

  Route::get('/view/{id}', 'NoteController@viewGet')->name('note.view.get');
  Route::post('/view', 'NoteController@viewPost')->name('note.view.post');

  Route::get('/search', 'NoteController@search')->name('note.search');
  Route::get('/search/country/{country_id}', 'NoteController@searchByCountry')->name('note.search.country');
  Route::get('/search/city/{city_id}', 'NoteController@searchByCity')->name('note.search.city');
});

Route::prefix('list')->group(function () {
  Route::get('/countries', 'ListController@countriesGet')->name('list.countries.get');
  Route::post('/countries', 'ListController@countriesPost')->name('list.countries.post');
  Route::post('/countries/update', 'ListController@countriesUpdate')->name('list.countries.update');
  Route::get('/country/delete/{id}', 'ListController@countryDelete')->name('list.country.delete');

  Route::get('/cities', 'ListController@citiesGet')->name('list.cities.get');
  Route::post('/cities', 'ListController@citiesPost')->name('list.cities.post');
  Route::post('/cities/update', 'ListController@citiesUpdate')->name('list.cities.update');
  Route::get('/cities/delete/{id}', 'ListController@citiesDelete')->name('list.cities.delete');
});

Route::prefix('api')->group(function () {
  Route::get('/count', 'ApiController@getNotesCount')->name('api.count');
  Route::get('/countries', 'ApiController@getCounties')->name('api.countries');
  Route::get('/cities/{id}', 'ApiController@getCities')->name('api.cities');
});


