<?php

if( ! isset( $content_width )){
    $content_width = 660;
}
function bootwp_setup(){

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');

}

require_once('wp_bootstrap_navwalker.php');

add_action('after_setup_theme', 'bootwp_setup');

add_action( 'after_setup_theme', 'wpt_setup' );
    if ( ! function_exists( 'wpt_setup' ) ):
        function wpt_setup() {
            register_nav_menu( 'primary', __( 'Primary navigation', 'wptuts' ) );
        } endif;



function bootwp_scripts(){

    /*add styles*/
    wp_enqueue_style( 'style', get_template_directory_uri() . './style.css' );


    // /*add scripts*/
    wp_enqueue_script( 'chart', get_template_directory_uri() . './assets/js/chart-master/Chart.js', array('jquery'), true );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . './assets/js/bootstrap.min.js', array('jquery'),"", true );
    wp_enqueue_script( 'acc', get_template_directory_uri() . './assets/js/jquery.dcjqaccordion.2.7.js', array('jquery'),"", true );

    wp_enqueue_script( 'tomin', get_template_directory_uri() . './assets/js/jquery.scrollTo.min.js', array('jquery'),"", true );
    wp_enqueue_script( 'nice', get_template_directory_uri() . './assets/js/jquery.nicescroll.js', array('jquery'),"", true );
    wp_enqueue_script( 'saprk', get_template_directory_uri() . './assets/js/jquery.sparkline.js', array('jquery'),"", true );

    wp_enqueue_script( 'common-scripts', get_template_directory_uri() . './assets/js/common-scripts.js', array('jquery'),"", true );
    wp_enqueue_script( 'gritter-js', get_template_directory_uri() . './assets/js/gritter/js/jquery.gritter.js', array('jquery'),"", true );
    wp_enqueue_script( 'gritter-conf', get_template_directory_uri() . './assets/js/gritter-conf.js', array('jquery'),"", true );



    wp_enqueue_script( 'saprk-chart', get_template_directory_uri() . './assets/js/sparkline-chart.js', array('jquery'),"", true );
    wp_enqueue_script( 'zabuto', get_template_directory_uri() . './assets/js/zabuto_calendar.js', array('jquery'),"", true );


}

add_action('wp_enqueue_scripts', 'bootwp_scripts');
