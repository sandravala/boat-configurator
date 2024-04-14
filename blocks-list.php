<?php
// Function to display the submenu page content
function boat_configurator_blocks_list_page()
{

    function get_pages_with_custom_category()
    {
        $args = array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'category_name' => 'boat config',
        );

        return get_posts($args);
    }

    $pages = get_pages_with_custom_category();

    if ($pages) {
        foreach ($pages as $page) {
            // Get the post content
            $content = $page->post_content;

            // Parse block data from the content
            $blocks = parse_blocks($content);

            echo '<a href="' . admin_url( 'post-new.php?post_type=boat_config' ) . '">Create New Page</a>';

            // Output block information
            foreach ($blocks as $block) {

                if ($block['blockName'] === 'create-block/boat-configurator') {

                    echo '<h3>Konfigūratorius: ' . $block['blockName'] . '</h3>';
                    echo '<h3>Puslapis: <a href="' . get_permalink($page->ID) . '"> ' . $page->post_name . '</a></h3>';
                    echo '<pre>' . print_r($block['attrs'], true) . '</pre>';
                    echo '<div>' . $block['innerHTML'] . '</div>';
                }
            }

        }
    } else {
        echo '<h3> Dar nesukurtas nė vienas konfigūratorius. </h3>';
    }
}
