<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

/**
 * Class ListController
 * @package App\Http\Controllers
 */
class ListController extends Controller
{
  /**
   * @param Country $countries
   * @param City $cities
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function countriesGet(Country $countries, City $cities)
  {
    return view('countries', ['countries' => $countries->sortable()->paginate(100), 'citiesCount' => $cities]);
  }

  /**
   * @param Request $request
   * @param Country $country
   * @return $this
   */
  public function countriesPost(Request $request, Country $country)
  {
    if ($request->input('country_name')) {
      $country->name = $request->input('country_name');
      $country->save();
      return back()->with('country_added', 'Новая страна успешно добавлена');
    } else {
      return back()->with('country_added_failed', 'Введите название страны');
    }
  }

  /**
   * @param Request $request
   * @param Country $country
   * @return \Illuminate\Http\JsonResponse
   */
  public function countriesUpdate(Request $request, Country $country)
  {
    if ($request->input('id')) {
      $country->findOrFail($request->input('id'))->update(['name' => $request->input('name')]);
      return response()->json(['response' => true]);
    } else {
      return response()->json(['response' => false, 'message' => 'Неизвестный id']);
    }
  }

  /**
   * @param $id
   * @param Country $country
   * @return $this
   */
  public function countryDelete($id, Country $country)
  {
    $country->findOrFail($id)->delete();
    return back()->with('country_deleted', 'Страна успешно удалена');
  }

  /**
   * @param City $cities
   * @param Country $countries
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function citiesGet(City $cities, Country $countries)
  {
    return view('cities', ['cities' => $cities->sortable()->paginate(100), 'countries' => $countries->sortable()->paginate(100), 'countryName' => $countries]);
  }


  /**
   * @param Request $request
   * @param City $city
   * @return $this
   */
  public function citiesPost(Request $request, City $city)
  {
    if ($request->input('city_name') && $request->input('country_id')) {
      $city->country_id = $request->input('country_id');
      $city->text = $request->input('city_name');
      $city->save();
      return back()->with('city_added', 'Новый город успешно добавлен');
    } else {
      return back()->with('city_added_failed', 'Для добавления нового города выберите страну принадежности и название города');
    }
  }

  /**
   * @param Request $request
   * @param City $city
   * @return \Illuminate\Http\JsonResponse
   */
  public function citiesUpdate(Request $request, City $city)
  {
    if ($request->input('id') && $request->input('country_id') && $request->input('name')) {
      $city->findOrFail($request->input('id'))->update(['country_id' => $request->input('country_id'), 'text' => $request->input('name')]);
      return response()->json(['response' => true]);
    } else {
      return response()->json(['response' => false, 'message' => 'Неизвестны параметры']);
    }
  }

  /**
   * @param $id
   * @param City $city
   * @return $this
   */
  public function citiesDelete($id, City $city)
  {
    $city->findOrFail($id)->delete();
    return back()->with('city_deleted', 'Город успешно удален');
  }

}
