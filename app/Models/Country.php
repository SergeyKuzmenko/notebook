<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * Class Country
 * @package App\Models
 */
class Country extends Model
{
  use Sortable;
  /**
   * @var array
   */
  public $sortable = ['id', 'name'];
  /**
   * @var array
   */
  protected $hidden = ["created_at", "updated_at"];
  /**
   * @var string
   */
  protected $table = 'country';
  /**
   * @var array
   */
  protected $fillable = ['name'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function cities()
  {
    return $this->hasMany('App\Models\City');
  }

  /**
   * @param $id
   * @return array
   */
  public function get_country_name($id)
  {
    $country = $this->where('id', $id)->select(['id', 'name'])->first();
    if ($country['id'] == null) {
      return ['id' => 0, 'name' => 'Не указана'];
    } else {
      return $country;
    }

  }
}
