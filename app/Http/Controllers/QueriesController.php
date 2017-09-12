<?php

namespace App\Http\Controllers;

use App\ESubMonitor\Enums\MetricEnum;
use App\ESubMonitor\InfluxQueryBuilder;
use App\ESubMonitor\Metric;
use App\Substation;
use Illuminate\Http\Request;
use Log;
use Influx;
use JavaScript;

class QueriesController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth")->except('getData');
    }

    public function index()
    {
        JavaScript::put(['substations' => Substation::all()]);
        return view("queries");
    }

    public function getData(Request $request)
    {
        $iqb = new InfluxQueryBuilder($request->all());

        $db = Influx::selectDB(env('INFLUX_DB_NAME')."_1m");
        $r = $db->query($iqb->getSelectQuery());
        $results = $r->getPoints();
        if ($request->input('aggregate') == 'none' && $request->input('selector') == 'none') {
            $r = $db->query($iqb->getPaginationQuery());
            $pagination = $r->getPoints();
            $count = isset($pagination[0]['count']) ? $pagination[0]['count'] : 0;
        } else {
            $count = 1;
        }

        return response()->json(['results' => $results, 'total' => $count]);

    }
}
