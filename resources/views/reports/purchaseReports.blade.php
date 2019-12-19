
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
@extends('layouts.admin')
@section('content')
    <div   class="container"   >
            <div class="w-25 float-left " style="padding-top: 15%; padding-left: 7%; " >
                <h4>Select Report</h4>

                <div class="radio">
                    <label><input type="radio" name="optradio" >Purchase Report</label>
                </div>
                <div class="radio">
                    <label><input type="radio"  name="optradio" checked>Advance Purchase Report</label>
                </div>

            </div>


        <div class=" float-right " style="padding: 3% 3%  5%; width: 65%">
            <form>

                <div class="form-group row">
                    <label for="item_name" class="col-sm-3 col-form-label">Itam Name</label>
                    <div class="col-sm-8"  style="position: relative">
                        <input type="text" id="item_name" autocomplete="off" class="form-control"  placeholder="">
                        <div id="itemList" class="itemList" data-toggle="popover" style=" position: absolute; top: 100%; left: 0">

                        </div>
                    </div>

                </div>
                <div class="form-group row">
                    <label for="item_sub_group" class="col-sm-3 col-form-label">Item Sub Group</label>
                        <div  class="col-sm-8">
                        <select  class="form-control">
                            <option selected disabled>---Select 0ne----</option>

                        @foreach($item_sub_group as $igp)
                            <option value="" >{{$igp->sub_group_name}}</option>
                            @endforeach

                        </select>
                        </div>


                </div>
                <div class="form-group row">
                    <label for="item_name" class="col-sm-3 col-form-label">Item Group</label>
                    <div  class="col-sm-8">
                        <select  class="form-control">
                            <option selected disabled>---Select 0ne----</option>

                        @foreach($item_group as $ig)
                            <option >{{$ig->group_name}}</option>
                                @endforeach

                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="item_name" class="col-sm-3 col-form-label">From</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control date" id="item_name" placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="item_name" class="col-sm-3 col-form-label">To</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control date" id="item_name" placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="item_name" class="col-sm-3 col-form-label">Vendor Name</label>
                    <div  class="col-sm-8">
                        <select  class="form-control">
                            <option selected disabled>---Select 0ne----</option>

                        @foreach($vendor_name as $vn)
                                <option value="" >{{$vn->vendor_name}}</option>
                            @endforeach

                        </select>
                    </div>

                </div>
                <div class="form-group row">
                    <label for="item_name" class="col-sm-3 col-form-label">Purchase Status</label>
                    <div  class="col-sm-8">
                    <select  class="form-control">
                        <option selected disabled>---Select 0ne----</option>

                            <option value="" >Opening Balance</option>
                            <option value="" >Local Purchase</option>
                            <option value="" >Vendor Purchase</option>
                            <option value="" >Other Receive</option>


                    </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="item_name" class="col-sm-3 col-form-label">Inventory Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="item_name" placeholder="">
                    </div>
                </div>
            </form>
            <div><button type="button" name="report" class=" col-sm-3 btn btn-info">Report</button> </div>

        </div>

    </div>
@endsection
@section('scripts')
    <script type="text/javascript">

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



        // else if (event.which == '13') {
        //     alert('You pressed a "enter" key in somewhere');
        //     }

        });
        $('#item_name').dblclick(function () {

            $.ajax({
                url:"{{ route('admin.dblclick') }}",
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

