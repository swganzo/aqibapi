<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Schema;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Assigning User and Request variables
    function __construct(){
      // QaField::migrateFromOld();
      // L5.3 runs contstruct before middleware
      $this->middleware(function ($request, $next) {
        $this->user = \Auth::user();
        $this->request = $request;
        return $next($request);
      });
    }

    public function search($items,$search,$field)
    {
      $searchArray = explode(' ',$search);
      $result = $items->where(function($q) use ($searchArray,$field){
        foreach ($searchArray as $key => $v) {
          $q->orWhere($field,'like','%'.$v.'%');
        }
      });
      return $result;
    }

    public function buildModal(Request $request)
    {
      $id = $request->get('modalaction').'Modal';
      $return['status']=true;
      $return['view'] = view('modules.modal',
        [
          'id'=>$id,
          'title' => $request->get('modaltitle'),
          'modalbody'=>$request->get('modalbody'),
          'vars'=>json_decode($request->get('modaldata'))
        ])
        ->render()
      ;
      return $return;
    }

    public function delete(Request $request){

      $return = [
        'status'=>false,
      ];
      $table = $request->get('table');
      $id = $request->get('id');

      // Should be except users
      if ($table == 'users') {
        $model = \DB::table($table)->orderBy('name','ASC');
      } else {
        $model = $this->user->$table();
      }

      $item = $model->where('relation_id',$id);
      // Check if item exists
      if ($item->exists()) {
        $item = $item->first();
        if ($item->access == 'write'){
          try {
            $item->delete();
            $return = [
              'id'=>$id,
              'status'=>true,
              'message'=>'Item Deleted'
            ];
          } catch (\Exception $e) {
            $return['message'] = $e->getMessage();
          }
        } else {
          $return['message'] = 'You don\'t have access';
        }
      } else {
        $return['message']='Item Not Found';
      }
      return response()->json($return);
    }

}
