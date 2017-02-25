<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Sensor;

class ApiController extends Controller {

  public function update(Request $request)
  {
    $return = [
      'status'=>false
    ];
    if($request->has('api_key')){
      $sensor = Sensor::where('api_key',$request->get('api_key'));
      if($sensor->exists()){
        $sensor = $sensor->first();
        $return = [
          'status'=>true,
        ];
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
    return $return;
  }

}

?>
