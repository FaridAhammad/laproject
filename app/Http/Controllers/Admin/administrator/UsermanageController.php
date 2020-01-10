<?php

namespace App\Http\Controllers\Admin\administrator;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\User_type;
use Illuminate\Support\Facades\Crypt;
use App\User;
use Auth;
use DB;

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

        
        
        $uams = DB::table('users')
        ->join('user_type', 'users.level', '=', 'user_type.user_level')
        ->select('users.*', 'user_type.*')->get();
        
        

        $user_types = User_type::all()->pluck('user_type_name_show', 'user_level');

        return view('admin.administrator.userManage', ['id'=>'','fname'=>'','user_name'=>'','email'=>'','user_ty'=>'','password'=>'', 'designation'=>'', 'mobile'=>'', 'update'=>$update], compact('uams','user_types'));

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
        
        $request->validate([
        'full_name' => 'required',
        'username' => ['required', 'string', 'max:255', 
        Rule::unique('users')->where (function ($query) use ($request) {
            return $query->where('status', 0);
        })],
        'email' => '',
        'password' => ['required', 'string', 'min:4'],
        'user_types' => 'required',
        'designation' => '',
        'mobile' => '',
        'pass_word'=> ''
        ]);
        
        if ($request->input('user_types') != '---Select One----') {

            $time = Carbon::now()->setTimezone('Asia/Dhaka');
            $data = $request->input('password');
            
            
            
            User::create([
                'fname' => $request->input('full_name'),
                'username'=> $request->input('username'),
                'email' => $request->input('email'),
                'password' => Hash::make($data),
                'level' => $request->input('user_types'),
                'designation'=> $request->input('designation'),
                'mobile'=> $request->input('mobile'),
                'warehouse_id' => Auth::user()->warehouse_id,
                'status' => 0,
                'entry_by' => Auth::user()->user_id,
                'entry_at' => $time,
                ]);
         }
        


       

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
        
        $uams=User::all();

//        $uam=User::select('user_id', 'fname', 'username', 'email', 'level')->find($user_id);



        $user_types = User_type::all()->pluck('user_type_name_show', 'user_level');

        $uam = User::select('user_id', 'fname', 'username', 'email', 'level', 'password', 'designation', 'mobile')->where('user_id', $user_id)->first();


        

                $id=$uam->user_id;
                $fname=$uam->fname;
                $user_name=$uam->username;
                $email=$uam->email;
                $password= $uam->password;
                
                $user_ty=$uam->level;
                $designation=$uam->designation;
                $mobile=$uam->mobile;


        $update = true;


        return view('admin.administrator.userManage', ['id'=>$id,'fname'=>$fname,'user_name'=>$user_name, 'email'=>$email,'user_ty'=>$user_ty,'password'=>$password, 'designation'=>$designation, 'mobile'=>$mobile, 'update'=>$update, 'uam'], compact('uams', 'user_types' ));


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


        $request->validate([
            'full_name' => 'required',
            'username' => ['required', 'string', 'max:255', 
            Rule::unique('users')->where (function ($query) use ($request) {
                return $query->where('status', 0);
            })->ignore($id, 'user_id')],
            'email' => '',
            'password' => ['required', 'string', 'min:4'],
            'user_types' => 'required',
            'designation' => '',
            'mobile' => ''
            ]);


        $uama = User::where('user_id', $id);
        $time = Carbon::now()->setTimezone('Asia/Dhaka');
        $data = $request->input('password');
        $uama->update([
            'fname' => $request->input('full_name'),
            'username'=> $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($data),
            'level' => $request->input('user_types'),
            'designation'=> $request->input('designation'),
            'mobile'=> $request->input('mobile'),
            'warehouse_id' => Auth::user()->warehouse_id,
            'status' => 0,
            'edit_by' => Auth::user()->user_id,
            'edit_at' => $time,
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
    public function destroy($user_id)
    {
        
        $id = User::where('user_id', $user_id)->first(); 

if($id) {

    $id->delete();
}
        
        return redirect()->route('admin.usermanage.index');


    }

}
