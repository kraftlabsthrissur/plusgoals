<section class="content-header">
    <h1>
        Users
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
    </ol>
</section>

<!-- Main content -->
<section id="content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-xs-8">
                        <h3 class="box-title">All Users</h3>
                    </div>

                </div><!-- /.box-header -->
                <div id="main_content">
                    <h4><?php echo ($this->session->flashdata('item')); ?></h4>
                </div>
                <div class="box-body table-responsive">
                    <div class="row">
                        <form class="ajax-submit" method="post" action="messages/list_user">
                        <div class="col-xs-12">
                          
                        <div class="col-xs-2">
                            <label>Select Manager</label>
                            <select class="form-control filtered_role" name="user_name" >
                                <option >Select Manager</option>
                                <?php echo $manager ;?>
                            </select>
                        </div>       
                        <div class="col-xs-2" style="height:59px !important">
                            <input type="submit" class="btn btn-primary"  value="Filter" style="position: absolute;bottom: 0px;">
                        </div>
                        </div>
                        </form>
                    </div>
                    <br/>
                    
                    <table id="users" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="select_users">
                                    <input type="checkbox" id="select_all_users"/>Select
                                </th>
                                <th class="code">
                                    ID
                                </th>
                                <th class="Name">
                                    User Name
                                </th>
                                <th class="Role">
                                    Designation
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($table_data) {
                                $k = 1;
                                foreach ($table_data as $row => $value) {
                                    ?>
                                    <tr class="">
                                        <td><input type="checkbox" class="select_checkbox" name="select_user[]" value="<?php echo $value['umid']; ?>"/></td>
                                        <td><?php echo $k; ?></td>
                                        <td><?php echo $value['umUserName']; ?></td>
                                        <td><?php echo $value['role_name']; ?></td>

                                    </tr>
                                    <?php
                                    $k++;
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        </tfoot>

                    </table>

                    <button class="btn btn-primary send_message" id="select_user_message">Send Message</button>

                </div>

            </div>
            <div class="modal fade in message_form" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title"><i class="fa fa-laptop"></i> Message</h4>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="list box box-info">
                                    <div class="items box-body" id="message"> 
                                        <div class="row">
                                            <div class="col-xs-6" > 
                                                <label>Message</label>
                                                <textarea class="form-control message_head" name="meassage_head"></textarea>
                                                <input type="hidden" class="form-control select_user_id" value="">
                                            </div>
                                            <div class="col-xs-6">
                                                <label>Message Content</label>
                                                <textarea class="form-control message_content" name="meassage_content"></textarea>
                                            </div>     
                                        </div>
                                    </div>
                                    <div class="modal-footer clearfix">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="close" >
                                            <i class="fa fa-times"></i> Cancel
                                        </button>
                                        <button type="button" class="btn btn-primary pull-left" id="send_message" >
                                            <i class="fa fa-check"></i> Ok
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  

    </div>
</div>
</section>



<script type="text/javascript">
    $(function () {
        $('#users').dataTable({
            "bInfo": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true
        });
   });

</script>


