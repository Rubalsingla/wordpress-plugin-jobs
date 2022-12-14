<?php

    if ( ! defined( 'ABSPATH' ) ) {
    	exit;
    }
    $job_id = get_the_ID();
    $job_opening_id=get_post_meta($job_id,'job_opening_id',true);
    //echo $job_opening_id;
 function get_awsm_jobs_date_format( $id = '', $format = '' ) {
		/**
		 * Filters the date format used in WP Job Openings.
		 *
		 * @since 2.1.0
		 *
		 * @param string $format The date format.
		 * @param string $id Unique ID to filter the date format.
		 */
		$format = apply_filters( 'awsm_jobs_date_format', $format, $id );
		if ( empty( $format ) ) {
			$format = get_option( 'date_format' );
		}
		return $format;
	}
    
   $applications = array(
            'post_type' => 'jobs-application',
            'post_status' => 'publish',
            'numberposts'=>-1,
            'meta_query' =>array(
                array(
                    'key'     => 'job_opening_id',
                    'value'   => $job_opening_id,
                    'compare' => '=='
                ),
            )
             );
             
    $applications_data = get_posts($applications);
     
    $applications=array();
    if(!empty($applications_data)){
        
        foreach($applications_data as $appliactionna){
            
           $applications[]=$appliactionna->ID;
            
        }
    }
    // echo"<pre>";
    // print_r($applications);
    // echo"</pre>";
    $post_count   = count( $applications );
    $check_status = get_post_status( $job_opening_id );
    $views_count  = get_post_meta( $job_opening_id, 'job_views_count', true );
    $job_title    = get_the_title( $job_opening_id );
    
    ?>
    <table class="awsm-job-stat-table">
	<?php
		$data_rows = array(
			'job_title'       => array(
				esc_html__( 'Job Title', 'job-openings' ),
				wp_strip_all_tags( $job_title ),
			),
			'current_status'  => array(
				esc_html__( 'Current Status:', 'job-openings' ),
				'',
			),
			'views'           => array(
				esc_html__( 'Views:', 'job_openings' ),
				! empty( $views_count ) ? esc_html( $views_count ) : 0,
			),
			'applications'    => array(
				esc_html__( 'Applications:', 'job-openings' ),
				'',
			),
			'last_submission' => array(
				esc_html__( 'Last Submission:', 'job-openings' ),
				'',
			),
		);
   
    
        if ( $check_status === 'publish' ) {
			$data_rows['current_status'][1] = '<span class="awsm-text-green">' . esc_html__( 'Active', 'job-openings' ) . '</span>';
		} elseif ( $check_status === 'expired' ) {
			$data_rows['current_status'][1] = '<span class="awsm-text-red">' . esc_html__( 'Expired', 'job-openings' ) . '</span>';
		} else {
			$data_rows['current_status'][1] = '<span>' . esc_html__( 'Pending', 'job_openings' ) . '</span>';
		}
		
		if ( $post_count > 0 ) {
			$data_rows['applications'][1] = sprintf( '<a href="%1$s">%2$s</a>', esc_url( admin_url( 'edit.php?post_type=jobs-application&awsm_filter_posts=' . $job_opening_id ) ), esc_attr( $post_count ) );
		} else {
			$data_rows['applications'][1] = esc_html( $post_count );
		}
   
    
        if ( $post_count > 0 ) {
			$applications                    = array_values( $applications );
			$edit_link                       = get_edit_post_link( $applications[0] );
			$data_rows['last_submission'][1] = sprintf( '<a href="%1$s">%2$s %3$s</a>', esc_url( $edit_link ), esc_html( human_time_diff( get_the_time( 'U', $applications[0] ), current_time( 'timestamp' ) ) ), esc_html__( 'ago', 'job-openings' ) );
		} else {
			$data_rows['last_submission'][1] = esc_html__( 'NA', 'job-openings' );
		}
		
		if ( $post->post_type === 'jobs-application' ) {
			$date_format         = get_awsm_jobs_date_format( 'job-status' );
			$job_submission_date = date_i18n( $date_format, get_post_time( 'U', false, $job_opening_id ) );
			$expiry_date         = get_post_meta( $job_opening_id, 'job_expiry', true );
			$formatted_date      = ! empty( $expiry_date ) ? date_i18n( $date_format, strtotime( $expiry_date ) ) : esc_html__( 'NA', 'job-openings' );

			if ( current_user_can( 'edit_post', $job_opening_id ) ) {
				$data_rows['job_title'][1] = sprintf( '<a href="%2$s">%1$s</a>', $data_rows['job_title'][1], esc_url( get_edit_post_link( $job_opening_id ) ) );
			}

			$data_rows['date_posted'] = array(
				esc_html__( 'Date Posted:', 'job-openings' ),
				esc_html( $job_submission_date ),
			);

			$data_rows['date_of_expiry'] = array(
				esc_html__( 'Date of Expiry:', 'job-openings' ),
				esc_html( $formatted_date ),
			);

			if ( $post_count > 1 ) {
				// phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found
				$next = $prev = $current = 0;
				// phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found
				$prev_btn = $next_btn = '';
				foreach ( $applications as $index => $application_id ) {
				    //echo $application_id;
					if ( intval( $post->ID ) === $application_id ) {
						$current = $index + 1;
						if ( isset( $applications[ $index + 1 ] ) ) {
							$prev = $applications[ $index + 1 ];
						}
						if ( isset( $applications[ $index - 1 ] ) ) {
							$next = $applications[ $index - 1 ];
						}
					}
					
				}

				$prev_btn = sprintf( '<a class="button awsm-job-prev-application-btn%3$s" href="%2$s">&larr; %1$s</a>', esc_html__( 'Prev', 'job-openings' ), $prev ? esc_url( get_edit_post_link( $prev ) ) : '#', ! $prev ? ' btn-disabled' : '' );

				$pagination = sprintf( '<span class="awsm-job-status-pagination">%1$s<br />%2$s</span>', esc_html( "{$current}/{$post_count}" ), esc_html__( 'Applications', 'job-openings' ) );

				$next_btn = sprintf( '<a class="button awsm-job-next-application-btn%3$s" href="%2$s">%1$s &rarr;</a>', esc_html__( 'Next', 'job-openings' ), $next ? esc_url( get_edit_post_link( $next ) ) : '#', ! $next ? ' btn-disabled' : '' );

				$data_rows['actions'][0] = '<div class="awsm-job-status-btn-wrapper">' . $prev_btn . $pagination . $next_btn . '</div>';
			}
		}
    
    
    $data_rows = apply_filters( 'awsm_job_status_mb_data_rows', $data_rows, $job_opening_id, $post->ID );

		foreach ( $data_rows as $data_row ) {
			$column_content = '';
			if ( isset( $data_row[0] ) && ! isset( $data_row[1] ) ) {
				$column_content = '<td colspan="2">' . $data_row[0] . '</td>';
			} else {
				$column_content = sprintf( '<td>%1$s</td><td>%2$s</td>', isset( $data_row[0] ) ? $data_row[0] : '', isset( $data_row[1] ) ? $data_row[1] : '' );
			}

			echo '<tr>' . $column_content . '</tr>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
</table>

    


