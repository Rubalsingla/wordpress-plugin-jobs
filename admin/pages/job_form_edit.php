<?php



function job_form_edit() 
{
    $formID=$_REQUEST['id'];
    //echo $formID;
    if($formID!=''){
        
        global $wpdb;
            $taxonomies = get_terms( array(
            'taxonomy' => 'job-attributes', //Custom taxonomy name
            'hide_empty' => false
        ) );
        
        global $wpdb;
        $tablename = $wpdb->prefix.'job_form_data';
        $jobedit_form = $wpdb->get_row("SELECT * FROM $tablename where id=$formID");
        $jobeditform=$jobedit_form->job_form;
        $jobeditform=unserialize($jobeditform);
      
        
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
	    <ul class="scale-button">
        <li id="scale_5_point">5 point likert scale</li>
        <li id="scale_3_point">3 point likert scale</li>
        </ul>
        <input type="hidden" id="formid" value="<?php echo $formID; ?>" name="formid">
        
        <div class="formdata">
            <!--<div class="form-field">-->
            <!--    <label>Header text</label>-->
            <!--    <input type="text" name="header_text" value="" class='attri_header'>-->
            <!--</div>-->
            
            
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
        <!--<div id="get-build-wrap" class="build-wrap form-wrapper-div"></div>-->
        
        <div class="at-update-btn"><input type="submit" name="submit" value="Update"></div>
    </form>
    
    
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
		jQuery('#get_job_form').on('submit', function( event ) {
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
  			 
  			var postdata=$('#get_job_form').serialize();
  		    var datas = JSON.stringify(data);
     		jQuery.ajax({
                url: 'admin-ajax.php',
                data:{formdata: datas,postdata: postdata, action: "editdata_formdata_form_ajax"},
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


