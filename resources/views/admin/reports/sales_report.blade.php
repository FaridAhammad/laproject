<style>
   table, th, td {
     
     border-collapse: collapse;
     text-align: center;
   }
 
   table {
      border: 2px solid black;
   }
   th, td {
      border: 1px solid black; 
   }


th:after,
      th:before {
      content: "";
      position: absolute;
      left: 0;
      width: 100%;
      }

      th{
      position: -webkit-sticky;
      font: 15px "Trebuchet MS" ,Tahoma ;font-weight:bold ;font-style:normal;
      position: sticky;
      top: 0;
      background: #FFFFFF;
      padding: 6px 0;
      }
      th:before {
      top: -1px;
      border: 1px solid black;
      }
      
      th:after {
      bottom: -2px;
      border: 1px solid black;
      }
      tr:nth-last-child(-n+2){
      border-bottom: 2px solid black;
      
      }
      tr:last-child{
      font-weight: bold;
      }
    </style>
 
 <div style="display:flex; flex-direction:column;">
    <div style="display:flex; justify-content:center"><input type="submit" id="print" value="Print" style="display:block;"></div>
     <div style="display:flex; flex-direction:column;">
     <p style="display:flex; justify-content:center; font-size:25px; font-weight: bold; margin:5px;">M/H HOME TILES</p>
     <p style="display:flex; justify-content:center; margin:0; font-size:18px;">Sales Report</p>
     </div>
 
 </div>

 <div style="padding-top:10px;">
    <table style="width:100%">
       <tr>
         <th>S/L</th>
         <th>Group No</th>
         <th>Amount</th>
         
       </tr>
       
       <?php $num = 1;  $totalamount=0; $qty=0; ?>
       @foreach ($data as $Item)
       <tr>
       
          <td>{{$num}}</td>
          <td>{{$Item->oi_no}}</td>
          <td>{{$Item->sum}}</td>
      
 
       </tr>
      
          <?php $num++;; $totalamount+=$Item->sum ?>
       @endforeach
       <tr>
        <td style="text-align: center" colspan="2"> Total</td>
        
        
        <td > {{ number_format($totalamount, 2) ?? 0}}</td>
        
        
        </tr>
     </table>
     
 </div>

 
 <script src="{{asset('JS')}}/jquery.min.js"></script>
 <script src="{{asset('JS')}}/bootstrap.min.js"></script>
 <script>
 $('#print').click(function() {
    window.print();
 });
 </script>


 