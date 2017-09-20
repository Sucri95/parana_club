<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CashTransaction;
use App\User;
use App\Product;
use App\SalesByUser;
use App\SalesDetail;
use App\Activity;
use App\ActivityByTutor;
use App\Classes;
use App\ClassDaySchedule;
use App\Day;
use DateTime;

class StatisticsController extends Controller
{

	public function index()
    {
        return view('list.statisctics_list');

    }

	private function findDay($day)
	{
		$name = '';

		if ($day == 1) {

			$name = "monday";

		}elseif ($day == 2) {

			$name = "tuesday";

		}elseif ($day == 3) {

			$name = "wednesday";

		}elseif ($day == 4) {

			$name = "thursday";

		}elseif ($day == 5) {

			$name = "friday";

		}elseif ($day == 6) {

			$name = "saturday";

		}elseif ($day == 7) {

			$name = "sunday";
		}

		return $name;
	}

	private function daycount($day, $startdate, $counter, $enddate)
	{

		$name = $this->findDay($day);

	    if($startdate >= $enddate)
	    {
	        return $counter;
	    }
	    else
	    {
	        return $this->daycount($name, strtotime("next ".$name, $startdate), ++$counter, strtotime($enddate));
	    }
	}

    //Get activities profitability
    //Route: activities_profitability
	public function activitiesProfitability(Request $request)
    {
        $response = array();
        $data = array();
        $c = 0;
        $count = 0;

        $inicial = date('Y-m-d', strtotime($request->inicial));
        $final = date('Y-m-d', strtotime($request->final));
        
        $date1 = new DateTime($request->inicial);
		$date2 = new DateTime($request->final);

        $activities = Activity::all();

        foreach ($activities as $activity) {
        	
        	$actbytutor = ActivityByTutor::where('activity_id', $activity->id)->first();
        	$classes    = Classes::where('activity_id', $activity->id)->get();
        	$tutor      = User::where('id', $actbytutor->user_id)->first();

        	foreach ($classes as $key) {

        		if ($key->start_date >= $inicial && $key->start_datel <= $final) {

        			$class_schedule = ClassDaySchedule::where('class_id', $key->id)->get();

        			foreach ($class_schedule as $cds) {

        				if ($cds->day_id == 8) {

        					$diff = $date2->diff($date1)->format("%a");

	        				$data[$c]['activity']        = $activity->name;
	        				$data[$c]['value']           = $cds->value;
	        				$data[$c]['number_inscribed']= $cds->inscribed;
	        				$data[$c]['tutor']           = $tutor->name.' '.$tutor->last_name;

	        				$data[$c]['tutor_prc_gain']  = $actbytutor->percentage_gain;
	        				$data[$c]['sub_total']       = $cds->value * $cds->inscribed * $diff;
	        				$data[$c]['costs']           = (($actbytutor->percentage_gain / 100) * $cds->value) * $diff;
	        				$data[$c]['total']           = $data[$c]['sub_total'] - $data[$c]['costs'];

        				}else{

        					$diff = $this->daycount($cds->day_id, strtotime($request->inicial), 0, strtotime($request->final));

	        				$data[$c]['activity']        = $activity->name;
	        				$data[$c]['value']           = $cds->value;
	        				$data[$c]['number_inscribed']= $cds->inscribed;
	        				$data[$c]['tutor']           = $tutor->name.' '.$tutor->last_name;

	        				$data[$c]['tutor_prc_gain']  = $actbytutor->percentage_gain;
	        				$data[$c]['sub_total']       = $cds->value * $cds->inscribed * $diff;
	        				$data[$c]['costs']           = (($actbytutor->percentage_gain / 100) * $cds->value) * $diff;
	        				$data[$c]['total']           = $data[$c]['sub_total'] - $data[$c]['costs'];
        				}

        				$c++;
        			}

        		}else{
        			$response[$count]['check'] = 'No';
        		}

        		$count++;
        	}
        }

	    header("Content-Type: application/json", true);
		echo json_encode($data);

    }


}
