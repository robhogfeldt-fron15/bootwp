<?php



require_once('wp_bootstrap_navwalker.php');



add_action( 'after_setup_theme', 'bootwp_setup' );
    if ( ! function_exists( 'bootwp_setup' ) ):
        function bootwp_setup() {
            register_nav_menu( 'primary', __( 'Primary navigation', 'bootwp' ) );
        } endif;


add_filter('show_admin_bar', '__return_false');

function bootwp_scripts(){

    /*add styles*/
    /*Övrig CSS imorteras via style.css*/
    /*Best practice verkade dock vara att köra alla här...*/
    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );


    /*add scripts*/
    /*TODO Fixa conditional_script_loading() */
    /*TODO Kolla vilka script som verkligen är beroende av jquery... */
    wp_enqueue_script( 'chart', get_template_directory_uri() . '/assets/js/chart-master/Chart.js', array('jquery'), true );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'),"", true );
    wp_enqueue_script( 'acc', get_template_directory_uri() . '/assets/js/jquery.dcjqaccordion.2.7.js', array('jquery'),"", true );

    wp_enqueue_script( 'tomin', get_template_directory_uri() . '/assets/js/jquery.scrollTo.min.js', array('jquery'),"", true );
    wp_enqueue_script( 'nice', get_template_directory_uri() . '/assets/js/jquery.nicescroll.js', array('jquery'),"", true );
    wp_enqueue_script( 'saprk', get_template_directory_uri() . '/assets/js/jquery.sparkline.js', array('jquery'),"", true );

    wp_enqueue_script( 'common-scripts', get_template_directory_uri() . '/assets/js/common-scripts.js', array('jquery'),"", true );
    wp_enqueue_script( 'gritter-js', get_template_directory_uri() . '/assets/js/gritter/js/jquery.gritter.js', array('jquery'),"", true );
    wp_enqueue_script( 'gritter-conf', get_template_directory_uri() . '/assets/js/gritter-conf.js', array('jquery'),"", true );



    wp_enqueue_script( 'saprk-chart', get_template_directory_uri() . '/assets/js/sparkline-chart.js', array('jquery'),"", true );
    wp_enqueue_script( 'zabuto', get_template_directory_uri() . '/assets/js/zabuto_calendar.js', array('jquery'),"", true );

    wp_enqueue_script( 'chartjs', get_template_directory_uri() . '/assets/js/chartjs-conf.js', array('jquery'),"", true );
    wp_enqueue_script( 'morris', get_template_directory_uri() . '/assets/js/morris-conf.js', array('jquery'),"", true );


}

add_action('wp_enqueue_scripts', 'bootwp_scripts');


function create_widget($name, $id, $description){
  register_sidebar(array(
    'name' => __($name),
    'id' => $id,
    'description' => __($description),
    // 'before_widget' => '<li id="%1$s" class="widget %2$s">',
    // 'after_widget' => "</li>n",
    'before_title' => '<h2 class="widgettitle">',
    // 'after_title' => "</h2>n"
  ));


}
create_widget('Dashboard Top Left', 'dashboard-top-left', 'Display on the top left of dashboard');
create_widget('Dashboard Top Center', 'dashboard-top-center', 'Display on the top center of dashboard');
create_widget('Dashboard Top Right', 'dashboard-top-right', 'Display on the top right of dashboard');






// IMPORTERA
//
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
		// $atts['data-toggle'] = 'dropdown'; // Vill ej toogla menyn då den sköts via externt script
		$atts['class'] = 'sub-menu dcjq-parent';
	}

	return $atts;
}, 10, 3);
