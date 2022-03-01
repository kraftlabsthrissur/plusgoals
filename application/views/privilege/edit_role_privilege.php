<?php
/**
 * @author ajith
 * @date 11 Feb, 2015
 */
?>
<section class="content-header">
    <h1>
        Edit Role Privilege
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>#privilege/list_roles"><i class="fa fa-laptop"></i> Role</a></li>
        <li class="active">Edit Role Privilege</li>
    </ol>
</section>

<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">Edit Role Privileges</h3>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">

                    <form  method="post" class="ajax-submit" action="privilege/edit_default_role_privilege/<?php echo $form_data['role_id']; ?>" >
                        <div class="row">
                            <div class="col-xs-10">
                                <div class="row">
                                    <div class="col-xs-2">
                                        Role Name
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="text"  class="required form-control" name="role_name" readonly="" value="<?php echo @$form_data['role_name']; ?>" />
                                        <?php echo @$error['role_name']; ?>
                                    </div>

                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">

                                    </div>
                                    <div class="col-xs-4">
                                        <select name="not-added" id="not-added" class="form-control" multiple="multiple" style="min-height: 300px;">
                                            <?php echo $actions_not_added; ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-1">
                                        <button class="form-control btn btn-primary" id="add-all"><i class="fa fa-angle-double-right"></i></button>
                                        <br/>
                                        <br/>
                                        <button class="form-control btn btn-primary" id="add"><i class="fa fa-angle-right"></i></button>
                                        <br/>
                                        <br/>
                                        <button class="form-control btn btn-warning" id="remove"><i class="fa fa-angle-left"></i></button>
                                        <br/>
                                        <br/>
                                        <button class="form-control btn btn-warning" id="remove-all"><i class="fa fa-angle-double-left"></i></button>
                                    </div>
                                    <div class="col-xs-4">
                                        <select name="added" id="added" class="form-control" multiple="multiple" style="min-height: 300px;">
                                            <?php echo $actions_added; ?>
                                        </select>
                                        <input type="hidden" name = 'added_actions' value="<?php echo @$form_data['added_actions']; ?>" id='added_actions' />
                                    </div>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-2">
                                    </div>
                                    <div class="col-xs-4">
                                        <input type="submit" class="btn btn-primary"   Value="Save"/>
                                        <input type="reset" class="btn btn-warning"  Value="Reset"/>
                                        <input type="hidden"  name="role_id" Value="<?php echo @$form_data['role_id']; ?>"/>
                                    </div>
                                </div>
                                <br/>
                            </div>
                        </div>                     
                    </form>
                </div><!--tablecontent-->
            </div><!--subcontent-->
        </div>
    </div>
</section>
<script type="text/javascript">
    $('#content').on('click', '#add', function () {
        var selected = $('#not-added option:selected');
        var optgroup_label;
        var optgroup_added;
        $.each(selected, function () {
            optgroup_label = $(this).parent('optgroup').attr('label');
            optgroup_added = $('#added').find('optgroup[label="' + optgroup_label + '"]');
            if (!optgroup_added.length) {
                $('#added').append('<optgroup label="' + optgroup_label + '"></optgroup>');
            }
            optgroup_added = $('#added').find('optgroup[label="' + optgroup_label + '"]');
            $(this).remove().appendTo(optgroup_added);
        });
        set_added_actions();
        return false;
    });
    $('#remove').click(function () {

        var selected = $('#added option:selected');
        var optgroup_label;
        var optgroup_added;
        $.each(selected, function () {
            optgroup_label = $(this).parent('optgroup').attr('label');
            optgroup_added = $('#not-added').find('optgroup[label="' + optgroup_label + '"]');
            if (!optgroup_added.length) {
                $('#not-added').append('<optgroup label="' + optgroup_label + '"></optgroup>');
            }
            optgroup_added = $('#not-added').find('optgroup[label="' + optgroup_label + '"]');
            $(this).remove().appendTo(optgroup_added);
        });
        set_added_actions();
        return false;
    });
    $('#remove-all').click(function () {
        var selected = $('#added option');
        var optgroup_label;
        var optgroup_added;
        $.each(selected, function () {
            optgroup_label = $(this).parent('optgroup').attr('label');
            optgroup_added = $('#not-added').find('optgroup[label="' + optgroup_label + '"]');
            if (!optgroup_added.length) {
                $('#not-added').append('<optgroup label="' + optgroup_label + '"></optgroup>');
            }
            optgroup_added = $('#not-added').find('optgroup[label="' + optgroup_label + '"]');
            $(this).remove().appendTo(optgroup_added);
        });
        set_added_actions();
        return false;
    })
    $('#add-all').click(function () {
        var selected = $('#not-added option');
        var optgroup_label;
        var optgroup_added;
        $.each(selected, function () {
            optgroup_label = $(this).parent('optgroup').attr('label');
            optgroup_added = $('#added').find('optgroup[label="' + optgroup_label + '"]');
            if (!optgroup_added.length) {
                $('#added').append('<optgroup label="' + optgroup_label + '"></optgroup>');
            }
            optgroup_added = $('#added').find('optgroup[label="' + optgroup_label + '"]');
            $(this).remove().appendTo(optgroup_added);
        });
        set_added_actions();
        return false;
    });
    $('#content').on('click', 'optgroup:not(option)', function (e) {
        e.preventDefault();
        if (e.target.localName !== 'option') {
            $(this).children().attr('selected', 'selected');
        }
        return false;
    });
    function set_added_actions() {
        var selected = $('#added option');
        var actions = '';
        $.each(selected, function () {
            actions += $(this).val() + ',';
        });
        $('#added_actions').val(actions);
    }
</script>
