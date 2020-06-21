<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AddNewNoteRequest
 * @package App\Http\Requests
 */
class AddNewNoteRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'last_name' => 'required|max:255',
      'first_name' => 'required|max:255',
      'patronymic' => 'nullable|max:255',
      'photo' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:5120',
      'birthday' => 'nullable',
      'country' => 'nullable|integer',
      'city' => 'nullable|integer',
      'email' => 'required|email',
      'phone' => 'required',
      'facebook_link' => 'nullable|url',
      'contact_note' => 'nullable|max:1000'
    ];
  }
}
