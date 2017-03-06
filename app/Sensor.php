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

  public function todayAverage()
  {
    $rawString = '';
    $rawStringArray = [];
    foreach ($this->header as $k => $v) {
      $rawStringArray[] = 'AVG('.$k.')';
    }
    $rawString = implode(', ',$rawStringArray);
    $readings = $this->readings()->select(\DB::raw($rawString))->whereRaw('DATE(created_at) = CURDATE()')->groupBy(\DB::raw('HOUR( `created_at` )'))->get();
    $return = [];
    foreach ($readings as $key => $reading) {
      dd($reading);
      $return['day'][$reading->created_at->format('d')];
    }
    return $return;
    // SET sql_mode= ''; SELECT AVG( pm25 ) , created_at FROM readings  where `sensor_id` = 1 and  DATE(created_at) = CURDATE() GROUP BY HOUR( created_at ) order by id;
  }
  public function weeklyAverage()
  {
    $rawString = '';
    $rawStringArray = [];
    foreach ($this->header as $k => $v) {
      $rawStringArray[] = 'AVG('.$k.')';
    }
    $rawString = implode(', ',$rawStringArray);
    return $this->readings()->select(\DB::raw($rawString))->whereRaw('DATE(created_at) = CURWEEK()')->groupBy(\DB::raw('HOUR( `created_at` )'))->get();
    // SET sql_mode= ''; SELECT AVG( pm25 ) , created_at FROM readings  where `sensor_id` = 1 and  DATE(created_at) = CURDATE() GROUP BY HOUR( created_at ) order by id;
  }

  public function readings($value='')
  {
    return $this->hasMany('\App\Reading');
  }
}
