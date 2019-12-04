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

                <div class="form-group row  {{ $errors->has('vendor_name') ? 'has-error' : '' }}">
                    <label for="vendor_name" class="col-sm-3 col-form-label">{{ trans('global.localPurchase.fields.vendor_name') }}</label>
                   <div class="col-sm-9">
                    <input type="text" id="vendor_name" name="vendor_name" class="form-control" value="{{ isset($wor) ? $wor->vendor_name : '' }}" step="0.01">
                    @if($errors->has('vendor_name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('vendor_name') }}
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

                @if($save==true)

                <div class="form-group row">

                    <span class="col-sm-3"></span>

                    <div class="col-sm-4">
                        <input class="btn btn-primary form-control" name="submit" type="submit" value="{{ trans('global.localPurchase.fields.save') }}">
                    </div>
                </div>


                    @elseif($save==false)
                <div class="form-group row">

                    <span class="col-sm-3"></span>

                    <div class="col-sm-4">
                        <input class="btn btn-primary form-control" name="submit" type="submit" value="Update">
                    </div>
                </div>


                    @endif



            </form>
        </div>




    </div>

    <div class="card table-responsive"  style="width:47%;">

        <table class="table table-striped " >
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
                <td><a href=""><i class="fa fa-print fa-2x"></i></a></td>
            </tr>
                @endforeach
            </tbody>
        </table>






    </div>
    </div>




    @if(session()->has('or_no'))

        <div class="card-body w-100 pt-0">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable">
                    <thead>
                    <tr>
                        <td align="center" bgcolor="#0099FF" class="" style="width:35%"><strong>Item Name</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Stock</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Unit</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Price</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Discount</strong></td>
                        <td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Amount</strong></td>
                        <td  rowspan="2" align="center" bgcolor="#FF0000">
                            <div class="button">

                                <input name="add" type="submit" id="add" value="ADD"  class="update"/>
                            </div>
                        </td>
                    </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td align="center" bgcolor="#CCCCCC">
                                {{--<input  name="receive_type" type="hidden" id="receive_type" value=""  required="required"/>--}}
                                {{--<input  name="" type="hidden" id="" value=""/>--}}
                                {{--<input  name="warehouse_id" type="hidden" id="warehouse_id" value=""/>--}}
                                {{--<input  name="or_date" type="hidden" id="or_date" value=""/>--}}
                                {{--<input  name="vendor_name" type="hidden" id="vendor_name" value=""--}}
                                {{--<input  name="vendor_id" type="hidden" id="vendor_id" value=""/>--}}
                                <input  name="item_id"  type="text" id="item_id" value=""  class="w-100"
                                        {{--required onblur="getData2('local_purchase_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"--}}

                                />


                            </td>
                            <td colspan="3" style="padding-right: 0"  bgcolor="#CCCCCC">
<span  id="po">
    <input name="stk"  type="text" class="input3" id="stk" style="width:32%" readonly="readonly"/>
   <input name="unit" type="text" class="input3" id="unit" style="width:32%; " readonly="readonly"/>
    <input name="price" type="text" class="input3" id="price" style="width:31%;"  readonly="readonly"/>
  </span></td>
                            <td align="center" bgcolor="#CCCCCC"><input name="discount" type="text" class="input3" id="discount"  maxlength="100" style="width:50px;" onchange="count()"/></td>
                            <td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:50px;" onchange="count()" required="required"/></td>

                            <td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:85px;" readonly="readonly" required/></td>
                        </tr>

                    </tbody>
                </table>

            </div>
            <div id="itemList" class="itemList" style="margin-top: -30px;  padding-left: 10px;">

            </div>
        </div>

    @endif






@endsection

@section('scripts')
    <script>
        $(document).ready(function(){

            $('#item_id').keyup(function(){

                if ($(this).val().length == 0) {
                    // Hide the element
                    $('#itemList').hide();
                }

                else {
                    var query = $(this).val();
                    if(query != '')
                    {
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url:"{{ route('admin.search') }}",
                            method:"POST",
                            data:{query:query, _token:_token},
                            success:function(data){
                                $('#itemList').fadeIn();
                                $('#itemList').html(data);
                            }
                        });
                    }
                }

            });

            $(document).on('click', 'li', function(){
                $('#item_id').val($(this).text());
                $('#itemList').fadeOut();
            });



        });





    </script>






@endsection



