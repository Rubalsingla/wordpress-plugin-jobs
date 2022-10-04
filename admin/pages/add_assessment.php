<?php


function add_assessment(){
    
    global $wpdb;
    $job_trait = $wpdb->prefix.'job_traits';
    $qry="select * from $job_trait  order by id desc";
    $traits_data=$wpdb->get_results($qry, object);
    $admin_url=admin_url();
    
    ?>
    
    <form class="assesment_form" id="assesment_form" name="assesment_form">
        <input type="hidden" id="admin_url" name="admin_url" value="<?php echo $admin_url; ?>" required>
        <h2>Add Assessment</h2>
        <div class="at-job-field"> 
            <div class="at-job-field-input">
             <label>Name</label>
    	     <input type="text" id="asssement_name" name="name" value="" required>
    	    </div>
        	<div class="at-job-field-input">
        	     <label>Type</label>
            	 <select name="assessment_type" class="assessment_type" id="assessment_type">
            	     <option value="">Select type</option>
            	     
            	    <option value="Personality Trait Assessment">Personality Trait Assessment</option>
            	    <option value="Reasoning Assessment">Reasoning Assessment</option>
            	    <option value="Others">Others</option>
            	 </select>
            </div>
            <div id="traits" style="display:none">
                <div class="traits_click"><span onclick="add_trait('<?php echo $admin_url; ?>')">Add Traits</span></div>
                 <div class="at-job-field-input">
            	     <label>Traits</label>
                	 <select name="traitsdata" class="traitsdata" id="traitsdata" required disabled>
                	     <option value="">Select Traits</option>
                	     <?php
                	     foreach($traits_data as $traits){
                	         ?>
                	            <option value="<?php echo $traits->id; ?>"><?php echo $traits->traits; ?></option>
                	         <?php
                	     }
                	     ?>
                	        
                	 </select>
                </div>
            </div>
        </div>
        <div class="global_sub_btn">
            <input type="submit" name="submit" value="submit">
        </div>
    </form>
     
     <?php
    
    
}

?>