<?php

namespace App\Http\Controllers\Admin\purchase;
use Carbon\Carbon;

use App\model\Warehouse_other_receive_detail;
use App\model\Warehouse_other_receive;
use function GuzzleHttp\describe_type;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Item_info;
use DB;

class LocalpurchaseController extends Controller
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
        
        

        if($request->session()->has('or_no'))
        {

            $save=false;
            $rr=session()->get('or_no');

            

            $wor=Warehouse_other_receive::Select('*')->where('or_no', $rr)->first();


//        $orno= db_last_insert_id('warehouse_other_receive','or_no');
            $whord=Warehouse_other_receive_detail::selectRaw('or_no, sum(amount) as sum')->groupBy('or_no')->orderBy('or_no', 'DESC')->take(5)->get();
            
            

          
            
            
           

                $data = DB::table('warehouse_other_receive_detail')
            ->join( 
                'item_info', 'item_info.item_id', '=', 'warehouse_other_receive_detail.item_id')
                ->where('warehouse_other_receive_detail.or_no', '=', $rr)
                ->select( 'warehouse_other_receive_detail.id',  
                'rate', 
                'qty',
                'warehouse_other_receive_detail.unit_name',
                'discount',
                'amount',
                'item_info.item_name')->get();


            return view('admin.purchase.localPurchase', ['whord'=>$whord, 'wor'=>$wor, 'date'=>$wor->or_date, 'save'=>$save, 'data'=>$data]);

        }


        else {



        $save=true;
        $datetime = Carbon::now();
        $date=$datetime->toDateString();

       $orno= db_last_insert_id('warehouse_other_receive','or_no');
        $whord=Warehouse_other_receive_detail::selectRaw('or_no, sum(amount) as sum')->groupBy('or_no')->orderBy('or_no', 'DESC')->take(5)->get();
//$whor=$whord->sum
//    $who=$whord->groupBy('or_no')->take(5);

//          if ($request->input('submit')=='submit') { return  $this->vistore();}










        return view('admin.purchase.localPurchase', ['whord'=>$whord, 'orno'=>$orno, 'date'=>$date, 'save'=>$save]);
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
        

        if(request()->input('add')) {
            $time = Carbon::now()->setTimezone('Asia/Dhaka');

            if( request()->input('discount') != null) {
                $discount = request()->input('discount');
            } else {
                $discount = 0;
            }
          
            Warehouse_other_receive_detail::create([
            "or_no" =>request()->input('or_no'),
            "vendor_name" => request()->input('vendor_name'),
            "or_date" => request()->input('or_date'),
            "receive_type" => request()->input('receive_type'),
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
            
            return redirect()->route('admin.localpurchase.index');
        }

        
       
        // $data = DB::table('warehouse_other_receive_detail')
        //     ->join( 
        //         'item_info', 'item_info.item_id', '=', 'warehouse_other_receive_detail.item_id')
        //         ->where('warehouse_other_receive_detail.or_no', '=', 2062)
        //         ->select( 'warehouse_other_receive_detail.id',  
        //         'rate', 
        //         'qty',
        //         'warehouse_other_receive_detail.unit_name',
        //         'discount',
        //         'amount',
        //         'item_info.item_name')->get();
        
        //     $output = '<table class=" table table-bordered table-striped table-hover datatable">'.
        //   '<tr>'.
        //   '<td>'.'<strong>'."Item Name".'</strong>'.'</td>'.
        //   '<td>'.'<strong>'."Unit Name".'</strong>'.'</td>'.
        //   '<td>'.'<strong>'."Unit Price".'</strong>'.'</td>'.
        //   '<td>'.'<strong>'."Qty".'</strong>'.'</td>'.
        //   '<td>'.'<strong>'."Discount".'</strong>'.'</td>'.
        //   '<td>'.'<strong>'."Amount".'</strong>'.'</td>'.
        //   '<td>'.'<strong>'."Delete".'</strong>'.'</td>'.
        //   '</tr>';

        //  foreach($data as $datas) {
        //     $output .= '<tr>'.
        //     '<td>'.'<strong>'.$datas->item_name.'</strong>'.'</td>'.
        //     '<td>'.'<strong>'.$datas->unit_name.'</strong>'.'</td>'.
        //     '<td>'.'<strong>'.$datas->rate.'</strong>'.'</td>'.
        //     '<td>'.'<strong>'.$datas->qty.'</strong>'.'</td>'.
        //     '<td>'.'<strong>'.$datas->discount.'</strong>'.'</td>'.
        //     '<td>'.'<strong>'.$datas->amount.'</strong>'.'</td>'.
        //     '<td>'.'<strong>'."Delete".'</strong>'.'</td>'.
        //     '</tr>';
        //  }
        
        //   $output .= '</table>';
        
          
        // $id = request()->get('item_id');
       
        


        // $item_id = '';
        // $stock = '';
        // $unit = '';
        // $qty = '';
        // $price= '';
        // $discount = '';
        // $amount = '';
        // return ['item_id'=>$item_id, 'stock'=>$stock, 'unit'=>$unit, 'qty'=>$qty, 'price'=>$price, 'discount'=>$discount, 'amount'=>$amount, 'output'=>$output];


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
            'or_no' => 'required|unique:warehouse_other_receive',
            'vp_date' => 'required',
            'vendor_name' => 'required',
            'receive_type' => 'required',

        ]);

        $user_a = Warehouse_other_receive::create([
            'or_no'=> $request->input('or_no'),
            'or_date'=> $request->input('vp_date'),
            'vendor_name'=> $request->input('vendor_name'),
            'receive_type'=> $request->input('receive_type'),
            'entry_by'=>10003,

        ]);


       $rr= $request->input('or_no');
       $r=$request->session()->put('or_no', $rr);






        return redirect()->route('admin.localpurchase.index');





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
            'vp_date' => 'required',
            'vendor_name' => 'required',
            'receive_type' => 'required',

        ]);
        $uama =  Warehouse_other_receive::where('or_no', $id);
        $uama->update([

            'or_no'=> $request->input('or_no'),
            'or_date'=> $request->input('vp_date'),
            'vendor_name'=> $request->input('vendor_name'),
            'receive_type'=> $request->input('receive_type'),
            'entry_by'=>10003,

        ]);
        session()->flash('message', 'Data Updated Successfully ');
        session()->flash('type', 'success');


        return redirect()->route('admin.localpurchase.index');



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
       $data = Warehouse_other_receive_detail::where('id', $id)->delete();
       return redirect()->route('admin.localpurchase.index');
    }



    function fetch(Request $request)
    {
     if($request->get('query'))
     {
    
      $query = $request->get('query');
      $data = DB::table('item_info')
        ->where('item_name', 'LIKE', "%{$query}%")
        ->orWhere('item_id', 'LIKE', "%{$query}%")
        ->get();
      
        

        
        

      $output = '<ul class="dropdown-menu overflow-auto ml-3" style="display:block; position:relative; max-height:200px; width: 335px;">';
      foreach($data as $row)
      {
       $output .= '
       <li id="list" class="ml-2 font-weight-bold text-decoration-none text-dark view overlay zoom" style="cursor:pointer">'.$row->item_name."&nbsp;"."#>".$row->item_id.'</li>
       ';
      }
      $output .= '</ul>';
      echo $output;
     }

     

    
}



function stocks(Request $request) {
   $item_id = $request->get('item_Id');
  $stock = present_stock($item_id, 51);

  $unit = DB::table('item_info')->where('item_id', $item_id)->value('unit_name');
  $cost = DB::table('item_info')->where('item_id', $item_id)->value('cost_price');
  

  
  

  


    return ['stock'=>$stock, 'unit'=>$unit, 'cost'=>$cost];

}



function destroyall() {
//    $detail = (request()->input('or_no'));
//    $r_detail = Warehouse_other_receive_detail::Where('or_no', $detail)->delete();
//    $other_r =   Warehouse_other_receive::Where('or_no', $detail)->delete();
   request()->session()->forget('or_no');

   return redirect()->route('admin.localpurchase.index');



}
     public  function  print($id){
        $whord=Warehouse_other_receive_detail::where('or_no','=', $id)->Where('status','=','1')->get();
        $whor=Warehouse_other_receive::where('or_no','=', $id)->first();





       return view('admin.purchase.invoiceprint', ['whord'=>$whord, 'whor'=>$whor]);
    }




}





