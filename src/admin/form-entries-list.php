<?php

function boat_configurator_render_entries_page() {

    global $wpdb;
    $table_name = $wpdb->prefix . DB_TABLE; 

    // Handle search input
    $search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
    $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
    $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) :


    // Get total number of entries
    $total_entries = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

    // Define number of entries per page
    $entries_per_page = 2;

    // Calculate total number of pages
    $total_pages = ceil($total_entries / $entries_per_page);

    // Get the current page number from the URL parameter
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;

    // Calculate offset
    $offset = max(0, ($current_page - 1) * $entries_per_page);

    // Retrieve entries for the current page
    $entries = $wpdb->get_results(
        "SELECT * FROM $table_name LIMIT $offset, $entries_per_page"
    );

echo '<form class="bc-form-entries-search" id="search-form" method="GET">';
echo '<h2>Išsaugotos konfigūracijos</h2>';
echo '<input type="hidden" name="post_type" value="boat_config">';
echo '<input type="hidden" name="page" value="boat-configurator-entries">';
echo '<input type="text" id="search-input" name="s" value="' . esc_attr($search_query) . '" placeholder="Ieškoti...">';

// Date range inputs
echo '<label class="date-range" for="start_date">Nuo:</label>';
echo '<input type="date" id="start_date" name="start_date" value="' . esc_attr($start_date) . '">';
echo '<label class="date-range" for="end_date">Iki:</label>';
echo '<input type="date" id="end_date" name="end_date" value="' . esc_attr($end_date) . '">';

echo '</form>';

echo '<div id="entries-container">';
// Output the initial table content here
render_entries_table($entries);
echo '</div>';


    // Generate pagination links
    $pagination_links = paginate_links(array(
        'base' => add_query_arg('paged', '%#%'),
        'format' => '',
        'prev_text' => __('« Ankstesnis'),
        'next_text' => __('Kitas »'),
        'total' => $total_pages,
        'current' => $current_page,
        'type' => 'array',
    ));


    if (!empty($pagination_links)) {
        echo '<div class="pagination-container"><ul class="pagination">';
    
        foreach ($pagination_links as $link) {
            // Check if the link is the current page
            if (strpos($link, 'current') !== false) {
                echo '<li class="active">' . $link . '</li>';
            } else {
                echo '<li>' . $link . '</li>';
            }
        }
    
        echo '</ul></div>';
    }

}

function render_entries_table($entries) {
    echo '<ul class="responsive-table" style="list-style-type: none; padding: 0;">';
    echo '<li class="table-header">';
    echo '<div class="col col-1">Modelis</div>';
    echo '<div class="col col-1">Laikas</div>';
    echo '<div class="col col-2">Klientas</div>';
    echo '<div class="col col-3">Konfigūracija</div>';
    echo '<div class="col col-4">Kontaktai</div>';
    echo '</li>';
    foreach ($entries as $entry) {
        $answers = maybe_unserialize($entry->answers);
        echo '<li class="table-row">';
        echo '<div class="col col-1" data-label="Modelis">';
        if (!empty($entry->post_title)) {
            // If post title is not empty, create a link to the post
            echo '<a href="' . esc_url(get_permalink($entry->post_id)) . '">' . esc_html($entry->post_title) . '</a>';
        } else {
            // If post title is empty, try to retrieve it from post ID
            $post_title = get_the_title($entry->post_id);
            if ($post_title) {
                // If title is found, create a link to the post
                echo '<a href="' . esc_url(get_permalink($entry->post_id)) . '">' . esc_html($post_title) . '</a>';
            } else {
                // If title is still not found, display a default message
                echo esc_html('Pavadinimas nenurodytas');
            }
        }
        echo '</div>';
        echo '<div class="col col-1" data-label="Laikas">';
        echo '<div>' . date('Y-m-d', strtotime($entry->timestamp)) . '</div>'; // Display date
        echo '<div>' . date('H:i:s', strtotime($entry->timestamp)) . '</div>'; // Display time
        echo '</div>';
        echo '<div class="col col-2" data-label="Klientas">' . $entry->first_name . ' ' . $entry->last_name . '</div>';
        echo '<div class="col col-3" data-label="Konfigūracija">';
        echo '<div class="responsive-questions">';
        foreach ($answers as $question => $answer) {
            echo '<div class="table-row bc-question">';
            echo '<div class="q-text">' . esc_html($question) . '</div>';
            echo '<div class="a-text">' . $answer['text'] . '</div>';
            if (!empty($answer['imgUrl'])) {
                echo '<img src="' . esc_url($answer['imgUrl']) . '" alt="Image">';
            }
            if (!empty($answer['color'])) {
                echo '<div style="width: 20px; height: 20px; background-color: ' . esc_attr($answer['color']) . '; border-radius: .2em;"></div>';
            }
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
        echo '<div class="col col-4" data-label="Kontaktai"><ul>';
        echo '<li>' . $entry->email . '</li>';
        echo '<li>' . $entry->phone . '</li>';
        echo '<li>' . $entry->country . '</li>';
        echo '<li>' . $entry->city . '</li>';
        echo '<li>' . $entry->zip . '</li>';
        echo '</ul></div>';
        echo '</li>';
    }
    echo '</ul>';
}

function boat_configurator_search_entries() {
    global $wpdb;
    $table_name = $wpdb->prefix . DB_TABLE; // Replace 'DB_TABLE' with your actual constant value

    $search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
    $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
    $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';

    // Prepare date range for SQL
    $date_query = '';
    if (!empty($start_date) && !empty($end_date)) {
        $date_query = $wpdb->prepare(" AND timestamp BETWEEN %s AND %s", $start_date, $end_date);
    } elseif (!empty($start_date)) {
        $date_query = $wpdb->prepare(" AND timestamp >= %s", $start_date);
    } elseif (!empty($end_date)) {
        $date_query = $wpdb->prepare(" AND timestamp <= %s", $end_date);
    }

    // Convert post title to post ID
    $post_id = '';
    if (!empty($search_query)) {
        $post_id = $wpdb->get_var($wpdb->prepare(
            "SELECT ID FROM $wpdb->posts WHERE post_title LIKE %s AND post_type = 'boat_config' LIMIT 1",
            '%' . $wpdb->esc_like($search_query) . '%'
        ));
    }

    // Retrieve entries that match the search query and date range
    $sql = "
        SELECT * FROM $table_name
        WHERE (first_name LIKE %s OR last_name LIKE %s OR email LIKE %s OR phone LIKE %s OR country LIKE %s OR city LIKE %s OR zip LIKE %s"
        . ($post_id ? " OR post_id = %d" : "") . ")
        $date_query
    ";

    $params = [
        '%' . $wpdb->esc_like($search_query) . '%',
        '%' . $wpdb->esc_like($search_query) . '%',
        '%' . $wpdb->esc_like($search_query) . '%',
        '%' . $wpdb->esc_like($search_query) . '%',
        '%' . $wpdb->esc_like($search_query) . '%',
        '%' . $wpdb->esc_like($search_query) . '%',
        '%' . $wpdb->esc_like($search_query) . '%'
    ];

    if ($post_id) {
        $params[] = $post_id;
    }

    $entries = $wpdb->get_results($wpdb->prepare($sql, ...$params));

    // Output the entries as HTML
    ob_start();
    render_entries_table($entries);
    $html = ob_get_clean();

    echo $html;
    wp_die();
}
add_action('wp_ajax_boat_configurator_search_entries', 'boat_configurator_search_entries');
add_action('wp_ajax_nopriv_boat_configurator_search_entries', 'boat_configurator_search_entries');

