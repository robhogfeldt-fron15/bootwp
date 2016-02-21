<?php



require_once('wp_bootstrap_navwalker.php');



add_action( 'after_setup_theme', 'bootwp_setup' );
    if ( ! function_exists( 'bootwp_setup' ) ):
        function bootwp_setup() {
            register_nav_menu( 'primary', __( 'Primary navigation', 'bootwp' ) );
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
class BS3_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth. It is possible to set the
	 * max depth to include all depths, see walk() method.
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @since 2.5.0
	 *
	 * @param object $element Data object
	 * @param array $children_elements List of elements to continue traversing.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of current element.
	 * @param array $args
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */
	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		$id_field = $this->db_fields['id'];

		if ( isset( $args[0] ) && is_object( $args[0] ) )
		{
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );

		}

		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		if ( is_object($args) && !empty($args->has_children) )
		{
			$link_after = $args->link_after;
			// $args->link_after = ' <b class="caret"></b>';
		}

		parent::start_el($output, $item, $depth, $args, $id);

		if ( is_object($args) && !empty($args->has_children) )
			$args->link_after = $link_after;
	}

	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		// $output .= "\n$indent<ul class=\"dropdown-menu list-unstyled\">\n";
    $output .= "\n$indent<ul class=\"sub\">\n";
	}
}
add_filter('nav_menu_link_attributes', function($atts, $item, $args) {
	if ( $args->has_children )
	{
		// $atts['data-toggle'] = 'dropdown';
		$atts['class'] = 'sub-menu dcjq-parent';
	}

	return $atts;
}, 10, 3);
