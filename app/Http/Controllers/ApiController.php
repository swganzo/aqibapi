<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Sensor;
use \App\Location;
use Illuminate\Http\JsonResponse;
use \App\Reading;

class ApiController extends Controller {

  private $fields = [
  'user_id',
  'sensor_id',
  'location_id',
  'gas',
  'mq135',
  'lat',
  'lon',
  'pm1',
  'pm25',
  'pm10',
  'so2',
  'o3',
  'no2',
  'co',
  'nh3',
  'humidity',
  'temperature',
  'other',
  ];

/**
 * [update update api]
 * @param  Request $request [laravel request object]
 * @return [json]           [json data]
 */
public function update(Request $request)
{
  $return = [
  'status'=>false
  ];

  if($request->has('api_key')){
    $sensor = Sensor::where('api_key',$request->get('api_key'));
      // find sensor if
    if($sensor->exists()){
      $sensor = $sensor->first();
        // Check if it's boot call or not by mac
      if($request->has('mac')){
          // Check if location exists if not create new one
        if ($request->has('lat') && $request->has('lon')) {
          $location = new Location;
          $location->lat = $request->get('lat');
          $location->lon = $request->get('lon');
            // check if location exists withing 1km
          $locations = Location::getLocationsFrom($location);
          if ($locations->where('sensor_id',$sensor->id)->exists()){
            $location = $locations->where('sensor_id',$sensor->id)->orderBy('updated_at','desc')->first();
          } else {
            $location->sensor_id = $sensor->id;
            $location->user_id = $sensor->user_id;
            if ($request->has('ip')) {
              $location->ip = $request->get('ip');
            }
            $location->save();
          }
          $return = [
          'status'=>true,
          ];
        } else {
          $return = [
          'status'=>false,
          'message'=>'Lat/Lon not provided'
          ];
        }
      } else {
          // Not boot call start storing data to last location
        $reading = new Reading;
        foreach ($request->all() as $key => $value) {
          
          if( in_array ($key, $this->fields) ){
            $reading->$key = $value;
          }
        }
        $reading->user_id = $sensor->user_id;
        $reading->sensor_id = $sensor->id;
        $reading->location_id = $sensor->last_location->id;
        $reading->save();
        $return = [
        'status'=>true,
        ];
        $return = $reading;
      }

    } else {
      $return = [
      'status'=>false,
      'message'=>'Invalid API KEY'
      ];
    }
  } else {
    $return = [
    'status'=>false,
    'message'=>'Missing API KEY'
    ];
  }
  return new JsonResponse($return);
}

}

?>
