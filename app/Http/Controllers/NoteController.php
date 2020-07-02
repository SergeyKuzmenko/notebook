<?php

namespace App\Http\Controllers;

use App\Models\SocialNetwork;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Http\Requests\AddNewNoteRequest;
use App\Models\Country;
use App\Models\City;
use App\Models\Note;

/**
 * Class NoteController
 * @package App\Http\Controllers
 */
class NoteController extends Controller
{

  /**
   * @param Country $countries
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function index(Country $countries)
  {
    return view('add', ['countries' => $countries->get()->toArray()]);
  }

  /**
   * @param AddNewNoteRequest $request
   * @param Note $note
   * @param SocialNetwork $socialNetwork
   * @return $this
   */
  public function newNote(AddNewNoteRequest $request, Note $note, SocialNetwork $socialNetwork)
  {
    if ($request->file('photo')) {
      $photo = $this->uploadPhoto($request->file('photo'));
    } else {
      $photo = null;
    }
    $note->last_name = $request->input('last_name');
    $note->first_name = $request->input('first_name');
    $note->patronymic = $request->input('patronymic');
    $note->photo = $photo;
    $note->birthday = $request->input('birthday');
    $note->country = $request->input('country');
    $note->city = $request->input('city');
    $note->email = $request->input('email');
    $note->phone = $request->input('phone');
    $note->link_facebook = $request->input('link_facebook');
    $note->contact_note = $request->input('contact_note');
    $note->save();

    if ($request->input('social_networks')['name'][0] !== null && $request->input('social_networks')['name'][0] !== null) {
      $request_array = $request->input('social_networks');
      $response_array = [];
      for ($i = 0; $i < count($request_array['name']); $i++) {
        $response_array[$i]['note_id'] = $note->id;
        $response_array[$i]['name'] = $request_array['name'][$i];
        $response_array[$i]['url'] = $request_array['link'][$i];
      }
      $social_networks = $response_array;
    } else {
      $social_networks = [];
    }

    if ($social_networks) {
      $socialNetwork->insert($social_networks);
    }

    return back()
      ->with('success', 'Запись успешно добавлена')
      ->with('url', route('note.view.get', ['id' => $note->id]));
  }

  /**
   * @param $photo
   * @return string
   */
  private function uploadPhoto($photo)
  {
    $folder = 'photos/';
    $name = Str::random(20) . '.' . $photo->getClientOriginalExtension();
    $image = Image::make($photo);
    $image->fit(256)->resize(256, null, function ($constraint) {
      $constraint->aspectRatio();
    })->save($folder . $name);
    return $image->basename;
  }

  /**
   * @param $id
   * @param Note $note
   * @param Country $country
   * @param City $city
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
   */
  public function updateGet($id, Note $note, Country $country, City $city)
  {
    $note = $note->where('id', $id)->first();
    if ($note) {
      return view('update', [
        'note' => $note,
        'countries' => $country->get()->toArray(),
        'cities' => $city->where('country_id', $note['country'])->get()->toArray(),
        'social_networks' => $note->social_networks->toArray()
      ]);
    } else {
      return abort(404);
    }
  }

  /**
   * @param $id
   * @param AddNewNoteRequest $request
   * @param Note $note
   * @param SocialNetwork $socialNetwork
   * @return $this
   */
  public function updatePost($id, AddNewNoteRequest $request, Note $note, SocialNetwork $socialNetwork)
  {
    $updatedData = [
      'last_name' => $request->input('last_name'),
      'first_name' => $request->input('first_name'),
      'patronymic' => $request->input('patronymic'),
      'birthday' => $request->input('birthday'),
      'country' => $request->input('country'),
      'city' => $request->input('city'),
      'email' => $request->input('email'),
      'phone' => $request->input('phone'),
      'link_facebook' => $request->input('link_facebook'),
      'contact_note' => $request->input('contact_note')
    ];
    if ($request->file('photo') && $request->file('photo') !== null) {
      $photo = $this->uploadPhoto($request->file('photo'));
      $updatedData['photo'] = $photo;
    }
    $note->where('id', $id)->first()->update($updatedData);

    if ($request->input('social_networks')['name'][0] !== null && $request->input('social_networks')['name'][0] !== null) {
      $request_array = array_values($request->input('social_networks'));
      $response_array = [];

      for ($i = 0; $i < count($request_array[0]); $i++) {
        $response_array[$i]['note_id'] = $id;
        $response_array[$i]['name'] = $request_array[0][$i];
        $response_array[$i]['url'] = $request_array[1][$i];
      }
      $social_networks = $response_array;
    } else {
      $social_networks = [];
    }

    if ($social_networks) {
      $socialNetwork->where('note_id', $id)->delete();
      $socialNetwork->insert($social_networks);
    }
    return back()->with('updated', 'Запись успешно обновлена');
  }

  /**
   * @param $id
   * @param Note $note
   * @param SocialNetwork $socialNetworks
   * @return $this
   */
  public function delete($id, Note $note, SocialNetwork $socialNetworks)
  {
    $note->findOrFail($id);
    // Delete related photo
    $photo = $note->where('id', $id)->select(['photo'])->first()->toArray();
    if ($photo['photo']) {
      unlink(public_path('photos/' . $photo['photo']));
    }
    // Delete related social networks
    $socialNetworks->where('note_id', $id)->delete();
    // Delete note
    $note->findOrFail($id)->delete();
    return back()->with('deleted', 'Запись успешно удалена');
  }

  /**
   * @param $id
   * @param Note $note
   * @param Country $country
   * @param City $city
   * @param SocialNetwork $socialNetworks
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function viewGet($id, Note $note, Country $country, City $city, SocialNetwork $socialNetworks)
  {
    return view('view', ['note' => $note->findOrFail($id), 'country' => $country, 'city' => $city, 'social_networks' => $socialNetworks->get_social_networks($id)]);
  }

  /**
   * @param Request $request
   * @param Note $note
   * @param Country $country
   * @param City $city
   * @return \Illuminate\Http\JsonResponse
   */
  public function viewPost(Request $request, Note $note, Country $country, City $city)
  {
    $id = $request->input('id');
    $data = $note->where('id', $id)
      ->with(['social_networks' => function ($query) use ($id) {
        $query->where(['note_id' => $id]);
      }])->first()->toArray();

    if ($data['photo']) {
      $photo = $note->get_photo_url($data['id']);
    } else {
      $photo = asset('public/img/contact-default-icon.png');
    }
    // Replace add add some parameters
    $data['photo'] = $photo;
    $data['country'] = $country->get_country_name($data['country']);
    $data['city'] = $city->get_city_name($data['city']);
    $data['delete_link'] = route('note.delete', ['id' => $data['id']]);
    $data['update_link'] = route('note.update.get', ['id' => $data['id']]);
    return response()->json([
      'response' => true,
      'data' => $data
    ]);
  }

  /**
   * @param $id
   * @param Note $note
   * @return $this
   */
  public function deletePhoto($id, Note $note)
  {
    $photo = $note->where('id', $id)->first();
    if ($photo['photo'] !== null) {
      unlink(public_path('photos/' . $photo['photo']));
      $photo->photo = null;
    }
    $photo->save();
    return back()->with('photo_deleted', 'Фото успешно удалено');
  }

  /**
   * @param Request $request
   * @param Note $note
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function search(Request $request, Note $note)
  {
    $query = $request->input('query');
    if ($query) {
      $result = $note->where('last_name', 'LIKE', "%$query%")
        ->orWhere('first_name', 'LIKE', "%$query%")
        ->orWhere('patronymic', 'LIKE', "%$query%")
        ->orWhere('email', 'LIKE', "%$query%")
        ->orWhere('phone', 'LIKE', "%$query%")
        ->get()->toArray();
      return view('search', ['notes' => $result, 'query' => $query]);
    } else {
      return back();
    }
  }

  /**
   * @param $country_id
   * @param Note $note
   * @param Country $country
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
   */
  public function searchByCountry($country_id, Note $note, Country $country)
  {
    if ($country_id) {
      $result = $note->where('country', $country_id)->get()->toArray();
      return view('search', ['notes' => $result, 'query' => $country->get_country_name($country_id)['name']]);
    } else {
      return back();
    }
  }

  /**
   * @param $city_id
   * @param Note $note
   * @param City $city
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
   */
  public function searchByCity($city_id, Note $note, City $city)
  {
    if ($city_id) {
      $result = $note->where('city', $city_id)->get()->toArray();
      return view('search', ['notes' => $result, 'query' => $city->get_city_name($city_id)['text']]);
    } else {
      return back();
    }
  }
}
