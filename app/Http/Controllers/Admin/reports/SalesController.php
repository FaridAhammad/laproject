<?php

namespace App\Http\Controllers\Admin\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\Product_sub_group;
use App\model\Vendor;
use App\model\Item_info;
use Carbon\Carbon;
use DB;


class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        $item_sub_group = Product_sub_group::select('sub_group_id', 'sub_group_name')->where('status', 0)->get();
        $item_group = DB::table('item_group')->select('group_id', 'group_name')->where('status', 0)->get();
        // $vendor = vendor::select('vendor_id', 'vendor_name')->where('status', 0)->get();


        return view('admin.reports.sales_rpt', compact('item_sub_group', 'item_group'));
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
        
        
         $report = $request->input('report');
       

        

    $datetime = Carbon::now()->setTimezone('Asia/Dhaka');
    $date=$datetime->toDateString();
    
   

        if($report == 'Advance Sales Report' ) {

            $data = DB::table('warehouse_other_issue_detail')
            ->join('item_info', 'warehouse_other_issue_detail.item_id', '=', 'item_info.item_id')
            ->join('item_sub_group','item_info.sub_group_id', '=', 'item_sub_group.sub_group_id' )
            ->join('item_group', 'item_sub_group.group_id', '=', 'item_group.group_id')
            ->join('customer', 'warehouse_other_issue_detail.customer_id', '=', 'customer.customer_id')
            ->select('warehouse_other_issue_detail.*', 'item_info.item_name', 
            'item_info.item_description', 'item_sub_group.sub_group_name',
            'item_group.group_name', 'customer.customer_name'    
            )->where(function($data) use ($request, $date){
                $data->where('warehouse_other_issue_detail.status', 1);
                
                if($request->input('item_name')) {
                    $data->where('warehouse_other_issue_detail.item_id', (explode('#>', $request->input('item_name'))[1]));
                }
                if($request->input('sub_item')) {
                    $data->where('item_info.sub_group_id', $request->input('sub_item'));
                }
                if($request->input('item_group')) {
                    $data->where('item_sub_group.group_id', $request->input('item_group'));
                }
                if($request->input('from')) {
                    $data->whereBetween('warehouse_other_issue_detail.oi_date',  [$request->input('from'), $date]);
                }
                if($request->input('from')&& $request->input('to') ) {
                    $data->whereBetween('warehouse_other_issue_detail.oi_date', [$request->input('from'),$request->input('to')]);
                    }
                 if($request->input('to')) {
                    $old_date = DB::table('warehouse_other_issue_detail')->select('oi_date')->first();
                    
                        $data->whereBetween('warehouse_other_issue_detail.oi_date', [$old_date->oi_date, $request->input('to')]);
                   }


                if($request->input('sales')) {
                    $data->where('warehouse_other_issue_detail.issue_type', $request->input('sales'));
                }
            })
            ->get();
             return view('admin.reports.advance_sales_report', compact('data'));
             
         }


         if($report == 'Sales Report') {

$datetime = Carbon::now()->setTimezone('Asia/Dhaka');
$date=$datetime->toDateString();
$data= DB::table('warehouse_other_issue_detail')
->join('item_info', 'warehouse_other_issue_detail.item_id','=','item_info.item_id')
->join('item_sub_group', 'item_info.sub_group_id','=','item_sub_group.sub_group_id')
->join('item_group', 'item_sub_group.group_id','=','item_group.group_id')

->where(function($data) use ( $request, $date){
$data->whereRaw("warehouse_other_issue_detail.status = 1 ");

if($request->input('item_name')) {
$data->where('warehouse_other_issue_detail.item_id',explode('#>', $request->input('item_name'))[1]);
}
if($request->input('sub_item')) {
$data->where('item_info.sub_group_id',$request->input('sub_item'));
}
if($request->input('item_group')) {
$data->where('item_sub_group.group_id',$request->input('item_group'));
}

if($request->input('from') ) {
$data->whereBetween('warehouse_other_issue_detail.oi_date', [$request->input('from'),$date]);
}

if($request->input('from')&& $request->input('to') ) {
$data->whereBetween('warehouse_other_issue_detail.oi_date', [$request->input('from'),$request->input('to')]);
}

if($request->input('to')) {
    $old_date = DB::table('warehouse_other_issue_detail')->select('oi_date')->first();
    
        $data->whereBetween('warehouse_other_issue_detail.oi_date', [$old_date->oi_date, $request->input('to')]);
   }



if($request->input('sales')) {
    $data->where('warehouse_other_issue_detail.issue_type', $request->input('sales'));
}

})
->selectRaw('oi_no, sum(amount) as sum')->groupBy('oi_no')->orderBy('oi_no')
->get();
return view('admin.reports.sales_report', compact('data'));
    
         }

        



        

       


      

        
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
        return view('admin.reports.sales_rpt');
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
        //
    }



    

    
    public function double_click(){

        $data = Item_info::all();
        
        
        $output = '<ul class="dropdown-menu overflow-auto ml-3" style="display:block; max-height:200px; width: 335px;">';
        foreach($data as $row)
        {
        $output .= '
        <li id="list" class="font-weight-bold text-decoration-none " style="cursor:pointer;">'.$row->item_name."&nbsp;"."#>".$row->item_id.'</li>
        ';
        }
        $output .= '</ul>';
        echo $output;
        
        }
       
       

      





        }




