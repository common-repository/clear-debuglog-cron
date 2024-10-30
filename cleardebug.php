<?php
/*
Plugin Name: Clear Debug.log Cron
Plugin URI: http://www.wpsupprt.co.uk
Author: SN
Version: 0.1
*/



add_action('debug_cron_jobs','debug_cron_func');

//calling the cron function 

if(!wp_next_scheduled('debug_cron_jobs'))
wp_schedule_event(time(),'hourly','debug_cron_jobs');


// a function to add a option in the options table
function debug_cron_func(){
  if($a=get_option('debug_cron'))
  update_option('debug_cron',$a.'+');
  else
  add_option('debug_cron','init_value');
  
  //delete debug.log
  $dir = ABSPATH . 'wp-content/';
  $debugfile = $dir."debug.log"; 
  unlink($debugfile);
}

//for clearing the sceduled tasks
register_deactivation_hook(__FILE__,'deactivate_cron_hook');

function deactivate_cron_hook(){
wp_clear_scheduled_hook('debug_cron_jobs');
}
?>