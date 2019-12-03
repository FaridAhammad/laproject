<?php

namespace App\Http\Controllers\Admin\purchase;
use Carbon\Carbon;

use App\model\Warehouse_other_receive_detail;
use App\model\Warehouse_other_receive;
use function GuzzleHttp\describe_type;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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


//        $orno= db_last_insert_id('warehouse_other_receive','or_no');
            $whord=Warehouse_other_receive_detail::selectRaw('or_no, sum(amount) as sum')->groupBy('or_no')->orderBy('or_no', 'DESC')->take(5)->get();

            return view('admin.purchase.localPurchase', ['whord'=>$whord, 'wor'=>$wor, 'date'=>$wor->or_date, 'save'=>$save]);

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
        //
    }
}

