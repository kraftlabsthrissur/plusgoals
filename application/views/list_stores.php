<?php
/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2014, Ajith Vp <ajith@kraftlabs.com>
 * @date 03-Jan-2015
 */
?>
<table id="storeResult" class="table table-bordered table-striped table-hover" >
    <thead>
        <tr>
            <td>Store Name</td>
            <td>Store Code</td>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result != '' && $result->num_rows() > 0) {
            foreach ($result->result() AS $result) {
                ?>
                <tr>
                    <td class="first">
                        <input type="hidden" class="smId"  value="<?php echo $result->smId; ?>" />
                        <input type="hidden" class="CustomerPriceGroup" value="<?php echo @$result->CustomerPriceGroup; ?>" />
                        <?php echo $result->smStoreName; ?>
                    </td>
                    <td class="second">
                    
                        <?php echo $result->smStorecode; ?>
                    </td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="2"> No Results found
                </td>
            </tr>
            <?php
        }
        ?>

    </tbody>
</table>
<script type="text/javascript">
    if ($('#storeResult tbody tr td').length > 1) {
        $(function () {
            $('#storeResult').dataTable({
                "bInfo": true,
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": true,
                "bAutoWidth": true,
            });
        });
    }
</script>