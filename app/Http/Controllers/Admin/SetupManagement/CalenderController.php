<?php

namespace App\Http\Controllers\Admin\SetupManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\hotelManagement\Calender;
class CalenderController extends Controller
{
    public function index()
    {
        $calendar = Calender::orderBy('id', 'ASC')->get();
        $dayTypes =  DB::table('calender_tbl')->select('day_type')->groupBy('day_type')->get();
        return view('admin.calender.view-calendar', ['calender' => $calendar, 'dayTypes' => $dayTypes]);
    }
  
    public function getcalendar()
    {

        $button = '';
        $Calendar = Calender::orderby('id', 'asc')->get();

        // $output ="<td> hello </td> <td> hello </td> <td> hello </td>";
        // return $output;

        $output = array('data' => array());

        $i = 1;

        foreach ($Calendar as $calendar) {

            $button = '<td style="width: 12%;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                                    <li class="action" onclick="editHolyday(' . $calendar->id . '); calls(\'' . $calendar->date . '\');"  ><a  class="btn" ><i class="fas fa-edit"></i> Edit </a></li>
                                </ul>
                            </div>
                        </td>';

            if ($calendar->day_type == "Offday" || $calendar->day_type == "Holiday") {
                $date = ' <td style="background: green;" >  ' . $calendar->date . ' </td>';
            } else {
                $date = ' <td >  ' . $calendar->date . ' </td>';
            }

            $output['data'][] = array(

                $i++ . '<input type="hidden" name="id" id="id" value="' . $calendar->id . '" />',

                $date,

                '<b>Day Name: </b>' . $calendar->day_name,

                $calendar->day_type,
                $button,

            );
        }

        return $output;
    }


    public function createcalendarForm(Request $request)
    {
        return view('admin.calender.create-calendar');
    }
   
    public function createcalendarStore(Request $request)
    {
        $holiDay = array(
            array("date" => '02-21', "Cause" => "International Mother Language Day"),
            array("date" => '03-26', "Cause" => "Independence Day"),
            array("date" => '05-01', "Cause" => "Labor Day"),
            array("date" => '12-16', "Cause" => "Victory Day"),
            array("date" => '12-25', "Cause" => "Christmas Day")
        );

        if ($request->type == 'add') {
            $findYear = Calender::where('date', 'like', '%' . $request->addyear . '%')->first();

            if ($findYear != '') {
                return response()->json(['message' => 'Year already exist!']);
            }

            DB::beginTransaction();
            try {
                $date = $request->addyear . "-01-01";
                $end_date = $request->addyear . "-12-31";
                while (strtotime($date) <= strtotime($end_date)) {
                    $datename = date('D', strtotime($date));
                    $Calendar = new Calender();
                    $Calendar->date          = $date;
                    $Calendar->day_name      = $datename;
                    $Calendar->day_type      = 'Onday';
                    $Calendar->offday_cause  = '';
                    $Calendar->save();
                    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                }
                DB::commit();
                return response()->json(['Success']);
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['error' => $e->getMessage()]);
            }
        }
        if ($request->type == 'offday') {
            $off_year = $request->off_year;
            $off_day = $request->off_day;
            Calender::where('day_name', $off_day)->where('date', 'LIKE', '%' . $off_year . '%')->update(['day_type' => 'Offday']);
            return response()->json(['Success']);
        }
        if ($request->type == 'holiday') {

            $holiday_date = $request->holidayDate;
            $holiday_Cause = $request->holidayCause;
            Calender::where('date', $holiday_date)->update(['day_type' => 'Holiday', 'offday_cause' => $holiday_Cause]);
            return response()->json(['Success']);
        }
    }
    public function update(Request $request)
    {

        DB::beginTransaction();

        try {
            $id = $request->id;
            $edit_type = $request->edit_type;
            $edit_cause = $request->edit_cause;
            Calender::where('id', $id)->update(['day_type' =>   $edit_type, 'offday_cause' => $edit_cause]);
          
            DB::commit();
            return response()->json(['Success']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
