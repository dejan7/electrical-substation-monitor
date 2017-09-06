<?php

namespace App\Http\Controllers;

use App\ESubMonitor\Metric;
use App\ESubMonitor\MetricEnum;
use App\Substation;
use Illuminate\Http\Request;
use Log;
use Influx;
use JavaScript;

class MonitorController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $results = Influx::selectDB('substation_1m')->query("SELECT time, LOCATION_ID, mean_IPTA from substation_data WHERE LOCATION_ID='61'");
        $points = $results->getPoints();

        JavaScript::put(['points' => $points, 'substations' => Substation::all()]);
        return view("monitor", []);
    }


}
