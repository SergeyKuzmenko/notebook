<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * Class Note
 * @package App\Models
 */
class Note extends Model
{
  use Sortable;
  /**
   * @var array
   */
  public $sortable = ['id', 'last_name', 'phone', 'email', 'birthday'];
  /**
   * @var array
   */
  protected $hidden = ["created_at", "updated_at"];
  /**
   * @var array
   */
  protected $fillable = ['last_name', 'first_name', 'patronymic', 'photo', 'birthday', 'country', 'city', 'email', 'phone', 'link_facebook', 'contact_note'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function social_networks()
  {
    return $this->hasMany('App\Models\SocialNetwork');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function country()
  {
    return $this->hasOne('App\Models\Country');
  }

  /**
   * @return mixed
   */
  public function count()
  {
    return $this->count();
  }

  /**
   * @param $id
   * @return string
   */
  public function get_full_name($id)
  {
    $user = $this->find($id);
    return $user->last_name . ' ' . $user->first_name . ' ' . $user->patronymic;
  }

  /**
   * @param $id
   * @return string
   */
  public function get_photo_url($id)
  {
    $user = $this->find($id);
    if ($user->photo !== null) {
      return asset('public/photos/' . '/' . $user->photo);
    } else {
      return asset('public/img/default-photo-view.png');
    }
  }

}
