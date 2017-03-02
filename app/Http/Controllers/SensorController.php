<?php
namespace App\Http\Controllers;

use \Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

use \App\Sensor;

class SensorController extends Controller {

  public function mapAll(Request $request)
  {
    $return = ['status'=>true];
    $sensors = Sensor::all();
    
    foreach ($sensors as $sensor) {
      if(!empty($sensor->last_location)){
        $return['sensorlist'][$sensor->id] = [
          'lat'=>$sensor->last_location->lat,
          'lon'=>$sensor->last_location->lon,
          'title'=>$sensor->title,
          'pm25'=>view('reading.map.pm25')->withSensor($sensor)->render(),
          'infowindow'=>view('reading.map.infowindow')->withSensor($sensor)->render()
        ];
      }
    }
    return $return;
  }

  public function record($action=null,$id=null)
    {
        // If Updating
        if(\Request::has('id')){
          $id = \Request::get('id');
        }
        // Copy texts
        switch ($action) {
          case 'store':
            $message_suffix = 'Stored';
            break;
          case 'edit':
            $message_suffix = 'Updated';
            break;
          case 'remove':
            $message_suffix = 'Removed';
            break;
        }
        $validation_rule = [
          'title'=>'required|max:255|min:3'
        ];
        $request = \Request::all();

        // Validate
        $validator = Validator::make($request, $validation_rule);
        if ($validator->fails()) {
          return [
            'status'=>false,
            'errors'=>$validator->errors()
          ];
        }
        if(!empty($id)){
          $item = Sensor::find($id);
          if($item->access != 'write'){
            return abort('403');
          }
        } else {
          $item = new Sensor;
        }
        // Try to save
        try {
          $item->title = $request['title'];
          $item->user_id = $this->user->id;
          $item->api_key = md5(uniqid(rand(), true));
          $item->save();
          \Session::flash('message', 'Sensor '.$message_suffix);
          return [
            'status'=>true,
            'url'=>url('sensor/item/'.$item->id)
          ];
        } catch (\Exception $e) {
          return [
            'status'=>false,
            'errors'=>$e->getMessage()
          ];
        }
    }

    function main($action=null,$id=null){
      // Save & Update action
      if(\Request::isMethod('post')){
        return $this->record($action,$id);
      }
      $title = __('Add Sensor');
      $layout = 'sensor.item';
      $item = null;
      if(!empty($id) || !empty(\Request::has('id'))){
        $this->title = __('Sensor Information');
        if(empty($id)){
          $id = \Request::get('id');
        }
        $item = Sensor::find($id);
        if(!empty($item->access) && $item->access == 'forbidden' ){
          return abort(403);
        }
      }
      $tabs = [
        'sensor'=>__('Sensor'),
        'readings'=>__('Readings')
      ];
      return view($layout)
        ->withTitle($title)
        ->withTabs($tabs)
        ->withItem($item)
      ;
    }

    public function index()
    {
      $table = [
        'title'=>__('Title'),
        'created_at'=>__('Created')
      ];
      $items = $this->user->sensors()->orderBy('id');
      if(\Request::has('search')){
        $search = \Request::get('search');
        $items = $this->search($items,$search,'title');
      }
      $items = $items->paginate(15);
      return view('sensor.index')
        ->withTitle(__('Sensors'))
        ->withTable($table)
        ->withItems($items)
      ;
    }

}

?>
