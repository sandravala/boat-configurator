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
		'rewrite'            => array( 'slug' => 'boat-config' ),
		'capability_type'    => 'page',
		'has_archive'        => true,
        'show_in_rest'          => true,
		//'hierarchical'       => false,
		//'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'template'              => array(
            array(
                'core/pattern',
                array(
                    'slug' => 'boat-configurator/boat-config-pattern',
                ),
            ),
        ),
	);

    register_post_type('boat_config', $args);
};

add_action('init', 'cpt_register_post_type');


