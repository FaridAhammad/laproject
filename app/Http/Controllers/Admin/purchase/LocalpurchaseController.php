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






        if($request->session()->has('or_no'))
        {

            $save=false;
            $rr=session()->get('or_no');



            $wor=Warehouse_other_receive::Select('*')->where('or_no', $rr)->first();


            $whord=Warehouse_other_receive_detail::selectRaw('or_no, sum(amount) as sum')->groupBy('or_no')->orderBy('or_no', 'DESC')->where('status','=', '1')->take(5)->get();








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
                    'item_info.item_name')->orderBy('warehouse_other_receive_detail.id', 'asc')->get();



            return view('admin.purchase.localPurchase', ['whord'=>$whord, 'wor'=>$wor, 'date'=>$wor->or_date, 'save'=>$save, 'data'=>$data]);

        }


        else {



            $save=true;
            $datetime = Carbon::now()->setTimezone('Asia/Dhaka');
            $date=$datetime->toDateString();

            $orno= db_last_insert_id('warehouse_other_receive','or_no');
            $whord=Warehouse_other_receive_detail::selectRaw('or_no, sum(amount) as sum')->groupBy('or_no')->orderBy('or_no', 'DESC')->where('status','=', '1')->take(5)->get();
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



   public function fetch(Request $request)
    {
        if($request->get('query'))
        {

            $query = $request->get('query');
            $data = DB::table('item_info')
                ->where('item_name', 'LIKE', "%{$query}%")
                ->orWhere('item_id', 'LIKE', "%{$query}%")
                ->get();






            $output = '<ul class="dropdown-menu overflow-auto ml-3" style="display:block;  max-height:200px; width: 335px;">';
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



   public function stocks(Request $request) {
        $item_id = $request->get('item_Id');
        $stock = present_stock($item_id, 51);

        $unit = DB::table('item_info')->where('item_id', $item_id)->value('unit_name');
        $cost = DB::table('item_info')->where('item_id', $item_id)->value('cost_price');








        return ['stock'=>$stock, 'unit'=>$unit, 'cost'=>$cost];

    }
   public function destroyall() {
    Warehouse_other_receive::Where('or_no', session('or_no'))->update([
     'status'=>'0'
    ]);
        request()->session()->forget('or_no');
        return redirect()->route('admin.localpurchase.index');
    }
    public  function confirmall($id){

        $wor= Warehouse_other_receive::where('or_no', $id)->first();
        Warehouse_other_receive_detail::where('or_no', $id)->update(array('status' => '1', 'or_date'=>$wor->or_date, 'vendor_name'=>$wor->vendor_name));
        $wor->update(array('status' => '1'));
        request()->session()->forget('or_no');
        return redirect()->route('admin.localpurchase.index');





    }
    public  function  print($id){
        $whord=Warehouse_other_receive_detail::where('or_no','=', $id)->Where('status','=','1')->get();
        $whor=Warehouse_other_receive::where('or_no','=', $id)->first();





       return view('admin.purchase.invoiceprint', ['whord'=>$whord, 'whor'=>$whor]);
    }








}
