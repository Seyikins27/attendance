<?php

namespace App\Http\Controllers;

use App\Models\ClassroomStudent;
use Illuminate\Http\Request;

class ClassroomStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class)
    {
        $css=[
            'css/plugins/select2/select2.min.css','css/plugins/dataTables/datatables.min.css','css/plugins/chosen/bootstrap-chosen.css'
        ];
        $js=[
            'js/plugins/select2/select2.full.min.js','js/plugins/chosen/chosen.jquery.js','js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/plugins/ckeditor/ckeditor.js'
        ];
        $tutor_id=session()->get('id');
        $students=ClassroomStudent::where(['classroom_id'=>$class])->with('classroom')->get();
        //dd($students->first());
        $classroom=$students->first();
        return view('tutor.classroom.students',compact(['css','js','students','classroom']));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classroom_student  $classroom_student
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom_student $classroom_student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classroom_student  $classroom_student
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom_student $classroom_student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classroom_student  $classroom_student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classroom_student $classroom_student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classroom_student  $classroom_student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom_student $classroom_student)
    {
        //
    }
}
