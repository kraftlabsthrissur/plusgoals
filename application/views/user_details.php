<?php
/**
 * @author Ajith Vp <ajith@kraftlabs.com>
 * @copyright Copyright (c) 2014, Ajith Vp <ajith@kraftlabs.com>
 * @date 12-Jan-2015
 */
?>
<table id="userResult" class="table table-bordered table-striped table-hover" >
    <thead>
        <tr>
            <th >User Name</th>
            <th >User Code</th>

        </tr>
    </thead>
    <tbody>
        <?php
        if ($result != '' && $result->num_rows() > 0) {
            foreach ($result->result() AS $result) {
                ?>
                <tr>
                    <td class="first">
                        <input type="hidden" value="<?php echo $result->umId; ?>" /><?php echo $result->userName; ?></a>
                    </td>
                    <td class="second"><?php echo $result->umUserCode; ?></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="8"> No Results found
                </td>
            </tr>
            <?php
        }
        ?>

    </tbody>
</table>
<script type="text/javascript">
    if ($('#userResult tbody tr td').length > 1) {
        $(function () {
            $('#userResult').dataTable({
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