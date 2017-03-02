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
  public function getLastReadingAttribute()
  {
    return \App\Reading::where('sensor_id',$this->id)->where('user_id',$this->user_id)->orderBy('updated_at','desc')->first();
  }
  public function getHeaderAttribute()
  {
    return [
      'pm1'=>'PM 1',
      'pm25'=>'PM 2.5',
      'pm10'=>'PM 10',
      'so2'=>'SO2',
      'o3'=>'O3',
      'no2'=>'NO2',
      'co'=>'CO',
      'nh3'=>'NH3',
      'temperature'=>'Temperature',
      'humidity'=>'Humidity',
    ];
  }

  public function readings($value='')
  {
    return $this->hasMany('\App\Reading');
  }
}
