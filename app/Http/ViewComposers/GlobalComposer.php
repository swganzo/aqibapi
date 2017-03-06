<?php
namespace App\Http\ViewComposers;

use Auth;
use Illuminate\Contracts\View\View;

class GlobalComposer {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
      if(Auth::check()){
        $navigation = [
          [
            'url'=>'sensors',
            'title'=>__('Sensors'),
            'icon'=>'thermometer',
            'children'=>[
              [
                'url'=>'sensor/create',
                'title'=>__('Create Sensor'),
                'icon'=>'plus'
              ]
            ]
          ],
          // [
          //   'url'=>'readings',
          //   'title'=>__('Readings'),
          //   'icon'=>'bar-chart'
          // ],
        ];
      } else {
        $navigation = null;
      }
      $styles = [
        'app.css'
      ];
      $scripts = [
        'footer'=>[
          'richmarker.js',
          'app.js',
        ],
        'header'=>[
          '//maps.googleapis.com/maps/api/js?key='.env('GMAP_API'),
          '//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js',
          '//d3js.org/d3.v3.js',
          '//ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js',
          '//ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.min.js',
        ]
      ];
      if(empty($view->title)){
        $view->with('title', config('app.name', 'AQIB API'));
      }
      $view->with('navigation', $navigation);
      $view->with('styles', $styles);
      $view->with('scripts', $scripts);
      if(Auth::check()){
        $view->with('user', Auth::user());
      }
    }
}
// https://laracasts.com/discuss/channels/general-discussion/l5-service-provider-for-sharing-view-variables
