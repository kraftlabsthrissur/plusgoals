<?php
/**
 * @author ajith
 * @date 29 Mar, 2017
 */
if ($assigned_persons) {
    foreach ($assigned_persons as $key => $value) {
        ?>
        <div class="assigned" data-task-id="<?php echo $value['task_id']; ?>" data-group-ref="<?php echo $value['group_ref']; ?>" data-user-id="<?php echo $value['assigned_user_id']; ?>" >
        <?php echo $value['umFirstName'] . ' ' . $value['umLastName']; ?>
            <span class="remove-assigned-user">X</span>
        </div>
        <?php
    }
}
?>
