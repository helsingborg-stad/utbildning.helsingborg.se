<?php

add_action('wp_head',function() {
   echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
});


add_filter('Municipio/load-wp-jquery', function() {
		return true;
	});