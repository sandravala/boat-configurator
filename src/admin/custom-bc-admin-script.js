document.addEventListener('DOMContentLoaded', function() {
    var linkElements = document.querySelectorAll('.copy-link');

    linkElements.forEach(function(linkElement) {
        linkElement.addEventListener('click', function(event) {
            event.preventDefault();
            var linkToCopy = this.getAttribute('href');
            copy(linkToCopy);

        });
    });


});


function copy(text) {
    return new Promise((resolve, reject) => {
        if (typeof navigator !== "undefined" && typeof navigator.clipboard !== "undefined" && navigator.permissions !== "undefined") {
            const type = "text/plain";
            const blob = new Blob([text], { type });
            const data = [new ClipboardItem({ [type]: blob })];
            navigator.permissions.query({name: "clipboard-write"}).then((permission) => {
                if (permission.state === "granted" || permission.state === "prompt") {
                    navigator.clipboard.write(data).then(resolve, reject).catch(reject);
                    linkCopiedAlert();
                }
                else {
                    reject(new Error("Permission not granted!"));
                }
            });
        }
        else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
                var tempInput = document.createElement('input');
                tempInput.value = text;
                document.body.appendChild(tempInput);
                tempInput.select();
            try {
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                resolve();
                linkCopiedAlert();
            }
            catch (e) {
                document.body.removeChild(tempInput);
                reject(e);
            }
        }
        else {
            reject(new Error("None of copying methods are supported by this browser!"));
        }
    });
    
}

function linkCopiedAlert() {
    alert('Link copied to the clipboard!');
}

jQuery(document).ready(function($) {
    function fetchEntries() {

        var data = {
            action: 'boat_configurator_search_entries',
            s: $('#search-input').val(),
            start_date: $('#start_date').val(),
            end_date: $('#end_date').val(),
            sort_column: $('#entries-container').data('sort-column'),
            sort_order: $('#entries-container').data('sort-order'),
            _ajax_nonce: $('#nonce').val() // Get nonce value
        };


        $.ajax({
            url: $('#ajax-url').val(), // Get ajaxurl value
            method: 'GET',
            data: data,
            success: function(response) {
                $('#entries-container').html(response);
            }
        });
    }

    $('#search-input, #start_date, #end_date').on('input change', function() {
        fetchEntries();
    });


    $(document).on('click', '.sort-column', function() {
        var column = $(this).data('column');
        var order = $(this).data('order');

        // Toggle sort order
        if (order === 'asc') {
            order = 'desc';
        } else if (order === 'desc') {
            order = 'none';
        } else {
            order = 'asc';
        }

        // Set the new sort data
        $('#entries-container').data('sort-column', column);
        $('#entries-container').data('sort-order', order);

        fetchEntries();
    });

});