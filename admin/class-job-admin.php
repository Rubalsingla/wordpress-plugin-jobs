<?php



class Job_Admin {

	private $plugin_name;
    private $version;
    private $cap;

public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        
        

		add_action('init', array($this, 'Job_post_document'));
        
		
        
        
    
}

  public function Job_post_document() {
		
		if ( post_type_exists( 'Jobs-openings' ) ) {
		    
		}
		else{
    		$current_user = wp_get_current_user();
            $labels = array(
                'name' => _x('Jobs openings', 'post type general name'),
                'singular_name' => _x('Jobs opening', 'post type singular name'),
                'add_new' => _x('New Opening', 'Job'),
                'add_new_item' => __('Add New Job'),
                'edit_item' => __('Edit Job'),
                'new_item' => __('New Opening'),
                'all_items' => __('All Openings'),
                'view_item' => __('View Job'),
                'search_items' => __('Search Job'),
                'not_found' => __('No Job found'),
                'not_found_in_trash' => __('No Job found in the Trash'),
                'parent_item_colon' => '',
                'menu_name' => ' Rocket Recruit'
            );
            $args = array(
                'labels' => $labels,
                'description' => 'Holds our Jobs openings and attributes specific data',
                'public' => true,
                'menu_icon'  => '',
                'menu_position' => 5,
                'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments', 'page-attributes', 'revisions'),
                'has_archive' => true,
                'hierarchical' => true, //allow parent pages
    			
    			
            );
    		/*if(!in_array('administrator',$current_user->roles)){
    			$args['capabilities'] = $this->cap;
    		}*/

            register_post_type('Jobs-openings', $args);
		}
    }

    public function Job_post_applications(){

        if ( post_type_exists( 'Jobs-application' ) ) {
            
        }
        else{
            $current_user = wp_get_current_user();
            $labels = array(
                'name' => _x('Jobs application', 'post type general name'),
                'singular_name' => _x('Jobs application', 'post type singular name'),
                
                'edit_item' => __('Edit Job'),
                
                'all_items' => __('All Application'),
                'view_item' => __('View Application'),
                'search_items' => __('Search Application'),
                'not_found' => __('No Application found'),
                'not_found_in_trash' => __('No Application found in the Trash'),
                'parent_item_colon' => '',
                'menu_name' => 'Applications'
            );
             $args = array(
                'labels' => $labels,
                'description' => 'Holds our Jobs openings and attributes specific data',
                'public' => true,
                'menu_position' => 5,
                'supports' => array('title', '', 'thumbnail', '', '', '', ''),
                'has_archive' => true,
                'show_in_menu' => 'edit.php?post_type=Jobs-openings',
                'hierarchical' => true, //allow parent pages
                'capabilities' => array(
                'create_posts' => false, // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups )
                ),
                'map_meta_cap' => true, 
                
                
            );
                
                
        
            /*if(!in_array('administrator',$current_user->roles)){
                $args['capabilities'] = $this->cap;
            }*/
           
            register_post_type('Jobs-application', $args);
        }

    }

    public function Job_post_form(){

        if ( post_type_exists( 'Job-form' ) ) {
            
        }
        else{
            $current_user = wp_get_current_user();
            $labels = array(
                'name' => _x('Job form', 'post type general name'),
                'singular_name' => _x('Job form ', 'post type singular name'),
                'add_new' => _x('New Job form', 'Job'),
                'add_new_item' => __('Add Job form'),
                'edit_item' => __('Edit Job form'),
                'new_item' => __('New Job form'),
                'all_items' => __('All Job Forms'),
                'view_item' => __('View Job Form'),
                'search_items' => __('Search Job Form'),
                'not_found' => __('No Job form found'),
                'not_found_in_trash' => __('No job form found in the Trash'),
                'parent_item_colon' => '',
                'menu_name' => 'Job form'
            );
            $args = array(
                'labels' => $labels,
                'description' => 'Holds our forms and attributes specific data',
                'public' => true,
                'menu_position' => 5,
                'supports' => array('title'),
                'has_archive' => true,
                'hierarchical' => true, //allow parent pages
                
                
            );
            /*if(!in_array('administrator',$current_user->roles)){
                $args['capabilities'] = $this->cap;
            }*/
           
            register_post_type('Job-form', $args);
        }

    }

    //  public function Job_taxonomies_document() {
    //      $labels = array(
    //          'name' => _x('Attributes', 'taxonomy general name'),
    //          'singular_name' => _x('Attributes', 'taxonomy singular name'),
    //          'search_items' => __('Search Attribute'),
    //          'all_items' => __('All Attribute'),
    //          'parent_item' => __('Parent Attribute'),
    //          'parent_item_colon' => __('Attribute:'),
    //          'edit_item' => __('Edit Attribute'),
    //          'not_found' => __('No Attribute found'),
    //         'not_found_in_trash' => __('No Attribute found in the Trash'),
    //          'update_item' => __('Update Attribute'),
    //          'add_new_item' => __('Add New Attribute'),
    //          'new_item_name' => __('New Attribute'),
    //          'menu_name' => __('Assessments'),
    //      );
    //      $args = array(
    //         'labels' => $labels,
    //         'hierarchical' => true,
    //      );
    //      register_taxonomy('job-attributes', 'jobs-openings', $args);
    //  }

    

    public function my_admin_menu() { 
    add_submenu_page('edit.php?post_type=jobs-openings', 'Candidates', 'Candidates', 'manage_options', 'edit.php?post_type=jobs-application'); 
    }
   
     public function register_my_custom_menu_page(){

     	require_once plugin_dir_path(dirname(__FILE__)) . 'admin/pages/job_form.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/pages/job_forms.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/pages/job_form_edit.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/pages/main_form.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/pages/job_types.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/pages/new_job_type.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/pages/edit_job_type.php';
        
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/pages/assessments.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/pages/add_assessment.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/pages/add_trait.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/pages/edit_assessment.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/pages/update_traits.php';
   
        add_submenu_page(
            'edit.php?post_type=jobs-openings',
            __( 'Assessments', 'textdomain' ),
            __( 'Assessments', 'textdomain' ),
            'manage_options',
            'assessments',
            'assessments'
        );
        
         add_submenu_page(
            'edit.php?post_type=jobs-openings',
            __( 'Job Types', 'textdomain' ),
            __( 'Job Types', 'textdomain' ),
            'manage_options',
            'job_types',
            'job_types'
        );
        
        add_submenu_page(
            'edit.php?post_type=jobs-openings',
            __( 'Main Form', 'textdomain' ),
            __( 'Main Form', 'textdomain' ),
            'manage_options',
            'main_form',
            'main_form'
        );
        add_submenu_page(
            'edit.php?post_type=jobs-openings',
            __( '', 'textdomain' ),
            __( '', 'textdomain' ),
            'manage_options',
            'edit_assessment',
            'edit_assessment'
        );
        add_submenu_page(
            'edit.php?post_type=jobs-openings',
            __( '', 'textdomain' ),
            __( '', 'textdomain' ),
            'manage_options',
            'add_assessment',
            'add_assessment'
        );
        
        add_submenu_page(
            'edit.php?post_type=jobs-openings',
            __( '', 'textdomain' ),
            __( '', 'textdomain' ),
            'manage_options',
            'add_traits',
            'add_traits'
        );
        
        
        
       
        
        add_submenu_page(
            'edit.php?post_type=jobs-openings',
            'New Type',
            '',
            'manage_options',
            'new_job_type',
            'new_job_type'
        );
        
        add_submenu_page(
            'edit.php?post_type=jobs-openings',
           'Edit Type',
           '',
            'manage_options',
            'edit_job_type',
            'edit_job_type'
        );
        
        
        
        /*add_submenu_page(
            'edit.php?post_type=jobs-openings',
            __( 'Attributes Forms', 'textdomain' ),
            __( 'Attributes Forms', 'textdomain' ),
            'manage_options',
            'job_forms',
            'job_forms'
        );
        add_submenu_page(
            'edit.php?post_type=jobs-openings',
            __( 'New Attribute Form', 'textdomain' ),
            __( 'New Attribute Form', 'textdomain' ),
            'manage_options',
            'new_job_form',
            'job_form'
        );*/
       
         
        
        /*add_submenu_page(
            'edit.php?post_type=jobs-openings',
            __( '', 'textdomain' ),
            __( '', 'textdomain' ),
            'manage_options',
            'job_form_edit',
            'job_form_edit'
        );
        */
        add_submenu_page(
            'edit.php?post_type=jobs-openings',
            __( '', 'textdomain' ),
            __( '', 'textdomain' ),
            'manage_options',
            'update_traits',
            'update_traits'
        );
    
    
    
    }

    public function enqueue_scripts() {
        
       // wp_enqueue_media();
       // wp_enqueue_script($this->plugin_name . 'jquery', plugin_dir_url(__FILE__) . 'js/jquery.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name.'jquery','https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name.'jquery-ui','https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name.'form-builder','https://formbuilder.online/assets/js/form-builder.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name.'form-builder-render','https://formbuilder.online/assets/js/form-render.min.js', array('jquery'), $this->version, true);
        //wp_enqueue_media();
        //wp_localize_script('my_custom_script', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
        wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/custom.js');
        wp_enqueue_script('my_custom_script1', plugin_dir_url(__FILE__) . 'js/custom1.js');
        wp_enqueue_script('set-form-data', plugin_dir_url(__FILE__) . 'js/set_form_data.js');
        wp_enqueue_script($this->plugin_name.'toast','https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script($this->plugin_name.'toast-latest','https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', array('jquery'), $this->version, true);
        
        wp_enqueue_script($this->plugin_name.'validate-data','http://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js', array('jquery'), $this->version, true);
         
        wp_enqueue_script($this->plugin_name.'sweet-data','https://unpkg.com/sweetalert/dist/sweetalert.min.js', array('jquery'), $this->version, true);
 
       

    }

    public function enqueue_styles() {
        
        wp_enqueue_style('my_custom_style', plugin_dir_url(__FILE__) . 'css/custom.css');
        wp_enqueue_style('my_custom_style-toast', 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css');
        wp_enqueue_style('my_custom_style-awesomeee', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css');
        
    }

   
    function job_form_save( $hook ) {
        global $post; 
        //print_r($post);

        //die('gt');

        if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
            if ( 'job-form' === $post->post_type ) {
                //wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'js/custom.js');
               // die('d');

            }
        }
       
    }

    function job_form_get( $hook ) {
        global $post; 

        if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
            if ( 'job-form' === $post->post_type ) {

                wp_enqueue_script('set-form-data', plugin_dir_url(__FILE__) . 'js/set_form_data.js');
               
               // die('d');
            }
        }
       
    }



    public function formdata_form_ajax()
    {
       if(isset($_POST))
        {
           if(!empty($_POST['postdata']))
           {
                parse_str($_POST['postdata'], $postdata);
                
                if(!empty($postdata))
                {
                    $formname=$postdata['formname'];
                    $form_job_att=$postdata['form_job_att'];
                    $decoded = json_decode(stripslashes($_POST['formdata']));
                    $formdata=serialize($decoded);
                    global $wpdb;
                    $tablename = $wpdb->prefix.'job_form_data';
                    $jobedit_form = $wpdb->get_row("SELECT * FROM $tablename where job_attribute=$form_job_att");
                    
                    if(empty($jobedit_form)){
                        
                         $data=array(
                        'name' => $formname, 
                        'status' => 'true',
                        'job_form' => $formdata, 
                        'job_attribute'=>$form_job_att
                         );
    
                        $result = $wpdb->insert( $tablename, $data);
                        if($result){
                            echo json_encode(array("formid"=>$result,"status"=>true,"code"=>200,'message'=>"Form Inserted"));
                            die();
                        }
                        else{
                            echo json_encode(array("status"=>false,"code"=>400,'message'=>'Something Wrong!'));
                            die();
                        }
                        
                    }else{
                        echo json_encode(array("status"=>false,"code"=>400,'message'=>'Job Attribute already exist!'));
                        die();
                    }
                }
                else{
                      echo json_encode(array("status"=>false,"code"=>400,'message'=>'Something Wrong!'));
                        die();
                }
            
           }
           else{
               echo json_encode(array("status"=>false,"code"=>400,'message'=>'Something Wrong!'));
                    die();
           }
       
        }
    
    }
    
    public function main_formdata_form_ajax(){
        
        if(isset($_POST))
        {
            if(!empty($_POST['formdata'])){
                
                $decoded = json_decode(stripslashes($_POST['formdata']));
                $formdata=serialize($decoded);
                	
                if(FALSE === get_option('main_job_form') && FALSE === update_option('main_job_form',FALSE)) {
                    
                    add_option('main_job_form',$formdata);
                    echo json_encode(array("status"=>true,"code"=>200,'message'=>"Main Form Inserted"));
                    die();
                    
                }
                else{
                    update_option('main_job_form',$formdata);
                    echo json_encode(array("status"=>true,"code"=>200,'message'=>"Main Form Updated"));
                    die();
                }
                
                echo json_encode(array("status"=>false,"code"=>400,'message'=>"Something Went Wrong!"));
                die();   
                
            }
        }
        
          
    }
    
    public function main_formdata_get_form_ajax(){
        
        if(FALSE === get_option('main_job_form') && FALSE === update_option('main_job_form',FALSE)) {
                    
            
            echo json_encode(array("status"=>false,"code"=>400,'message'=>"Main form is empty"));
            die();
            
        }
        else{
            $main_get_form=get_option('main_job_form');
            $main_get_form=unserialize($main_get_form);
            echo json_encode(array("status"=>true,"code"=>200,'form'=>$main_get_form));
            die();
        }
    }
    
    public function edit_formdata_ajax(){
        
        if($_POST['postdata']){
           
           $formID=$_POST['postdata']; 
           
            global $wpdb;
            $tablename = $wpdb->prefix.'job_form_data';
            $jobedit_form = $wpdb->get_results("SELECT * FROM $tablename where id=$formID");
            if(!empty($jobedit_form)){
                
                    $job_form=$jobedit_form[0]->job_form;
                    $job_form=unserialize($job_form);
                    echo json_encode(array("status"=>true,"code"=>200,'form'=>$job_form));
                    die();
                    
                }
                else{
                   echo json_encode(array("status"=>false,"code"=>400));
                    die(); 
                }
            }
            else{
                echo json_encode(array("status"=>false,"code"=>400));
                die();
            }
        
        
    }
    
    public function editdata_formdata_form_ajax(){
        
        
        if(isset($_POST))
        {
           if(!empty($_POST['postdata'])){

                parse_str($_POST['postdata'], $postdata);
                $formname=$postdata['formname'];
                $form_job_att=$postdata['form_job_att'];
                $formid=$postdata['formid'];
                $decoded = json_decode(stripslashes($_POST['formdata']));
                //print_r($decoded);
                //die('eth');
                
                //echo"<pre>";
                //print_r($decoded);
                //echo"</pre>";
                //die('fgh');
                
                $formdata=serialize($decoded);
                global $wpdb;
                $tablename = $wpdb->prefix.'job_form_data';
                $jobedit_form = $wpdb->get_row("SELECT * FROM $tablename where job_attribute=$form_job_att and id != $formid");
                if(empty($jobedit_form)){
                    
                    $data=array(
                        'name' => $formname, 
                        'status' => 'true',
                        'job_form' => $formdata, 
                        'job_attribute'=>$form_job_att
                     );
                     //echo"<pre>";
                     //print_r($data);
                     //echo"</pre>";
                    $result=$wpdb->update( $tablename, $data,array('id'=>$formid));
                    //print_r($result);
                     //echo $wpdb->last_query;
                    
                    if($result){
                        echo json_encode(array("formid"=>$result,"status"=>true,"code"=>200,'message'=>"Form Updated"));
                        die();
                    }
                    else{
                         echo json_encode(array("status"=>false,"code"=>400,'message'=>'Something Wrong!'));
                        die();
                    }
                }
                else{
                    echo json_encode(array("status"=>false,"code"=>400,'message'=>'Job Attribute already exist!'));
                    die();
                }
                
                die();
           }
        }
        
        
        
    }
    
    public function download_formdata_ajax(){
        
        if(isset($_POST))
        {
            if(!empty($_POST['postdata']))
            {
            $postid=$_POST['postdata'];
            $resumedata=get_post_meta($postid,'resume_files',true);
            if($resumedata)
            {
                $zip = new ZipArchive();
                $filename = "myzipfile.zip";
                if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
                    //exit("cannot open <$filename>\n");
                    echo json_encode(array("status"=>false,"code"=>400,'message'=>'Cannot open Zip file'));
                    die();
                }
                else{
                $resumefiles=unserialize($resumedata);
                foreach($resumefiles as $file){
                    
                    $path=$file['file'];
                    $url=$file['file_url'];
                    if(file_exists($path))
                    {
                    //echo $path;
                        //die('ghgj');
                     //$zip->addFile(basename($path).file_get_contents($path));
                     $zip->addFromString(basename($path),  file_get_contents($url));  
                    }
                    else{
                        
                    }
                }
                //print_r($zip);
                $zip->close();
                /*header("Content-type: application/zip");
                header("Content-Disposition: attachment; filename=" . $filename);
                header("Pragma: no-cache");
                header("Expires: 0");
               readfile($filename);
                unlink($filename);
                echo $filename;*/
                
                
    header("Content-Type: application/force-download");

      header("Content-type: application/zip");

      header('Content-Description: File Download');

      header('Content-Disposition: attachment; filename=' . $filename);

      header('Content-Transfer-Encoding: binary');

      header('Expires: 0');

      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

      header('Pragma: public');

      header('Content-length: ' . filesize($filename));
     ob_clean();
     flush();
     readfile($filename);
     die();

                
                }
               
            }
           
            die();
           }
            
        }
        
    }
    
    public function add_get_val(){
        
        if(isset($_REQUEST['download_pdf'])){
            $postid=$_REQUEST['id'];
            $resumedata=get_post_meta($postid,'resume_files',true);
            if($resumedata)
            {
                $zip = new ZipArchive();
                $filename = "myzipfile.zip";
                if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
                    exit("cannot open <$filename>\n");
                   // echo json_encode(array("status"=>false,"code"=>400,'message'=>'Cannot open Zip file'));
                    //die();
                }
                else{
                $resumefiles=unserialize($resumedata);
                foreach($resumefiles as $file){
                    
                    $path=$file['file'];
                    $url=$file['file_url'];
                    if(file_exists($path))
                    {
                    //echo $path;
                        //die('ghgj');
                     //$zip->addFile(basename($path).file_get_contents($path));
                     $zip->addFromString(basename($path),  file_get_contents($url));  
                    }
                    else{
                        
                    }
                }
                
                 //print_r($zip);
                $zip->close();
                header("Content-type: application/zip");
                header("Content-Disposition: attachment; filename=" . $filename);
                
                readfile($filename);
                unlink($filename);
                //echo $filename;
        
            }
            
            
            
            }
    }
    if(isset($_REQUEST['download_candidate_data']) || isset($_REQUEST['print_candidate_data']) || isset($_REQUEST['cover_file'])){
        
            $postid=$_REQUEST['id'];
             $job_opening_id=get_post_meta($postid,'job_opening_id',true);
            if(isset($_REQUEST['cover_file'])){
            $resumedata=get_post_meta($postid,'cover_file',true);
            if($resumedata)
            {
                $zip = new ZipArchive();
                $filename = "cover_file.zip";
                if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
                    exit("cannot open <$filename>\n");
                    die();
                }
                else
                {
                    $resumefiles=unserialize($resumedata);
                    foreach($resumefiles as $file){
                        
                        $path=$file['file'];
                        $url=$file['file_url'];
                        if(file_exists($path))
                        {
                        
                         $zip->addFromString(basename($path),  file_get_contents($url));  
                        }
                        else{
                            
                        }
                    }
                    
                    $zip->close();
                    header("Content-type: application/zip");
                    header("Content-Disposition: attachment; filename=" . $filename);
                    readfile($filename);
                    unlink($filename);
                    die();
                }
            
            }
            }
            
            $mergearray=array();
       
            $assessment = get_post_meta($job_opening_id,'assessment',true) ? get_post_meta($job_opening_id,'assessment',true):'';
            if($assessment!=''){
                global $wpdb;
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
            
            /*$job_attributes=get_the_terms($job_opening_id,'job-attributes');
            if(!empty($job_attributes)){
              $jobattri_ids=array();
              foreach($job_attributes as $job_attribute){
                  $jobattri_ids[]=$job_attribute->term_id;
                }
                $jobattri_ids=implode(",",$jobattri_ids);
                global $wpdb;
                $tablename = $wpdb->prefix.'job_form_data';
                $jobforms = $wpdb->get_results("SELECT * FROM $tablename where job_attribute IN ($jobattri_ids)");
                if(!empty($jobforms))
                {
                  foreach($jobforms as $jobform){
                      
                    $form=$jobform->job_form;
                    if(is_serialized($form))
                    {
                        $formdata=unserialize($form);
                        $mergearray=array_merge($mergearray,$formdata);
                    }
                  }
                }
            
          }*/
      
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
        
        require_once(plugin_dir_path( __DIR__ ) . 'mpdf/vendor/autoload.php');
         $mpdf = new \Mpdf\Mpdf();
        
         $job_status=get_post_meta($postid,'job_status',true);
         $rating=get_post_meta($postid,'rating',true);
         
         $job_name=get_the_title($job_opening_id);
         $application_title="Application #".$postid." ".$job_name;
         $date=get_the_date('d F Y',$postid);
         $time=get_the_time('g:i a',$postid);
         $submitedd="Submitted on ". $time .", ".$date;
         $job_status="Application Status:". ucfirst($job_status);
         $fullimage="<img src='".plugins_url()."/job-openings/admin/images/starfull.png' class='starfull' alt='...'>";
         $full=plugins_url()."/job-openings/admin/images/startfull.png";
         $empty=plugins_url()."/job-openings/admin/images/starempty.png";
         
         
         $pdfdata="";
         
         $pdfdata.="<style>
         @page *{
    margin-top: 2.54cm;
    margin-bottom: 1cm;
    margin-left: 3.175cm;
    margin-right: 3.175cm;
}
         </style>";
         
         $pdfdata.="<h1 style='color:#000000;font-size:28px;margin:0;padding-bottom:0;'>$application_title</h1>";
         $pdfdata.="<p style='color:#72777c;font-size:14px;'>$submitedd</p>";
         $pdfdata.="<div style='padding-bottom:20px;'><span style='margin-right:30px;color:red;width:100%;'>$job_status</span><span style='float:right;'>";
         for($i=1;$i<=5; $i++){
            
            if($rating)
            {
                if($rating>=$i){
                    
                      $pdfdata.="<img src=$full style='width:20px;'>";
                }
                else{
                    $pdfdata.="<img src=$empty style='width:20px;'>";
                    
                }
            }
            else{
               $pdfdata.="<img src=$empty style='width:20px;'>";
            }
        }   
        
        $pdfdata.="</span></div><div class='inside'><div class='form-table'>";
        $i=1;
        foreach($mergearray as $form)
        {
           
            if($form->type=='text'){
                //data=get_post_meta($postid,$form->name,true);
                $label=isset($form->label) ? $form->label:'';
                $name='name_'.$i;
                $data=isset($form->name) ? get_post_meta($postid,$form->name,true):get_post_meta($postid,$name,true);
                $pdfdata.="<div class='candidate_custom_data' style='border:1px solid #cccccc;border-radius:5px;padding:20px;margin-bottom:10px;'>";
                $pdfdata.="<h4 style='margin:0;padding-bottom:5px;'>$label</h4>";
                $pdfdata.="<p style='margin:0;padding:0;'>$data</p>";
                $pdfdata.="</div>";
            }
             if($form->type=='select'){
                //$data=get_post_meta($postid,$form->name,true);
                 $label=isset($form->label) ? $form->label:'';
                $name='name_'.$i;
                $data=isset($form->name) ? get_post_meta($postid,$form->name,true):get_post_meta($postid,$name,true);
                $pdfdata.="<div class='candidate_custom_data' style='border:1px solid #cccccc;border-radius:5px;padding:20px;margin-bottom:10px;'>";
                $pdfdata.="<h4 style='margin:0;padding-bottom:5px;'>$label</h4>";
                $pdfdata.="<p style='margin:0;padding:0;'>$data</p>";
                $pdfdata.="</div>";
            }
            if($form->type=='textarea'){
                //$data=get_post_meta($postid,$form->name,true);
                 $label=isset($form->label) ? $form->label:'';
                $name='name_'.$i;
                $data=isset($form->name) ? get_post_meta($postid,$form->name,true):get_post_meta($postid,$name,true);
                $pdfdata.="<div class='candidate_custom_data' style='border:1px solid #cccccc;border-radius:5px;padding:20px;margin-bottom:10px;'>";
                $pdfdata.="<h4 style='margin:0;padding-bottom:5px;'>$label</h4>";
                $pdfdata.="<p style='margin:0;padding:0;'>$data</p>";
                $pdfdata.="</div>";
            }
            if($form->type=='number'){
                //$data=get_post_meta($postid,$form->name,true);
                 $label=isset($form->label) ? $form->label:'';
                $name='name_'.$i;
                $data=isset($form->name) ? get_post_meta($postid,$form->name,true):get_post_meta($postid,$name,true);
                $pdfdata.="<div class='candidate_custom_data' style='border:1px solid #cccccc;border-radius:5px;padding:20px;margin-bottom:10px;'>";
                $pdfdata.="<h4 style='margin:0;padding-bottom:5px;'>$label</h4>";
                $pdfdata.="<p style='margin:0;padding:0;'>$data</p>";
                $pdfdata.="</div>";
            }
            if($form->type=='checkbox-group'){
               // $data=get_post_meta($postid,$form->name,true);
                $label=isset($form->label) ? $form->label:'Condition';
                $name='name_'.$i;
                $data=isset($form->name) ? get_post_meta($postid,$form->name,true):get_post_meta($postid,$name,true);
                $pdfdata.="<div class='candidate_custom_data' style='border:1px solid #cccccc;border-radius:5px;padding:20px;margin-bottom:10px;'>";
                $pdfdata.="<h4 style='margin:0;padding-bottom:5px;'>$label</h4>";
                $pdfdata.="<p style='margin:0;padding:0;'>$data</p>";
                $pdfdata.="</div>";
            }
            if($form->type=='date'){
                //$data=get_post_meta($postid,$form->name,true);
                 $label=isset($form->label) ? $form->label:'';
                $name='name_'.$i;
                $data=isset($form->name) ? get_post_meta($postid,$form->name,true):get_post_meta($postid,$name,true);
                $pdfdata.="<div class='candidate_custom_data' style='border:1px solid #cccccc;border-radius:5px;padding:20px;margin-bottom:10px;'>";
                $pdfdata.="<h4 style='margin:0;padding-bottom:5px;'>$label</h4>";
                $pdfdata.="<p style='margin:0;padding:0;'>$data</p>";
                $pdfdata.="</div>";
            }
            if($form->type=='radio-group'){
                //$data=get_post_meta($postid,$form->name,true);
                 $label=isset($form->label) ? $form->label:'Condition';
                $name='name_'.$i;
                $data=isset($form->name) ? get_post_meta($postid,$form->name,true):get_post_meta($postid,$name,true);
                $pdfdata.="<div class='candidate_custom_data' style='border:1px solid #cccccc;border-radius:5px;padding:20px;margin-bottom:10px;'>";
                $pdfdata.="<h4 style='margin:0;padding-bottom:5px;'>$label</h4>";
                $pdfdata.="<p style='margin:0;padding:0;'>$data</p>";
                $pdfdata.="</div>";
            }
            //  if($form->type=='file'){
                
            //     }
            $i=$i+1;
        }
        if ( metadata_exists( 'post', $postid, 'resume_files' ) ) 
                    {
                         $data=get_post_meta($postid,'resume_files',true);
                         $resumedata=unserialize($data);
                         if(!empty($resumedata)){
                            $pdfdata.="<div class='candidate_custom_data' style='border:1px solid #cccccc;border-radius:5px;padding:20px;margin-bottom:10px;'>";
                            $pdfdata.="<h4 style='margin:0;padding-bottom:5px;'>Resume Files</h4>";
                            foreach($resumedata as $filedata){
                              
                                 $image_url=$filedata['file_url'];
                                 $pdfdata.="<h6>$image_url</h6>";
                              
                            }
                            $pdfdata.="</div>";
                         }
                    }
                    if ( metadata_exists( 'post', $postid, 'cover_file' ) ) 
                    {
                         $data=get_post_meta($postid,'cover_file',true);
                         $resumedata=unserialize($data);
                         if(!empty($resumedata)){
                            $pdfdata.="<div class='candidate_custom_data' style='border:1px solid #cccccc;border-radius:5px;padding:20px;margin-bottom:10px;'>";
                           $pdfdata.="<h4 style='margin:0;padding-bottom:5px;'>Cover files</h4>";
                            foreach($resumedata as $filedata){
                              
                                 $image_url=$filedata['file_url'];
                                 
                                 $pdfdata.="<h6>$image_url</h6>";
                              
                            }
                            $pdfdata.="</div>";
                         }
                    }
        $pdfdata.="</div></div>";
        $mpdf->WriteHTML($pdfdata);
        if(isset($_REQUEST['print_candidate_data'])){
            $mpdf->Output();
        }
        else{
            $mpdf->Output('MyPDF.pdf', 'D');
        }
    }
    }
    
    public function set_custom_edit_application_columns($columns){
        
        unset( $columns['date'] );
        $columns['title'] = __( 'Applicant', 'your_text_domain' );
        $columns['id'] = __( 'ID', 'your_text_domain' );
        $columns['job'] = __( 'Job', 'your_text_domain' );
        $columns['applied_on'] = __( 'Applied On', 'your_text_domain' );
        $columns['status'] = __( 'Status', 'your_text_domain' );
        $columns['notes'] = __( 'Notes', 'your_text_domain' );
        $columns['rating'] = __( 'Rating', 'your_text_domain' );
        return $columns;
        
    }
    
    public function custom_application_column($column, $post_id){
        
        $job_opening_id=get_post_meta( $post_id , 'job_opening_id' , true );
        //echo $job_opening_id;
        
        
        switch ( $column ) {
        
        case 'id' :
            $job_id=get_post_meta( $job_opening_id , 'job_id' , true );
            echo $job_id ? $job_id:'';
            
            break;
        case 'job' :
            $job=get_the_title( $job_opening_id);
            echo $job ? $job:'';
            break; 
            
        case 'applied_on' :
            echo $this->time_elapsed_string(get_the_date(), true) ? $this->time_elapsed_string(get_the_date(), true):'';
            break;  
            
        case 'status' :
        $status=get_post_meta( $post_id , 'job_status' , true );
        if($status=='inprogress'){
             echo "<span class='inprogress'>In Progress</span>";
        }
        if($status=='shortlisted'){
             echo "<span class='shortlisted'>Shortlisted</span>";
        }
        if($status=='rejected'){
             echo "<span class='rejected'>Rejected</span>";
        }
         if($status=='selected'){
             echo "<span class='selected'>Selected</span>";
        }
       
        break;  
        
        case 'notes' :
        $candidate_notes=get_post_meta( $post_id , 'candidate_notes' , true );
        if($candidate_notes){
            
            echo $candidate_notes;
            break; 
        
        }
        else{
            echo "----";
            break; 
            
        }
        case 'rating' :
        $rating=get_post_meta( $post_id , 'rating' , true );
        for($i=1;$i<=5; $i++){
            
            if($rating)
            {
                if($rating>=$i){
                    
                     ?><div class="star star-full" aria-hidden="true"></div><?php
                }
                else{
                    ?><div class="star star-empty" aria-hidden="true"></div><?php
                }
            }
            else{
                 ?><div class="star star-empty" aria-hidden="true"></div><?php
            }
        }   
        
        break;  

        

    }
    }
    public function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
    
    
     public function mail_form_ajax(){
         
        if(!empty($_POST))
        {
            function jobs_sanitize_textarea( $input ) {
        		if ( function_exists( 'sanitize_textarea_field' ) ) {
        			$input = sanitize_textarea_field( $input );
        		} else {
        			$input = esc_textarea( $input );
        		}
        		return $input;
        	}
           $post_id = intval( $_POST['application_id'] );
           $cc            = sanitize_text_field( wp_unslash( $_POST['applicant_cc'] ) );
		   $subject       = sanitize_text_field( wp_unslash( $_POST['applicant_subject'] ) );
		   $mail_content  = jobs_sanitize_textarea( wp_unslash( $_POST['applicant_content'] ) );
		   $applicant_email       = sanitize_text_field( wp_unslash( $_POST['applicant_email'] ) );
			
			
               
			
			if ( empty( $subject ) || empty( $mail_content ) ) {
			    
				echo json_encode(array("status"=>false,"code"=>400,'message'=>'Subject and mail content required!'));
                die();
			}
			
			$current_user = wp_get_current_user();
            $email=$current_user->user_email;
            $firstname=$current_user->user_login;
            $date = date('M d,Y @ h:i');
            
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'Cc: '.$cc. "\r\n";
            // Create email headers
            $headers .= 'From: '.$email."\r\n".
                'Reply-To: '.$email."\r\n" .
                'X-Mailer: PHP/' . phpversion();

            $sent=wp_mail( $applicant_email, $subject, $mail_content,$headers );
            if($sent)
            {
                $user_id      = get_current_user_id();
    			$current_time = current_time( 'timestamp' );
    			$mails_meta   = get_post_meta( $post_id, 'application_mails', true );
    			$mails        = ! empty( $mails_meta ) && is_array( $mails_meta ) ? $mails_meta : array();
    			$mail_data    = array(
    				'send_by'       => $user_id,
    				'mail_date'     => $current_time,
    				'cc'            => $cc,
    				'subject'       => $subject,
    				'mail_content'  => $mail_content,
    				'applicant_email' => $applicant_email,
    			);
    			$mails[]      = $mail_data;
    			$updated = update_post_meta( $post_id, 'application_mails', $mails );
    			if ( $updated ) {
    			        $message="Application Mail Sent";
    // 			        $activities   = get_post_meta( $post_id, 'activity_log', true );
				// 		$activities   = ! empty( $activities ) && is_array( $activities ) ? $activities : array();
				// 		$activities[] = array("message"=>$message,"username"=>$firstname,"date"=>$date);
				// 		update_post_meta( $post_id, 'activity_log', $activities );
						
						
						if ( metadata_exists( 'post', $post_id, 'activity_log' ) ) 
                        {
                            
                            $activity_log=get_post_meta($post_id, 'activity_log', true);
                            $mainarray=unserialize($activity_log);
                            $user_view_activity=array("message"=>$message,"username"=>$firstname,"date"=>$date);
                            array_push($mainarray,$user_view_activity);
                            $activity_log=serialize($mainarray);
                            update_post_meta($post_id, 'activity_log', $activity_log);
                        }
                        else{
                                $mainarray=array();
                                $user_view_activity=array("message"=>$message,"username"=>$firstname,"date"=>$date);
                                array_push($mainarray,$user_view_activity);
                                $activity_log=serialize($mainarray);
                                add_post_meta($post_id, 'activity_log', $activity_log);
                        }
						
						
						echo json_encode(array("status"=>true,"code"=>200,'message'=>'Email sent!'));
                        die();
    			    
    			}
            } 
            else
            {
            	echo json_encode(array("status"=>false,"code"=>400,'message'=>'Email No sent!'));
                die();
            }
			
			
			
			
        }
         
     }   
     
    public function post_types_admin_order( $wp_query ) {
  if (is_admin()) {

//   $post_type = $wp_query->query['post_type'];

//   if ( $post_type == 'jobs-application') { //like post 

//     $wp_query->set('orderby', 'date'); //like comments

//     $wp_query->set('order', 'DESC'); //change order
//   }

  }

 }
 
 public function jobtype_form_ajax(){
     
       if(isset($_POST))
        {
           if(!empty($_POST['postdata']))
           {
                parse_str($_POST['postdata'], $postdata);
                
                if(!empty($postdata))
                {
                    $job_type=$postdata['job_type'];
                   // echo $job_type;
                   
                    global $wpdb;
                    $tablename = $wpdb->prefix.'job_types';
                    $jobedit_form = $wpdb->get_row("SELECT * FROM $tablename where name='$job_type'");
                    
                    if(empty($jobedit_form)){
                        
                         $data=array(
                        'name' => $job_type
                         );
    
                        $result = $wpdb->insert( $tablename,$data);
                        if($result){
                            echo json_encode(array("formid"=>$result,"status"=>true,"code"=>200,'message'=>"Job Type Inserted"));
                            die();
                        }
                        else{
                            echo json_encode(array("formid"=>$result,"status"=>false,"code"=>400,'message'=>'Something Wrong!'));
                            die();
                        }
                        
                    }else{
                        echo json_encode(array("status"=>false,"code"=>400,'message'=>'Job Type already exist!'));
                        die();
                    }
                }
                else{
                      echo json_encode(array("status"=>false,"code"=>400,'message'=>'Something Wrong!'));
                        die();
                }
            
           }
           else{
               echo json_encode(array("status"=>false,"code"=>400,'message'=>'Something Wrong!'));
                    die();
           }
       
        }
     
     die('');
 }
    
   public function edit_jobtype_ajax(){
    
    
    if(isset($_POST))
    {
       if(!empty($_POST['postdata'])){

            parse_str($_POST['postdata'], $postdata);
            $typename=$postdata['typename'];
            $jobid=$postdata['jobid'];
           
            global $wpdb;
            $tablename = $wpdb->prefix.'job_types';
            $jobedit_form = $wpdb->get_row("SELECT * FROM $tablename where name='$typename' and id != $jobid");
            if(empty($jobedit_form)){
                
                $data=array(
                    'name' => $typename, 
                 );
                 
                $result=$wpdb->update( $tablename, $data,array('id' => $jobid ));
                //echo $result;
                //echo $wpdb->last_query;
                
                if($result){
                    echo json_encode(array("formid"=>$result,"status"=>true,"code"=>200,'message'=>"Type Updated"));
                    die();
                }
                else{
                     echo json_encode(array("status"=>false,"code"=>400,'message'=>'Something Wrong!'));
                    die();
                }
            }
            else{
                echo json_encode(array("status"=>false,"code"=>400,'message'=>'Job Type already exist!'));
                die();
            }
            
            die();
       }
    }
    
      
    }
    
    public function assesment_form_ajax(){
        
       if(isset($_POST))
        {
           if(!empty($_POST['postdata'])){
               
            parse_str($_POST['postdata'], $postdata);
            $name=$postdata['name'];
            $assessment_type=$postdata['assessment_type'];
            $traitsdata=$postdata['traitsdata'];
            global $wpdb;
            $assign_table = $wpdb->prefix.'job_assesments';
            $assignment_data=array(
                    'name' => $name, 
                    'type' => $assessment_type,
                    'traits' => $traitsdata,
                );
                
                $result_assign = $wpdb->insert( $assign_table, $assignment_data);
                if($result_assign){
                    echo json_encode(array("formid"=>$result_assign,"status"=>true,"code"=>200,'message'=>"New Assessment Inserted"));
                     die();
                 }
                 else{
                 echo json_encode(array("status"=>false,"code"=>400,'message'=>'Something Wrong!'));
                    die();
                }
            
               
           }
            
        }
        
    }
    
    public function edit_assesment_form_ajax(){
        if(isset($_POST))
        {
           if(!empty($_POST['postdata'])){
               
            parse_str($_POST['postdata'], $postdata);
            $name=$postdata['name'];
            $assessment_type=$postdata['assessment_type'];
            $traitsdata=$postdata['traitsdata'];
            $assesment_id=$postdata['assesment_id'];
            global $wpdb;
            $assign_table = $wpdb->prefix.'job_assesments';
            $assignment_data=array(
                    'name' => $name, 
                    'type' => $assessment_type,
                    'traits' => $traitsdata,
                );
                
                $result_assign = $wpdb->update( $assign_table, $assignment_data,array('id'=>$assesment_id));
                if($result_assign){
                    echo json_encode(array("formid"=>$result_assign,"status"=>true,"code"=>200,'message'=>"Assessment Updated"));
                     die();
                 }
                 else{
                 echo json_encode(array("status"=>false,"code"=>400,'message'=>'Something Wrong!'));
                    die();
                }
            
               
           }
            
        }
        
        die();
    }
    
    public function assesment_traits_form_ajax(){
        
       if(isset($_POST))
        {
           if(!empty($_POST['postdata'])){
               
            parse_str($_POST['postdata'], $postdata);
            $assignment_name=$postdata['assignment_name'];
            $type=$postdata['type'];
            $trait_name=$postdata['trait_name'];
            if($assignment_name==''){
                
                echo json_encode(array("status"=>false,"code"=>400,'message'=>"Assessment Name is required"));
                die();
            }
            
            if($type==''){
                
                echo json_encode(array("status"=>false,"code"=>400,'message'=>"Assessment Type is required"));
                die();
            }
            $formdata=$_POST['formdata'];
            if(isset($formdata) && !empty($formdata))
            {
                

                $decoded = json_decode(stripslashes($formdata));
                $formdata=serialize($decoded);
                global $wpdb;
                $trait_table = $wpdb->prefix.'job_traits';
                $assign_table = $wpdb->prefix.'job_assesments';
               
                $data=array(
                    'traits' => $trait_name, 
                    'form_data' => $formdata,
                    
                );

                $result = $wpdb->insert( $trait_table, $data);
                $traitid = $wpdb->insert_id;
                
                $assignment_data=array(
                    'name' => $assignment_name, 
                    'type' => $type,
                    'traits' => $traitid,
                );
                
                $result_assign = $wpdb->insert( $assign_table, $assignment_data);
                if($result_assign){
                    echo json_encode(array("formid"=>$result_assign,"status"=>true,"code"=>200,'message'=>"Assessment Inserted"));
                     die();
                 }
                 else{
                 echo json_encode(array("status"=>false,"code"=>400,'message'=>'Something Wrong!'));
                    die();
                }
                
                
            }
            
           }
        }  

    }
    
    public function update_traits_form_ajax(){
        
       if(isset($_POST))
        {
           if(!empty($_POST['postdata'])){
              
                parse_str($_POST['postdata'], $postdata);
                
                
                $trait_id=$postdata['trait_id'];
                $assignment_name=$postdata['assignment_name'];
                $type=$postdata['type'];
                $trait_name=$postdata['trait_name'];
                $assesment_id=$postdata['assesment_id'];
                $formdata=$_POST['formdata'];
                
                
                
                if(isset($formdata) && !empty($formdata))
                {
                
                    $decoded = json_decode(stripslashes($formdata));
                    $formdata=serialize($decoded);
                    global $wpdb;
                    $assign_table = $wpdb->prefix.'job_assesments';
                    $job_traits = $wpdb->prefix.'job_traits';
                    
                    $assignment_data=array(
                        'name' => $assignment_name, 
                        'type' => $type,
                        'traits' => $trait_id,
                    );
                        
                    $result_trait = $wpdb->update( $assign_table, $assignment_data,array('id'=>$assesment_id));
                    
                    $traits_data=array(
                        'traits' => $trait_name, 
                        'form_data' => $formdata,
                    );
                        
                    $result_assign = $wpdb->update( $job_traits, $traits_data,array('id'=>$trait_id));
                    
                    //echo $result_assign;
                    
                    
                    
                    if($result_assign){
                        echo json_encode(array("formid"=>$result_assign,"status"=>true,"code"=>200,'message'=>"Assessment Updated"));
                        die();
                     }
                     else{
                     echo json_encode(array("status"=>false,"code"=>400,'message'=>'Something Wrong!'));
                        die();
                    }
                }
           }
            
        }
    }
    
    public function deletejob_form_ajax(){
        
        if(isset($_POST)){
            $id=$_POST['postdata'];
            if($id!=''){
                global $wpdb;
                $tablename = $wpdb->prefix.'job_types';
                $result = $wpdb->get_row("delete FROM $tablename where id=$id");
                if($result){
                    echo json_encode(array("status"=>true,"code"=>200,'message'=>"Job type deleted"));
                    die();
                }
                else{
                    echo json_encode(array("status"=>true,"code"=>200,'message'=>"Job type deleted"));
                    die();
                }
            }
            else{
                
                echo json_encode(array("status"=>false,"code"=>400,'message'=>"Delete id not found!"));
                die();
            }
                 
        }
        else{
            echo json_encode(array("status"=>false,"code"=>400,'message'=>"Delete id not found!"));
            die();
        }
    }
        
}

