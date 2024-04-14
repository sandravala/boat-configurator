<?php

function boat_configurator_render_entries_page() {

    global $wpdb;
    $table_name = $wpdb->prefix . DB_TABLE; // Replace 'DB_TABLE' with your actual constant value

    // Get total number of entries
    $total_entries = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

    // Define number of entries per page
    $entries_per_page = 10;

    // Calculate total number of pages
    $total_pages = ceil($total_entries / $entries_per_page);

    // Get the current page number from the URL parameter
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;

    // Calculate offset
    $offset = max(0, ($current_page - 1) * $entries_per_page);

    // Retrieve entries for the current page
    $entries = $wpdb->get_results("SELECT * FROM $table_name LIMIT $offset, $entries_per_page");

    // Display table header
    echo '<table>';
    echo '<tr><th>ID</th><th>Column 1</th><th>Column 2</th><th>Column 3</th></tr>';

    // Display entries
    foreach ($entries as $entry) {
        echo '<tr>';
        echo '<td>' . $entry->id . '</td>';
        echo '<td>' . $entry->email . '</td>';
        echo '<td>' . $entry->answers . '</td>';
        echo '<td>' . $entry->timestamp . '</td>';
        echo '</tr>';
    }
    echo '</table>';



    // Generate pagination links
    $pagination_links = paginate_links(array(
        'base' => add_query_arg('paged', '%#%'),
        'format' => '',
        'prev_text' => __('« Ankstesnis'),
        'next_text' => __('Kitas »'),
        'total' => $total_pages,
        'current' => $current_page,
    ));

    // Output pagination links
    echo '<div class="pagination">';
    echo $pagination_links;
    echo '</div>';

}