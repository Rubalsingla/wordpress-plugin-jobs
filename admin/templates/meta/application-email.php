<?php
    $user_id        = get_current_user_id();
	$application_id = $post->ID;
	$applicant_mail = get_post_meta( $application_id, 'email', true );

?>
<div class="awsm-applicant-meta-mail-container">
	<div class="awsm-applicant-meta-mail-main posttypediv">
		<ul class="category-tabs awsm-applicant-meta-mail-tabs">
			<li class="tabs"><a href="#awsm-applicant-meta-new-mail"><?php esc_html_e( 'New Mail', 'job-openings' ); ?></a></li>
			<li class="hide-if-no-js"><a href="#awsm-applicant-meta-sent-mails"><?php esc_html_e( 'Sent Mails', 'job-openings' ); ?></a></li>
		</ul>
		<div id="awsm-applicant-meta-new-mail" class="tabs-panel awsm-applicant-meta-mail-tabs-panel">
			<div class="awsm-form-section-main">
				<div class="awsm-form-section">
					
					<div class="awsm-row" id="awsm_application_mail_ele">
						<?php
							/**
							 * Fires before main form fields in applicant emails meta box.
							 *
							 * @since 3.1.0
							 *
							 * @param int $application_id The Application ID.
							 */
							do_action( 'before_awsm_job_applicant_emails_mb_main_fields', $application_id );
						?>
						<input type="hidden" id="application_id" name="application_id" value="<?php echo $application_id; ?>">
						<div class="awsm-col awsm-form-group awsm-col-half">
							<label for="mail_meta_applicant_email"><?php esc_html_e( 'Applicant', 'job-openings' ); ?></label>
								<input type="text" class="awsm-form-control" id="mail_meta_applicant_email" value="<?php echo esc_attr( $applicant_mail ); ?>"  />
								<span id="applicanterror"></span>
						</div><!-- .col -->
						<div class="awsm-col awsm-form-group awsm-col-half">
							<label for="awsm_mail_meta_applicant_cc"><?php esc_html_e( 'CC:', 'job-openings' ); ?></label>
								<input type="text" class="awsm-form-control applicant-mail-field" name="mail_meta_applicant_cc" id="awsm_mail_meta_applicant_cc" value="" />
						</div><!-- .col -->
						<div class="awsm-col awsm-form-group awsm-col-full">
							<label for="awsm_mail_meta_applicant_subject"><?php esc_html_e( 'Subject ', 'job-openings' ); ?></label>
								<input type="text" class="awsm-form-control wide-fat awsm-applicant-mail-field awsm-applicant-mail-req-field" id="awsm_mail_meta_applicant_subject" name="mail_meta_applicant_subject" value="" />
								<span id="subjecterror"></span>
						</div><!-- .col -->
						<div class="awsm-col awsm-form-group awsm-col-full mail_content">
							<label for="awsm_mail_meta_applicant_content"><?php esc_html_e( 'Content ', 'job-openings' ); ?></label>
							<textarea class="awsm-form-control awsm-applicant-mail-field awsm-applicant-mail-req-field" id="awsm_mail_meta_applicant_content" name="mail_meta_applicant_content" rows="5" cols="50"></textarea>
							<span id="contenterror"></span>
						</div><!-- .col -->
						
						<?php
							/**
							 * Fires after main form fields in applicant emails meta box.
							 *
							 * @since 3.1.0
							 *
							 * @param int $application_id The Application ID.
							 */
							do_action( 'after_awsm_job_applicant_emails_mb_main_fields', $application_id );
						?>
					</div>
					<ul class="awsm-list-inline">
						<li>
							<button type="button" name="awsm_applicant_mail_btn" class="button button-large" id="awsm_applicant_mail_btn" data-response-text="<?php esc_html_e( 'Sending...', 'job-openings' ); ?>"><?php esc_html_e( 'Send', 'job-openings' ); ?></button>
						</li>
					</ul>
					<div class="awsm-applicant-mail-message"></div>
				</div><!-- .awsm-form-section -->
			</div><!-- .awsm-form-section-main -->
		</div>
		<div id="awsm-applicant-meta-sent-mails" class="tabs-panel awsm-applicant-meta-mail-tabs-panel" style="display: none;">
			<div id="awsm-jobs-applicant-mails-container">
				<?php
					$mail_details = get_post_meta( $application_id, 'application_mails', true );
				if ( ! empty( $mail_details ) && is_array( $mail_details ) ) {
					$mail_details = array_reverse( $mail_details );
					foreach ( $mail_details as $mail_detail ) {
						$author_name = $mail_detail['send_by'] === 0 ? esc_html__( 'System', 'job-openings' ) : $this->get_username( $mail_detail['send_by'] );
						$this->applicant_mail_template(
							array(
								'author'    => $author_name,
								'date_i18n' => esc_html( date_i18n( __( 'M j, Y @ H:i', 'default' ), $mail_detail['mail_date'] ) ),
								'subject'   => $mail_detail['subject'],
								'content'   => wpautop( $mail_detail['mail_content'] ),
							)
						);
					}
				} else {
					printf( '<div id="awsm_jobs_no_mail_wrapper"><p>%s</p></div>', esc_html__( 'No mails to show!', 'job-openings' ) );
				}
				?>
			</div>
		</div>
	</div>
</div>

<script>
jQuery('docuemnt').ready(function(){
    
    jQuery('#awsm-applicant-meta-new-mail').on('click', '#awsm_applicant_mail_btn', function(e) {
        
        	e.preventDefault();
        	
        	function IsEmail(email) {
              var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
              if(!regex.test(email)) {
                return false;
              }else{
                return true;
              }
            }
        	var applicant_email = jQuery('#mail_meta_applicant_email').val();
        	if(applicant_email==''){
        	    
        	    toastr.error("Applicant Email field is required");
        	    //jQuery('#applicanterror').html("This field is required").css({"color":"red"});
        	    //setTimeout(function () {
                           //jQuery('#applicanterror').html("");
                       //  }, 5000);
        	    return false;
        	}
        	else{
        	    if(IsEmail(applicant_email)==false){

                    toastr.error("Please fill valid Applicant email address.");
                    return false;
                }
        	}
        	
        	var applicant_subject = jQuery('#awsm_mail_meta_applicant_subject').val();
        	if(applicant_subject==''){
        	     toastr.error("Subject field is required");
        	    //jQuery('#subjecterror').html("This field is required").css({"color":"red"});
        	    //setTimeout(function () {
                           //jQuery('#subjecterror').html("");
                        // }, 5000);
        	    return false;
        	}
        	
        	var applicant_content = jQuery('#awsm_mail_meta_applicant_content').val();
        	if(applicant_content==''){
        	    
        	     toastr.error("Content field is required");
        	    jQuery('#contenterror').html("This field is required").css({"color":"red"});
        	    setTimeout(function () {
                           jQuery('#contenterror').html("");
                         }, 5000);
        	    
        	   
        	    return false;
        	}
        	
        	var applicant_cc = jQuery('#awsm_mail_meta_applicant_cc').val();
            if(applicant_cc!=''){
        	    if(IsEmail(applicant_cc)==false){
    
                    toastr.error("Please fill valid CC email address.");
                    return false;
                }
            }
        	
        	var application_id = jQuery('#application_id').val();
        		jQuery.ajax({
                  url: 'admin-ajax.php',
                  data:{application_id:application_id,applicant_cc:applicant_cc,applicant_email: applicant_email,applicant_subject: applicant_subject,applicant_content: applicant_content, action: "mail_form_ajax"},
                  method: "POST",
                  dataType: "json",
                  success: function(data) {
                     
                  if(data.status==true && data.code==200){
                            toastr.success(data.message);
                            setTimeout(() =>  window.location.reload(), 250);
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


jQuery('.awsm-applicant-meta-mail-container').on('click', '.awsm-jobs-applicant-mail-header', function() {
		jQuery(this).parent().toggleClass('open');
	});

	jQuery('ul.awsm-applicant-meta-mail-tabs a').on('click', function(e) {
		e.preventDefault();
		var $currentTab = $(this);
		if (! $currentTab.closest('li').hasClass('tabs')) {
			var tabPanelId = $currentTab.attr('href');
			jQuery('ul.awsm-applicant-meta-mail-tabs li').removeClass('tabs');
		$currentTab.closest('li').addClass('tabs');
			jQuery('.awsm-applicant-meta-mail-tabs-panel').hide();
		jQuery(tabPanelId).fadeIn();
		}
	});

});
</script>

