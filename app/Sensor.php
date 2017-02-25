<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model {
  public function getUrlAttribute()
  {
    return url('project/item/'.$this->id);
  }
}
