<?php

namespace App\Http\Controllers\Admin\sales;
use Carbon\Carbon;

use App\model\Warehouse_other_receive_detail;
use App\model\Warehouse_other_receive;


use App\model\Warehouse_other_issue_detail;
use App\model\Warehouse_other_issue;

use function GuzzleHttp\describe_type;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Item_info;
use DB;

class LocalsalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

//    select `or_no`,SUM(amount) from `warehouse_other_receive_detail` where 1 group by `or_no` order by `or_no` desc limit 5
//select( 'or_no','amount')->orderBy('or_no', 'DESC')->get()->where('accepted', 1)->sum('amount');


    public function index(Request $request)
    {

        

     // $a = find_all_field('item_info', '*', '1');
        
        // $b = present_stock(91, 51);

        
        

        // $item_id = \DB::table('item_info')->select('item_id')->where('item_name', '000111')->get();
        
        

        if($request->session()->has('oi_no'))
        {

            $save=false;

            $rr=session()->get('oi_no');

            

            $wor=Warehouse_other_issue::Select('*')->where('oi_no', $rr)->first();


//        $orno= db_last_insert_id('warehouse_other_receive','or_no');
            $whord=Warehouse_other_issue_detail::selectRaw('oi_no, sum(amount) as sum')->groupBy('oi_no')->orderBy('oi_no', 'DESC')->take(5)->get();
            
            

          
            
            
           

                $data = DB::table('warehouse_other_issue_detail')
            ->join( 
                'item_info', 'item_info.item_id', '=', 'warehouse_other_issue_detail.item_id')
                ->where('warehouse_other_issue_detail.oi_no', '=', $rr)
                ->select( 'warehouse_other_issue_detail.id',  
                'rate', 
                'qty',
                'warehouse_other_issue_detail.unit_name',
                'discount',
                'amount',
                'item_info.item_name')->get();


            return view('admin.sales.local_sales', ['whord'=>$whord, 'wor'=>$wor, 'date'=>$wor->oi_date, 'save'=>$save, 'data'=>$data]);

        }


        else {



        $save=true;
        $datetime = Carbon::now();
        $date=$datetime->toDateString();

       $oino= db_last_insert_id('warehouse_other_issue','oi_no');
        $whord=Warehouse_other_issue_detail::selectRaw('oi_no, sum(amount) as sum')->groupBy('oi_no')->orderBy('oi_no', 'DESC')->take(5)->get();
//$whor=$whord->sum
//    $who=$whord->groupBy('or_no')->take(5);

//          if ($request->input('submit')=='submit') { return  $this->vistore();}










        return view('admin.sales.local_sales', ['whord'=>$whord, 'oino'=>$oino, 'date'=>$date, 'save'=>$save]);
        }

       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {


        request()->validate([
            'item'=> 'required',
            'qty'=> 'required',
        ]);

        $id = request()->input('item');
        $item = explode('#>', $id);
        $item_id = $item[1];
        
        if( request()->input('issue_type') != "Customer Sales") {

            $time = Carbon::now()->setTimezone('Asia/Dhaka');

            if( request()->input('discount') != null) {
                $discount = request()->input('discount');
            } else {
                $discount = 0;
            }

            
          
            Warehouse_other_issue_detail::create([
            "oi_no" =>request()->input('oi_no'),
            "issued_to" => request()->input('vendor_name'),
            "oi_date" => request()->input('oi_date'),
            "issue_type" => request()->input('issue_type'),
            "warehouse_id" => 51,
            "item_id" => $item_id,
            "unit_name" => request()->input('unit'),
            "rate" => request()->input('price'),
            "qty" => request()->input('qty'),
            "discount" => $discount,
            "amount" => request()->input('amount'),
            "entry_by" => 1003,
            "entry_at" => $time,
            ]);
            
            return redirect()->route('admin.localsales.index');

        }

        else {
            $time = Carbon::now()->setTimezone('Asia/Dhaka');

            if( request()->input('discount') != null) {
                $discount = request()->input('discount');
            } else {
                $discount = 0;
            }

            $customer = request()->input('vendor_name');
            
            
           $id = DB::table('customer')->where('customer_name', $customer)->value('customer_id');

            Warehouse_other_issue_detail::create([
                "oi_no" =>request()->input('oi_no'),
                "issued_to" => request()->input('vendor_name'),
                'customer_id'=> $id,
                "oi_date" => request()->input('oi_date'),
                "issue_type" => request()->input('issue_type'),
                "warehouse_id" => 51,
                "item_id" => $item_id,
                "unit_name" => request()->input('unit'),
                "rate" => request()->input('price'),
                "qty" => request()->input('qty'),
                "discount" => $discount,
                "amount" => request()->input('amount'),
                "entry_by" => 1003,
                "entry_at" => $time,
                ]);
                
                return redirect()->route('admin.localsales.index');


        }

        

        
       
        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        

        if( $request->input('issue_type') != "Customer Sales") {
            request()->validate([
                'oi_no' => 'required|unique:warehouse_other_issue',
                'oi_date' => 'required',
                'vendor_name' => 'required',
                'issue_type' => 'required',
    
            ]);
    
            
    
            $user_a = Warehouse_other_issue::create([
                'oi_no'=> $request->input('oi_no'),
                'oi_date'=> $request->input('oi_date'),
                'issued_to'=> $request->input('vendor_name'),
                'issue_type'=> $request->input('issue_type'),
                'entry_by'=>10003,
    
            ]);

        }
    
        

        else {

            request()->validate([
                'oi_no' => 'required|unique:warehouse_other_issue',
                'oi_date' => 'required',
                'issue_type' => 'required',
                'vendor_name' => 'required',
    
            ]);

            $customer = $request->vendor_name;

            
            
           $name = DB::table('customer')->where('customer_id', $customer)->value('customer_name');
           
           Warehouse_other_issue::create([
            'oi_no'=> $request->input('oi_no'),
            'oi_date'=> $request->input('oi_date'),
            'customer_id'=> $customer,
            'issued_to'=>$name,
            'issue_type'=> $request->input('issue_type'),
            'entry_by'=>10003,

        ]);

        }
        
        

       


       $rr= $request->input('oi_no');
       $r=$request->session()->put('oi_no', $rr);






        return redirect()->route('admin.localsales.index');





    }

//    public function sarif(Request $request){
//        $save=false;
//        $rr=session()->get('or_no');
//
//
//
//        $wor=Warehouse_other_receive::Select('*')->where('or_no', $rr)->first();
//
//
//
//
//
//
//
////        $orno= db_last_insert_id('warehouse_other_receive','or_no');
//        $whord=Warehouse_other_receive_detail::selectRaw('or_no, sum(amount) as sum')->groupBy('or_no')->orderBy('or_no', 'DESC')->take(5)->get();
//
//        return view('admin.purchase.localPurchase', ['whord'=>$whord, 'wor'=>$wor, 'date'=>$wor->or_date, 'save'=>$save]);
//    }

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
        //
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
            'oi_date' => 'required',
            'vendor_name' => 'required',
            'issue_type' => 'required',

        ]);
        $uama =  Warehouse_other_issue::where('oi_no', $id);
        $uama->update([

            'oi_no'=> $request->input('oi_no'),
            'oi_date'=> $request->input('oi_date'),
            'issued_to'=> $request->input('vendor_name'),
            'issue_type'=> $request->input('receive_type'),
            'entry_by'=>10003,

        ]);
        session()->flash('message', 'Data Updated Successfully ');
        session()->flash('type', 'success');


        return redirect()->route('admin.localsales.index');



        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $data = Warehouse_other_issue_detail::where('id', $id)->delete();
       return redirect()->route('admin.localsales.index');
    }








function deleteall() {

   request()->session()->forget('oi_no');

   return redirect()->route('admin.localsales.index');



}


function customer() {

   


     $datas = DB::table('customer')->where('status', 0)->get();
     if($datas) {
         $output = '<label class="col-sm-3 col-form-label">'."Customer Name".'</label><div class="col-sm-9"><select class="form-control" id="vendor_name" name="vendor_name"><option disabled selected>'."Select a vendor name".'</option>';
         foreach($datas as $data) {
            
             $output .='<option value='.$data->customer_id.'>'.$data->customer_name.'</option>';
         }
         $output .='</select></div></<label>';
         echo $output;

     }

}
 


}





