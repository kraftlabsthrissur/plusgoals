<html>
    <head>
        <title>Expense Statement</title>
        <style type="text/css">

            label{
                padding: 5px 5px 0px 5px;
                font-weight: bold;
                display: block;
            }
            p{
                width: 100%;
                padding: 5px;
                font-size: 120%;
                margin: 0px;
            }
            table{
                width: 100%;
            }

            table, tr, td{
                border-collapse:collapse;
                vertical-align: baseline;
            }
            h1, h2 , h4, h3{
                text-align: center;
                font-weight: bold;
            }
            th{
                border-bottom:2px solid #000;
                border-top:2px solid #000;
            }
            .numeric {
                text-align:right;
            }
            .table_head_row th{
                border-left: 1px solid black;
                border-right: 1px solid black;
                text-align: center;  
            }
            .table_body_row td{
                border-left: 1px solid black;
                border-right: 1px solid black;
                border-bottom: 1px solid black;
                text-align: center;   
            }
            .table_body_row{
                border-bottom: 2px solid black; 
            }
           
            .logo_image{
                text-align: center;
                display: block;
               margin-left: auto;
                margin-right: auto;
                filter: gray; /* IE6-9 */
                filter: grayscale(1); /* Microsoft Edge and Firefox 35+ */
                -webkit-filter: grayscale(1);
                
            }
            img{
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        
        <div class="logo_image"><img  src="file://<?php echo $_SERVER["DOCUMENT_ROOT"];?>/vaidyaratnamcrm/images/logo.gif"></div>
        
        <h2><?php echo isset($company_name) ? $company_name : " "; ?></h2>
        <h4><?php echo isset($company_address) ? $company_address : " "; ?></h4>
        <h3><?php echo isset($order_name) ? $order_name : " "; ?></h3>
        <br>
        <table style="width:100%;">
            <tr>

                <td style="width:50% ;"> 
                    <b>Name:</b>  <?php echo isset($result[0]['umUserName']) ? $result[0]['umUserName'] : " "; ?>
                </td> 

                <td style="width:30%;" >
                    <b>Designation:</b>   <?php echo isset($result[0]['role_name']) ? $result[0]['role_name'] : " "; ?>
                </td> 
                <td style="width:20%;">
                    <b>HQ:</b>  <?php echo isset($order_date) ? $order_date : " "; ?>
                </td> 
            </tr>
            <tr>                
                <td style="width:30%;">
                    <b>Month :</b>  <?php echo date('F-Y'); ?>
                </td> 

                <td style="width:40%;">

                </td>
                <td style="width:30%">
                    <b>Date :</b>  <?php echo date('Y-m-d'); ?>
                </td> 
            </tr>
        </table>
        <br/>
        <table >
            <tr class="table_head_row">
                <th>Date</th>
                <th>Town Visited</th>
                <th>DA</th>
                <th>TA</th>
                <th>Lodge</th>
                <th>Courier</th>
                <th>Sundries</th>
                <th>Total</th>
            </tr>

            <?php
            if (isset($result) && $result != "") {
                foreach ($result as $key => $value) {
                   ?>
                    <tr class="table_body_row">
                        <td><?php echo $value['date']; ?></td>
                        <td><?php echo $value['town_visited']; ?></td>
                        <td><?php echo $value['da']; ?></td>
                        <td><?php echo $value['ta']; ?></td>
                        <td><?php echo $value['lodge']; ?></td>
                        <td><?php echo $value['courier']; ?></td>
                        <td><?php echo $value['sundries']; ?></td>
                        <td><?php echo $value['total']; ?></td>

                    </tr>
               <?php } 
             } ?>
         <br>
        <br>
    </table> 
    <table style="width:100%;">
        <tr>
            <td style="width:40%;">Checked by ASM</td>
            <td style="width:40%;">Verified by Marketing Dept.</td>
            <td style="width:20%;"> Accounts Dept. </td>
            <td></td>
        </tr>
   </table> 

</body>
</html>

