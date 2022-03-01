<?php
/**
 * @author ajith
 * @date 20 Feb, 2015
 */
?>
<div class="modal fade in" id="staff" tabindex="-1" role="dialog" aria-hidden="false" style="display: block;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-laptop"></i> Select User(s)</h4>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="list box box-info">

                        <div class="items box-body table-responsive" > 
                            <table  id = "users" class="table  table-bordered table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <th>
                                        </th>
                                        <th>
                                            User Code
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Role
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($table_data) {
                                        foreach ($table_data as $row) {
                                            ?>
                                            <tr>
                                                <td >
                                                    <input type="<?php echo $type; ?>" value="<?php echo $row['umId']; ?>">
                                                </td>
                                                <td >
                                                    <?php echo $row['umUserCode']; ?>
                                                </td>
                                                <td >
                                                    <?php echo $row['umFirstName'] . ' ' . $row['umLastName']; ?>
                                                </td>
                                                <td >
                                                    <?php echo $row['role_name']; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <input type="hidden" id="parent_hierarchy_id" value="<?php echo $parent_hierarchy_id; ?>"/>
                        <input type="hidden" id="hierarchy_id" value="<?php echo $hierarchy_id; ?>"/>
                        <button type="button" class="btn btn-danger close-btn" data-dismiss="modal"  >
                            <i class="fa fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="<?php echo $mode; ?> btn btn-primary pull-left" id="select-users"  >
                            <i class="fa fa-check"></i> Ok
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#right-content').on('click', '.modal .close, .modal .close-btn', function () {
        $('.modal').slideUp(800, function () {
            $('#staff.modal').remove();
        });
    });

    $(function () {
        $('#users').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true,
        });
    });

    $('.add-staff').on('click', function () {
        var selected_users = get_selected_users();
        if (selected_users === '') {
            alert('Please select Staff');
            return false;
        }
        var hierarchy_id = $('#hierarchy_id').val();
        var parent_hierarchy_id = $('#parent_hierarchy_id').val();
        var parent_hierarchy = $('.hierarchy_id[value="' + parent_hierarchy_id + '"]').closest('.hierarchy');
        $.ajax({
            url: base_url + 'privilege/add_staff',
            data: {
                'hierarchy_id': hierarchy_id,
                'parent_hierarchy_id': parent_hierarchy_id,
                'selected_users': selected_users
            },
            method: 'POST'
        }).success(function (response) {
            $('#right-content').html(response);
            draw_hierarchy();
        });

    });
    $('.change-staff').on('click', function () {
        var selected_users = get_selected_users();
        if (selected_users === '') {
            alert('Please select Staff');
            return false;
        }
        var hierarchy_id = $('#hierarchy_id').val();
        var parent_hierarchy_id = $('#parent_hierarchy_id').val();
        if (parent_hierarchy_id == '0') {
            var parent_hierarchy = $('.hierarchy-table');
        } else {
            var parent_hierarchy = $('.hierarchy_id[value="' + parent_hierarchy_id + '"]').closest('.hierarchy');
        }
        $.ajax({
            url: base_url + 'privilege/change_staff',
            data: {
                'hierarchy_id': hierarchy_id,
                'parent_hierarchy_id': parent_hierarchy_id,
                'selected_users': selected_users
            },
            method: 'POST'
        }).success(function (response) {
            $('#right-content').html(response);
            draw_hierarchy();
        });

    });
    function get_selected_users() {
        var selected = $('#users input:checked');
        var selected_users = '';
        $.each(selected, function () {
            selected_users += $(this).val() + ',';
        });
        return selected_users;
    }
</script>