<?php 

if ( function_exists( 'register_block_pattern_category' ) ) {
    function mypatterngut_register_pattern_categories() {
      register_block_pattern_category(
        'mypatterns',
        array( 'label' => __( 'MyPatterns', 'boatconfig' ) )
      );
    }
    add_action( 'init', 'mypatterngut_register_pattern_categories' );
  }
  

function register_boat_config_pattern() {

    register_block_pattern(
        'boat-configurator/boat-config-pattern',
        array(
            'title'       => __( 'Laivo konfigūratorius', 'boat-configurator' ),
            'description' => _x( 'Laivo konfigūratorius', 'boat-configurator' ),
            'content'     => BOAT_CONFIG_PATTERN,
        )
    );

}
add_action( 'init', 'register_boat_config_pattern' );


