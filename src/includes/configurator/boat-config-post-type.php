<?php

function cpt_register_post_type()
{


    $labels = array(
		'name'                  => 'Laivo konfigūratorius',
		'singular_name'         => 'Laivo konfigūratorius',
		'menu_name'             => 'Laivo konfigūratorius',
		'name_admin_bar'        => 'Laivo konfigūratorius',
		'add_new'               => 'Sukurti naują',
		'add_new_item'          => 'Sukurti naują',
		'new_item'              => 'Naujas konfigūratorius',
		'edit_item'             => 'Koreguoti',
		'view_item'             => 'Peržiūrėti',
		'all_items'             => 'Visi',
		'search_items'          => 'Ieškoti',
		'parent_item_colon'     => 'parent_item_colon',
		'not_found'             => 'Konfigūratorių nėra',
		'not_found_in_trash'    => 'Konfigūratorių šiukšlinėje nėra',
		'featured_image'        => 'Laivo modelio nuotrauka',
		'set_featured_image'    => 'Nustatyti laivo modelio nuotrauką',
		'remove_featured_image' => 'Ištrinti laivo modelio nuotrauką',
		'use_featured_image'    => 'Naudoti laivo modelio nuotrauką',
		'archives'              => 'Laivo konfigūratorių archyvas',
		'insert_into_item'      => 'Įterpti į konfigūratorių',
		'uploaded_to_this_item' => 'Įkelta į konfigūratorių',
		'filter_items_list'     => 'Filtruoti konfigūratorių sąrašą',
		'items_list_navigation' => 'Konfigūratorių sąrašo navigacija',
		'items_list'            => 'Konfigūratorių sąrašas',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => false,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'boat-configurator' ),
		'capability_type'    => 'page',
		'has_archive'        => true,
        'show_in_rest'          => true,
		//'hierarchical'       => false,
		//'menu_position'      => null,
		'taxonomies'          => array( 'category' ),
		'supports'           => array( 'thumbnail', 'editor' ),
        'template'              => array(
            array(
				array( 'core/image', array(
					'align' => 'left',
				) ),
				array( 'core/heading', array(
					'placeholder' => 'Add Author...',
				) ),
				array( 'core/paragraph', array(
					'placeholder' => 'Add Description...',
				) ),
			),
        ),
	);

    register_post_type('boat_config', $args);
};

add_action('init', 'cpt_register_post_type');

// function configurator_template($template) {
//     if (is_singular('boat_config')) {
//         $custom_template = plugin_dir_path(__FILE__) . 'templates/single-boat-config.html';
//         if (file_exists($custom_template)) {
//             return $custom_template;
//         }
//     }
//     return $template;
// }
// add_filter('template_include', 'configurator_template');

// add_filter( 'template_include', 'configurator_template' );
// function configurator_template( $template ) {

//     $post_type = 'boat_config'; // Change this to the name of your custom post type!

//     if ( is_post_type_archive( $post_type ) && file_exists( plugin_dir_path(__DIR__) . "templates/archive-$post_type.php" ) ){
//         $template = plugin_dir_path(__DIR__) . "templates/archive-$post_type.php";
//     }

//     if ( is_singular( $post_type ) && file_exists( plugin_dir_path(__DIR__) . "templates/single-$post_type.php" ) ){
//         $template = plugin_dir_path(__DIR__) . "templates/single-$post_type.php";
//     }

//     return $template;
// }

// add_filter( 'single_template', 'boat_config_template' );
// function boat_config_template($single_template) {
//      global $post;

//      if ($post->post_type == 'boat_config' ) {
//           $single_template = dirname( __FILE__ ) . '/templates/single-boat-config.html';
//      }
//      return $single_template;
  
// }


