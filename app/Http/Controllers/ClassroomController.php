<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ClassroomController extends Controller
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
        return view('tutor.classroom.index',compact(['css','js','classrooms']));
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
            'name'=>'required',
            'description'=>'required',
            'active'=>'required'
        ];
        //dd($request);
        $custom_messages=[
        ];
        $validator=Validator::make($request->all(), $rules, $custom_messages);
        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        else
        {
            try{
               $code= Str::random(5);
               $teacher_id=session()->get('id');
               $data=[
                   'name'=>$request->name,
                   'code'=>$code,
                   'description'=>$request->description,
                   'teacher_id'=>$teacher_id,
                   'active'=>$request->active
               ];
               Classroom::create($data);
               return redirect()->back()->with('success','classroom added successfully');
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
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {

    }

    public function get_by_code(Request $request)
    {
      if(isset($request->classroom_code) && $request->classroom_code !=null)
      {
         $classroom=Classroom::where('code',$request->classroom_code)->where('active',1)->with('teacher')->first();
         if($classroom!=null)
         {
            return [
                'status'=>true,
                'message'=>view('student.classroom.details',compact('classroom'))->render()
            ];
         }
      }
      return [
        'status'=>false,
        'message'=>'Resource is invalid'
      ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom)
    {

        $js=[
           'js/plugins/ckeditor/ckeditor.js'
        ];
        return view('tutor.classroom.edit', compact('js','classroom'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classroom $classroom)
    {
        $rules=[
            'name'=>'required',
            'description'=>'required',
            'active'=>'required'
        ];
        //dd($request);
        $custom_messages=[
        ];
        $validator=Validator::make($request->all(), $rules, $custom_messages);
        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        else
        {
            try{
               $data=[
                   'name'=>$request->name,
                   'description'=>$request->description,
                   'active'=>$request->active
               ];
               $classroom->update($data);
               return redirect()->back()->with('success','classroom updated successfully');
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
     * @param  \App\Models\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom)
    {
        //
    }
}
