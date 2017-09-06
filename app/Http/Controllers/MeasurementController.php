<?php

namespace App\Http\Controllers;

use App\ESubMonitor\Enums\IntervalEnum;
use App\ESubMonitor\Metric;
use App\Facades\InfluxDB;
use App\ESubMonitor\Enums\MetricEnum;
use App\Http\Transformers\EsubChartTransformer;
use App\Substation;
use Illuminate\Http\Request;
use InfluxDB\Database;
use InfluxDB\Point;
use Log;

class MeasurementController extends Controller
{
    /**
     * Receives measurements (from simulator)
     *
     * @param Request $request
     */
    public function listener(Request $request)
    {
        $request->validate([
            MetricEnum::LOCATION_ID => "required"
        ]);

        $metric = new Metric($request->all());
        $points = [$metric->toInfluxDBPoint()];

        InfluxDB::writePoints($points, Database::PRECISION_MILLISECONDS);
    }

    /**
     * @param $interval - 1m, 5m, 30m, 60m, 24h
     * @param $location_id
     * @param $parameters
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData($interval, $location_id, $parameters)
    {
        $interval = IntervalEnum::get($interval);
        $parameters = explode(",", $parameters);
        foreach ($parameters as $i=>$val) {
            //$parameters[$i] = MetricEnum::$val;
        }

        if (!(Substation::where('location_id', $location_id)->first()))
            return response()->json(["error" => 'Invalid location id!', 400]);

        if ($interval == IntervalEnum::REAL_TIME)
            return response()->json(["error" => 'This endpoint is used only for polling!', 400]);

        $db = \Influx::selectDB(env("INFLUX_DB_NAME") . "_" . $interval);

        $queryString = "SELECT time, LOCATION_ID";
        foreach ($parameters as $p) {
            $queryString .= ", mean_" . $p;
        }

        $queryString .= " FROM substation_data WHERE LOCATION_ID = '$location_id' GROUP BY LOCATION_ID ORDER BY time DESC LIMIT 20";

        $r = $db->query($queryString);
        $points = $r->getPoints();
        return response()->json(new EsubChartTransformer($points));
    }
}
