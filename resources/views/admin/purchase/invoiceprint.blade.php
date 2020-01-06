<html>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">

    <style type="text/css">
        td, td, th{
            font:bold 11px "Trebuchet MS" ,Tahoma ; color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none

        }
        th{
            border: 1px solid;

        }
        .br-r{
            border-right: 1px solid;
        }
        .heig{
            height: 30px;
            !important;
        }


        <!--

    </style>
    <link href="{{asset('CSS')}}/bootstrap.min.css" rel="stylesheet" />
    <link href="{{asset('CSS')}}/font-awesome.css" rel="stylesheet" />

</head>
<body class="responsive" style="background-color: #9fcdff; margin: 0 auto; width: 880px; height: 1024px; margin: 20px auto ; position: relative" >
<div style="background-color: white;  " class=" w-100; h-100">
    <h3 style="padding-top: 10%; padding-left: 30%; text-align: center; "><u>Bill_________________</u></h3>

    <div style="margin-top:30px; padding-left: 10px">
        <table style=" width: 50%;  float: left">
            <tr style=" text-align: center">
                <td >Name   :</td>
                <td>{{$whor->vendor_name}}</td>
            </tr>
            <tr style="text-align: center">
                <td >Address:</td>
                <td>Plot # 5/2, Road # 01</td>
            </tr>

        </table>
        <table style=" width: 49%">
            <tr style="text-align: center">
                <td style="">VP NO  :</td>
                <td>{{$whor->or_no}}</td>
            </tr>
            <tr style="text-align: center">
                <td style="">Date    :</td>
                <td>{{$whor->or_date}}</td>
            </tr>
        </table>

    </div>
    <div style="margin-top: 60px; padding: 0 10px; ">
        <table class="" style="border: 1px solid; width: 100%; height: 50%; ">

            <tr style="text-align: center" class="heig">
                <th>SL#</th>
                <th>Qty</th>
                <th> Unit Price In TK</th>
                <th> Discount</th>
                <th> Total Price In TK</th>
            </tr>


            <?php $sl=1; $sum=0;?>
 @foreach($whord as $invoice)
            <tr style="text-align: center;" class="heig">
                <td class="br-r">{{$sl}}</td>
                <td class="br-r">{{$invoice->qty}}</td>
                <td class="br-r">{{$invoice->rate}}</td>
                <td class="br-r">{{$invoice->discount}}</td>
                <td class="br-r">{{$invoice->amount}}</td>
            </tr>

     <?php $sl++; $sum+=$invoice->amount?>

            @endforeach
            <tr >
                <td class="br-r"></td>
                <td class="br-r"></td>
                <td class="br-r"></td>
                <td class="br-r"></td>
                <td class="br-r"></td>

            </tr>

            <tr style="border: 1px solid" class="heig">
                <td colspan="4" class="br-r heig">Total</td>
                <td style="text-align: center">{{$sum.'TK'}}</td>
            </tr>


        </table>


    </div>
    <div style="position: absolute; bottom: 150px; left: 50px;">
        <h6 style="opacity: 0.9">Customer's Signature
            with seal</h6>

    </div>
    <div style="position: absolute; bottom: 100px; right: 50px;">
        <h3 style="opacity: 0.5">Logical Triangle Ltd</h3>

    </div>





</div>

<script src="{{asset('JS')}}/jquery.min.js"></script>
<script src="{{asset('JS')}}/bootstrap.min.js"></script>


</body>
</html>
