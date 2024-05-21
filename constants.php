<?php

define('MAILERLITE_KEY', '');

define( 'DB_TABLE', 'boat_config_table' );
define( 'CONFIG_ICON', plugin_dir_url( __FILE__ ) . 'src/assets/icon.svg');
define('BOAT_CONFIG_PATTERN', 
'<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"0","left":"var:preset|spacing|10"},"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20"}}}} -->
<div class="wp-block-columns alignwide" style="padding-right:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:column {"verticalAlignment":"stretch","width":"70%","layout":{"type":"constrained","justifyContent":"right","contentSize":"100%"}} -->
<div class="wp-block-column is-vertically-aligned-stretch" style="flex-basis:70%"><!-- wp:image {"id":76,"aspectRatio":"1.7777777777777777","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"0.8em"}},"className":"is-style-default"} -->
<figure class="wp-block-image size-full has-custom-border is-style-default bc-thumbnail"><img src="' . plugin_dir_url( __FILE__ ) . 'src/assets/laivas slider.webp" alt="" class="wp-image-76" style="border-radius:0.8em;aspect-ratio:1.7777777777777777;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"30%","style":{"spacing":{"padding":{"right":"var:preset|spacing|20","left":"var:preset|spacing|20","top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"},"blockGap":"0"}},"layout":{"type":"constrained","justifyContent":"center"}} -->
<div class="wp-block-column is-vertically-aligned-center" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20);flex-basis:30%"><!-- wp:group {"style":{"dimensions":{"minHeight":"100%"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"space-between"}} -->
<div class="wp-block-group" style="min-height:100%"><!-- wp:heading {"style":{"typography":{"textTransform":"uppercase"}},"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size bc-title" style="text-transform:uppercase">MODEL</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>parameter 1</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>parameter 2</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>parameter 3</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>parameter 4</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:spacer {"height":"5px"} -->
<div style="height:5px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">

<!-- wp:create-block/boat-configurator {"question":"model X"} /-->

<!-- wp:separator -->
<hr class="wp-block-separator has-alpha-channel-opacity"/>
<!-- /wp:separator --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p></p>
<!-- /wp:paragraph -->');