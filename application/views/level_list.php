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
            <th >Level Name</th>
            <th >View</th>
            <th >Insert</th>
            <th >Update</th>

        </tr>
    </thead>
    <tbody>
        <?php
        if ($result != '' && $result->num_rows() > 0) {
            foreach ($result->result() AS $result) {
                ?>
                <tr>
                    <td class="first">
                       <?php echo $result->slmLevelName; ?></a>
                    </td>
                    <td class="second"><?php echo $result->slmView; ?></td>
                    <td class="second"><?php echo $result->slmInsert; ?></td>
                    <td class="second"><?php echo $result->slmUpdate; ?></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="4"> No Results found
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