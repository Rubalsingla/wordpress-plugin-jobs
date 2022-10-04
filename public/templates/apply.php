<?php


/* Template Name: apply */

get_header();
if(isset($_GET['postID']))
{
  $mergearray=array();
  $postid= $_GET['postID'];
  $assessment = get_post_meta($postid,'assessment',true) ? get_post_meta($postid,'assessment',true):'';
  if($assessment!=''){
      
        $assesment_table = $wpdb->prefix.'job_assesments';
        $assessments = $wpdb->get_results("SELECT * FROM $assesment_table where id=$assessment");
        $trait_id=$assessments[0]->traits;
        if($trait_id!=''){
            
            $traits_table = $wpdb->prefix.'job_traits';
            $trait_data = $wpdb->get_results("SELECT * FROM $traits_table where id=$trait_id");
            $formdata=$trait_data[0]->form_data;
            if(is_serialized($formdata))
            {
                $formdata=unserialize($formdata);
                $mergearray=array_merge($mergearray,$formdata);
            }
        
            
        }
    
    }
  
 
  
//   $job_attributes=get_the_terms($postid,'job-attributes');
//   if(!empty($job_attributes)){
//       $jobattri_ids=array();
//       foreach($job_attributes as $job_attribute){
//           $jobattri_ids[]=$job_attribute->term_id;
//         }
//         $jobattri_ids=implode(",",$jobattri_ids);
//       global $wpdb;
//         $tablename = $wpdb->prefix.'job_form_data';
//       $jobforms = $wpdb->get_results("SELECT * FROM $tablename where job_attribute IN ($jobattri_ids)");
//       if(!empty($jobforms))
//         {
          
//           foreach($jobforms as $jobform){
              
//             $form=$jobform->job_form;
//             if(is_serialized($form))
//             {
//                 $formdata=unserialize($form);
//                 $mergearray=array_merge($mergearray,$formdata);
//             }
//           }
//         }
    
//   }
  
  
   
    ?>

    <div class="container">
        <div class="leftfield-top-content">
            <h2>Job Application for Wanted:</h2>
            <h4>Expressions of Interest</h4>
            <h6><?php echo get_post_meta($postid,'job_type',true); ?></h6>
            <div class="inner-leftfield-ct">
              <p><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo get_post_meta($postid,'job_location',true); ?></p>
              <p><i class="fa fa-calendar" aria-hidden="true">
                </i>Applications for this job close: 
              
              <?php 
             // echo get_post_meta($postid,'job_expiry',true);
                $today = date("Y-m-d");
                $expire = get_post_meta($postid,'job_expiry',true) ? get_post_meta($postid,'job_expiry',true):'';
                $today_time = strtotime($today);
                $expire_time = strtotime($expire);
        
                if ($expire_time < $today_time) { 
                   
                 
                     echo "Applications for this job closed";
                }
                else{
                    $date=date_create(get_post_meta($postid,'job_expiry',true));
                    echo date_format($date,"d/m/Y");
                }
                      
              ?>
              
              </p>
            </div>
          </div>
           
    
        <!--<h1 class="mt-form-heading">To start we need some contact information.</h1>-->
     
     <?php
    $mergearray = array_map("unserialize", array_unique(array_map("serialize", $mergearray)));
    if(FALSE === get_option('main_job_form') && FALSE === update_option('main_job_form',FALSE)) 
    {
       
        $main_get_form=array();
        $mergearray=array_merge($main_get_form,$mergearray);
       
    }
    else{
        
        $main_get_form=get_option('main_job_form');
        $main_get_form=unserialize($main_get_form);
        $mergearray=array_merge($main_get_form,$mergearray);
        
    }
    
    //echo"<pre>";
    //print_r($mergearray);
    // echo"</pre>";
    $i=1;
    global $j;
    $j=0;
    $loop_length = count($mergearray);
    
//     function searchForId($id, $array) {
//   foreach ($array as $key => $val) {
//       if ($val->type === $id && $val->subtype== $id) {
//           return $key;
//       }
//   }
//   return null;
// }
// echo $id = searchForId('button', $mergearray);
    
    // $section_table1=19;
    // $section_table2= $section_table1+15;
    // $section_table3= $section_table2+5;
    // $section_table4= $section_table3+9;
    // $section_table5= $section_table4+9;
    $b=0;
    foreach($mergearray as $formp)
    {
        if($formp->type=='button' && $formp->subtype=='button'){
            
            $b=$b+1;
        }
    }
    
    ?>
     <!-- multistep form -->
             <!-- Circles which indicates the steps of the form: -->
              <div style="text-align:center;" class="progressbar">
                  <?php
                  if($b>=1){
                  for($p=1;$p<=$b;$p++){
                      
                        if($p==1){
                          ?>
                             <span class="step stepone"><p>01</p></span>
                          <?php
                        }
                        if($p==2){
                          ?>
                             <span class="step steptwo"><p>02</p></span>
                          <?php
                        }
                        if($p==3){
                          ?>
                             <span class="step stepthree"><p>03</p></span>
                          <?php
                        }
                        if($p==4){
                          ?>
                             <span class="step stepfour"><p>04</p></span>
                          <?php
                        }
                    
                  }
                  $laststep=$b+1;
                  $laststep="0$laststep";
                  ?>
                  
                 <span class="step stepfour lastchild"><p><?php echo isset($b) ? $laststep:'01' ?></p></span>
                 <?php
                  }
                  ?>
                  
              </div>
    <form class="my-multistep-form" id="applyform" name="applyform" method="post" enctype="multipart/form-data"> 
    <?php
    foreach($mergearray as $form)
    {
        if($i==1){
            ?>
            <div class="tab">
                
            <?php
        }
        ?>
        <div class="tab-content-input">
        <?php
        $label=isset($form->label) ? $form->label:'';
        $class=isset($form->className) ? $form->className:'';
        $name=isset($form->name) ? $form->name:'name_'.$i;
        if($form->type=='text'){
           
          ?>
          <label><?php echo  $label; ?></label><span><?php echo $form->required ? '*':''; ?></span>
          <input type="<?php echo $form->subtype; ?>" name="<?php echo $name; ?>" class="<?php echo $class; ?>" <?php echo $form->required ? 'required':''; ?>>
          <?php
        }
        if($form->type=='select'){
          ?>
          <label><?php echo  $label; ?></label><span><?php echo $form->required ? '*':''; ?></span>
          <select class="<?php echo $class; ?>" name="<?php echo $name; ?>" <?php echo $form->required ? 'required':''; ?>>
            
            <!--<option value="">Select <?php echo  $form->label; ?></option>-->
            <?php
    
            if(!empty($form->values))
            {
    
              foreach($form->values as $values){
              ?><option value="<?php echo $values->value; ?>"> <?php echo $values->label; ?></option><?php
              }
            }
            ?>
          </select>
          <?php
        }
    
        if($form->type=='textarea'){
          ?>
          <label><?php echo  $label; ?></label><span><?php echo $form->required ? '*':''; ?></span>
          <textarea name="<?php echo $name; ?>" class="<?php echo $class; ?>" <?php echo $form->required ? 'required':''; ?>></textarea>
          <?php
        }
        if($form->type=='number'){
          ?>
          <label><?php echo  $label; ?></label><span><?php echo $form->required ? '*':''; ?></span>
          <input type="<?php echo  $form->type; ?>" class="<?php echo $class; ?>" name="<?php echo $name; ?>" <?php echo $form->required ? 'required':''; ?>>
          
          <?php
        }
        if($form->type=='file'){
          ?>
          <div class="custom-upload-file">
                <div class="custom-upload-file-wrap">
                    <div class="upload-content">
                <div>
            <label class="file">
                <p class="htmlshow"></p>
            <div class="inner-upload-content">
                <img src="<?php echo plugins_url('/job-openings/public/images/image-upload.png'); ?>">
                <h4><?php echo  $label; ?></h4>
               
                             
            </div>
          
          <span><?php echo $form->required ? '*':''; ?></span>
        
          <input type="<?php echo  $form->type; ?>" class="<?php echo $class; ?>" name="<?php echo $name; ?>" <?php echo $form->required ? 'required':''; ?> <?php echo $form->multiple ? 'multiple':''; ?>>
            
           
           </label>
          </div>
          </div>
          </div>
          </div>
          <?php
        }
        
        if($form->type=='fineuploader'){
          ?>
          <label><?php echo  $label; ?></label><span><?php echo $form->required ? '*':''; ?></span>
          <input type="<?php echo  $form->fineuploader; ?>" class="<?php echo $class; ?>" name="<?php echo $name; ?>" <?php echo $form->required ? 'required':''; ?> <?php echo $form->multiple ? 'multiple':''; ?>>
          
          <?php
        }
        
        if($form->type=='paragraph'){
          ?>
          <label><?php echo strip_tags(html_entity_decode($label)); ?></label>
          
          
          <?php
        }
        
        
        
        if($form->type=='checkbox-group'){
          ?>
          <div class="custom-checkbox-btn">
          <label><?php echo $label; ?></label><span><?php echo $form->required ? '*':''; ?></span>
          
            <?php
    
            if(!empty($form->values))
            {
    
              foreach($form->values as $values){
              ?>
              <div class="custom-inner-checkbox-btn">
              <input type="checkbox" name="<?php echo $name; ?>" class="<?php echo $class; ?>" value="<?php echo $values->value; ?>" <?php echo ($values->selected==1 ? 'checked' : '');?>>
              <label for=""> <?php echo $values->label; ?></label><span><?php echo $form->required ? '*':''; ?></span>
              </div>
              <?php
              }
            }
            ?>
          </div>
          <?php
        }
        
        if($form->type=='date'){
          ?>
          <label><?php echo  $label; ?></label><span><?php echo $form->required ? '*':''; ?></span>
          <input type="<?php echo  $form->type; ?>" class="<?php echo $class; ?>" name="<?php echo $name; ?>" <?php echo $form->required ? 'required':''; ?>>
          
          <?php
        }
        
        if($form->type=='header'){
            
            if($form->subtype=='h1')
            {
             ?>
             <h1 class="mt-form-heading"> <?php echo  $label; ?> </h1>
             <?php
            }
            if($form->subtype=='h2')
            {
             ?>
             <h2 class="mt-form-heading"> <?php echo  $label; ?> </h2>
             <?php
            }
            if($form->subtype=='h3')
            {
             ?>
             <h3> <?php echo  $label; ?> </h3>
             <?php
            }
            if($form->subtype=='h4')
            {
             ?>
             <h4 class="mt-form-heading"> <?php echo  $label; ?> </h4>
             <?php
            }
            if($form->subtype=='h5')
            {
             ?>
             <h5 class="mt-form-heading"> <?php echo  $label; ?> </h5>
             <?php
            }
            if($form->subtype=='h6')
            {
             ?>
             <h6 class="mt-form-heading"> <?php echo  $label; ?> </h6>
             <?php
            }
        
        }
        
         if($form->type=='radio-group'){
          ?>
          <div class="custom-radio-btn">
          <label><?php echo $label; ?></label><span><?php echo $form->required ? '*':''; ?></span>
          
            <?php
    
            if(!empty($form->values))
            {
    
              foreach($form->values as $values){
              ?>
              <div class="custom-inner-radio-btn">
              <input type="radio" name="<?php echo $name; ?>" class="<?php echo $class; ?>" value="<?php echo $values->value; ?>" <?php echo ($values->selected==1 ? 'checked' : '');?>>
              <label for=""> <?php echo $values->label; ?></label>
              </div>
              
              <?php
              }
            }
            ?>
          </div>
          <?php
        }
        ?>
        </div>
        <?php
        
        if($form->type=='button' && $form->subtype=='button'){
            
          
        ?>
         <div style="overflow:auto;" class="my-mt-buttons">
            <div class="custom-button">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
             <input type="button" id="nextBtn" onclick="nextPrev(1)" class="<?php echo $form->className; ?>" name="<?php echo $form->name; ?>" value="<?php echo $form->value; ?>">
            
            </div>
        </div>
       
        </div>
        <div class="tab">
         <?php
         $j=$j+1;
        }
       
            
        
            
        
        
        if($i==$loop_length)
        {
            if($form->type=='button' && $form->subtype=='submit'){
                ?>
                 <div style="overflow:auto;" class="my-mt-buttons">
                    <div class="custom-button">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                     <input type="submit" class="<?php echo $form->className; ?>" name="<?php echo $form->name; ?>" value="<?php echo $form->value; ?>">
                    
                    </div>
                </div>
               
                </div>
                
                 <?php
            }
            else{
                ?>
                <div style="overflow:auto;" class="my-mt-buttons">
                    <div class="custom-button">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                      <input type="submit" value="submit" name="submit">
                    
                    </div>
                </div>
               
                <?php
            }
            ?>
            </div>
            <?php
        }
        
        
        $i=$i+1;
    }
    ?>
     
      <input type="hidden" name="job_opening_id" value="<?php echo $postid; ?>">
       
    <!--<input type="submit" value="submit" name="submit">-->
    </form>
    </div>
    <?php
    
}
?>
<script src="https://kit.fontawesome.com/a282321041.js" crossorigin="anonymous"></script>
<script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            
           //alert(n);
          // This function will display the specified tab of the form...
          var x = document.getElementsByClassName("tab");
          console.log(x);
          //alert(x.length);
          x[n].style.display = "block";
          //... and fix the Previous/Next buttons:
          if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
          } else {
            document.getElementById("prevBtn").style.display = "inline";
          }
          if (n == (x.length - 1)) {
            //document.getElementById("nextBtn").innerHTML = "Submit";
            //document.getElementById("nextBtn").type="submit"; 
          } else {
            document.getElementById("nextBtn").innerHTML = "Next";
          }
          //... and run a function that will display the correct step indicator:
          fixStepIndicator(n)
        }

        function nextPrev(n) {
          // This function will figure out which tab to display
          var x = document.getElementsByClassName("tab");
          // Exit the function if any field in the current tab is invalid:
          if (n == 1 && !validateForm()) return false;
          // Hide the current tab:
          x[currentTab].style.display = "none";
          // Increase or decrease the current tab by 1:
          currentTab = currentTab + n;
          // if you have reached the end of the form...
          if (currentTab >= x.length) {
            // ... the form gets submitted:
            //document.getElementById("applyform").submit();
            return false;
          }
          // Otherwise, display the correct tab:
          showTab(currentTab);
        }

        function validateForm() {
          // This function deals with validation of the form fields
          var x, y, i, valid = true;
          x = document.getElementsByClassName("tab");
          y = x[currentTab].getElementsByTagName("input");
          // A loop that checks every input field in the current tab:
          for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].required) {
            //   // add an "invalid" class to the field:
               //y[i].className += " invalid";
            //   // and set the current valid status to false
               //valid = false;
               if (y[i].value == "") {
              // add an "invalid" class to the field:
              y[i].className += " invalid";
              // and set the current valid status to false
              valid = false;
            }
             }
             
             if(y[i].type=='email')
             {
                  var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                  var is_email=re.test(y[i].value);

                  if(is_email)
                  {
                    
                  }
                  else{
                    y[i].className += " invalid";

                    // and set the current valid status to false
                    valid = false;
                  }
            }
          }
          // If the valid status is true, mark the step as finished and valid:
          if (valid) {
             
            
            document.getElementsByClassName("step")[currentTab].className += " finish";
          }
          return valid; // return the valid status
        }

        function fixStepIndicator(n) {
           // alert(n);
          // This function removes the "active" class of all steps...
          var i, x = document.getElementsByClassName("step");
          for (i = 0; i < x.length; i++) {
              //alert(i);
            x[i].className = x[i].className.replace(" active", "");
            x[i].className = x[i].className.replace(" finish", "");
          }
           for (j = 0; j < n; j++) {
              //alert(i);
            x[j].className += " finish";
          }
          //... and adds the "active" class on the current step:
          x[n].className += " active";
         
        }
        </script>
    <script>
      jQuery( document ).ready( function( $ ) {
          
         
            jQuery("#applyform .tab .tab-content-input").find("h1,h2,h3,h4,h5,h6").parent().css({
                
                "width":"100%"
                
            });
            
            jQuery("#applyform .tab .tab-content-input").find(".custom-upload-file").parent().css({
                
                "width":"49%"
                
            });
    
          jQuery('#applyform').on('submit', function( event ) {
                event.preventDefault();
                //var formdata = new FormData();
                //console.log(formdata);
                // Display the key/value pairs
                 //console.log("newddhj");
                var form = document.querySelector('#applyform');
                var formData = new FormData(form);
    
                // for (var [key, value] of formData.entries()) { 
                //   console.log(key, value);
                // }

                //or
                
                //console.log(...formData)
                //var formdata=$('#applyform').serialize();
                // console.log(formdata);
                //return;
                formData.append("action", "apply_form_ajax"); 
                //data:{formdata: formData,action: "apply_form_ajax"},
    
                  jQuery.ajax({
                        method: "POST",
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        data:formData,
                        dataType: "json",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                          console.log(data);
    
                            if(data.status==true && data.code==200){
    
                              //alert("<?php echo get_site_url(); ?>");
                              //window.location.replace("<?php echo site_url('job-openings'); ?>");
                              //window.location="<?php site_url('jobs') ?>";
                               toastr.success(data.message);
                               setTimeout(() => window.location.replace("<?php echo site_url('job-openings') ?>"), 250);
                            }
                            else{
                                toastr.error(data.message);
                              //location.reload()
                            }
                           
                        },
                        error: function(data){
                            if(data.message){
                                 toastr.error(data.message);
                            }
                            else{
                                toastr.error("Something went wrong!");
                            }
                            console.log(data);
                        }
                        
                  });
    
              });
        });
    </script>
    <script>
         jQuery(document).ready(function() {
              jQuery('input[type=file]').change(function() {
                  //console.log(this.files);
                  var f = this.files;
                  //el =jQuery(this).parent().children(".htmlshow").css({"color": "red", "border": "2px solid red"});
                  //console.log(el);
                //   if (f.length > 1) {
                //       console.log(this.files, 1);
                //       el.text('Sorry, multiple files are not allowed');
                //       return;
                //   }
                  // el.removeClass('focus');
                 var all = new Array();
                  for(var i=0; i<f.length;i++){
                      
                      all[i]=(f[i].name + '<br>' +'<span class="sml">' +'type: ' + f[i].type + ', ' + Math.round(f[i].size / 1024) + ' KB</span>');
                  }
                 jQuery(this).parent().children(".htmlshow").html(all);
                  //console.log(all);
                  //jQuery(this).parent().jQuery('.htmlshow').html(all);
              });

            //   jQuery('input[type=file]').on('focus', function() {
            //       jQuery(this).parent().addClass('focus');
            //   });

            //   jQuery('input[type=file]').on('blur', function() {
            //       jQuery(this).parent().removeClass('focus');
            //   });

          });
        </script>
    
    <?php
    
    get_footer();
    
    ?>




