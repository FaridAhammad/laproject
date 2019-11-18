<?php

namespace App\Http\Controllers\Admin\administrator;

use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\User_activity_management;
use App\model\User_type;

class UsermanageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $update = false;



        $uams=User_activity_management::all();
        $user_types= User_type::all()->pluck('user_type_name_show', 'user_level');

        return view('admin.administrator.userManage', ['id'=>'','fname'=>'','user_name'=>'','email'=>'','user_ty'=>'','password'=>'', 'update'=>$update], compact('uams','user_types'));

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
        abort_unless(\Gate::allows('user_create'), 403);

        $validator=Validator::make($request->all(), [

            ]);

        if($validator->fails()){

            redirect()->back()->withErrors($validator)->exceptInput();
        }
        $user_activity_management = User_activity_management::create($request->all());

        return redirect()->route('admin.usermanage.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        abort_unless(\Gate::allows('user_edit'), 403);
        $uams=User_activity_management::all();

//        $uam=User_activity_management::select('user_id', 'fname', 'username', 'email', 'level')->find($user_id);



        $user_types= User_type::all()->pluck('user_type_name_show', 'user_level');

        $uam = User_activity_management::select('user_id', 'fname', 'username', 'email', 'level', 'password')->where('user_id', $user_id)->first();


                $id=$uam->user_id;
                $fname=$uam->fname;
                $user_name=$uam->username;
                $email=$uam->email;
                $password= $uam->password;
                $user_ty=$uam->level;

        $update = true;












        return view('admin.administrator.userManage', ['id'=>$id,'fname'=>$fname,'user_name'=>$user_name, 'email'=>$email,'user_ty'=>$user_ty,'password'=>$password, 'update'=>$update, 'uam'], compact('uams', 'user_types' ));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {



        $uama = User_activity_management::where('user_id', $id);



        $uama->update([

                'fname'=>$request->input('fname'),
                'username'=>$request->input('username'),
                 'email'=>$request->input('email'),
                'password'=>$request->input('password'),
                'level'=>$request->input('level'),

        ]);
        $update=false;
        return redirect()->route('admin.usermanage.index');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User_activity_management::where('user_id', $id);

        $user->delete();
        return redirect()->route('admin.usermanage.index');


    }
}
