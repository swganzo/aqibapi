<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model {
  public function getUrlAttribute()
  {
    return url('sensor/item/'.$this->id);
  }
  public function getLastLocationAttribute()
  {
    return \App\Location::where('sensor_id',$this->id)->where('user_id',$this->user_id)->orderBy('updated_at','desc')->first();
  }

  public function readings($value='')
  {
    return $this->hasMany('\App\Reading');
  }
}
