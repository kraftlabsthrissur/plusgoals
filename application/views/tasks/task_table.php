<table id="<?php echo $id; ?>" class="table table-bordered table-striped table-hover tasks" style="width:100%;">
    <thead>
        <tr>
            <th>
                Task Date
            </th>
            <th>
                Due Date
            </th>
            <th>
                Created Date
            </th>
            <th style="width: 150px;">
                Task
            </th>
            <!-- <th style="width: 150px;">
                                    Description
                                </th> -->
            <th>
                Priority
            </th>
            <?php if ($assigned_by == "other") { ?>
            <th>
                Assigned To
            </th>
            <th>
                Assigned By
            </th>
            <?php } else if ($assigned_by == "me"){ ?>
            <th>
                Assigned To
            </th>
            <th>
                Assigned By
            </th>
            <?php } ?>
            <th>
                Status
            </th>
            <th>
                Percentage
            </th>
            <th>
                Actions
            </th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>