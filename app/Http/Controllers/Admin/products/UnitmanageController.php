<?php

namespace App\Http\Controllers\Admin\products;

use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Unit_management;


class UnitmanageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $update = false;

        $uams=Unit_management::where('status', 0)->get();
       
        
         return view('admin.products.unit', ['name'=>'', 'detail'=> '', 'update'=>$update], compact('uams'));

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

        
        
        request()->validate([
            'unit_name'=>  ['required', 'string', 'max:255'],
            'unit_detail'=> '',
        ]);

        $unit_management = Unit_management::create($request->all());

        return redirect()->route('admin.unitmanage.index');
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
    public function edit($id)
    {
        abort_unless(\Gate::allows('user_edit'), 403);
        $uams=Unit_management::all();



        $uam = Unit_management::select('id', 'unit_name', 'unit_detail')->where('id', $id)->first();


                $id=$uam->id;
                $name=$uam->unit_name;
                $detail=$uam->unit_detail;
                

        $update = true;


        return view('admin.products.unit', ['id'=>$id,'name'=>$name,'detail'=>$detail,'update'=>$update, 'uam'], compact('uams'));


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



        $uama = Unit_management::where('id', $id);



        $uama->update([

                'unit_name'=>$request->input('unit_name'),
                'unit_detail'=>$request->input('unit_detail'),
                 
        ]);
        $update=false;
        return redirect()->route('admin.unitmanage.index');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Unit_management::where('id', $id);

        $user->delete();
        return redirect()->route('admin.unitmanage.index');


    }
}
