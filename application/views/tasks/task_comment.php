<?php
/**
 * @author ajith
 * @date 28 Mar, 2017
 */
?>
<?php
if ($comments) {
    foreach ($comments as $key => $value) {        
        ?>
        <div class="row ">
            <div class="col-xs-8 <?php echo ($value['user_id'] == $user_id) ? "pull-right right" : "pull-left left"; ?>">
                <div class="meta">
                    <small><?php 
                    $date = date('d-m-Y h:i A',strtotime($value['date']));
                    echo $value['umFirstName'] . ' ' . $value['umLastName'] . ' wrote on ' . $date; ?></small>
                </div>
                <div class="data">
                    <p><?php echo $value['comment']; ?></p>
                    <span>Task Completion : <?php echo $value['perc_of_completion']; ?>%</span>
                    <?php
                   // if(sizeof($attached_files) > 1){
                    if($attached_files > 0){ 
                        foreach ($attached_files as $key1 => $file) { 
                           if($file['task_comment_id'] == $value['task_comment_id']) { ?>
                             <div class ="file">
                                <a href="<?php echo $file['file_path'].'/'.$file['file_name']  ?>" target = '_blank'>
                                  <?php echo $file['file_name']  ?>
                                </a>
                            </div>                                                  
                        <?php 
                            }
                        }
                    } ?>
                </div>                
            </div>
        </div>
        <?php
    }
}
?>