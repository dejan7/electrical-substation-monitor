<?php

namespace App\Console\Commands;

use App\Alert;
use Illuminate\Console\Command;
use Influx;
use DB;

class SendAlertEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendalertemails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends emails for all users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $alerts = Alert::all();

        foreach ($alerts as $alert) {
            $queryString = "SELECT time, location_id, mean_". $alert['column'] . " FROM substation_data WHERE " . $alert['column'];
            if ($alert['comparison'] == "gt")
                $queryString .= " > ";
            else
                $queryString .= " < ";

            $queryString .= $alert['value'];

            $queryString .= " ORDER BY TIME DESC LIMIT 1";

            $db = Influx::selectDB(env('INFLUX_DB_NAME')."_".$alert['interval']);
            $r = $db->query($queryString);
            $points = $r->getPoints();

            if ($points) {
                //event happened, check if we didn't already notify user
                $notified = DB::table('alert_history')
                    ->where('time', $points[0]['time'])
                    ->where('user_id', $alert['user_id'])
                    ->first();

                if (!$notified) {
                    $user = User::find($alert['user_id']);
                    //send email
                }

            }
        }
    }
}
