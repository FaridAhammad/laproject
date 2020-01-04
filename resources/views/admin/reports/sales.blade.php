@extends('layouts.admin')
@section('content')
<div   class="container"   >
<form action="{{ route('admin.sales.store') }}" method="POST" enctype="multipart/form-data">

    @csrf
 
    <div class="w-25 float-left " style="padding-top: 15%; padding-left: 7%; " >
        <h4>Select Report</h4>

        <div class="radio">
            <label><input type="radio" name="report" value="Sales Report" >Sales Report</label>
        </div>
        <div class="radio">
            <label><input type="radio"  name="report" value="Advance Sales Report" checked>Advance Sales Report</label>
        </div>

    </div>


<div class=" float-right " style="padding: 3% 3%  5%; width: 65%">
    

        <div class="form-group row">
            <label for="item_name" class="col-sm-3 col-form-label font-weight-bold">Itam Name</label>
            <div class="col-sm-8"  style="position: relative">
                <input type="text" id="item_name" name="item_name" autocomplete="off" class="form-control border border-secondary">
                <div id="itemList" class="itemList" data-toggle="popover" style=" position: absolute; top: 100%; left: 0">

                </div>
            </div>

        </div>
        <div class="form-group row">
            <label for="item_sub_group" class="col-sm-3 col-form-label font-weight-bold">Item Sub Group</label>
                <div  class="col-sm-8">
                <select  class="form-control border border-secondary" id="item_sub_group" name="sub_item">
                    <option selected value=''>---Select 0ne----</option>
                    @foreach ($item_sub_group as $sub_item)

                <option value="{{ $sub_item->sub_group_id }}">{{ $sub_item->sub_group_name }}</option>
                        
                    @endforeach

               
                    

                </select>
                </div>


        </div>
        <div class="form-group row">
            <label for="item_group" class="col-sm-3 col-form-label font-weight-bold">Item Group</label>
            <div  class="col-sm-8">
                <select  class="form-control border border-secondary" id="item_group" name="item_group">
                    <option selected value=''>---Select 0ne----</option>
                    @foreach ($item_group as $item)
                <option value="{{ $item->group_id }}">{{ $item->group_name }}</option> 
                    @endforeach

               

                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="from" class="col-sm-3 col-form-label font-weight-bold">From</label>
            <div class="col-sm-8">
                <input type="text" class="form-control date border border-secondary" name="from">
            </div>
        </div>
        <div class="form-group row">
            <label for="to" class="col-sm-3 col-form-label font-weight-bold">To</label>
            <div class="col-sm-8">
                <input type="text" class="form-control date border border-secondary" name="to">
            </div>
        </div>
        {{-- <div class="form-group row">
            <label for="vendor_name" class="col-sm-3 col-form-label font-weight-bold">Vendor Name</label>
            <div  class="col-sm-8">
                <select  class="form-control border border-secondary" id="vendor_name" name="vendor">
                    <option selected value=''>---Select 0ne----</option>
                    @foreach ($vendor as $vendors)

                <option value="{{ $vendors->vendor_id }}">{{ $vendors->vendor_name }}</option>
                        
                    @endforeach

               
                </select>
            </div>

        </div> --}}
        <div class="form-group row">
            <label for="purchase_status" class="col-sm-3 col-form-label font-weight-bold">Sales Status</label>
            <div  class="col-sm-8">
            <select  class="form-control border border-secondary" name="sales">
                <option selected value=''>---Select 0ne----</option>

                    <option value="Opening Balance" >Opening Balance</option>
                    <option value="Local Sales" >Local Sales</option>
                    <option value="Vendor Sales" >Vendor Sales</option>
                    <option value="Other Receive" >Other Receive</option>


            </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="inventory_name" class="col-sm-3 col-form-label font-weight-bold">Inventory Name</label>
            <div class="col-sm-8">
                <input type="text" name="inventory" id="inventory_name" class="form-control border border-secondary"  autocomplete="off">
                
                
            </div>
            
        </div>
    
    <input type="submit" class=" col-sm-3 btn btn-info" value="Report" formtarget="_blank"> 

</div>

</form>

</div>



    
@endsection
@section('scripts')
<script>


$('#item_name').keyup(function(event){
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
                        $('#itemList').fadeIn(0);
                        $('#itemList').html(data);
                    }
                });
            }
        }
        
        });

        $('#item_name').dblclick(function () {
            $.ajax({
                url:"{{ route('admin.doubleclick') }}",
                method:"GET",
                success:function(data){
                    $('#itemList').fadeIn(0);
                    $('#itemList').html(data);
                }
            });
        });

        $(document).on('click', '#list', function(){
            $('#item_name').val($(this).text());
            $('#itemList').fadeOut(0);
        });

        $(document).click(function() {
            $('#itemList').fadeOut();
        });



       


</script>
@endsection