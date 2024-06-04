<?php

function boat_configurator_render_entries_page() {

    global $wpdb;
    $table_name = $wpdb->prefix . DB_TABLE; 

    // phpcs:disable
    // Handle search input
    $search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
    $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
    $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';
    $sort_column = isset($_GET['sort_column']) ? sanitize_text_field($_GET['sort_column']) : '';
    $sort_order = isset($_GET['sort_order']) ? sanitize_text_field($_GET['sort_order']) : 'none';
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    // phpcs:enable

    // Fetch entries based on parameters
    $entries_data = fetch_entries($search_query, $start_date, $end_date, $sort_column, $sort_order, $current_page);
    $entries = $entries_data['entries'];
    $total_entries = $entries_data['total_entries'];
    $total_pages = $entries_data['total_pages'];

        echo '<form class="bc-form-entries-search" id="search-form" method="GET">';
        echo '<h2>Išsaugotos konfigūracijos</h2>';
        echo '<input type="hidden" name="post_type" value="boat_config">';
        echo '<input type="hidden" name="page" value="boat-configurator-entries">';
        echo '<input type="hidden" id="ajax-url" value="' . esc_url(admin_url('admin-ajax.php')) . '">';
        echo '<input type="hidden" id="boat_config_entries_list_nonce" value="' . esc_attr( wp_create_nonce('boat_config_entries_list_nonce') ) . '">';
        echo '<input type="text" id="search-input" name="s" value="' . esc_attr($search_query) . '" placeholder="Ieškoti...">';

        // Date range inputs
        echo '<label class="date-range" for="start_date">Nuo:</label>';
        echo '<input type="date" id="start_date" name="start_date" value="' . esc_attr($start_date) . '">';
        echo '<label class="date-range" for="end_date">Iki:</label>';
        echo '<input type="date" id="end_date" name="end_date" value="' . esc_attr($end_date) . '">';

        echo '</form>';

        echo '<div id="entries-container" data-sort-order="" data-sort-column="">';
        // Output the initial table content here
        render_entries_table($entries, $sort_column, $sort_order, $total_pages, $current_page, $total_entries);
        echo '</div>';


   
}

// Function to display sort icon based on current order
function display_sort_icon($current_column, $current_order, $column) {
    if ($current_column === $column) {
        if ($current_order === 'asc') {
            return '↑';
        } elseif ($current_order === 'desc') {
            return '↓';
        }
    }
    return '↑↓';
}

function render_entries_table($entries, $sort_column, $sort_order, $total_pages, $current_page, $total_entries) {
    
    $base_url = admin_url('edit.php?post_type=boat_config&page=boat-configurator-entries&paged=%#%');
    $pagination_base_url = esc_url(admin_url('edit.php'));
    $query_params = array('bc_nonce' =>  wp_create_nonce('bc_nonce_search'));

    // Add search query if it exists
    if (!empty($search_query)) {
        $query_params['s'] = sanitize_text_field($search_query);
    }
    
    // Add start date if it exists
    if (!empty($start_date)) {
        $query_params['start_date'] = sanitize_text_field($start_date);
    }
    
    // Add end date if it exists
    if (!empty($end_date)) {
        $query_params['end_date'] = sanitize_text_field($end_date);
    }
    
    // Add sort column if it exists
    if (!empty($sort_column)) {
        $query_params['sort_column'] = sanitize_text_field($sort_column);
    }
    
    // Add sort order if it exists
    if (!empty($sort_order)) {
        $query_params['sort_order'] = sanitize_text_field($sort_order);
    }          
            

    $query_string = http_build_query($query_params);

        // Generate pagination links
        $pagination_links = paginate_links(array(
            'base' => $base_url,
            'format' => '?paged=%#%', // Add 'paged' parameter format
            'prev_text' => __('« Ankstesnis'),
            'next_text' => __('Kitas »'),
            'total' => $total_pages,
            'current' => $current_page,
            'type' => 'array',
            'args' => $query_params
        ));
   
        // Define the base URL
    $pagination_base_url = esc_url(admin_url('edit.php'));

    // Get existing query arguments
    $existing_query_args = array(
        'post_type' => get_query_var('post_type'),
        'page' => get_query_var('page'),
        's' => get_query_var('s'),
        'start_date' => get_query_var('start_date'),
        'end_date' => get_query_var('end_date'),
        'bc_nonce' => get_query_var('bc_nonce')
    );

    // Add the boat configurator specific query arguments
    $pagination_base_url = add_query_arg(
        array(
            'post_type' => 'boat_config',
            'page' => 'boat-configurator-entries'
        ),
        $pagination_base_url
    );

    // Append existing query arguments to the URL
    $pagination_base_url = add_query_arg($existing_query_args, $pagination_base_url);
  
   
    echo '<p style="padding-left: 1em;"> Įrašų skaičius: ' . esc_html($total_entries) . '</p>';
    
    echo '<ul class="responsive-table" style="list-style-type: none; padding: 0;">';
    echo '<li class="table-header">';


    echo '<div class="col col-1">Modelis <span class="sort-column" data-column="post_id" data-order="' . esc_attr( $sort_column == 'post_id' ? $sort_order : 'none' ) . '"><a>' . esc_html( display_sort_icon( $sort_column, $sort_order, 'post_id' ) ) . '</a></span></div>';
    echo '<div class="col col-1">Laikas <span class="sort-column" data-column="timestamp" data-order="' . esc_attr( $sort_column == 'timestamp' ? $sort_order : 'none' ) . '"><a>' . esc_html( display_sort_icon( $sort_column, $sort_order, 'timestamp' ) ) . '</a></span></div>';
    echo '<div class="col col-2">Klientas <span class="sort-column" data-column="first_name" data-order="' . esc_attr( $sort_column == 'first_name' ? $sort_order : 'none' ) . '"><a>' . esc_html( display_sort_icon( $sort_column, $sort_order, 'first_name' ) ) . '</a></span></div>';
    
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
        echo '<div>' . esc_html(gmdate('Y-m-d', strtotime($entry->timestamp))) . '</div>'; // Display date
        echo '<div>' . esc_html(gmdate('H:i:s', strtotime($entry->timestamp))) . '</div>'; // Display time
        echo '</div>';
        echo '<div class="col col-2" data-label="Klientas">' . esc_html($entry->first_name) . ' ' . esc_html($entry->last_name) . '</div>';
        echo '<div class="col col-3" data-label="Konfigūracija">';
        echo '<div class="responsive-questions">';
        foreach ($answers as $question => $answer) {
            echo '<div class="table-row bc-question">';
            echo '<div class="q-text">' . esc_html($question) . '</div>';
            echo '<div class="a-text">' . esc_html($answer['text']) . '</div>';
            if (!empty($answer['imgUrl'])) {
                echo '<img class="form-entries-answer-img" src="' . esc_url($answer['imgUrl']) . '" alt="Image">';
            }
            if (!empty($answer['color'])) {
                echo '<div style="width: 20px; height: 20px; background-color: ' . esc_attr($answer['color']) . '; border-radius: .2em;"></div>';
            }
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
        echo '<div class="col col-4" data-label="Kontaktai"><ul>';
        echo '<li>' . esc_html($entry->email) . '</li>';
        echo '<li>' . esc_html($entry->phone) . '</li>';
        echo '<li>' . esc_html($entry->country) . '</li>';
        echo '<li>' . esc_html($entry->city) . '</li>';
        echo '<li>' . esc_html($entry->zip) . '</li>';
        echo '</ul></div>';
        echo '</li>';
    }
    echo '</ul>';


    if (!empty($pagination_links)) {
        echo '<div class="pagination-container"><ul class="pagination">';
    
        foreach ($pagination_links as $link) {
            // Check if the link is the current page
            if (strpos($link, 'current') !== false) {
                echo '<li class="active">' . wp_kses_post($link) . '</li>';
            } else {
                echo '<li>' . wp_kses_post($link) . '</li>';
            }
        }
    
        echo '</ul></div>';
    }

}

function fetch_entries($search_query = '', $start_date = '', $end_date = '', $sort_column = '', $sort_order = 'none', $current_page = 1) {
    global $wpdb;
    $table_name = $wpdb->prefix . DB_TABLE;

    // Define number of entries per page
    $entries_per_page = 2;

    // Prepare date range for SQL
    $date_query = '';
    if (!empty($start_date) && !empty($end_date)) {
        $end_date = gmdate('Y-m-d 00:00:00', strtotime($end_date . ' +1 day'));
        $date_query = $wpdb->prepare(" AND timestamp BETWEEN %s AND %s", $start_date, $end_date);
    } elseif (!empty($start_date)) {
        $start_date = gmdate('Y-m-d 00:00:00', strtotime($start_date));
        $date_query = $wpdb->prepare(" AND timestamp >= %s", $start_date);
    } elseif (!empty($end_date)) {
        $end_date = gmdate('Y-m-d 00:00:00', strtotime($end_date . ' +1 day'));
        $date_query = $wpdb->prepare(" AND timestamp <= %s", $end_date);
    }

    // Prepare search part of the query
    $search_query_sql = '';
    $search_placeholders = [];
    if (!empty($search_query)) {
        $search_placeholders = array_fill(0, 8, '%' . $wpdb->esc_like($search_query) . '%');
        // phpcs:ignore WordPress.DB.PreparedSQLPlaceholders.ReplacementsWrongNumber
        $search_query_sql = $wpdb->prepare(" AND (first_name LIKE %s OR last_name LIKE %s OR email LIKE %s OR phone LIKE %s OR post_title LIKE %s OR country LIKE %s OR city LIKE %s OR zip LIKE %s)",
        $search_placeholders
        ); 
    }

    // Prepare sorting part of the query
    $sort_query = '';
    if ($sort_column && in_array($sort_order, ['asc', 'desc'])) {
        //$sort_query =$wpdb->prepare(" ORDER BY %s %s", $sort_column, $sort_order);
        $sort_query = " ORDER BY `$sort_column` $sort_order";
    }

    // Prepare the full query with or without search conditions
    $query = "SELECT * FROM %i WHERE 1=1 $date_query $search_query_sql $sort_query";

    // Retrieve all entries that match the search query
    // phpcs:disable
    $entries = !empty($query) ? $wpdb->get_results( $wpdb->prepare( $query, $table_name)) : $wpdb->get_results( $wpdb->prepare("SELECT * FROM %i", $table_name));
    // phpcs:enable

    // Get total number of search results
    $total_entries = count($entries);

    // Calculate total number of pages
    $total_pages = ceil($total_entries / $entries_per_page);

    // Calculate offset for the query
    $offset = max(0, ($current_page - 1) * $entries_per_page);

    // Slice entries for the current page
    $entries = array_slice($entries, $offset, $entries_per_page);

    return [
        'entries' => $entries,
        'total_entries' => $total_entries,
        'total_pages' => $total_pages,
        'current_page' => $current_page
    ];
}

function boat_configurator_search_entries() {

    if (!check_ajax_referer('boat_config_entries_list_nonce', '_ajax_nonce')) {
        wp_send_json_error(array('message' => 'Invalid nonce'));
        wp_die();
    }
        
    global $wpdb;
    $table_name = $wpdb->prefix . DB_TABLE; // Replace 'DB_TABLE' with your actual constant value

    $search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
    $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
    $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';
    $sort_column = isset($_GET['sort_column']) ? sanitize_text_field($_GET['sort_column']) : '';
    $sort_order = isset($_GET['sort_order']) ? sanitize_text_field($_GET['sort_order']) : 'none';
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;

    // Fetch entries based on parameters
    $entries_data = fetch_entries($search_query, $start_date, $end_date, $sort_column, $sort_order, $current_page);
    $entries = $entries_data['entries'];
    $total_entries = $entries_data['total_entries'];
    $total_pages = $entries_data['total_pages'];

   // Output the entries as HTML
    ob_start();
    render_entries_table($entries, $sort_column, $sort_order, $total_pages, $current_page, $total_entries);
    $html = ob_get_clean();

    echo wp_kses_post($html);
    wp_die();
}
add_action('wp_ajax_boat_configurator_search_entries', 'boat_configurator_search_entries');
//add_action('wp_ajax_nopriv_boat_configurator_search_entries', 'boat_configurator_search_entries');

