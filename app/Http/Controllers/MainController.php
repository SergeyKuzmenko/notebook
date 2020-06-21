<?php

namespace App\Http\Controllers;

use App\Models\Note;

/**
 * Class MainController
 * @package App\Http\Controllers
 */
class MainController extends Controller
{
  /**
   * @param Note $notes
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function index(Note $notes)
  {
    return view('index', ['notes' => $notes->sortable()->paginate(100)]);
  }
}
