<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Country;
use App\Models\City;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{
  /**
   * @param Note $notes
   * @return \Illuminate\Http\JsonResponse
   */
  public function getNotesCount(Note $notes)
  {
    return response()->json([
      'response' => true,
      'count' => $notes->all()->count()
    ]);
  }

  /**
   * @param Country $countries
   * @return \Illuminate\Http\JsonResponse
   */
  public function getCounties(Country $countries)
  {
    return response()->json([
      'response' => true,
      'countries' => $countries->get()
    ]);
  }

  /**
   * @param $id
   * @param City $cities
   * @return \Illuminate\Http\JsonResponse
   */
  public function getCities($id, City $cities)
  {
    if ((integer)$id) {
      return response()->json([
        'response' => true,
        'cities' => $cities->where('country_id', $id)->get()
      ]);
    } else {
      return response()->json([
        'response' => false,
        'message' => 'Не указан параметр {id} страны'
      ]);
    }
  }
}
