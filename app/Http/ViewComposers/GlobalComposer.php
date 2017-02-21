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
      } else {
        $navigation = null;
      }
      $styles = [
        'app.css',
        'bootstrap-tagsinput.css',
      ];
      $scripts = [
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
      ];
      $view->with('title', config('app.name', 'Laravel'));
      $view->with('navigation', $navigation);
      $view->with('styles', $styles);
      $view->with('scripts', $scripts);
      if(Auth::check()){
        $view->with('user', Auth::user());
      }
    }


}
// https://laracasts.com/discuss/channels/general-discussion/l5-service-provider-for-sharing-view-variables
