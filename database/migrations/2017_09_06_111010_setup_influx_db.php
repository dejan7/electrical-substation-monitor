<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetupInfluxDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //return;
        //create DBs
        $db = Influx::selectDB(env('INFLUX_DB_NAME'));
        $db->create();

        $db = Influx::selectDB(env('INFLUX_DB_NAME')."_1m");
        $db->create();

        $db = Influx::selectDB(env('INFLUX_DB_NAME')."_5m");
        $db->create();

        $db = Influx::selectDB(env('INFLUX_DB_NAME')."_60m");
        $db->create();

        $db = Influx::selectDB(env('INFLUX_DB_NAME')."_6h");
        $db->create();

        $db = Influx::selectDB(env('INFLUX_DB_NAME')."_24h");
        $db->create();

        /**
         * influxdata/influxdb-php library doesn't support Continuous Query creation
         * Set the queries by sending raw requests
         */
        $cl = new GuzzleHttp\Client();
        $cl->request('GET',env("INFLUX_DB_HOST") . ":" . env("INFLUX_DB_PORT") . "/query", [
            'query' => [
                'chunked' => 'true',
                'database' => env('INFLUX_DB_NAME'),
                'q' => 'CREATE CONTINUOUS QUERY "'.env('INFLUX_DB_NAME').'_1m" ON "'.env('INFLUX_DB_NAME').'" BEGIN SELECT mean(*) INTO "substation_1m"."autogen".:MEASUREMENT FROM /.*/ GROUP BY time(1m),LOCATION_ID END'
            ]
        ]);

        $cl->request('GET',env("INFLUX_DB_HOST") . ":" . env("INFLUX_DB_PORT") . "/query", [
            'query' => [
                'chunked' => 'true',
                'database' => env('INFLUX_DB_NAME'),
                'q' => 'CREATE CONTINUOUS QUERY "'.env('INFLUX_DB_NAME').'_5m" ON "'.env('INFLUX_DB_NAME').'" BEGIN SELECT mean(*) INTO "substation_5m"."autogen".:MEASUREMENT FROM /.*/ GROUP BY time(5m),LOCATION_ID  END'
            ]
        ]);

        $cl->request('GET',env("INFLUX_DB_HOST") . ":" . env("INFLUX_DB_PORT") . "/query", [
            'query' => [
                'chunked' => 'true',
                'database' => env('INFLUX_DB_NAME'),
                'q' => 'CREATE CONTINUOUS QUERY "'.env('INFLUX_DB_NAME').'_60m" ON "'.env('INFLUX_DB_NAME').'" BEGIN SELECT mean(*) INTO "substation_60m"."autogen".:MEASUREMENT FROM /.*/ GROUP BY time(60m),LOCATION_ID  END'
            ]
        ]);

        $cl->request('GET',env("INFLUX_DB_HOST") . ":" . env("INFLUX_DB_PORT") . "/query", [
            'query' => [
                'chunked' => 'true',
                'database' => env('INFLUX_DB_NAME'),
                'q' => 'CREATE CONTINUOUS QUERY "'.env('INFLUX_DB_NAME').'_6h" ON "'.env('INFLUX_DB_NAME').'" BEGIN SELECT mean(*) INTO "substation_6h"."autogen".:MEASUREMENT FROM /.*/ GROUP BY time(6h),LOCATION_ID  END'
            ]
        ]);

        $cl->request('GET',env("INFLUX_DB_HOST") . ":" . env("INFLUX_DB_PORT") . "/query", [
            'query' => [
                'chunked' => 'true',
                'database' => env('INFLUX_DB_NAME'),
                'q' => 'CREATE CONTINUOUS QUERY "'.env('INFLUX_DB_NAME').'_24h" ON "'.env('INFLUX_DB_NAME').'" BEGIN SELECT mean(*) INTO "substation_24h"."autogen".:MEASUREMENT FROM /.*/ GROUP BY time(24h),LOCATION_ID  END'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //return;
        $db = Influx::selectDB(env('INFLUX_DB_NAME'));
        $db->drop();
        $db = Influx::selectDB(env('INFLUX_DB_NAME')."_1m");
        $db->drop();
        $db = Influx::selectDB(env('INFLUX_DB_NAME')."_5m");
        $db->drop();
        $db = Influx::selectDB(env('INFLUX_DB_NAME')."_60m");
        $db->drop();
        $db = Influx::selectDB(env('INFLUX_DB_NAME')."_6h");
        $db->drop();
        $db = Influx::selectDB(env('INFLUX_DB_NAME')."_24h");
        $db->drop();


    }
}
