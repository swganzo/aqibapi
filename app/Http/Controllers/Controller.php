<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $user;
    public $view;
    public $request;
    public $items;
    public $item;
    public $table;
    public $layout;
    public $title;
    public $navigation;

    // Assigning User and Request variables
    function __construct(){
      // QaField::migrateFromOld();
      // L5.3 runs contstruct before middleware
      $this->middleware(function ($request, $next) {
        $this->user = \Auth::user();
        $this->request = $request;
        $this->navigation = $this->getNavigation();
        $this->$title = config('app.name', 'Laravel');

        return $next($request);
      });
    }

    // Main build view action
    public function buildView(){
      $this->view = view($this->layout)
        ->withTitle($this->title)
        ->withNavigation($this->navigation)
        ->withStyles(
            [
              'app.css',
              'bootstrap-tagsinput.css',
            ]
          )
        ->withScripts(
            [
              'footer'=>[
                'app.js',
                'bootstrap-tagsinput.min.js',
                'typeahead.bundle.js'
              ],
              'header'=>[
                'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js',
                'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js',
                'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.min.js',
              ]
            ]
          )
      ;
      if(!empty($this->table)){
        $this->view->with('table',$this->table);
      }
      if(!empty($this->user)){
        $this->view->with('user',$this->user);
      }
      if(!empty($this->item)){
        $this->view->with('item',$this->item);
      }
      if(!empty($this->items)){
        $this->view->with('items',$this->items);
      }
      return;
    }

    public function getNavigation()
    {
      return [
        [
          'url'=>'sensors',
          'title'=>'Sensors',
          'icon'=>'thermometer',
          'children'=>[
            [
              'url'=>'sensor/create',
              'title'=>'Create Sensor',
              'icon'=>'plus'
            ]
          ]
        ],
        [
          'url'=>'readings',
          'title'=>'Readings',
          'icon'=>'bar-chart'
        ],
      ];
    }
}
