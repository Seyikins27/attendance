<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;
use App\Models\Student;
use File;

class IndexController extends Controller
{
    //
    public function tutor()
    {
        if(session()->get('tutor_authenticated')==true)
        {
            return redirect()->route('tutor-dashboard');
        }
        else{
            return redirect()->route('tutor-login');
        }
    }

    public function student()
    {
        if(session()->get('student_authenticated')==true)
        {
            return redirect()->route('student-dashboard');
        }
        else{
            return redirect()->route('student-login');
        }
    }

    public function tutor_register(Request $request)
    {
        $rules=[
            'email'=>'required|email|unique:teachers,email',
            'name'=>'required|min:3',
            'title'=>'required',
            'password'=>'required|confirmed|min:8',
            'password_confirmation'=>'required_with:password|min:8',
        ];
        $custom_messages=[
            'email.email'=>'Email field must contain a valid email address',
            'email.unique'=>'Tutor with Email already exists',
            'password.confirmed'=>'Password and Confirm password must be the same'
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
                    'fullname'=>$request->name,
                    'title'=>$request->title,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password_confirmation),
                    'active'=>1
                ];
                $created_teacher=Teacher::create($data);
                return redirect()->route('tutor-login')->with('success','Account created successfully');
            }
            catch(\Exception $e)
            {
                return back()->withErrors($e->getMessage());
            }
        }
    }

    public function student_register(Request $request)
    {
        $rules=[
            'idno'=>'required',
            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'required|email|unique:teachers,email',
            'password'=>'required|confirmed|min:8',
            'password_confirmation'=>'required_with:password|min:8',
            'captured_pic'=>'required'
        ];
        $custom_messages=[
            'idno.required'=>'Your Student ID Number is required',
            'email.email'=>'Email field must contain a valid email address',
            'email.unique'=>'Tutor with Email already exists',
            'password.confirmed'=>'Password and Confirm password must be the same',
            'captured_pic.required'=>'Your face has not been captured'
        ];

        $validator=Validator::make($request->all(), $rules, $custom_messages);
        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        else
        {
            try{
                $captured_pic=$this->base64_to_image($request->idno,$request->captured_pic);
                $data=[
                    'idno'=>$request->idno,
                    'firstname'=>$request->firstname,
                    'lastname'=>$request->lastname,
                    'middlename'=>$request->middlename,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password_confirmation),
                    'facial_data'=>$captured_pic,
                    'active'=>1
                ];
                Student::create($data);
                return redirect()->route('student-login')->with('success','Account created successfully');
            }
            catch(\Exception $e)
            {
                return back()->withErrors($e->getMessage());
            }
        }

    }

    public function tutor_auth(Request $request)
    {
        $rules=[
            'email'=>'required|email',
            'password'=>'required',
        ];

        $custom_messages=[
            'email.required'=>'Your email is required',
            'email.email'=>'Email field must contain a valid email address',
            'password.required'=>'Your password is required'
        ];

        $validator=Validator::make($request->all(), $rules, $custom_messages);
        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        else
        {
            $email=$request->email;
            $password= $request->password;
            $user=Teacher::where('email',$email)->first();
            if($user)
            {
                if(Hash::check($password, $user->password)){
                    if($user->active!=1)
                    {
                        return redirect('tutor-login')->with('error','User has not been activated');
                    }
                    else{
                        //dd($user);
                         $request->session()->put('id', $user->id);
                         $request->session()->put('username',$user->_fullname());
                         $request->session()->put('isAuthenticated',true);
                         $request->session()->put('tutor_authenticated',true);
                        return redirect()->route('tutor-index');
                    }
                }
                else
                {
                    return redirect()->route('tutor-login')->with('error','Email and Password mismatch');
                }

            }
            else
            {
                return redirect()->route('tutor-login')->with('error','User does not exist');
            }
        }

    }

    public function base64_to_image($path_name,$base64_string)
    {
        try{
            $path_name=str_replace(' ','',$path_name);
            $img = $base64_string;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file_path = "images/".$path_name;
            $path = public_path($file_path);
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }
            $image_name=uniqid().".png";
            //$image_path="images/".$image_name.'.png';
            $image_path=$path."/".$image_name;
            //$file->move(public_path($file_path),$fileName);
            file_put_contents($image_path, $data);
            return $file_path."/".$image_name;
        }
        catch(\Exception $e){
            return "Could not correctly capture image because ".$e->getMessage();
        }

    }

    public function student_auth(Request $request)
    {
        $rules=[
            'email'=>'required|email',
            'password'=>'required',
        ];

        $custom_messages=[
            'email.required'=>'Your email is required',
            'email.email'=>'Email field must contain a valid email address',
            'password.required'=>'Your password is required'
        ];

        $validator=Validator::make($request->all(), $rules, $custom_messages);
        if($validator->fails())
        {
            return back()->withErrors($validator->errors());
        }
        else
        {
            $email=$request->email;
            $password= $request->password;
            $user=Student::where('email',$email)->first();
            if($user)
            {
                if(Hash::check($password, $user->password)){
                    if($user->active!=1)
                    {
                        return redirect('student-login')->with('error','Student User has not been activated');
                    }
                    else{
                        //dd($user);
                         $request->session()->put('id', $user->id);
                         $request->session()->put('username',$user->_fullname());
                         $request->session()->put('student_id',$user->idno);
                         $request->session()->put('isAuthenticated',true);
                         $request->session()->put('student_authenticated',true);
                        return redirect()->route('student-index');
                    }
                }
                else
                {
                    return redirect()->route('student-login')->with('error','Email and Password mismatch');
                }

            }
            else
            {
                return redirect()->route('student-login')->with('error','Student User does not exist');
            }
        }

    }

    public function logout()
    {
        if(session()->has('tutor_authenticated') && session()->get('tutor_authenticated')==true)
        {
            session()->invalidate();
            return redirect()->route('tutor-index')->with('success','Logged out');
        }
        else if(session()->has('student_authenticated') && session()->get('student_authenticated')==true)
        {
            session()->invalidate();
            return redirect()->route('student-index')->with('success','Logged out');
        }
    }
}
