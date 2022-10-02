<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $css=[
            'css/plugins/select2/select2.min.css','css/plugins/dataTables/datatables.min.css','css/plugins/chosen/bootstrap-chosen.css'
        ];
        $js=[
            'js/plugins/select2/select2.full.min.js','js/plugins/chosen/chosen.jquery.js','js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/plugins/ckeditor/ckeditor.js'
        ];
        $user_id=session()->get('id');
        $classrooms=Classroom::where('teacher_id',$user_id)->get();
        $venues=Venue::where('added_by',$user_id)->get();
        $classroom_ids=$classrooms->pluck('id')->toArray();
        $attendances=Attendance::whereIn('classroom_id',$classroom_ids)->with(['classroom','venue'])->get();
        return view('tutor.attendance.index',compact(['css','js','classrooms','venues','attendances']));
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
            'classroom'=>'required|exists:classrooms,id',
            'signin_start'=>'required|',
            'signin_end'=>'required|after:signin_start',
            'signout_start'=>'required|after:signin_end',
            'signout_end'=>'required|after:signout_start',
            'late'=>'required|integer',
            'attendance_date'=>'required|date_format:Y-m-d|after_or_equal:today',
            'venue'=>'required|exists:venues,id',
            'active'=>'required'
        ];
        //dd($request);
        $custom_messages=[
            'signin_end.after'=>'Signin End Time must be a time after Signin Start Time',
            'signout_start.after'=>'Signout Start Time must be a time after Signin End Time',
            'signout_end.after'=>'Signout End Time must be a time after Signout Start Time'
        ];
        $validator=Validator::make($request->all(), $rules, $custom_messages);
        if($validator->fails())
        {
            return back()->withErrors($validator->errors())->withInput();
        }
        else
        {
            try{
               $data=[
                   'classroom_id'=>$request->classroom,
                   'signin_start'=>$request->signin_start,
                   'signin_end'=>$request->signin_end,
                   'signout_start'=>$request->signout_start,
                   'signout_end'=>$request->signout_end,
                   'late_minute'=>$request->late,
                   'attendance_date'=>$request->attendance_date,
                   'venue_id'=>$request->venue,
                   'active'=>$request->active
               ];
               DB::enableQueryLog();
               $conflict=Attendance::where(['classroom_id'=>$request->classroom,'venue_id'=>$request->venue,'attendance_date'=>$request->attendance_date])
               ->where(function($q) use ($request){
                    $q->where(function($qa) use ($request){
                      $qa->where(function($qaa) use ($request){
                        $qaa->where('signin_start','<=',$request->signin_start)->where('signout_start','>=',$request->signin_start);
                      }
                     )->orWhere('signout_start','>=',$request->signout_start);})
                    ->orWhere(function($qb) use ($request){
                      $qb->where('signin_start','>',$request->signin_start)->where('signout_start','>',$request->signout_start);
                   });
               })->get();
               //dd(DB::getQueryLog());
               if($conflict->count()>=1)
               {
                return back()->withErrors('A time has already been set on '.$request->attendance_date.' for that that Classroom and Venue')->withInput();
               }

               Attendance::create($data);
               return redirect()->back()->with('success','Attendance Event Set successfully');
            }
            catch(\Exception $e)
            {
                return back()->withErrors($e->getMessage())->withInput();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        $css=[
            'css/plugins/chosen/bootstrap-chosen.css'
        ];
        $js=[
           'js/plugins/chosen/chosen.jquery.js'
        ];
        $user_id=session()->get('id');
        $classrooms=Classroom::where('teacher_id',$user_id)->get();
        $venues=Venue::where('added_by',$user_id)->get();
        return view('tutor.attendance.edit',compact(['attendance','css','js','classrooms','venues']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        $rules=[
            'classroom'=>'required|exists:classrooms,id',
            'signin_start'=>'required',
            'signin_end'=>'required|after:signin_start',
            'signout_start'=>'required|after:signin_end',
            'signout_end'=>'required|after:signout_start',
            'late'=>'required|integer',
            'attendance_date'=>'required|date_format:Y-m-d|after_or_equal:today',
            'venue'=>'required|exists:venues,id',
            'active'=>'required'
        ];
        //dd($request);
        $custom_messages=[
            'signin_end.after'=>'Signin End Time must be a time after Signin Start Time',
            'signout_start.after'=>'Signout Start Time must be a time after Signin End Time',
            'signout_end.after'=>'Signout End Time must be a time after Signout Start Time'
        ];
        $validator=Validator::make($request->all(), $rules, $custom_messages);
        if($validator->fails())
        {
            return back()->withErrors($validator->errors())->withInput();
        }
        else
        {
            try{
               $data=[
                   'classroom_id'=>$request->classroom,
                   'signin_start'=>$request->signin_start,
                   'signin_end'=>$request->signin_end,
                   'signout_start'=>$request->signout_start,
                   'signout_end'=>$request->signout_end,
                   'late_minute'=>$request->late,
                   'attendance_date'=>$request->attendance_date,
                   'venue_id'=>$request->venue,
                   'active'=>$request->active
               ];
               DB::enableQueryLog();
               /*$conflict=Attendance::where(['classroom_id'=>$request->classroom,'venue_id'=>$request->venue,'attendance_date'=>$request->attendance_date])
               ->where(function($q) use ($request){
                    $q->where(function($qa) use ($request){
                      $qa->where(function($qaa) use ($request){
                        $qaa->where('signin_start','<=',$request->signin_start)->where('signout_start','>=',$request->signin_start);
                      }
                      )->orWhere(function($qab) use ($request){
                        $qab->where('signout_start','>=',$request->signout_start)->where('signin_start','<=',$request->signin_start);
                      });
                    })->orWhere(function($qb) use ($request){
                      $qb->where('signin_start','>',$request->signin_start)->where('signout_start','>',$request->signout_start);
                   });
               })->whereNotIn('id',[$attendance->id])->get();
               //dd(DB::getQueryLog());
               dd($conflict);
               if($conflict->count()>=1)
               {
                return back()->withErrors('A time has already been set on '.$request->attendance_date.' for that that Classroom and Venue')->withInput();
               }*/

               $attendance->update($data);
               return redirect()->back()->with('success','Attendance Event Updated successfully');
            }
            catch(\Exception $e)
            {
                return back()->withErrors($e->getMessage())->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
