<?php

namespace App\Http\Controllers\Admin\products;


use App\model\Product_sub_group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\User_activity_management;
use App\model\User_type;
use App\model\Product_group;

use Dotenv\Validator;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;

class ProductsubgroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $update = false;



        $uams=Product_sub_group::with('product_group')->select('*')->where('status', 0)->get();

        $product_gp=Product_group::all()->where('status', 0);


        return view('admin.products.productSubGroup', [ 'update'=>$update], compact('uams', 'product_gp'));


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
            'sub_group_name' => [
                'required',
                'max:191',
                Rule::unique('item_sub_group')->where(function ($query) use ($request) {
                    return $query->where('status', 0);

                })],


            'group_name' => 'required',
        ]);

        $product_gp=Product_group::all()->where('status', 0);

    $user_a = Product_sub_group::create([
        'sub_group_name'=> $request->input('sub_group_name'),
        'group_id'=> $request->input('group_name'),

    ]);

return redirect()->route('admin.productsubgroup.index');

        //
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


        $uams=Product_sub_group::with('product_group')->select('*')->where('status', 0)->get();
        $uam=Product_sub_group::with('product_group')->select('*')->where('sub_group_id', $id)->first();
        $sub_group_id=$uam->sub_group_id;
        $gname=$uam->sub_group_name;
        $group_id=$uam->group_id;

        $product_gp=Product_group::all()->where('status', 0);
        $update=true;
        return view('admin.products.productSubGroup', ['gname'=>$gname, 'group_i'=>$group_id, 'update'=>$update,  'sub_group_id'=>$sub_group_id], compact('uams', 'product_gp'));

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
            'sub_group_name' => [
                'required',
                'max:191',
                Rule::unique('item_sub_group')->where(function ($query) use ($request) {
                    return $query->where('status', 0);

                })->ignore($id,'sub_group_id')],


            'group_name' => 'required',
        ]);
        $uama = Product_sub_group::where('sub_group_id', $id);

        $uama->update([

            'sub_group_name'=>$request->input('sub_group_name'),
            'group_id'=>$request->input('group_name'),


        ]);
        $update=false;



        return redirect()->route('admin.productsubgroup.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $uama = Product_sub_group::where('sub_group_id', $id);
        $uama->delete();
        return redirect()->route('admin.productsubgroup.index');

    }
}
