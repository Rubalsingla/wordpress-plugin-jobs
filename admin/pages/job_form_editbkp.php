<?php

function job_form_edit() 
{
    $formID=$_REQUEST['id'];
    // echo $formID;
    if($formID!=''){
        
        global $wpdb;
            $taxonomies = get_terms( array(
            'taxonomy' => 'job-attributes', //Custom taxonomy name
            'hide_empty' => false
        ) );
        
        global $wpdb;
        $tablename = $wpdb->prefix.'job_form_data';
        $jobedit_form = $wpdb->get_row("SELECT * FROM $tablename where id=$formID");
       
        
    ?>
    <h1>Edit Job Form</h1>
    <form id="get_job_form" name="get_job_form" method="post">
        <div class="at-job-field">
            <div class="at-job-field-input">
                <label>Form Name</label>
                <input type="text" name="formname" value="<?php echo $jobedit_form ? $jobedit_form->name:'' ?>" required>
            </div>
            <div class="at-job-field-input">
                <label>Job Attribute</label> 
                <select name="form_job_att" class="form_job_att" id="form_job_att" required>
            	     <option value="">Select job attribute</option>
            	     <?php
            	     
            	     if ( !empty($taxonomies) ) :
            	     
            	        foreach( $taxonomies as $attribute ){
            	        
            	            ?><option value="<?php echo $attribute->term_id; ?>" <?php if(!empty($jobedit_form)) { if($jobedit_form->job_attribute==$attribute->term_id) { echo'selected'; } } ?>><?php echo $attribute->name; ?></option>
            	        <?php
            	        }
            	        
            	     endif;
            	     ?>
            	     
            	     
            	 </select>
            </div>
	    </div>
        <input type="hidden" id="formid" value="<?php echo $formID; ?>" name="formid">
        <div id="get-build-wrap" class="build-wrap form-wrapper-div"></div>
        
        <div class="at-update-btn"><input type="submit" name="submit" value="Update"></div>
    </form>
    
    
    <script>

	jQuery(document).ready(function(){
      //initialize Form Builder
       var formID = jQuery("#formid").val();
       
       jQuery.ajax({
                 type: 'POST',
                  url: 'admin-ajax.php',
                  dataType: "json",
                  data:{postdata:formID,action: "edit_formdata_ajax"},
                  async:false,
                  success: function(data) 
                  {
                
                    if(data.status==true && data.code==200){
                    
                        
                       var fbTemplate = document.getElementById('get-build-wrap'),
                       options = {
                          formData: data.form,
                       };
                         jQuery(fbTemplate).formBuilder(options);
                         
                     }
                     else{
                         var fbTemplate = document.getElementById('get-build-wrap'),
                       options = {
                          formData: '',
                       };
                         jQuery(fbTemplate).formBuilder(options);
                     }
                 },
                 error: function (data) {
                     var fbTemplate = document.getElementById('get-build-wrap'),
                       options = {
                          formData: '',
                       };
                         jQuery(fbTemplate).formBuilder(options);
                }
		  });
    });

		
	</script>
	<script>
	jQuery( document ).ready( function( $ ) {
		jQuery('#get_job_form').on('submit', function( event ) {
  			event.preventDefault();
  			var postdata=$('#get_job_form').serialize();
  			var fbEditor = document.getElementById('mainn_job_form');
     		const dataType = 'json' // optional 'js'|'json'|'xml', defaults 'js'
    		var formdata=jQuery(fbEditor).formBuilder('getData', dataType);

     		jQuery.ajax({
                url: 'admin-ajax.php',
                data:{formdata: formdata,postdata: postdata, action: "editdata_formdata_form_ajax"},
                method: "POST",
                dataType: "json",
                success: function(data) {
                     
                if(data.status==true && data.code==200){
                            toastr.success(data.message);
                            setTimeout(() => window.location.href="<?php echo admin_url('/admin.php?page=job_forms') ?>", 250);
                       }
                       else{
                           toastr.error(data.message);
                       }
                      //console.log(data);
                   },
                   error: function(data){
                       if(data.message){
                           
                            toastr.error(data.message);

                       }
                       else{
                           
                           toastr.error("Something Went wrong!");
                           
                       }
                   }
         });
  		});

	});
</script>
    <?php
    }
}


