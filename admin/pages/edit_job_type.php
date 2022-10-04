<?php

function edit_job_type(){
    
    $jobID=$_REQUEST['id'];
    if($jobID!='')
   {
        
        global $wpdb;
        $tablename = $wpdb->prefix.'job_types';
        $jobedit_form = $wpdb->get_row("SELECT * FROM $tablename where id=$jobID");
       
        
    ?>
    <h1>Edit Job Type</h1>
    <form id="get_job_type" name="get_job_type" method="post">
        <div class="at-job-field">
            <div class="at-job-field-input">
                <label>Name</label>
                <input type="text" name="typename" value="<?php echo $jobedit_form ? $jobedit_form->name:'' ?>" required>
            </div>
	    </div>
        <input type="hidden" id="jobid" value=<?php echo $jobID; ?> name="jobid">
        
        <div class="at-update-btn"><input type="submit" name="submit" value="Update"></div>
    </form>
    
	<script>
	jQuery( document ).ready( function( $ ) {
		jQuery('#get_job_type').on('submit', function( event ) {
  			event.preventDefault();
  			var postdata=$('#get_job_type').serialize();
  		

     		jQuery.ajax({
                url: 'admin-ajax.php',
                data:{postdata: postdata, action: "edit_jobtype_ajax"},
                method: "POST",
                dataType: "json",
                success: function(data) {
                     
                if(data.status==true && data.code==200){
                            toastr.success(data.message);
                            setTimeout(() => window.location.href="<?php echo admin_url('/admin.php?page=job_types') ?>", 250);
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

?>