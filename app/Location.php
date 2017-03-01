<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

  /**
   * [getLocationsFrom finds locations from given point]
   * @param  [location]  $start [location object]
   * @param  integer $range [range in km]
   * @return [collection]         [Location collection]
   */
  public static function getLocationsFrom($start,$range = 1)
  {
    $lat1 = $start->lat;
    $lon1 = $start->lon;
    //earth's radius in miles
    // $r = 3959;
    //earth's radius in km
    $r = 6371;
    //compute max and min latitudes / longitudes for search square
    $latN = rad2deg(asin(sin(deg2rad($lat1)) * cos($range / $r) + cos(deg2rad($lat1)) * sin($range / $r) * cos(deg2rad(0))));
    $latS = rad2deg(asin(sin(deg2rad($lat1)) * cos($range / $r) + cos(deg2rad($lat1)) * sin($range / $r) * cos(deg2rad(180))));
    $lonE = rad2deg(deg2rad($lon1) + atan2(sin(deg2rad(90)) * sin($range / $r) * cos(deg2rad($lat1)), cos($range / $r) - sin(deg2rad($lat1)) * sin(deg2rad($latN))));
    $lonW = rad2deg(deg2rad($lon1) + atan2(sin(deg2rad(270)) * sin($range / $r) * cos(deg2rad($lat1)), cos($range / $r) - sin(deg2rad($lat1)) * sin(deg2rad($latN))));
    $locations = self::where('lat','<=',$latN)
      ->where('lat','>=',$latS)
      ->where('lon','<=',$lonE)
      ->where('lon','>=',$lonW)
      // ->where('lat','!=',$lat1)
      // ->where('lon','!=',$lon1)
    ;

    return $locations;
  }

  /**
  * [getLocationsWithin Returns Location collection within Northeast and Soutwest range]
  * @param  [location] $ne [north east point of box]
  * @param  [location] $sw [south west point of box]
  * @param  [float] $range [range in kilometr]
  * @return [collection]     [returns collection of locations]
  */
  public static function getLocationsWithin($ne,$sw,$range = 1){
    //http://www.darrinward.com/lat-long/?id=1204956
    $return = array();
    //earth's radius in miles
    // $r = 3959;
    //earth's radius in km
    $r = 6371;

    //compute max and min latitudes / longitudes for search square
    $latN = rad2deg(asin(sin(deg2rad($ne->lat)) * cos($range / $r) + cos(deg2rad($ne->lat)) * sin($range / $r) * cos(deg2rad(0))));
    $latS = rad2deg(asin(sin(deg2rad($sw->lat)) * cos($range / $r) + cos(deg2rad($sw->lat)) * sin($range / $r) * cos(deg2rad(180))));
    $lonE = rad2deg(deg2rad($ne->lon) + atan2(sin(deg2rad(90)) * sin($range / $r) * cos(deg2rad($ne->lat)), cos($range / $r) - sin(deg2rad($ne->lat)) * sin(deg2rad($latN))));
    $lonW = rad2deg(deg2rad($sw->lon) + atan2(sin(deg2rad(270)) * sin($range / $r) * cos(deg2rad($sw->lat)), cos($range / $r) - sin(deg2rad($sw->lat)) * sin(deg2rad($latN))));

    //find all locations within the search square's area
    $locations = self::where('lat','<=',$latN)
      ->where('lat','>=',$latS)
      ->where('lon','<=',$lonE)
      ->where('lon','>=',$lonW)
    ;
    return $locations;
  }

/**
 * [getDistance get distance between 2 locations http://www.geodatasource.com/developers/php]
 * @param  [location] $start [location object]
 * @param  [location] $end   [location object]
 * @param  string $unit  [M = Miles, K = Kilometr, N = Nautical Miles]
 * @return [array]        [returns array]
 */
  public static function getDistance($start,$end,$unit='K'){
    $return = [];
    try{
      $lat1 = $start->lat;
      $lon1 = $start->lon;
      $lat2 = $end->lat;
      $lon2 = $end->lon;

      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $unit = strtoupper($unit);
      if ($unit == "K") {
        $distance = ($miles * 1.609344);
      } else if ($unit == "N") {
        $distance = ($miles * 0.8684);
      } else if ($unit == 'M') {
        $distance = $miles;
      }
      $return['status']=true;
      $return['distance']=round($distance,1);
      return $return;
    } catch (Exception $e) {
      $return['status']=false;
      $return['message'] = 'Exception-'.$e->getMessage();
    }
    return $return;
  }

}
