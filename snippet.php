<?php

	/**
	 * @snippet       Schedule Elementor Popup
	 * @sourcecode    https://github.com/spiderjay/schedule-elementor-popup
	 * @author        Jay Phillips
	 * @compatible    Wordpress 5.6.1
	 */

	$sched_popup_control = 	array(
					'id'	=> '100',			/* the post ID for the Popup */
					'show'	=> '2021-01-01 00:00:00',	/* the date / time to enable the Popup */
					'hide'	=> '2021-01-31 23:59:59'	/* the date / time to disable the Popup */
				);
	
	// get/set the timezone setting from wordpress
	$tz = wp_timezone_string();
	date_default_timezone_set($tz);

	// create datetime object 
	$dt = new DateTime();
	$dt->setTimezone(new DateTimeZone($tz));

	// current timestamp in correct time zone
	$ts_now = $dt->getTimestamp();
	
	// change datetime object to the 'show' time
	$dt = new DateTime( $sched_popup_control['show'] );	
	$dt->setTimezone(new DateTimeZone($tz));
	
	// timestamp for show time
	$ts_show = $dt->getTimestamp();
	
	// change datetime object to the 'hide' time
	$dt = new DateTime( $sched_popup_control['hide'] );	
	$dt->setTimezone(new DateTimeZone($tz));
	
	// timestamp for hide time
	$ts_hide = $dt->getTimestamp();
	
	// show post/popup if time matches
	if ( $ts_now > $ts_show && $ts_now < $ts_hide ){
		$post = array( 'ID' => $sched_popup_control['id'], 'post_status' => 'publish' );
		wp_update_post($post);		
	}
	
	// hide post/popup if time doesn't match
	if ( $ts_now > $ts_hide || $ts_now < $ts_show ){
		$post = array( 'ID' => $sched_popup_control['id'], 'post_status' => 'draft' );
		wp_update_post($post);
	}
