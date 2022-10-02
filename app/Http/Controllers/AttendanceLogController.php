<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\ClassroomStudent;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ballen\Distical\Calculator as DistanceCalculator;
use Ballen\Distical\Entities\LatLong;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Storage;

class AttendanceLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            'attendance'=>'required|exists:attendances,id',
            'student'=>'required|exists:students,id',
            'longitude'=>'required',
            'latitude'=>'required'
        ];
        //dd($request);
        $custom_messages=[
            'attendance.exists'=>'Invalid Attendance Event',
            'student.exists'=>'Student is non existent'
        ];
        $validator=Validator::make($request->all(), $rules, $custom_messages);
        if($validator->fails())
        {
            //return back()->withErrors($validator->errors());
            return [
                'status'=>false,
                'message'=>$validator->errors()->all()
            ];
        }
        else
        {
            try{
               $attendance_exists=AttendanceLog::where(['attendance_id'=>$request->attendance,'student_id'=>$request->student])->first();
               if($attendance_exists!=null && $attendance_exists->count()>=1)
               {
                return [
                    'status'=>false,
                    'message'=>'You have previously signed in for this event'
                ];
               }
               $attendance=Attendance::where('id',$request->attendance)->with('venue')->first();
               $current_time=date('H:i:s');
               if($attendance !=null && $attendance->active==1)
               {
                    if(strtotime($current_time)>(strtotime($attendance->signin_end)+($attendance->late_minute*60)))
                    {
                        return [
                            'status'=>false,
                            'message'=>'Signin for this attendance event is over'
                        ];
                    }
                    elseif($current_time<$attendance->signin_start){
                        return [
                            'status'=>false,
                            'message'=>'Signin for this attendance event has not started'
                        ];
                    }
                    else
                    {
                       $diff=$this->calculate_coord_diff($attendance->venue->latitude,$attendance->venue->longitude, $request->latitude, $request->longitude);
                       if($diff>$attendance->venue->max_distance)
                       {
                        return [
                            'status'=>false,
                            'message'=>'You are not within the geographical range of the attendance venue, You are '.$diff.'m away from the venue'
                        ];
                       }
                       else
                       {
                         return [
                            'status'=>true,
                            'popup'=>true,
                            'message'=>view('student.attendance.webcam')->render()
                         ];
                       }
                    }
               }
               else
               {
                    return [
                        'status'=>false,
                        'message'=>'Invalid Attendance'
                    ];
               }
            }
            catch(\Exception $e)
            {
                return [
                    'status'=>false,
                    'message'=>$e->getMessage()
                ];
            }
        }
    }

    function verify_face(Request $request)
    {
        //dd($request);
        $student_id=session()->get('id');
        $attendance=$request->attendance;
        $student_details=Student::where('id',$student_id)->first();
        $picture_stream=$request->picture_stream;
        $url = 'http://127.0.0.1:5000/face/capture';
        $data = [];
        $data['capture_stream'] = $picture_stream;
        $data['file_path'] = str_replace('\\','/',public_path($student_details->facial_data));
        //dd($data);
        $response = Http::post($url, $data);
        $body=(object)$response->json();

        try{
            if ($body->status === true) {

                $data=[
                    'attendance_id'=>$attendance,
                    'student_id'=>$student_id,
                    'time_in'=>date("H:i:s"),
                    'time_out'=>null,
                    'date_in'=>date('Y-m-d'),
                    'date_out'=>null
                  ];

                  AttendanceLog::create($data);
                  return [
                    'status'=>true,
                    'message'=>'Signed in successfully'
                ];
            }
            else{
                return [
                    'status'=>false,
                    'message'=>$body->message
                ];
            }
        }
        catch(\Exception $e)
        {
            return [
                'status'=>false,
                'message'=>$e->getMessage()
            ];
        }
    }

    function signout(Request $request)
    {
        $rules=[
            'attendance'=>'required|exists:attendances,id',
            'student'=>'required|exists:students,id',
            'longitude'=>'required',
            'latitude'=>'required'
        ];
        //dd($request);
        $custom_messages=[
            'attendance.exists'=>'Invalid Attendance Event',
            'student.exists'=>'Student is non existent'
        ];
        $validator=Validator::make($request->all(), $rules, $custom_messages);
        if($validator->fails())
        {
            //return back()->withErrors($validator->errors());
            return [
                'status'=>false,
                'message'=>$validator->errors()->all()
            ];
        }
        else
        {
            try{
               $attendance_exists=AttendanceLog::where(['attendance_id'=>$request->attendance,'student_id'=>$request->student])->first();
               if($attendance_exists!=null && $attendance_exists->time_out!=null)
               {
                return [
                    'status'=>false,
                    'message'=>'You have already signed out of this event'
                ];
               }

               $attendance=Attendance::where('id',$request->attendance)->with('venue')->first();
               $current_time=date('H:i:s');
               if($attendance !=null && $attendance->active==1)
               {
                    if($current_time>$attendance->signout_end)
                    {
                        return [
                            'status'=>false,
                            'message'=>'Signout for this attendance event is over'
                        ];
                    }
                    elseif($current_time<$attendance->signout_start){
                        return [
                            'status'=>false,
                            'message'=>'Signout for this attendance event has not started'
                        ];
                    }
                    else
                    {
                      /* $set_location=new LatLong($attendance->venue->latitude,$attendance->venue->longitude);
                       $current_location=new LatLong($request->latitude, $request->longitude);
                       $distanceCalculator = new DistanceCalculator($set_location, $current_location);

                        // You can then compute the distance...
                        $distance = $distanceCalculator->get();

                        return [
                            'status'=>false,
                            'message'=>'Distance in Meters is '.$distance->asKilometres()
                        ];*/

                       $diff=$this->calculate_coord_diff($attendance->venue->latitude,$attendance->venue->longitude, $request->latitude, $request->longitude);
                       if($diff>$attendance->venue->max_distance)
                       {
                        return [
                            'status'=>false,
                            'message'=>'You are not within the geographical range of the attendance venue, You are '.$diff.'m away from the venue'
                        ];
                       }
                       else
                       {

                        if($attendance_exists==null)
                        {
                            $data=[
                                'attendance_id'=>$attendance->id,
                                'student_id'=>$request->student,
                                'time_in'=>null,
                                'time_out'=>date("H:i:s"),
                                'date_in'=>null,
                                'date_out'=>date('Y-m-d')
                              ];

                              AttendanceLog::create($data);
                        }
                        else{
                            $data=[
                                'time_out'=>$current_time,
                                'date_out'=>date('Y-m-d')
                              ];

                              $attendance_exists->update($data);
                        }
                          return [
                            'status'=>true,
                            'message'=>'Signout successful'
                        ];
                       }
                    }
               }
               else
               {
                    return [
                        'status'=>false,
                        'message'=>'Invalid Attendance'
                    ];
               }
            }
            catch(\Exception $e)
            {
                return [
                    'status'=>false,
                    'message'=>$e->getMessage()
                ];
            }
        }
    }

    function calculate_coord_diff($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return round($miles *1609.34);
    }

    function student_log($classroom=null)
    {
        if(session()->get('student_authenticated')==true)
        {
            $css=[
                'css/plugins/dataTables/datatables.min.css'
            ];
            $js=[
                'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/student.js','js/fence.js'
            ];
            $student_id=session()->get('id');
            $attendance_logs=[];
            if($classroom!=null)
            {
                $classroom=Classroom::find($classroom);
                //dd($classroom);
                $attendances=Attendance::where('classroom_id',$classroom->id)->get();
                $attendance_ids=$attendances->pluck('id')->toArray();
                //dd($attendance_ids);
                $attendance_logs=AttendanceLog::where('student_id',$student_id)->whereIn('attendance_id',$attendance_ids)->orderBy('attendance_id')->orderBy('created_at')->get();
            }
            else
            {
                $attendance_logs=AttendanceLog::where('student_id',$student_id)->orderBy('attendance_id')->orderBy('created_at')->get();
            }
            return view('student.attendance.log',compact(['css','js','attendance_logs']));
        }
    }

    function tutor_log($class_id)
    {
        if(session()->get('tutor_authenticated')==true)
        {
            $css=[
                'css/plugins/dataTables/datatables.min.css'
            ];
            $js=[
                'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/student.js'
            ];
            $tutor_id=session()->get('id');
            $attendance_logs=[];
            $classroom=Classroom::where(['id'=>$class_id,'teacher_id'=>$tutor_id])->first();
            if($classroom==null)
            {
                return back()->withErrors('Invalid Classroom Selected');
            }
            $students=ClassroomStudent::where('classroom_id',$class_id)->get();
            $attendances=Attendance::where('classroom_id',$classroom->id)->with('venue')->get();
            $attendance_ids=$attendances->pluck('id')->toArray();
            $attendance_dates=$attendances->pluck('attendance_date');
            $signin_starts=$attendances->pluck('signin_start');
            $signout_ends=$attendances->pluck('signout_end');
            $attendance_logs=AttendanceLog::whereIn('attendance_id',$attendance_ids)->with(['student','attendance'])->orderBy('attendance_id')->orderBy('created_at')->get();
            return view('tutor.attendance.log',compact(['css','js','classroom','students','attendances','signin_starts','signout_ends','attendance_logs']));
        }
    }

    public function by_event(Request $request)
    {
       $attendance_event=$request->attendance;
       if($attendance_event!=null)
       {
            $attendance_logs=AttendanceLog::where('attendance_id',$attendance_event);
            $css=[
                'css/plugins/dataTables/datatables.min.css'
                ];
            $js=[
                'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/student.js','js/fence.js'
            ];
            return view();
       }
       else
       {
         return back()->withErrors('Invalid Attendance Event');
       }
    }

    public function student_attendance($classroom_id, $student_id)
    {
        $css=[
            'css/plugins/dataTables/datatables.min.css'
        ];
        $js=[
            'js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js'
        ];
        $classroom=Classroom::where('id',$classroom_id)->first();
        $classroom_attendances=Attendance::where('classroom_id',$classroom_id)->get();
        $attendance_ids=$classroom_attendances->pluck('id')->toArray();
        $student_details=Student::where('id',$student_id)->first();
        $attendance_logs=AttendanceLog::whereIn('attendance_id',$attendance_ids)->where('student_id',$student_id)->with(['attendance','attendance.venue','student'])->get();
        return view('tutor.attendance.student_log',compact(['css','js','classroom','classroom_attendances','student_details','attendance_logs']));
    }

    public function show(Attendance_log $attendance_log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance_log  $attendance_log
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance_log $attendance_log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance_log  $attendance_log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance_log $attendance_log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance_log  $attendance_log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance_log $attendance_log)
    {
        //
    }
}
