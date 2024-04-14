/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json` it will be enqueued on the front end of the site.
 *
 * Example:
 *
 * ```js
 * {
 *   "viewScript": "file:./view.js"
 * }
 * ```
 *
 * If you're not making any changes to this file because your project doesn't need any
 * JavaScript running in the front-end, then you should delete this file and remove
 * the `viewScript` property from `block.json`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */

/* eslint-disable no-console */
console.log( 'Hello World! (from create-block-boat-configurator block)' );
/* eslint-enable no-console */

document.addEventListener('DOMContentLoaded', function() {
    const validateEmail = (email) => {
        // Test for the minimum length the email can be
        if (email.trim().length < 6) {
            return false;
        }

        // Test for an @ character after the first position
        if (email.indexOf('@', 1) < 0) {
            return false;
        }

        // Split out the local and domain parts
        const parts = email.split('@', 2);

        // LOCAL PART
        // Test for invalid characters
        if (!parts[0].match(/^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~\.-]+$/)) {
            return false;
        }

        // DOMAIN PART
        // Test for sequences of periods
        if (parts[1].match(/\.{2,}/)) {
            return false;
        }

        const domain = parts[1];
        // Split the domain into subs
        const subs = domain.split('.');
        if (subs.length < 2) {
            return false;
        }

        const subsLen = subs.length;
        for (let i = 0; i < subsLen; i++) {
            // Test for invalid characters
            if (!subs[i].match(/^[a-z0-9-]+$/i)) {
                return false;
            }
        }

        return true;
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        event.target.disabled = true;


        const emailInput = document.getElementById('email-input').value;
        const errorMessage = document.getElementById('email-error');

        if (!validateEmail(emailInput)) {
            // Create error message span if it doesn't exist
            if (!errorMessage) {
                const errorSpan = document.createElement('span');
                errorSpan.id = 'email-error';
                errorSpan.textContent = 'Please enter a valid email address.';
                errorSpan.style.color = 'red';
                document.getElementById('email-input').insertAdjacentElement('afterend', errorSpan);
            } else {
                errorMessage.textContent = 'Please enter a valid email address.';
                errorMessage.style.display = 'block';
            }
            return;
        }

        let currentElement = event.target;
        console.log(currentElement.tagName);

    // Traverse up the DOM tree until a form element is found or until reaching the document root
    while (currentElement && currentElement.tagName !== 'FORM') {
        currentElement = currentElement.parentNode;
        console.log(currentElement.tagName);
    }

    if (currentElement.tagName === 'FORM') {
        currentElement.submit();
    }  else {
        console.log('nerado formos');
    }


        // If validation passes, allow form submission
        //document.getElementById('my-form').submit();
    };

    const initFormValidation = () => {
        const submitButton = document.getElementById('submit_form');
        submitButton.addEventListener('click', handleSubmit);
    };

    initFormValidation();
});

