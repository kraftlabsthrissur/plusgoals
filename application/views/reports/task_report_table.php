<div class="box">
    <div class="box-header">
        <div class="col-xs-8">
            <h3 class="box-title">Report Table</h3>
        </div>

    </div><!-- /.box-header -->
    <div id="main_content">
        <h4><?php echo ($this->session->flashdata('item')); ?></h4>
    </div>
    <form  method="post" class="expense_report_pdf" action="<?php echo base_url(); ?>taskreport/generate_task_report">
        <input type="hidden" name="user_id" class="form-control date datepicker" value="<?php echo isset($form_data['user_id']) ? $form_data['user_id'] : ""; ?>">
        <input type="hidden" name="from_date" class="form-control date datepicker" value="<?php echo isset($form_data['from_date']) ? $form_data['from_date'] : ""; ?>">
        <input type="hidden" name="to_date" class="form-control date datepicker" value="<?php echo isset($form_data['to_date']) ? $form_data['to_date'] : ""; ?>">
        <div class="box-body table-responsive">
            <table id="tasks" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            Task Name
                        </th>
                        <th>
                            Task Description
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($table_data) && is_array($table_data)) {
                        foreach ($table_data as $row) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row['task_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['task_desc']; ?>
                                </td>

                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <br>
            <input type="submit" class="btn btn-primary " id="generate_task_report_pdf"  data-dismiss="modal" value="Export" >

        </div>
    </form>
</div>