<?php
function main_form(){
    
    
    ?>
   <h1>Main Job Form</h1>
    <form class="custom-main-job-form" id="main_job_form" name="main_job_form" method="post">
        <div id="mainn-build-wrap" class="build-wrap form-wrapper-div"></div>
        <input type="submit" name="submit" value="Update">
    </form>
    
    
   
	
	<script>

	jQuery(document).ready(function(){
      //initialize Form Builder
       jQuery.ajax({
                 type: 'POST',
                  url: 'admin-ajax.php',
                  dataType: "json",
                  data:{action: "main_formdata_get_form_ajax"},
                  async:false,
                  success: function(data) 
                  {
                
                    if(data.status==true && data.code==200){
                    
                       var fbTemplate = document.getElementById('mainn-build-wrap'),
                       options = {
                          formData: data.form,
                       };
                         jQuery(fbTemplate).formBuilder(options);
                     }
                     else{
                         var fbTemplate = document.getElementById('mainn-build-wrap'),
                       options = {
                          formData: '',
                       };
                         jQuery(fbTemplate).formBuilder(options);
                     }
                 },
                 error: function (data) {
                     var fbTemplate = document.getElementById('mainn-build-wrap'),
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
			jQuery('#main_job_form').on('submit', function( event ) {
      			event.preventDefault();
      			var postdata=$('#main_job_form').serialize();
      			var fbEditor = document.getElementById('mainn_job_form');
         		const dataType = 'json' // optional 'js'|'json'|'xml', defaults 'js'
        		var formdata=jQuery(fbEditor).formBuilder('getData', dataType);

         		jQuery.ajax({
                   url: 'admin-ajax.php',
                   data:{formdata: formdata,postdata: postdata, action: "main_formdata_form_ajax"},
                   method: "POST",
                   dataType: "json",
                   success: function(data) {
                       if(data.status==true && data.code==200){
                            toastr.success(data.message);
                            setTimeout(() => window.location.reload(), 250);
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
