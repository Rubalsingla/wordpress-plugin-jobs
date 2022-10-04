<?php

function new_job_type(){

    ?>
    <h2>Add New Job Type</h2>
     <form class="custom-job-data" id="job_type_data" name="job_type_data">
     <div class="at-job-field"> 
         <div class="at-job-field-input">
             <label>Job Type Name</label>
    	     <input type="text" name="job_type" value="" required>
    	 </div>
    </div>
	 <input type="submit" name="submit" value="submit">

	</form>
	
		<script>

		jQuery( document ).ready( function( $ ) {

			jQuery('#job_type_data').on('submit', function( event ) {
       			event.preventDefault();
       			var postdata=$('#job_type_data').serialize();
        		jQuery.ajax({
                  url: 'admin-ajax.php',
                  data:{postdata: postdata, action: "jobtype_form_ajax"},
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

?>