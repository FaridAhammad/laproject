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
            <form action=" @if($save==true) {{ route("admin.localsales.store") }} @else {{ route("admin.localsales.update", $wor->oi_no) }} @endif" method="POST" enctype="multipart/form-data">
                @csrf
                @if($save==false)
                    @method('PUT')

                    @endif


                <div class=" form-group row {{ $errors->has('oi_no') ? 'has-error' : '' }}">
                    <label for="oi_no" class="col-sm-3 col-form-label" >Sales No*</label>

                    <div class="col-sm-9">
                        <input type="text" id="oi_no" name="oi_no" readonly class="form-control-plaintext" value="{{ isset($oino) ?  "  ".$oino : "  ".$wor->oi_no}}" >
                    @if($errors->has('oi_no'))
                        <em class="invalid-feedback">
                            {{ $errors->first('oi_no') }}
                        </em>
                    @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('oi_date') ? 'has-error' : '' }}">
                    <label for="oi_date" class="col-sm-3 col-form-label">Sales Date</label>
                    <div class="col-sm-9">
                    <input type="text" id="oi_date" name="oi_date" class="form-control date" value="{{$date ?? ''}}">
                    @if($errors->has('oi_date'))
                        <em class="invalid-feedback">
                            {{ $errors->first('oi_date') }}
                        </em>
                    @endif
                    </div>

                </div>

               
                <div class="form-group row  {{ $errors->has('issue_type') ? 'has-error' : '' }}">
                    <label for="issue_name" class="col-sm-3 col-form-label">Issue Type</label>
                   <div class="col-sm-9">
                    <select name="issue_type" id="issue_type" class="form-control">
                       <option @if($save==true) selected @else hidden @endif disabled>Select an Issue Type</option>

                        {{--{{old('job_status',$profile->job_status)=="unemployed"? 'selected':''}--}}
                        {{--@if($update==true) { @if($product_nature == "Purchasable") selected @endif } @endif--}}

                       
                       <option   @if($save==false) { @if($wor->issue_type == "Local Sales") selected @endif } @endif value="Local Sales") >Local Sales</option>
                       <option   @if($save==false) { @if($wor->issue_type == "Customer Sales") selected @endif } @endif value="Customer Sales") >Customer Sales</option>
                       <option   @if($save==false) { @if($wor->issue_type == "Other Issue") selected @endif } @endif value="Other Issue") >Other Issue</option>
                   </select>
                   @if($errors->has('issue_type'))
                   <em class="invalid-feedback  ">
                       {{ $errors->first('issue_type') }}
                   </em>
               @endif

                   </div>

                </div>

                <div id="customer" class="form-group row">
                
                  
                </div>

                @if($save==true)

                <div class="form-group row">

                   

                    <div style="margin-left: 14px;">
                        <input class="btn btn-primary form-control" id="int_sales" name="submit" type="submit" value="Initiate Sales Information">
                    </div>
                </div>


                    @elseif($save==false)
                <div class="form-group row">

                    

                    <div class="d-flex justify-content-center" style="margin-left: 14px;">
                        <input class="btn btn-primary form-control" name="submit" type="submit" value="Update Sales Information">
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

                <td><strong>{{$aa->oi_no}}</strong></td>
                <td><strong>{{$aa->sum}}</strong></td>
                <td><a href=""><i class="fa fa-print fa-2x"></i></a></td>
            </tr>
                @endforeach
            </tbody>
        </table>






    </div>
    </div>




    @if(session()->has('oi_no'))

        <div class="card-body w-100 pt-0">
            <div class="table-responsive">
            <form action="{{ route('admin.insert') }}" method="POST">
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
                                
                                        <input name="add" class="button pt-1 pb-2" type="submit" id="add" value="ADD"  class="update"/>
                                    
                                </td>
                            </tr>
                            
                            
        
                                <tr>
                                    <td align="center" bgcolor="#CCCCCC">

                                        <input  name="issue_type" type="hidden" id="issue_type" value="{{$wor->issue_type}}"  required="required"/>
                                       
                                        <input  name="oi_no" type="hidden" id="" value="{{ isset($oino) ?  "  ".$oino : "  ".$wor->oi_no}}"/>
                                        {{-- <input  name="warehouse_id" type="hidden" id="warehouse_id" value=""/> --}}
                                        <input  name="oi_date" type="hidden" id="oi_date" value="{{$date ?? ''}}"/>
                                        <input  name="vendor_name" type="hidden" id="vendor_name" value="{{ isset($wor) ? $wor->issued_to : '' }}"/>
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
            <input name="price" type="text" class="input3" id="price" style="width:31%;" oninput="count()" autocomplete="off"/>
          </span></td>
                                    <td align="center" bgcolor="#CCCCCC"><input name="discount" type="text" class="input3" id="discount"  maxlength="100" style="width:50px;" oninput="count()" autocomplete="off"></td>
                                    <td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3{{ $errors->has('qty') ? ' is-invalid' : '' }}" id="qty" required maxlength="100" style="width:50px;" oninput="count()" autocomplete="off"/>
                                        @if($errors->has('qty'))
                                        <em class="invalid-feedback" role="alert">
                                            {{ $errors->first('qty') }}
                                        </em>
                                    @endif
                                    </td>
                                   
                                    <td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:85px;" readonly="readonly" required/></td>
                                </tr>
                              
        
                            
                        </table>
             </form>

                <div id="itemList" data-toggle="popover" style="margin-top:-40px; position: absolute;
                left: 248px;
                top: 565px;
                z-index: 10">

                </div> 

                <div id="databaseData">
                    <table class=" table table-bordered table-striped table-hover datatable" id="tab_1">
                            
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
                       
                        <?php $num = 1;  ?>  
                         @foreach ($data as $datas) 
                        <tr>
                            
                        <td><strong>{{ $num }}</strong></td>
                        <td><strong>{{ $datas->item_name }}</strong></td>
                            <td><strong>{{ $datas->unit_name }}</strong></td>
                            <td><strong>{{ $datas->rate }}</strong></td>
                            <td><strong>{{ $datas->qty }}</strong></td>
                            <td><strong>{{ $datas->discount }}</strong></td>
                            <td><strong>{{ $datas->amount }}</strong></td>
                        <td><strong><form action="{{ route('admin.localsales.destroy',  $datas->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-xs btn-danger" name='delete' value="{{ trans('global.delete') }}">
                        </form></strong></td>
                        </tr>
                        <?php $num++; ?> 
                     @endforeach 
                        {{-- <tr>
                            <td colspan="4"><strong>Total:</strong></td>
                            <td><strong id="total_qty">00</strong></td>
                            <td></td>
                            <td><strong id="total_amount">00</strong></td>
                            <td></td>
                        </tr> --}}
                    </table>

                   
                     
            
                </div>
                
                
            </div>

            <div class="row">
                
                    <div class="col">
                    <form action="{{ route('admin.deleteall') }}" method="POST">
                        @csrf
                                 
                        
                        <input  name="oi_no" type="hidden" id="" value="{{ isset($oino) ?  "  ".$oino : "  ".$wor->oi_no}}"/>
                        <input type="submit" name="delete_all" class="btn btn-danger" value="Delete All">
                    </form>
                        
                    </div>
                
                <div class="col d-flex justify-content-end">
                        <form action="" method="POST">
                             <input type="submit" class="btn btn-success" value="Confirm">
                             
                            </form>
                    
                </div>
            </div>

            
            </div>
        </div>

    @endif







    

@endsection
@section('scripts')
<script>
$(document).ready(function(){


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


        
    });


    $('#search').dblclick(function(event) {

        $.ajax({
                url:"{{ route('admin.doubleclick') }}",
                method:"GET",
                success:function(data){
                    $('#itemList').fadeIn();
                    $('#itemList').html(data);
                }
            });


    });


    


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


 var result = [];
  $('table tr').each(function(){
  	$('td', this).each(function(index, val){
    	if(!result[index]) result[index] = 0;
      result[index] += parseInt($(val).text());
    });
  });
  console.log(result);
 
 $('table[id^=tab_]').append('<tr></tr>');
 $('table[id^=tab_] tr').last().append('<td colspan="4">'+'<strong>'+"Total:"+'</strong>'+'</td>');
 $('table[id^=tab_] tr').last().append('<td>'+'<strong>'+result[4]+'</strong>'+'</td>');
 $('table[id^=tab_] tr').last().append('<td>'+'</td>');
 $('table[id^=tab_] tr').last().append('<td>'+'<strong>'+result[6]+'</strong>'+'</td>');
 $('table[id^=tab_] tr').last().append('<td>'+'</td>');




 $('#customer').hide();
 $('#issue_type').click(function() {

    
    if($(this).val() =='Local Sales') {
        $('#customer').show();
        // $('#vendor_label').text('Vendor Name');
        $('#customer').html('<label class="col-sm-3 col-form-label">Customer Name</label><div class="col-sm-9"><input type="text" name="vendor_name" class="form-control" value="{{ isset($wor) ? $wor->issued_to : '' }}"></input></div>'
        
        );
    }
    
    else if($(this).val() == 'Customer Sales') {
        
        
        $.ajax({
            type:'GET',
            url:"{{ route('admin.customer') }}",
            
            success: function(response) {
                $('#customer').show();
                console.log(response);
                $('#customer').html(response);
                
               
                
            },
            error: function() {
                alert('error');
                alert(error);
            }
        });


    }

    else if($(this).val() =='Other Issue') {
        $('#customer').show();
        
        $('#customer').html('<label class="col-sm-3 col-form-label">Issue To</label><div class="col-sm-9"><input type="text" name="vendor_name" class="form-control" value="{{ isset($wor) ? $wor->issued_to : '' }}"></input></div>'
        
        );
    }

 });

 $(window).on('load', function() {

    
 if($('#issue_type').val() =='Local Sales') {
      $('#customer').show();
     // $('#vendor_label').text('Vendor Name');
     $('#customer').html('<label class="col-sm-3 col-form-label">Customer Name</label><div class="col-sm-9"><input type="text"  name="vendor_name" class="form-control" value="{{ isset($wor) ? $wor->issued_to : '' }}"></input></div>'
      
      );
  }


  else if($('#issue_type').val() == 'Customer Sales') {
    
    var ab = $("#vendor_name").val();
    console.log(ab);
    
    $.ajax({
            type:'GET',
            url:"{{ route('admin.customer') }}",
        
            success: function(response) {
                $('#customer').show();
            
                $('#customer').html(response);
                $("div#customer select#vendor_name option").each(function(){
                    console.log($(this).text());
        if($(this).text()==ab){ 
            $(this).attr("selected","selected");    
        }
    });

               
                
            },
            error: function() {
                alert('error');
                alert(error);
            }
        });

       
    }

  else if($('#issue_type').val() =='Other Issue') {
      $('#customer').show();
    
    $('#customer').html('<label class="col-sm-3 col-form-label">Issue To</label><div class="col-sm-9"><input type="text"  name="vendor_name" class="form-control" value="{{ isset($wor) ? $wor->issued_to : '' }}"></input></div>'
      
      );
  }

 });












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




