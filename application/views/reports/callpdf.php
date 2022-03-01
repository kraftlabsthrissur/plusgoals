<html>
    <head>
        <title>FSO Daily Report</title>
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
            .table_head_row th {
                border-left: 1px solid black;
                border-right: 1px solid black;
                text-align: center;  
            }
            .table_body_row td {
                border-left: 1px solid black;
                border-right: 1px solid black;
                border-bottom: 1px solid black;
                text-align: center;   
            }
            .table_body_row  {
                border-bottom: 1px solid black; 
            }
            table .prescribing , .sample {
                border-right: 1px solid black; 
            }
            .table_foot_row tr{
                border-bottom: 2px solid black;
                border-right: 1px solid black;
                border-left: 1px solid black;
            }
            .td_prescribing , .td_sample {
                border-right: 1px solid black;
                display: table-cell;
                padding: 2px;
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



        <h3><?php echo isset($report_head1) ? $report_head1 : " "; ?></h3>
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
                    <b>Area Of Working:</b>   <?php echo isset($result[0]['role_name']) ? $result[0]['role_name'] : " "; ?>
                </td> 
                <td style="width:20%;">
                    <b>HQ:</b>  <?php echo isset($order_date) ? $order_date : " "; ?>
                </td> 
            </tr>
            <tr>                

                <td style="width:30%">
                    <b>Date :</b>  <?php echo date('Y-m-d'); ?>
                </td> 
                <td></td>
                <td></td>
            </tr>
        </table>
        <br/>
        <div class="row">
            <label>(A) Customer call :-</label>
        </div>
        <table >
            <thead>
                <tr class="table_head_row">
                    <th>S.No</th>
                    <th>Name of the Customer</th>
                    <th>Customer Type</th>
                    <th>Product Prescribing</th>
                    <th>Sample Given</th>
                    <th>Amount of Order Booked</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                if (isset($result) && $result != "") {
                    foreach ($result as $key => $value) {
                        
                            ?>
                            <tr class="table_body_row">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $value['smStoreName']; ?></td>
                                <td><?php echo $value['customer_group']; ?></td>
                                <td class="prescribing">
                                    <?php
                                       
                                       echo $value['prescribing_product'];
                                    ?>
                                </td>
                                <td class="sample">

                                    <?php
                                   
                                       echo $value['sample'];
                                    ?>      
                                </td>
                                <td> <?php echo $value['order_booked']; ?> </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
             
                ?>
            </tbody>      
            <tfoot class="table_foot_row">
                <tr>
                    <td>Today Total :-</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Till Date Total :-</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>

        </table>

        <br/>
        <div class="row">
            <label>(B) Dealer/Retailer Call</label>
        </div>
        <br/>
        <table>
            <thead>
                <tr class="table_head_row">
                    <th>S.No</th> 
                    <th>Name</th> 
                    <th>Proposed Target</th> 
                    <th>Achievement Till Date</th> 
                    <th>P.O.B</th> 
                </tr> 
            </thead>
            <tbody class="table_body_row">

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

            </tbody>
        </table>
        <br/> 
        <table style="width:100%;">

            <tr> 
                <td style="width:50% ;"> (C) Outstanding :</td> 
                <td> > 30 Days Rs.</td> 
            </tr>
            <tr>
                <td> (D) Total Target For The Month Rs :</td>
                <td></td>
            </tr>
            <tr>
                <td>  Till Date Achievement Rs :</td>
                <td></td>
            </tr>
            <tr>
                <td> (E)New Dealer </td>
                <td></td>
            </tr>
            <tr>
                <td style="width: 45%;"> Proposed :</td>
                <td style="width: 45%;"> Started :</td> 
            </tr>
            <tr>
                <td>(F) Competitor Activity :</td>
                <td></td>
            </tr>
            <tr>
                <td>(G) Suggestions For Improving Sales :</td>
                <td></td>
            </tr>
        </table> 

    </body>

</html>

