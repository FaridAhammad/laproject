<?php

namespace App\Http\Controllers\Admin\products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dotenv\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\model\Item_info;
use App\model\Product_sub_group;
use App\model\Unit_management;

class ProductmanageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $update = false;
        $item = Item_info::where('status', 0)->get();
        $sub_item = Product_sub_group::where('status', 0)->pluck('sub_group_name','sub_group_id');
        $unit_item = Unit_management::where('status', 0)->pluck('unit_name','id');

        return view('admin.products.products', ['itemname'=>'', 'details'=>'', 'cost'=>'', 'sale'=>'', 'update'=>$update], compact('item', 'sub_item', 'unit_item'));

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
        request()->validate([
            'item_name'=> ['required', 
            'string', 
            'max:255',
             Rule::unique('item_info')->where( function ($query) use ($request) {
             return $query->where('status', 0);
            
             })           
                    ],
            
            'sub_group_name'=> ['required','string'],

           
            
            'product_nature'=> ['required', 'string'],

            'unit_name'=> ['required', 'string'],

           

        ]);

        
        $time = Carbon::now()->setTimezone('Asia/Dhaka');

        Item_info::create([
        
        'item_name'=>$request->input('item_name'),
        'sub_group_id'=>$request->input('sub_group_name'),
        'item_description'=>$request->input('details'),
        'product_nature'=>$request->input('product_nature'),
        'unit_name'=>$request->input('unit_name'),
        'cost_price'=>$request->input('cost'),
        'sale_price'=>$request->input('sale'),
        'entry_by'=>'1001',
        'entry_at'=>$time,

        ]);

        return redirect()->route('admin.productmanage.index');


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
    public function edit($item_id)
    {
        $item = Item_info::where('status', 0)->get();
        $sub_item = Product_sub_group::where('status', 0)->pluck('sub_group_name','sub_group_id');
        $unit_item = Unit_management::where('status', 0)->pluck('unit_name','id');

        $items = Item_info::select('item_id', 'item_name', 'sub_group_id', 'item_description',
        'product_nature', 'unit_name', 'cost_price', 'sale_price')->where('item_id', $item_id)->first();

        $id = $items->item_id;
        $item_name = $items->item_name; 
        $sub_group_name = $items->sub_group_id; 
        $details = $items->item_description;
        $product_nature = $items->product_nature;
        $unit_name = $items->unit_name;
        $cost = $items->cost_price;
        $sale = $items->sale_price; 
        $update = true;

        return view('admin.products.products', ['id'=>$id, 'itemname'=>$item_name, 'sub_group_name'=>$sub_group_name, 'details'=>$details, 'product_nature'=>$product_nature, 'unit_name'=>$unit_name, 'cost'=>$cost, 'sale'=>$sale, 'update'=>$update], compact('item', 'sub_item', 'unit_item'));

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
            'item_name'=> ['required', 
            'string', 
            'max:255',
             Rule::unique('item_info')->where( function ($query) use ($request) {
             return $query->where('status', 0);
            
             })->ignore($id, 'item_id')           
                    ],
            
            'sub_group_name'=> ['required','string'],

            
            
            'product_nature'=> ['required', 'string'],

            'unit_name'=> ['required', 'string'],

            

        ]);

        $items = Item_info::where('item_id', $id);

        $time = Carbon::now()->setTimezone('Asia/Dhaka');

        $items->update([
        
            'item_name'=>$request->input('item_name'),
            'sub_group_id'=>$request->input('sub_group_name'),
            'item_description'=>$request->input('details'),
            'product_nature'=>$request->input('product_nature'),
            'unit_name'=>$request->input('unit_name'),
            'cost_price'=>$request->input('cost'),
            'sale_price'=>$request->input('sale'),
            'edit_by'=>'1001',
            'edit_at'=>$time,
    
            ]);
            $update=false;

            return redirect()->route('admin.productmanage.index');
    




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($item_id)
    {
        $items = Item_info::where('item_id', $item_id);
        $time = Carbon::now()->setTimezone('Asia/Dhaka');

        $items->update([
            'status'=> '1',
            'delete_by'=> '1001',
            'delete_at'=> $time,
        ]);

        return redirect()->route('admin.productmanage.index');

    }
}
