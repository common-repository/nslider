<?php
/*
    Plugin Name: Nslider
    Description: This is a simple wordpress plugin which can add a slideshow with thumbnails in your wordpress site
    Author: Bhanu pratap singh
    Version: 1.0
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

add_action( 'init', 'nslider_posttype' );

function nslider_posttype() {
  register_post_type( 'nslider',
    array(
      'label' => 'NSlider',
	  'menu_icon' => plugins_url( 'images/icon.png' , __FILE__ ),
	  'supports' => array(
            'title',
			'editor',
			'custom-fields',
            'thumbnail'),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'nslider'),
    )
  );
}

/*
*
*
************* Register your scripts *******************
*
*
*/
// 

add_action( 'wp_enqueue_scripts', 'nslider_register_scripts' );

function nslider_register_scripts() {
    if (!is_admin()) {
        // register
        wp_register_script('slider_script', plugins_url('js/js-image-slider.js', __FILE__));
 
        // enqueue
        wp_enqueue_script('slider_script');
    }
}

/*
*
************* Register your stylesheets *******************
*
*/

add_action( 'wp_enqueue_scripts', 'nslider_styles' );

function nslider_styles() {
	wp_register_style( 'slider_style', plugins_url( 'nslider/css/js-image-slider.css' ) );
	wp_enqueue_style( 'slider_style' );
}


/*
*
*
Function to show slides
*
*
*/

function nslider_function() {
    $args = array(
        'post_type' => 'nslider',
        'posts_per_page' => 5
    );

	echo '<div id="sliderFrame">';
    echo '<div id="slider">';
	
    //the loop
    $loop = new WP_Query($args);
    while ($loop->have_posts()) {
        $loop->the_post();
 
        $the_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $type);
        $result .='<img title="'.get_the_title().'" src="' . $the_url[0] . '" />';
		
		}
	echo $result;
	
    echo '</div> <!-slider-->';
	
	echo '<div id="thumbs">';
	
	$loop = new WP_Query($args);
    while ($loop->have_posts()) {
        $loop->the_post();
		
		$the_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $type);
		
            echo '<div class="thumb">';
                echo '<div class="frame"><img src="' . $the_url[0] . '" /></div>';
                echo '<div class="thumb-title"><p>'. get_the_title() .'</p></div>';
				echo '<br>';
				echo '<div class="thumb-content" >'. the_content() .'</div>';
                echo '<div style="clear:both;"></div>';
            echo '</div> <!--thumb-->';
			}
	echo '</div> <!--thumbs-->';
	
	echo '</div><!--sliderFrame-->';
	
}

/*
*
*
Add Short code
*
*
*/

add_shortcode('nslider-shortcode', 'nslider_function');


?>