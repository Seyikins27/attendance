<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $css=[
            'css/plugins/dataTables/datatables.min.css','css/plugins/chosen/bootstrap-chosen.css'
        ];
        $js=[
           'js/plugins/chosen/chosen.jquery.js','js/plugins/dataTables/datatables.min.js','js/plugins/dataTables/dataTables.bootstrap4.min.js','js/fence.js'
        ];
        $user_id=session()->get('id');
        $venues=Venue::where('added_by',$user_id)->get();
        return view('tutor.venue.index',compact(['css','js','venues']));
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
            'longitude'=>'required',
            'latitude'=>'required',
            'max_distance'=>'required',
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
               $teacher_id=session()->get('id');
               $data=[
                   'name'=>$request->name,
                   'longitude'=>$request->longitude,
                   'latitude'=>$request->latitude,
                   'max_distance'=>$request->max_distance,
                   'added_by'=>$teacher_id
               ];
               Venue::create($data);
               return redirect()->back()->with('success','Venue added successfully');
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
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function show(Venue $venue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function edit(Venue $venue)
    {
        $js=[
            'js/fence.js'
        ];
        return view('tutor.venue.edit', compact('venue','js'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venue $venue)
    {
        $rules=[
            'name'=>'required',
            'longitude'=>'required',
            'latitude'=>'required',
            'max_distance'=>'required',
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
                   'longitude'=>$request->longitude,
                   'latitude'=>$request->latitude,
                   'max_distance'=>$request->max_distance,
               ];
               $venue->update($data);
               return redirect()->back()->with('success','Venue updated successfully');
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
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venue $venue)
    {
        //
    }
}
