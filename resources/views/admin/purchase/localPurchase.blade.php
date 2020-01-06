@extends('layouts.admin')
@section('styles')
    <style type="text/css">
        .itemList ul li {
            color: black;
            cursor: pointer;
            padding-left: 5px;


        }
        .itemList ul li:nth-child(odd) {
            color: black;
            background-color:#CCCCCC;
        }
        .itemList ul li:nth-child(even) {
            color: black;
            background-color: white;
        }
        .itemList ul li:hover{
            color: white;
            background-color: #0b4d75;
        }
    </style>
@endsection
@section('content')
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  -->

    <div class="w-100">

        <div class="card  w-50 float-left mr-2">
            <div >
                @if(session()->has('message'))
                    <p class="text-center font-weight-bold  alert-{{session('type')}}">
                        {{session('message')}}
                    </p>
                @endif

            </div>



            <div class="card-body">
                <form action=" @if($save==true) {{ route("admin.localpurchase.store") }} @else {{ route("admin.localpurchase.update", $wor->or_no) }} @endif" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($save==false)
                        @method('PUT')

                    @endif


                    <div class=" form-group row {{ $errors->has('or_no') ? 'has-error' : '' }}">
                        <label for="or_no" class="col-sm-3 col-form-label" >{{ trans('global.localPurchase.fields.vp_no') }}*</label>

                        <div class="col-sm-9">
                            <input type="text" id="or_no" name="or_no" readonly class="form-control-plaintext" value="{{ isset($orno) ?  "  ".$orno : "  ".$wor->or_no}}" >
                            @if($errors->has('or_no'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('or_no') }}
                                </em>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('vp_date') ? 'has-error' : '' }}">
                        <label for="vp_date" class="col-sm-3 col-form-label">{{ trans('global.localPurchase.fields.vp_date') }}</label>
                        <div class="col-sm-9">
                            <input type="text" id="vp_date" name="vp_date" class="form-control date" value="{{$date ?? ''}}" step="0.01">
                            @if($errors->has('vp_date'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('vp_date') }}
                                </em>
                            @endif
                        </div>

                    </div>
                    <div class="form-group row  {{ $errors->has('receive_type') ? 'has-error' : '' }}">
                        <label for="receive_type" class="col-sm-3 col-form-label">{{ trans('global.localPurchase.fields.receive_type') }}</label>
                        <div class="col-sm-9">
                            <select name="receive_type" id="receive_type" class="form-control"  step="0.01">
                                <option @if($save==true) selected @else hidden @endif disabled>Select a Receive Type </option>

                                {{--{{old('job_status',$profile->job_status)=="unemployed"? 'selected':''}--}}
                                {{--@if($update==true) { @if($product_nature == "Purchasable") selected @endif } @endif--}}

                                <option  @if($save==false) { @if($wor->receive_type == "Opening Balance") selected @endif } @endif value="Opening Balance")>Opening Balance</option>
                                <option @if($save==false) { @if($wor->receive_type == "Local Purchase") selected @endif } @endif value="Local Purchase") >Local Purchase</option>
                                <option @if($save==false) { @if($wor->receive_type == "Vendor Purchase") selected @endif } @endif value="Vendor Purchase") >Vendor Purchase</option>
                                <option @if($save==false) { @if($wor->receive_type == "Other Receive") selected @endif } @endif value="Other Receive") >Other Receive</option>
                            </select>
                            @if($errors->has('receive_type'))
                                <em class="invalid-feedback  ">
                                    {{ $errors->first('vendor_name') }}
                                </em>
                            @endif

                        </div>

                    </div>

                    <div id="vendor_namea"  class="form-group row   {{ $errors->has('vendor_name') ? 'has-error' : '' }}">
                        <label for="vendor_name" id="vendor_level" class="col-sm-3 col-form-label">{{ trans('global.localPurchase.fields.vendor_name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" id="vendor_name" name="vendor_name" class="form-control" value="{{ isset($wor) ? $wor->vendor_name : '' }}" step="0.01">
                            @if($errors->has('vendor_name'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('vendor_name') }}
                                </em>
                            @endif
                        </div>

                    </div>


                    @if($save==true)

                        <div class="form-group row">



                            <div class="col-sm-4">
                                <input class="btn btn-primary form-control" name="submit" type="submit" value="{{ trans('global.localPurchase.fields.save') }}">
                            </div>
                        </div>


                    @elseif($save==false)
                        <div class="form-group row">



                            <div class="col-sm-4">
                                <input class="btn btn-primary form-control" name="submit" type="submit" value="{{ trans('global.localPurchase.fields.update') }}">
                            </div>
                        </div>


                    @endif



                </form>
            </div>




        </div>

        <div class="card table-responsive"  style="width:47%;">

            <table class="table table-striped " style="margin-bottom: 0px" >
                <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Amount</th>
                    <th>Print</th>
                </tr>
                </thead>
                <tbody>
                @foreach($whord as $aa)
                    <tr>

                        <td><strong>{{$aa->or_no}}</strong></td>
                        <td><strong>{{$aa->sum}}</strong></td>
                        <td><a target="_blank" href="{{route('admin.print', $aa->or_no)}}"><i class="fa fa-print fa-2x"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>






        </div>
    </div>




    @if(session()->has('or_no'))

        <div class="card-body w-100 pt-0">
            <div class="table-responsive">
                <form action="{{ route('admin.create') }}" method="POST">
                    @csrf
                    <table class=" table table-bordered table-striped table-hover datatable">

                        <tr>
                            <td align="center" bgcolor="#0099FF" class="" style="width:35%"><strong>Item Name</strong></td>
                            <td align="center" bgcolor="#0099FF"><strong>Stock</strong></td>
                            <td align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
                            <td align="center" bgcolor="#0099FF"><strong>Price</strong></td>
                            <td align="center" bgcolor="#0099FF"><strong>Discount</strong></td>
                            <td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>

                            <td align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                            <td rowspan="2" align="center" bgcolor="#FF0000" class="pt-5">

                                <input name="add" class="button pt-2 pb-2" type="submit" id="add" value="ADD" style="border-radius:15px"  class="update"/>

                            </td>
                        </tr>



                        <tr>
                            <td align="center" bgcolor="#CCCCCC">

                                <input  name="receive_type" type="hidden" id="receive_type" value="{{$wor->receive_type}}"  required="required"/>

                                <input  name="or_no" type="hidden" id="" value="{{ isset($orno) ?  "  ".$orno : "  ".$wor->or_no}}"/>
                                {{-- <input  name="warehouse_id" type="hidden" id="warehouse_id" value=""/> --}}
                                <input  name="or_date" type="hidden" id="or_date" value="{{$date ?? ''}}"/>
                                <input  name="vendor_name" type="hidden" id="vendor_name" value="{{ isset($wor) ? $wor->vendor_name : '' }}"/>
                                {{-- <input  name="vendor_id" type="hidden" id="vendor_id" value=""/> --}}

                                <div class="form-group">

                                    <input  name="item" type="text" id="search" value=""  class="w-100{{ $errors->has('item') ? ' is-invalid' : '' }}" required onblur="getData2('local_purchase_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);" autocomplete="off"/>
                                    @if($errors->has('item'))
                                        <em class="invalid-feedback" role="alert">
                                            {{ $errors->first('item') }}
                                        </em>
                                    @endif
                                </div>
                {{ csrf_field() }}
            </div>




            </td>

            <td colspan="3" style="padding-right: 0"  bgcolor="#CCCCCC">
        <span  id="po">
            <input name="stk"  type="text" class="input3" id="stk" style="width:32%" readonly="readonly"/>
           <input name="unit" type="text" class="input3" id="unit" style="width:32%; " readonly="readonly"/>
            <input name="price" type="text" class="input3" id="price" style="width:31%;" oninput="count()"/>
          </span></td>
            <td align="center" bgcolor="#CCCCCC"><input name="discount" type="text" class="input3" id="discount"  maxlength="100" style="width:50px;" oninput="count()"/></td>
            <td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3{{ $errors->has('qty') ? ' is-invalid' : '' }}" id="qty" required maxlength="100" style="width:50px;" oninput="count()"/>
                @if($errors->has('qty'))
                    <em class="invalid-feedback" role="alert">
                        {{ $errors->first('qty') }}
                    </em>
                @endif
            </td>

            <td align="center" bgcolor="#CCCCCC">
                <input name="amount" type="text" class="input3" id="amount" style="width:85px;" readonly="readonly" required/>
            </td>
            </tr>



            </table>
            </form>

            <div id="itemList" class="itemList" data-toggle="popover" style="margin-top:-40px; position: absolute;

                ">

            </div>

            <div id="databaseData" style="position: static">
                <table class=" table table-bordered table-striped table-hover datatable">

                    <tr>
                        <td><strong>{{ trans('global.sl') }}</strong></td>
                        <td><strong>Item Name</strong></td>
                        <td><strong>Unit Name</strong></td>
                        <td><strong>Unit Price</strong></td>
                        <td><strong>Qty</strong></td>
                        <td><strong>Discount</strong></td>
                        <td><strong>Amount</strong></td>
                        <td><strong>Delete</strong></td>

                    </tr>

                    <?php $num = 1; ?>
                    @foreach ($data as $datas)
                        <tr id="sum">

                            <td><strong>{{ $num }}</strong></td>
                            <td><strong>{{ $datas->item_name }}</strong></td>
                            <td><strong>{{ $datas->unit_name }}</strong></td>
                            <td><strong>{{ $datas->rate }}</strong></td>
                            <td><strong>{{ $datas->qty }}</strong></td>
                            <td><strong>{{ $datas->discount }}</strong></td>
                            <td><strong>{{ $datas->amount }}</strong></td>
                            <td>
                                <strong>
                                    <form action="{{ route('admin.localpurchase.destroy',  $datas->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" name='delete' value="{{ trans('global.delete') }}">
                                    </form>
                                </strong>
                            </td>

                        </tr>

                        <?php $num++; ?>

                    @endforeach



                     {{--<tr>--}}
                        {{--<td colspan="4"><strong>Total:</strong></td>--}}
                        {{--<td><strong id="total_qty"></strong></td>--}}
                        {{--<td></td>--}}
                        {{--<td><strong id="total_amount">{{number_format($sum, 2)}}</strong></td>--}}
                        {{--<td></td>--}}
                    {{--</tr>--}}
                </table>


                    <div class="">
                        <form action="{{ route('admin.destroyall') }}" method="POST" class="float-left">
                            @csrf


                            <input type="submit" name="delete_all" class="btn btn-danger" value="Delete All">
                        </form>




                        <form action="{{route('admin.confirm', $wor->or_no)}}" method="POST" class="float-right" onsubmit="return confirm('Are Yor Sure ');">
                            @csrf
                            @method('PUT')

                            <input type="submit" class="btn btn-success" value="Confirm" >

                        </form>
                    </div>








            </div>

        </div>




        </div>
        </div>

    @endif









@endsection
@section('scripts')
    <script>









        $(document).ready(function(){



            // for search  item name.......................
            $('#search').keyup(function(event){



                if ($(this).val().length == 0) {
                    // Hide the element
                    $('#itemList').hide();
                }

                else if($(this).val().length > 0) {

                    var query = $(this).val();
                    if(query != '')
                    {
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url:"{{ route('admin.auto.fetch') }}",
                            method:"POST",
                            data:{query:query, _token:_token},
                            success:function(data){
                                $('#itemList').fadeIn();
                                $('#itemList').html(data);
                            }
                        });
                    }
                }


// else if (event.which == '13') {
//     alert('You pressed a "enter" key in somewhere');
//     }

            });
            $('#search').dblclick(function () {

                $.ajax({
                    url:"{{ route('admin.dblclick') }}",
                    method:"GET",
                    success:function(data){
                        $('#itemList').fadeIn(0);
                        $('#itemList').html(data);
                    }
                });


            });

            //for receive  type change code



            $(document).on('click', '#list', function(){

                $('#search').val($(this).text());
                var item_Id =  $('#search').val().split("#>")[1];

                $.ajax({
                    url: "{{ route('admin.auto.get') }}",
                    type: "POST",
                    data: {
                        item_Id: item_Id,
                        "_token": "{{ csrf_token() }}",
                    },


                    success: function (data) {
                        var stock =(data.stock);
                        var unit = (data.unit);
                        var cost = (data.cost);
                        $('#stk').val(stock);
                        $('#unit').val(unit);
                        $('#price').val(cost);



                    },
                    error: function(error)
                    {
                        alert('failed');
                        console.log(error);
                    }
                });


                $('#itemList').fadeOut();




            });

            $(document).click(function() {
                $('#itemList').fadeOut();
            });
            // end item name search , stock , unit, cost, amoutn calculate item name.......................



            // for find toatal amount and  unit.......................
            var result = [];
            $('#databaseData table tr').each(function(){
                $('td', this).each(function(index, val){
                    if(!result[index]) result[index] = 0;
                    result[index] += parseInt($(val).text());

                });
                if (isNaN(result[4])||isNaN(result[6])){
                    result[4]=0;
                    result[6]=0;

                }

            });

            $('#databaseData table').append('<tr></tr>');
            $('#databaseData table tr').last().append('<td colspan="4">'+'<strong>'+"Total:"+'</strong>'+'</td>');
            $('#databaseData table tr').last().append('<td>'+'<strong>'+result[4].toFixed(2)+'</strong>'+'</td>');
            $('#databaseData table tr').last().append('<td>'+'</td>');
            $('#databaseData table tr').last().append('<td>'+'<strong>'+result[6] .toFixed(2)+'</strong>'+'</td>');
            $('#databaseData table tr').last().append('<td>'+'</td>');


            // end total amount and unit .......................


//   $(result).each(function(){
//   	$('table tr').last().append('<td>'+this+'</td>')



//  });








        });








    </script>

    <script language="javascript">
        function count()
        {
            var discount = document.getElementById('discount').value;
            var rate = ((document.getElementById('price').value)*1);
            var qty = ((document.getElementById('qty').value)*1);
            var num;
            if((rate>0)&&(qty>0))
            {
                if(discount!='')
                {var dis = discount.search("%");
                    if(dis>0)
                    {discount  = (discount.substring(0,dis)*1);
                        var num=(((rate)*(qty))-((((rate)*(qty))*(discount))/100));
                    }
                    else
                    {discount = (discount*1);
                        var num=(qty*(rate-discount));
                    }}
                else
                {var num=(((document.getElementById('qty').value)*1)*((document.getElementById('price').value)*1));}



                document.getElementById('amount').value = num.toFixed(2);
            }

        }
    </script>



@endsection




