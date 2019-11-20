<?php

namespace App\Http\Controllers\Admin\products;
use App\Rules\Uppercase;
use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Unit_management;
use Carbon\Carbon;
use Illuminate\Validation\Rule; 


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
            'unit_name'=>  ['required', 
            'string',
            'max:255', 
            Rule::unique('unit_management')->where (function ($query) use ($request) {
                return $query->where('status', 0);
            })
            
        ],
            
            

            'unit_detail'=> '',
            
        ]);

        // Rule::unique('unit_management,')->where(function ($query) {
        //     return $query->where('status', 0);
        // }),

        // 'unique:unit_management',
        
        
        // $unit_management = Unit_management::create($request->all());

        $time = Carbon::now()->setTimezone('Asia/Dhaka');

        $unit_management = Unit_management::create([
            'unit_name'=> $request->input('unit_name'),
            'unit_detail'=> $request->input('unit_detail'),
            'entry_by'=> '1001',
            'entry_at'=> $time,
        ]);

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
        $uams=Unit_management::where('status', 0)->get();



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

       request()->validate([
            'unit_name'=>  ['required', 
            'string', 
            'max:255',
            Rule::unique('unit_management')->where (function ($query) use ($request) {
                return $query->where('status', 0);
            })->ignore($id, 'id')

            ],

        ]);


        $uama = Unit_management::where('id', $id);


        $time = Carbon::now()->setTimezone('Asia/Dhaka');

        $uama->update([

                'unit_name'=>$request->input('unit_name'),
                'unit_detail'=>$request->input('unit_detail'),
                'edit_by'=> '1001',
                'edit_at'=> $time,
                 
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

        $time = Carbon::now()->setTimezone('Asia/Dhaka');
        $user->update([
            'status'=> '1',
            'delete_by'=> '1001',
            'delete_at'=> $time,


        ]);

        // $user->delete();
        return redirect()->route('admin.unitmanage.index');


    }
}
