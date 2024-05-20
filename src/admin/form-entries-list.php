<?php

function boat_configurator_render_entries_page() {

    global $wpdb;
    $table_name = $wpdb->prefix . DB_TABLE; // Replace 'DB_TABLE' with your actual constant value

    // Get total number of entries
    $total_entries = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

    if ($total_entries == 0) {
        echo '<p>No entries yet!</p>';
        return;
    }

    // Define number of entries per page
    $entries_per_page = 2;

    // Calculate total number of pages
    $total_pages = ceil($total_entries / $entries_per_page);

    // Get the current page number from the URL parameter
    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;

    // Calculate offset
    $offset = max(0, ($current_page - 1) * $entries_per_page);

    // Retrieve entries for the current page
    $entries = $wpdb->get_results("SELECT * FROM $table_name LIMIT $offset, $entries_per_page");





    echo 
    '<div class="container">
        <h2>Išsaugotos konfigūracijos</h2>
            <ul class="responsive-table" style="list-style-type: none; padding: 0;">';
    echo '<li class="table-header">';
    echo '<div class="col col-1">Modelis</div>';
    echo '<div class="col col-2">Klientas</div>';
    echo '<div class="col col-3">Konfigūracija</div>';
    echo '<div class="col col-4">Kontaktai</div>';
    echo '</li>';
    foreach ($entries as $entry) {

        $answers = maybe_unserialize($entry->answers);

        echo '<li class="table-row">';
        echo '<div class="col col-1" data-label="Modelis">' . $entry->post_id . '</div>';
        echo '<div class="col col-2" data-label="Klientas">' . $entry->first_name . ' ' . $entry->last_name . '</div>';
        echo '<div class="col col-3" data-label="Konfigūracija">';
        echo '<div class="responsive-questions" >';
        foreach ($answers as $question => $answer) {
            echo '<div class="table-row bc-question">';
            echo '<div class="q-text" >' . esc_html($question) . '</div>'; 
            echo '<div class="a-text" >' . $answer['text'] . '</div>'; 
            
            if (!empty($answer['imgUrl'])) {
                echo '<img src="' . esc_url($answer['imgUrl']) . '" alt="Image">';
            }
    
            // Check if the answer has a color
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
    echo '</ul></div>';





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