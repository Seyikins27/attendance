<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\ClassroomStudent;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id=$user_id=session()->get('id');
        $student_id=session()->get('student_id');
        $classrooms=ClassroomStudent::where('student_id',$user_id)->get();
        $classroom_ids=$classrooms->pluck('classroom_id')->toArray();
        $active_attendance=Attendance::where(['attendance_date'=>date('Y-m-d'),'active'=>1])->whereIn('classroom_id',$classroom_ids)->count();
        return view('student.dashboard',compact(['student_id','classrooms','active_attendance']));
    }

    function enrol_in_class()
    {
        $css=[
            'css/plugins/select2/select2.min.css','css/plugins/dataTables/datatables.min.css','css/plugins/chosen/bootstrap-chosen.css'
        ];
        $js=[
            'js/plugins/select2/select2.full.min.js','js/plugins/chosen/chosen.jquery.js','js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/student.js'
        ];
       $user_id=$user_id=session()->get('id');
       $student_id=session()->get('student_id');
       $classrooms=ClassroomStudent::where('student_id',$user_id)->with('classroom')->get();
       return view('student.classroom.enrol',compact(['css','js','student_id','classrooms']));
    }

    function drop_enrolment(Request $request)
    {
        $rules=[
            'classroom'=>'required|exists:classrooms,id',
            'student'=>'required|exists:students,id'
        ];
        //dd($request);
        $custom_messages=[
            'classroom.exists'=>'Classroom is Invalid',
            'student.exists'=>'Invalid Student ID',
        ];
        $validator=Validator::make($request->all(), $rules, $custom_messages);
        if($validator->fails())
        {
            return [
                'status'=>false,
                'message'=>$validator->errors()->all()
               ];
        }
        else
        {
            try{
                $data=[
                    'student_id'=>$request->student,
                    'classroom_id'=>$request->classroom,
                ];
               $classroom_student=ClassroomStudent::where($data);
               if($classroom_student !=null)
               {
                    $classroom_student->delete();
                    return [
                        'status'=>true,
                        'message'=>'Dropped Enrolment Successfully'
                    ];
               }
               else{
                    return [
                        'status'=>false,
                        'message'=>'Attempt to Drop Enrolment was not Successful'
                    ];
               }

            }
            catch(\Exception $e)
            {
                return [
                    'status'=>false,
                    'message'=>'Enrolment Drop not Successful because '.$e->getMessage()
                   ];
            }
        }
    }

    function enrol(Request $request)
    {
        $rules=[
            'classroom'=>'required|exists:classrooms,id',
            'student'=>'required|exists:students,id|unique:classroom_students,student_id,NULL,id,classroom_id,'.$request->classroom
        ];
        //dd($request);
        $custom_messages=[
            'classroom.exists'=>'Classroom is Invalid',
            'student.exists'=>'Invalid Student ID',
            'student.unique'=>'You are already enrolled in this classroom'
        ];
        $validator=Validator::make($request->all(), $rules, $custom_messages);
        if($validator->fails())
        {
            return [
                'status'=>false,
                'message'=>$validator->errors()->all()
               ];
        }
        else
        {
            try{
                $data=[
                    'student_id'=>$request->student,
                    'classroom_id'=>$request->classroom,
                    'active'=>1
                ];
               ClassroomStudent::create($data);
               return [
                'status'=>true,
                'message'=>'Enrolment Successful'
               ];
            }
            catch(\Exception $e)
            {
                return [
                    'status'=>false,
                    'message'=>'Enrolment not Successful because '.$e->getMessage()
                   ];
            }
        }
    }

    function active_attendance()
    {
        $css=[
            'css/plugins/select2/select2.min.css','css/plugins/dataTables/datatables.min.css','css/plugins/chosen/bootstrap-chosen.css','css/webcam.css'
        ];
        $js=[
            'js/plugins/select2/select2.full.min.js','js/plugins/chosen/chosen.jquery.js','js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/student.js','js/fence.js'
        ];
        $user_id=$user_id=session()->get('id');
        $student_id=session()->get('student_id');
        $classrooms=ClassroomStudent::where('student_id',$user_id)->get();
        $classroom_ids=$classrooms->pluck('classroom_id')->toArray();
        //dd($classroom_ids);
        //DB::enableQueryLog();
        $active_attendances=Attendance::where(['attendance_date'=>date('Y-m-d'),'active'=>1])->whereIn('classroom_id',$classroom_ids)->with(['classroom','venue'])->get();
        //dd(DB::getQueryLog());
        return view('student.attendance.active',compact(['css','js','active_attendances']));
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
