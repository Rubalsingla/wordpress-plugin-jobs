<?php

function availability() 
{

    /*New Code Push By Ravi */
    /*testing */
    /* New Branch by Rubal changes */
    /* by admin*/


    global $wpdb;
    $Bikes = $wpdb->prefix.'posts';
    $getbikes = $wpdb->get_results("Select * from $Bikes where post_type = 'motorcycle' and post_status='publish'");
    $getlocation = $wpdb->get_results("Select * from $Bikes where post_type = 'location' and post_status='publish'");

    
    
    ?>
  <h1>Create Bikes availability</h1> 
  <p></p>
  <form action="/action_page.php">
  <label for="bikes">Select Bikes:</label><br>
  <select>
      <option>Select Bike</option>
      <?php
      if(!empty($getbikes)){
        foreach ($getbikes as $bikes) {

            ?> <option value="<?php echo $bikes->ID; ?>"> <?php echo $bikes->post_title; ?></option><?php
            
        }

      }
      ?>

  </select><br><br>
  <label for="bikes">Select location:</label><br>
  <select>
      <option>Select Location</option>
      <?php
      if(!empty($getlocation)){
        foreach ($getlocation as $location) {

            ?> <option value="<?php echo $location->ID; ?>"> <?php echo $location->post_title; ?></option><?php
            
        }

      }
      ?>


  </select><br><br>
  <label for="bikes">Start date:</label> <br>
  <input type="date" id="startdate" name="enddate" value=""><br><br>
   <label for="bikes">End date:</label> <br>
  <input type="date" id="enddate" name="enddate" value=""><br><br>
 
  <input type="submit" value="Submit">
</form> 
        <?php
}

/* New Testing */

?>
