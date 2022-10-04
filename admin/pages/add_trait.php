<?php

function add_traits() 
{
    $add_assessment=$_REQUEST['assignment_name'];
    $type=$_REQUEST['type'];
    $admin_url=admin_url();
    ?>
    
        <form name="add_trait" id="add_trait">
            <div class="add_trait-input">
                <input type="hidden" name="admin_url" value="<?php echo $admin_url; ?>" required readonly>
                <input type="hidden" name="assignment_name" value="<?php echo $add_assessment; ?>" required readonly>
                <input type="hidden" name="type" value="<?php echo $type; ?>" required readonly>
                <label>Trait Name</label>
                <input type="text" name="trait_name" value="" required>
            </div>
                <ul class="scale-button">
                    <li id="scale_5_point">5 point likert scale</li>
                    <!--<li id="scale_3_point">3 point likert scale</li>-->
                </ul>
            <div class="formdata"></div>
            <div class="global_sub_btn">
                <input type="submit" name="submit" value="submit">
            </div>
        </form>
    
    <?php
    
    
}
  
  
 