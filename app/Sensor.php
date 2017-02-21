<?php
namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model {
  use Searchable;
  protected $table = 'sensors';
  public $timestamps = true;

}
