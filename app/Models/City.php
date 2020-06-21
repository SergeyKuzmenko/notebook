<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


/**
 * Class City
 * @package App\Models
 */
class City extends Model
{
  use Sortable;
  /**
   * @var array
   */
  public $sortable = ['id', 'country_id', 'text'];
  /**
   * @var array
   */
  protected $hidden = ["created_at", "updated_at"];
  /**
   * @var array
   */
  protected $fillable = ['country_id', 'text'];
  /**
   * @var string
   */
  protected $table = 'city';

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function country()
  {
    return $this->belongsTo('App\Models\Country');
  }

  /**
   * @param $id
   * @return array
   */
  public function get_city_name($id)
  {
    $city = $this->where('id', $id)->select(['id', 'text'])->first();
    if ($city == null) {
      return ['id' => 0, 'text' => 'Не указан'];

    } else {
      return $city;
    }
  }

}
