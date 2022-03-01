<?php
/**
 *
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2014, Ajith Vp <ajith@kraftlabs.com>
 *            @date 03-Jan-2015
 */
?>
<table id="salesorders"
       class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th><input type="checkbox" class="select-all" /></th>
            <th>View</th>
            <th>Date</th>
            <th>SO No.</th>
            <th>Net Amt</th>
            <th>Div. Name</th>
            <th>Status</th>
            <th>Customer</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result != '' && $result->num_rows() > 0) {
            foreach ($result->result() as $result) {
                ?>
                <tr>
                    <td><input type="checkbox" class="select" /></td>
                    <td><a id='<?php echo $result->sosID; ?>'
                           href="<?php echo base_url() . '#salesorder/edit_sales_order/' . $result->sosID; ?>">View</a>
                    </td>
                    <td><?php echo $result->sosBillDate; ?></td>
                    <td><?php echo $result->sosSONo; ?></td>
                    <td><?php echo $result->sosNetAmount; ?></td>
                    <td><?php echo $result->sosDivisionName; ?></td>
                    <td><?php echo $result->OrderStatus; ?></td>
                    <td><?php echo $result->smStoreName; ?></td>
                    <td><?php echo $result->IsDownloaded; ?></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr class="no-data">
                <td>No Records found</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
        }
        ?>

    </tbody>
</table>
<script type="text/javascript">
    $(function () {
        $('#salesorders').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
            "aaSorting": [[1, "desc"]],
            "aoColumns": [
                {"bSortable": false}, 
                {"bSortable": false},
                {"bSortable": true},
                {"bSortable": true},
                {"bSortable": true},
                {"bSortable": true},
                {"bSortable": true},
                {"bSortable": true},
                {"bSortable": true},
            ]
        });
    });
</script>
