<?php

function edit_assessment() 
{
    $id=$_REQUEST['id'];
    if($id!='')
    {
       global $wpdb;
       $assessment = $wpdb->prefix.'job_assesments'; 
       $qry="select * from $assessment where id=$id";
       $result=$wpdb->get_results($qry, object);
       $job_trait = $wpdb->prefix.'job_traits';
       $qry="select * from $job_trait  order by id desc";
       $traits_data=$wpdb->get_results($qry, object);
       $admin_url=admin_url();
       
       if(!empty($result)){
        ?>
        <form class="edit_assesment_form" id="edit_assesment_form" name="edit_assesment_form">
            <input type="hidden" name="admin_url" value="<?php echo $admin_url; ?>" required readonly>
            <input type="hidden" id="assesment_id" name="assesment_id" value="<?php echo $id; ?>" required>
            <h2>Update Assessment</h2>
            <div class="at-job-field"> 
                <div class="at-job-field-input">
                 <label>Name</label>
        	     <input type="text" id="asssement_name" name="name" value="<?php echo $result[0]->name; ?>" required>
        	    </div>
            	<div class="at-job-field-input">
            	     <label>Type</label>
                	 <select name="assessment_type" class="assessment_type" id="assessment_type">
                	     <option value="">Select type</option>
                	     <option value="Personality Trait Assessment" <?php if($result[0]->type=='Personality Trait Assessment') { echo"selected"; } ?> >Personality Trait Assessment</option>
                	     <option value="Reasoning Assessment" <?php if($result[0]->type=='Reasoning Assessment') { echo"selected"; } ?>>Reasoning Assessment</option>
                	     <option value="Others" <?php if($result[0]->type=='Others') { echo"selected"; } ?>>Others</option>
                	 </select>
                </div>
                <div id="traits" style="display:none">
                 <div class="traits_click"><span onclick="update_trait('<?php echo $admin_url; ?>')">Update Traits</span></div>
                     <div class="at-job-field-input">
                	      <label>Traits</label>
                    	  <select name="traitsdata" class="traitsdata" id="traitsdata" required disabled>
                    	     <option value="">Select Traits</option>
                    	     <?php
                    	     foreach($traits_data as $traits){
                    	         ?>
                    	         <option value="<?php echo $traits->id; ?>" <?php if($result[0]->traits==$traits->id) { echo"selected"; } ?>><?php echo $traits->traits; ?></option>
                    	         <?php
                    	     }
                    	     ?>
                    	 </select>
                    </div>
                </div>
            </div>
            <div class="global_sub_btn">
            <input type="submit" name="submit" value="Update">
            </div>
        </form>
        
    <script>
	jQuery(document).ready(function(){
        
            var astype=jQuery('#assessment_type').val();
            if(astype=='Personality Trait Assessment'){
                    jQuery('#traits').css({"display":"block"});
                    jQuery('#traitsdata').removeAttr('disabled');
                }
                else{
                     jQuery('#traits').css({"display":"none"});
                }
       
            jQuery('.assessment_type').on('change', function() {
            var type=this.value;
            if(type=='Personality Trait Assessment'){
                jQuery('#traits').css({"display":"block"});
                jQuery('#traitsdata').removeAttr('disabled');
            }
            else{
                 jQuery('#traits').css({"display":"none"});
            }
        });
    });
    
		
	</script>
    <?php
       }
    }
}

?>