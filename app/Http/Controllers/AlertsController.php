<?php

namespace App\Http\Controllers;

use App\Alert;
use App\User;
use Illuminate\Http\Request;
use Log;
use JavaScript;

class AlertsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        JavaScript::put(['alerts' => Alert::where('user_id', auth()->user()->id)->get()]);
        return view('alerts');
    }

    public function storeAlerts(Request $request)
    {
        $data = $request->all();
        $userID = auth()->user()->id;
        Alert::where('user_id', $userID)->delete();

        $insert = [];
        foreach ($data['column'] as $key => $val) {
            Alert::create([
                'user_id'    => $userID,
                'column'     => $data['column'][$key],
                'comparison' => $data['comparison'][$key],
                'value'      => $data['value'][$key],
                'interval'   => $data['interval'][$key],
            ]);
        }

        return redirect()->back()->with('message', 'Zapamćeno!');
    }

}
