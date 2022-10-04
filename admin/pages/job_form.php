<?php

function job_form() 
{
    global $wpdb;
    $taxonomies = get_terms( array(
    'taxonomy' => 'job-attributes', //Custom taxonomy name
    'hide_empty' => false
        ) );
    
   
    
	?>

	 <form class="custom-job-data" id="job_form_data" name="job_form_data">
     <div class="at-job-field"> 
     <div class="at-job-field-input">
         <label>Form Name</label>
	     <input type="text" name="formname" value="" required>
	 </div>
	 <div class="at-job-field-input">
	     <label>Job Attributes</label>
    	 <select name="form_job_att" class="form_job_att" id="form_job_att" required>
    	     <option value="">Select job attribute</option>
    	     <?php
    	     
    	     if ( !empty($taxonomies) ) :
    	     
    	        foreach( $taxonomies as $attribute ){
    	        
    	            ?><option value="<?php echo $attribute->term_id; ?>"><?php echo $attribute->name; ?></option>
    	        <?php
    	        }
    	        
    	     endif;
    	     ?>
    	     
    	     
    	 </select>
     </div>
	 </div>
	  <ul class="scale-button">
        <li id="scale_5_point">5 point likert scale</li>
        <li id="scale_3_point">3 point likert scale</li>
        </ul>
        <div class="formdata">
        </div>

	 <!--<div id="build-wrap" class="build-wrap form-wrapper-div"></div>-->
	 
	 <input type="submit" name="submit" value="submit">

	</form>
    <!-- Form Builder Script -->
   <script>

	jQuery(document).ready(function(){
     
     jQuery("#scale_5_point").click(function(){
         
         var scale_html="<div class='scale_5_point_sec'><i class='fa fa-window-close close' aria-hidden='true'></i><div class='my-scale-input'><label>Label</label><input type='text' name='label' class='label' value='Label'></div> <div class='my-scale-option'><label>Options</label><div class='sortable-options-wrap'><input type='text' class='option-attr' name='options' value='Value-1'><input type='text' name='options' value='Value-2' class='option-attr'><input type='text' name='options' value='Value-3' class='option-attr'><input type='text' value='Value-4' name='options' class='option-attr'><input type='text' value='Value-5' name='options' class='option-attr'></div></div></div>";
        
        jQuery('.formdata').append(scale_html);
     });
     jQuery("#scale_3_point").click(function(){
        
         var scale_html="<div class='scale_5_point_sec'><i class='fa fa-window-close close' aria-hidden='true'></i><div class='my-scale-input'><label>Label</label><input type='text' name='label' class='label' value='Label'></div> <div class='my-scale-option'><label>Options</label><div class='sortable-options-wrap'><input type='text' class='option-attr' name='options' value='Value-1'><input type='text' name='options' value='Value-2' class='option-attr'><input type='text' name='options' value='Value-3' class='option-attr'></div></div></div>";
        
        jQuery('.formdata').append(scale_html);
     });
     
    });

		
	</script>
	<script>
	  jQuery( document ).ready( function( $ ) {
	      jQuery(document).on( 'click','.close',function( $ ) {
	          jQuery(this).parent().remove();
	      });
	  });
	</script>
	<script>

		jQuery( document ).ready( function( $ ) {

			jQuery('#job_form_data').on('submit', function( event ) {
       			event.preventDefault();
       			
       				var formdata = jQuery(".formdata .scale_5_point_sec");
  			const data=[];
  			
  			    formdata.each(function(index, value) {
  			        
      			    const scale_5_point_data={};
      			    var scale_sec_label=jQuery(this).find(".label").val();
      			    var name="likertscale-"+index;
      			    
      			    var formvalues = {
                            "type": "select", 
                            "required":"true",
                            "label":scale_sec_label,
                            "name":name,
                            "access": false,
                            "multiple": false
                    };
                    
                    var valuesdata=[];
                    jQuery(this).find(".sortable-options-wrap .option-attr").each(function(w, wp){
                       
                        var optiondta=jQuery(this).val();
                        var optiondtarray = {"label": optiondta, "value":optiondta};
                        valuesdata.push(optiondtarray);
                       
                    });
                    
                    Object.assign(formvalues, {'values': valuesdata});
                    data.push(formvalues);
                
  			 });
       			
       			
       			
       			var postdata=$('#job_form_data').serialize();
       			var datas = JSON.stringify(data);
       			//console.log(postdata);
       			//return;
       			//var fbEditor = document.getElementById('build-wrap');
        		//const dataType = 'json' // optional 'js'|'json'|'xml', defaults 'js'
        		//var formdata=jQuery(fbEditor).formBuilder('getData', dataType);

        		jQuery.ajax({
                  url: 'admin-ajax.php',
                  data:{formdata: datas,postdata: postdata, action: "formdata_form_ajax"},
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

?>