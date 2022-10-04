<?php

function update_traits(){
    
    $add_assessment=$_REQUEST['assignment_name'];
    $type=$_REQUEST['type'];
    $trait=$_REQUEST['trait'];
    $assesment_id=$_REQUEST['assesment_id'];
    $admin_url=admin_url();
    global $wpdb;
    
    function get_trait_name($trait_id){
       global $wpdb;
       $traitname = $wpdb->prefix.'job_traits'; 
       $qry="select * from $traitname where id='$trait_id'";
       $result=$wpdb->get_results($qry, object);
       if(!empty($result)){
           return $result[0]->traits;
       }
       else{
           return"";
       }
    }
    $tablename = $wpdb->prefix.'job_traits';
    $jobedit_form = $wpdb->get_row("SELECT * FROM $tablename where id=$trait");
    $jobeditform=$jobedit_form->form_data;
    $jobeditform=unserialize($jobeditform);
    
    ?>
    <form name="update_trait" id="update_trait">
    <div class="add_trait-input">
    <input type="hidden" id="admin_url" name="admin_url" value="<?php echo $admin_url; ?>" required>
    <input type="hidden" name="trait_id" value="<?php echo $trait; ?>" required readonly>    
    <input type="text" name="assignment_name" value="<?php echo $add_assessment; ?>" required readonly>
    <input type="hidden" name="assesment_id" value="<?php echo $assesment_id; ?>" required readonly>
    <input type="text" name="type" value="<?php echo $type; ?>" required readonly>
    <label>Trait Name</label>
    <input type="text" name="trait_name" value="<?php echo get_trait_name($trait); ?>" required>
    </div>
        <ul class="scale-button">
            <li id="scale_5_point">5 point likert scale</li>
        </ul>
        <div class="formdata">
            <?php
            if(!empty($jobeditform)){
                foreach($jobeditform as $form){
                    ?>
                    <div class='scale_5_point_sec'><i class="fa fa-window-close close" aria-hidden="true"></i>
                       <div class="my-scale-input">
                            <label>Label</label>
                            <input type='text' name='label' class='label' value='<?php echo $form ? $form->label:'Label' ?>'>
                       </div>
                       <div class="my-scale-option">
                           <label>Options</label>
                                <div class='sortable-options-wrap'>
                                   <?php
                                   if(isset($form->values) && !empty($form->values)){
                                        $k=1;
                                        foreach($form->values as $values){
                                           ?>
                                            <input type='text' class='option-attr' name='options' value="<?php echo $values ? $values->label:'Value-$k' ?>">
                                           <?php
                                           $k++;
                                        }
                                   }
                                   ?>
                               </div>
                       </div>
                    </div>
                   <?php
                }
            }
            ?>
        </div>
    <div class="global_sub_btn">    
        <input type="submit" name="submit" value="submit">
    </div>
    </form>
    
	
    <?php
}
?>