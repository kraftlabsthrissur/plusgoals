<?php
/**
 * @author ajith
 * @date 29 Mar, 2017
 */

if ($files) {
    foreach ($files as $key => $value) {
        ?>
        <div class='file'>
            <a href="<?php echo $value['file_path'].'/'.$value['file_name']  ?>" >
                <?php echo $value['file_name']  ?>
            </a>            
        </div>
        <?php         
    }
}
?>


