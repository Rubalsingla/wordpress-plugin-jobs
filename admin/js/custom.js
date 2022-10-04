jQuery('document').ready(function(){
   
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
    
    jQuery('#assesment_form').on('submit', function( event ) {
            
            event.preventDefault();
            var postdata=$('#assesment_form').serialize();
            var admin_url=jQuery('input[name="admin_url"]').val();
            
        	jQuery.ajax({
              url: 'admin-ajax.php',
              data:{postdata: postdata, action: "assesment_form_ajax"},
              method: "POST",
              dataType: "json",
              success: function(data) {
                    if(data.status==true && data.code==200){
                        toastr.success(data.message);
                        setTimeout(() => window.location.href=admin_url+"/admin.php?page=assessments", 250);
                        
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
        
    jQuery("#scale_5_point").click(function(){
         
        var scale_html="<div class='scale_5_point_sec'><i class='fa fa-window-close close' aria-hidden='true'></i><div class='my-scale-input'><label>Label</label><input type='text' name='label' class='label' value='Label'></div> <div class='my-scale-option'><label>Options</label><div class='sortable-options-wrap'><input type='text' class='option-attr' name='options' value='Strongly disagree'><input type='text' name='options' value='Disagree' class='option-attr'><input type='text' name='options' value='Neutral' class='option-attr'><input type='text' value='Agree' name='options' class='option-attr'><input type='text' value='Strongly agree' name='options' class='option-attr'></div></div></div>";
        jQuery('.formdata').append(scale_html);
     });
     
     jQuery(document).on( 'click','.close',function( $ ) {
	          jQuery(this).parent().remove();
	  });
	  
	  jQuery('#add_trait').on('submit', function( event ) {
            
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
   		var postdata=$('#add_trait').serialize();
   		var datas = JSON.stringify(data);
   		var admin_url=jQuery('input[name="admin_url"]').val();
        
		jQuery.ajax({
            url: 'admin-ajax.php',
            data:{formdata: datas,postdata: postdata, action: "assesment_traits_form_ajax"},
            method: "POST",
            dataType: "json",
            success: function(data) {
             
            if(data.status==true && data.code==200){
                    toastr.success(data.message);
                    setTimeout(() => window.location.href=admin_url+"/admin.php?page=assessments", 250);
                }
                else{
                   toastr.error(data.message);
               }
              
           },
            error: function(data){
            if(data.message){
               
                toastr.error(data.message);

            }
            else{
               
               toastr.error(data.message);
               
            }
           }
        });
    });
    
    jQuery('#edit_assesment_form').on('submit', function( event ) {
        
            
        event.preventDefault();
        var postdata=$('#edit_assesment_form').serialize();
        var admin_url=jQuery('input[name="admin_url"]').val();
    	jQuery.ajax({
            url: 'admin-ajax.php',
            data:{postdata: postdata, action: "edit_assesment_form_ajax"},
            method: "POST",
            dataType: "json",
            success: function(data) {
                if(data.status==true && data.code==200){
                            toastr.success(data.message);
                            setTimeout(() => window.location.href=admin_url+"/admin.php?page=assessments", 250);
                }
                else{
                   toastr.error(data.message);
                }
                
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
        
        jQuery('#update_trait').on('submit', function( event ) {
            
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
       			
       			
       			
       			var postdata=$('#update_trait').serialize();
       			var admin_url=jQuery('input[name="admin_url"]').val();
       			var datas = JSON.stringify(data);
       			
       			console.log(postdata);
                console.log(datas);  
                //return false;
        		jQuery.ajax({
                  url: 'admin-ajax.php',
                  data:{formdata: datas,postdata: postdata, action: "update_traits_form_ajax"},
                  method: "POST",
                  dataType: "json",
                  success: function(data) {
                     
                  if(data.status==true && data.code==200){
                            toastr.success(data.message);
                            setTimeout(() => window.location.href=admin_url+"/admin.php?page=assessments", 250);
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
                           
                           toastr.error(data.message);
                           
                       }
                   }
            });
        		

       		});
       		
       	jQuery('[data-confirm]').on('click', function(e){
        e.preventDefault(); //cancel default action

        //Recuperate href value
        var href = jQuery(this).attr('href');
        var message = jQuery(this).data('confirm');
        var id = jQuery(this).data('id');
        
        swal({
            title: "Are you sure ??",
            text: message, 
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
             jQuery.ajax({
            url: 'admin-ajax.php',
            data:{postdata: id, action: "deletejob_form_ajax"},
            method: "post",
            dataType: "json",
            success: function(data) {
             console.log(data);
            if(data.status==true && data.code==200){
                    toastr.success(data.message);
                    setTimeout(() => window.location.href=href+"edit.php?post_type=jobs-openings&page=job_types", 250);
                }
                else{
                   toastr.error(data.message);
               }
              
           },
            error: function(data){
           console.log(data);
           }
        });
            
          } else {
            
          }
        });
       
    });
       		
       	jQuery('a:empty').css('display', 'none'); 	
	 //var data=jQuery("#menu-posts-jobs-openings >a").attr("title");
	 
	 //console.log(data);
     
});

    function update_trait(admin_url){
        
             
       var assignment=document.getElementById('asssement_name').value;
       var assignment_type=document.getElementById('assessment_type').value;
       var traitsdata=document.getElementById('traitsdata').value;
       var assesment_id=document.getElementById('assesment_id').value;
       
       if(assignment==''){
              toastr.error("Assesment Name is required");
              return;
        }
        if(assignment_type==''){
              toastr.error("Assesment Type is required");
              return;
        }
        if(traitsdata==''){
              toastr.error("Please select trait");
              return;
        }
        
        if(assesment_id==''){
              toastr.error("Something Wrong!");
              return;
        }
        
       window.location.href=admin_url+ "admin.php?page=update_traits&assignment_name="+assignment+"&type="+assignment_type.trim()+"&trait="+traitsdata+"&assesment_id="+assesment_id;
       
    }
    
    function add_trait(admin_url){
            var assignment=document.getElementById('asssement_name').value;
            var assignment_type=document.getElementById('assessment_type').value;
            if(assignment==''){
                  toastr.error("Assesment Name is required");
                  return;
            }
            if(assignment_type==''){
                  toastr.error("Assesment Type is required");
                  return;
            }
            window.location.href=admin_url+ "admin.php?page=add_traits&assignment_name="+assignment+"&type="+assignment_type;
    }