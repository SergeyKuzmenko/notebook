<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SocialNetwork
 * @package App\Models
 */
class SocialNetwork extends Model
{
  /**
   * @var array
   */
  protected $hidden = ["created_at", "updated_at"];
  /**
   * @var array
   */
  protected $fillable = ['note_id', 'name', 'url'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function note()
  {
    return $this->belongsTo('App\Models\Note');
  }

  /**
   * @param $note_id
   * @return Collection
   */
  public function get_social_networks($note_id)
  {
    return $this->where('note_id', $note_id)->get();
  }
}
