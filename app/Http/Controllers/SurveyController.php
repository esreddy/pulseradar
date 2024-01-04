<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Survey;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SurveyController extends Controller
{



    function viewSurveys()
    {

        //$records = Employee::with('role')->paginate(4);
        //$records = Survey::with(['role', 'parent'])->paginate(4);
        $records = Survey::paginate(4);
        //$records = Survey::whereIn('status', ['1', '2', '4'])->paginate(2);

        return view('surveys',compact('records'));
    }

    public function surveyAdd()
    {
        $data = array();
        if(Session::has('loginId'))
        {
            $data = Employee::where('id','=', Session::get('loginId'))->first();
        }
        // Fetching states from the database using the State model
        $states = State::pluck('name', 'id'); // Assuming 'name' is the column with state names

        return view('survey-add')->with('states', $states);

        //return view('survey-add',compact('data'));
    }

    public function updateStatus($id)
    {
        // Retrieve the record from the database
        $record = Survey::find($id);

        if ($record)
        {
            // Update the status (modify this logic according to your requirements)
            if($record->status == 4)
            {
                $record->status = 1;
            }elseif($record->status == 1){
                $record->status = 4;
            }
            $record->save();

            return back();
        }
    }
    public function updateStatus2($id)
    {
        // Retrieve the record from the database
        $record = Survey::find($id);

        if ($record)
        {
            $record->status = 0;
            $record->save();

            return back();
        }
    }
}
