import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
/* eslint-disable no-console */
// console.log('Hello World! (from create-block-boat-configurator block)');
/* eslint-enable no-console */

// jQuery(document).ready(function ($) {


//     $.ajax({
//         url: bc_fe_ajax_data.ajax_url,
//         type: 'GET',
//         data: {
//             action: 'fetch_bc_questions',
//             security: bc_fe_ajax_data.security,
//             post_id: bc_fe_ajax_data.post_id
//         },
//         dataType: 'json',
//         success: function (response) {
//             if (response.success) {
//                 var questions = response.data;

//                 // Process the retrieved questions
//                 console.log(questions);
//                 renderForm(questions);

//             } else {
//                 console.error('Error retrieving questions:', response.data);
//             }
//         },
//         error: function (xhr, status, error) {
//             console.error('AJAX error:', error);
//         }
//     });

// });

document.addEventListener('DOMContentLoaded', function () {

    const bcDataFront = bcData;
    console.log(bcDataFront);
    renderForm(bcDataFront);

    document.getElementById('create-block-boat-configurator-script-js-before').remove();


});


function renderForm(questionsData) {
    const bcDiv = document.getElementsByClassName('wp-block-create-block-boat-configurator')[0];
    ReactDOM.render(<BoatConfig {...questionsData} />, bcDiv);
}


function BoatConfig(questionsData) {
    const privacyPolicyUrl = questionsData.privacyPolicy;
    const [currentIndex, setCurrentIndex] = useState(0);
    const [question, setQuestion] = useState(questionsData.questions[0]);
    const [progress, setProgress] = useState(0);
    const [answers, setAnswers] = useState({
        agreePolicies: true,
        subscribe: true,
    });
    const [formSubmitting, setFormSubitting] = useState(false);
    const [formSubmitMessage, setFormSubmitMessage] = useState('');
    const [formSubmitSuccess, setFormSubmitSuccess] = useState(false);



    useEffect(() => {
        setQuestion(questionsData.questions[currentIndex]);
        setProgress(((currentIndex) / (questionsData.questions.length - 1)) * 100);
    }, [currentIndex, questionsData.questions]);

    const handlePrevClick = () => {
        if (currentIndex > 0) {
            setCurrentIndex(currentIndex - 1);
        }
    };

    const handleNextClick = () => {
        if (currentIndex < questionsData.questions.length - 1) {
            setCurrentIndex(currentIndex + 1);
        }
    };

    const updateAnswers = (questionIdentifier, value) => {
        setAnswers(prev => ({
            ...prev,
            [questionIdentifier]: value
        }));
        console.log(answers);
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        var formData = jQuery('#bc-form').serialize();
        setFormSubitting(true);

        jQuery.ajax({
            url: questionsData.ajaxUrl,
            type: 'POST',
            data: {
                action: 'handle_form_submission',
                security: questionsData.feNonce, // Include nonce in the data payload
                form_data: formData,
            },
            success: function (response) {
                if (response.success) {
                    console.log('success: ', response.data.text);
                    setFormSubmitMessage('Data submitted successfully!');
                    setFormSubmitSuccess(true);
                } else {
                    console.log('Error:', response);
                    setFormSubmitMessage('Ooops! Something went wrong... please try again!');
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', xhr.responseText);
                setFormSubmitMessage('Ooops! Something went wrong... please try again!');
            }
        });



        // const emailInput = document.getElementById('email').value;
        // const errorMessage = document.getElementById('email-error');

        // if (!validateEmail(emailInput)) {
        //     // Create error message span if it doesn't exist
        //     if (!errorMessage) {
        //         const errorSpan = document.createElement('span');
        //         errorSpan.id = 'email-error';
        //         errorSpan.textContent = 'Please enter a valid email address.';
        //         errorSpan.style.color = 'red';
        //         document.getElementById('email').insertAdjacentElement('afterend', errorSpan);
        //     } else {
        //         errorMessage.textContent = 'Please enter a valid email address.';
        //         errorMessage.style.display = 'block';
        //     }
        //     return;
        // }

    }

    const countryOptions = [
        { value: "US", text: "United States" },
        { value: "CA", text: "Canada" },
        { value: "Afghanistan", text: "Afghanistan" },
        { value: "Albania", text: "Albania" },
        { value: "Algeria", text: "Algeria" },
        { value: "Andorra", text: "Andorra" },
        { value: "Angola", text: "Angola" },
        { value: "Antigua & Deps", text: "Antigua & Deps" },
        { value: "Argentina", text: "Argentina" },
        { value: "Armenia", text: "Armenia" },
        { value: "Australia", text: "Australia" },
        { value: "Austria", text: "Austria" },
        { value: "Azerbaijan", text: "Azerbaijan" },
        { value: "Bahamas", text: "Bahamas" },
        { value: "Bahrain", text: "Bahrain" },
        { value: "Bangladesh", text: "Bangladesh" },
        { value: "Barbados", text: "Barbados" },
        { value: "Belarus", text: "Belarus" },
        { value: "Belgium", text: "Belgium" },
        { value: "Belize", text: "Belize" },
        { value: "Benin", text: "Benin" },
        { value: "Bhutan", text: "Bhutan" },
        { value: "Bolivia", text: "Bolivia" },
        { value: "Bosnia", text: "Bosnia" },
        { value: "Herzegovina", text: "Herzegovina" },
        { value: "Botswana", text: "Botswana" },
        { value: "Brazil", text: "Brazil" },
        { value: "Brunei", text: "Brunei" },
        { value: "Bulgaria", text: "Bulgaria" },
        { value: "Burkina", text: "Burkina" },
        { value: "Burundi", text: "Burundi" },
        { value: "Cambodia", text: "Cambodia" },
        { value: "Cameroon", text: "Cameroon" },
        { value: "Cape Verde", text: "Cape Verde" },
        { value: "Central African Rep", text: "Central African Rep" },
        { value: "Chad", text: "Chad" },
        { value: "Chile", text: "Chile" },
        { value: "China", text: "China" },
        { value: "Colombia", text: "Colombia" },
        { value: "Comoros", text: "Comoros" },
        { value: "Congo", text: "Congo" },
        { value: "Congo (Democratic Rep)", text: "Congo (Democratic Rep)" },
        { value: "Costa Rica", text: "Costa Rica" },
        { value: "Croatia", text: "Croatia" },
        { value: "Cuba", text: "Cuba" },
        { value: "Cyprus", text: "Cyprus" },
        { value: "Czech Republic", text: "Czech Republic" },
        { value: "Denmark", text: "Denmark" },
        { value: "Djibouti", text: "Djibouti" },
        { value: "Dominica", text: "Dominica" },
        { value: "Dominican Republic", text: "Dominican Republic" },
        { value: "East Timor", text: "East Timor" },
        { value: "Ecuador", text: "Ecuador" },
        { value: "Egypt", text: "Egypt" },
        { value: "El Salvador", text: "El Salvador" },
        { value: "Equatorial Guinea", text: "Equatorial Guinea" },
        { value: "Eritrea", text: "Eritrea" },
        { value: "Estonia", text: "Estonia" },
        { value: "Ethiopia", text: "Ethiopia" },
        { value: "Fiji", text: "Fiji" },
        { value: "Finland", text: "Finland" },
        { value: "France", text: "France" },
        { value: "Gabon", text: "Gabon" },
        { value: "Gambia", text: "Gambia" },
        { value: "Georgia", text: "Georgia" },
        { value: "Germany", text: "Germany" },
        { value: "Ghana", text: "Ghana" },
        { value: "Greece", text: "Greece" },
        { value: "Grenada", text: "Grenada" },
        { value: "Guatemala", text: "Guatemala" },
        { value: "Guinea", text: "Guinea" },
        { value: "Guinea-Bissau", text: "Guinea-Bissau" },
        { value: "Guyana", text: "Guyana" },
        { value: "Haiti", text: "Haiti" },
        { value: "Honduras", text: "Honduras" },
        { value: "Hungary", text: "Hungary" },
        { value: "Iceland", text: "Iceland" },
        { value: "India", text: "India" },
        { value: "Indonesia", text: "Indonesia" },
        { value: "Iran", text: "Iran" },
        { value: "Iraq", text: "Iraq" },
        { value: "Ireland (Republic)", text: "Ireland (Republic)" },
        { value: "Israel", text: "Israel" },
        { value: "Italy", text: "Italy" },
        { value: "Ivory Coast", text: "Ivory Coast" },
        { value: "Jamaica", text: "Jamaica" },
        { value: "Japan", text: "Japan" },
        { value: "Jordan", text: "Jordan" },
        { value: "Kazakhstan", text: "Kazakhstan" },
        { value: "Kenya", text: "Kenya" },
        { value: "Kiribati", text: "Kiribati" },
        { value: "Korea North", text: "Korea North" },
        { value: "Korea South", text: "Korea South" },
        { value: "Kosovo", text: "Kosovo" },
        { value: "Kuwait", text: "Kuwait" },
        { value: "Kyrgyzstan", text: "Kyrgyzstan" },
        { value: "Laos", text: "Laos" },
        { value: "Latvia", text: "Latvia" },
        { value: "Lebanon", text: "Lebanon" },
        { value: "Lesotho", text: "Lesotho" },
        { value: "Liberia", text: "Liberia" },
        { value: "Libya", text: "Libya" },
        { value: "Liechtenstein", text: "Liechtenstein" },
        { value: "Lithuania", text: "Lithuania" },
        { value: "Luxembourg", text: "Luxembourg" },
        { value: "Macedonia", text: "Macedonia" },
        { value: "Madagascar", text: "Madagascar" },
        { value: "Malawi", text: "Malawi" },
        { value: "Malaysia", text: "Malaysia" },
        { value: "Maldives", text: "Maldives" },
        { value: "Mali", text: "Mali" },
        { value: "Malta", text: "Malta" },
        { value: "Marshall Islands", text: "Marshall Islands" },
        { value: "Mauritania", text: "Mauritania" },
        { value: "Mexico", text: "Mexico" },
        { value: "Micronesia", text: "Micronesia" },
        { value: "Moldova", text: "Moldova" },
        { value: "Monaco", text: "Monaco" },
        { value: "Mongolia", text: "Mongolia" },
        { value: "Montenegro", text: "Montenegro" },
        { value: "Morocco", text: "Morocco" },
        { value: "Mozambique", text: "Mozambique" },
        { value: "Myanmar (Burma)", text: "Myanmar (Burma)" },
        { value: "Namibia", text: "Namibia" },
        { value: "Nauru", text: "Nauru" },
        { value: "Nepal", text: "Nepal" },
        { value: "Netherlands", text: "Netherlands" },
        { value: "New Zealand", text: "New Zealand" },
        { value: "Nicaragua", text: "Nicaragua" },
        { value: "Niger", text: "Niger" },
        { value: "Nigeria", text: "Nigeria" },
        { value: "Norway", text: "Norway" },
        { value: "Oman", text: "Oman" },
        { value: "Pakistan", text: "Pakistan" },
        { value: "Palau", text: "Palau" },
        { value: "Panama", text: "Panama" },
        { value: "Papua New Guinea", text: "Papua New Guinea" },
        { value: "Paraguay", text: "Paraguay" },
        { value: "Peru", text: "Peru" },
        { value: "Philippines", text: "Philippines" },
        { value: "Poland", text: "Poland" },
        { value: "Portugal", text: "Portugal" },
        { value: "Qatar", text: "Qatar" },
        { value: "Romania", text: "Romania" },
        { value: "Rwanda", text: "Rwanda" },
        { value: "St Kitts & Nevis", text: "St Kitts & Nevis" },
        { value: "St Lucia", text: "St Lucia" },
        { value: "Saint Vincent & the Grenadines", text: "Saint Vincent & the Grenadines" },
        { value: "Samoa", text: "Samoa" },
        { value: "San Marino", text: "San Marino" },
        { value: "Sao Tome & Principe", text: "Sao Tome & Principe" },
        { value: "Saudi Arabia", text: "Saudi Arabia" },
        { value: "Senegal", text: "Senegal" },
        { value: "Serbia", text: "Serbia" },
        { value: "Seychelles", text: "Seychelles" },
        { value: "Sierra Leone", text: "Sierra Leone" },
        { value: "Singapore", text: "Singapore" },
        { value: "Slovakia", text: "Slovakia" },
        { value: "Slovenia", text: "Slovenia" },
        { value: "Solomon Islands", text: "Solomon Islands" },
        { value: "Somalia", text: "Somalia" },
        { value: "South Africa", text: "South Africa" },
        { value: "South Sudan", text: "South Sudan" },
        { value: "Spain", text: "Spain" },
        { value: "Sri Lanka", text: "Sri Lanka" },
        { value: "Sudan", text: "Sudan" },
        { value: "Suriname", text: "Suriname" },
        { value: "Swaziland", text: "Swaziland" },
        { value: "Sweden", text: "Sweden" },
        { value: "Switzerland", text: "Switzerland" },
        { value: "Syria", text: "Syria" },
        { value: "Taiwan", text: "Taiwan" },
        { value: "Tajikistan", text: "Tajikistan" },
        { value: "Tanzania", text: "Tanzania" },
        { value: "Thailand", text: "Thailand" },
        { value: "Togo", text: "Togo" },
        { value: "Tonga", text: "Tonga" },
        { value: "Trinidad & Tobago", text: "Trinidad & Tobago" },
        { value: "Tunisia", text: "Tunisia" },
        { value: "Turkey", text: "Turkey" },
        { value: "Turkmenistan", text: "Turkmenistan" },
        { value: "Tuvalu", text: "Tuvalu" },
        { value: "Uganda", text: "Uganda" },
        { value: "Ukraine", text: "Ukraine" },
        { value: "United Arab Emirates", text: "United Arab Emirates" },
        { value: "United Kingdom", text: "United Kingdom" },
        { value: "Uruguay", text: "Uruguay" },
        { value: "Uzbekistan", text: "Uzbekistan" },
        { value: "Vanuatu", text: "Vanuatu" },
        { value: "Vatican City", text: "Vatican City" },
        { value: "Venezuela", text: "Venezuela" },
        { value: "Vietnam", text: "Vietnam" },
        { value: "Yemen", text: "Yemen" },
        { value: "Zambia", text: "Zambia" },
        { value: "Zimbabwe", text: "Zimbabwe" }
    ];

    const contactFormFields = [
        { type: 'text', id: 'firstName', label: 'First Name*', required: { required: true } },
        { type: 'text', id: 'lastName', label: 'Last Name*', required: { required: true } },
        { type: 'email', id: 'email', label: 'Email*', required: { required: true } },
        { type: 'number', id: 'phone', label: 'Phone', required: {} },
        { type: 'select', id: 'country', label: 'Country*', required: { required: true }, options: countryOptions },
        { type: 'text', id: 'city', label: 'City*', required: { required: true } },
        { type: 'text', id: 'zip', label: 'Zip Code*', required: { required: true } }
    ]



    return (
        <>
            {
                !formSubmitting &&
                <form id='bc-form'>
                    <div className='bc-frontend'>
                        <div className='pagination-progress'>
                            <p className='progress-label'>{progress.toFixed(0)} %</p>
                            <div className="progress-bar">
                                <span style={{ width: `${progress}%` }}></span>
                            </div>
                        </div>
                        <div key={currentIndex} class={`question-container ${currentIndex === questionsData.questions.length - 1 ? 'contact' : ''}`}>
                            {currentIndex !== questionsData.questions.length - 1 ? (


                                <p>{question.text}</p>

                            ) : (
                                <p>Craft the future of your nautical adventures with Hendrixon. By providing your details below, a Hendrixon expert from your local dealership will extend a precise and tailored quote for your custom-built vessel. </p>

                            )}

                            <div class={`options-container ${currentIndex === questionsData.questions.length - 1 ? 'contact' : ''}`}>

                                {currentIndex !== questionsData.questions.length - 1 ? (
                                    question.options.map((option, optionIndex) => (
                                        <label key={optionIndex} class="option-label">
                                            <input
                                                type="radio"
                                                name={question.text}
                                                value={option.optionText}
                                                id={`${currentIndex}_${optionIndex}`}
                                                onChange={() => updateAnswers(question.text, option.optionText)}
                                            />
                                            <div className="card">
                                                <div className="top-text">
                                                    {option.optionText}
                                                </div>
                                                <div className="img">
                                                    {option.imgUrl && <img src={option.imgUrl} alt={option.text} />}
                                                    {option.color && <div style={{ background: option.color }}></div>}
                                                </div>
                                            </div>
                                        </label>
                                    ))
                                ) : (
                                    <>
                                        {contactFormFields.map((field, fieldindex) => (

                                            <div className='contact-row'>
                                                <div class="col-5">
                                                    <label class="input-bc-custom">
                                                        {field.type !== 'select' ?
                                                            <input
                                                                class="input-bc-custom__field"
                                                                type={field.type}
                                                                placeholder=" "
                                                                style={{ fontSize: "20px" }}
                                                                id={field.id}
                                                                name={field.id}
                                                                value={answers[field.id]}
                                                                onChange={(e) => updateAnswers(field.id, e.target.value)}
                                                                {...field.required}
                                                            />
                                                            :
                                                            <select
                                                                class="input-bc-custom__field"
                                                                type={field.type}
                                                                placeholder=" "
                                                                style={{ fontSize: "20px" }}
                                                                id={field.id}
                                                                name={field.id}
                                                                value={answers[field.id]}
                                                                onChange={(e) => updateAnswers(field.id, e.target.value)}
                                                                {...field.required}
                                                            >
                                                                {field.options.map((option, optionIndex) => (
                                                                    <option value={option.value}>{option.text}</option>
                                                                ))}
                                                            </select>
                                                        }

                                                        <span class="input-bc-custom__label">{field.label}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        ))}

                                        {[{ id: 'subscribe', text: 'Embrace the future of boating by subscribing to receive updates from Hendrixon. Be the first to learn about new product launches, exclusive events, and more. By selecting "I agree," you authorize Hendrixon and our trusted partners to utilize your personal information for marketing and promotional activities. Set sail on a journey of innovation and luxury with us—where every update brings you closer to the voyage of your dreams.' },
                                        { id: 'agreePolicies', text: 'By clicking this box, I acknowledge and accept the ' }].map((checkbox, chId) => (
                                            <div className='contact-row'>
                                                <div class="col-5">
                                                    <label class="input-bc-custom" style={{ display: 'flex', alignItems: 'flex-start' }}>
                                                        <input
                                                            class="input-bc-custom__field"
                                                            type='checkbox'
                                                            placeholder=" "
                                                            style={{ fontSize: "20px", width: 'auto' }}
                                                            id="subscribe"
                                                            value={answers[checkbox.id]}
                                                            onClick={(e) => updateAnswers(checkbox.id, e.target.checked)}
                                                            defaultChecked="true"
                                                        />
                                                        <p style={{ margin: '3px 0 0 0', padding: '0 0 0 1em', fontSize: '10px' }}>
                                                            {checkbox.id === 'subscribe' ? checkbox.text : (
                                                                <>
                                                                    {checkbox.text}
                                                                    <a href={privacyPolicyUrl} target="_blank" rel="noopener noreferrer" title="This link opens in new tab">Policies &amp; Terms</a>
                                                                </>
                                                            )}
                                                        </p>
                                                    </label>
                                                </div>
                                            </div>
                                        ))}

                                    </>

                                )}

                            </div>
                        </div>





                        <div class={` pagination-footer ${currentIndex === 0 ? 'previous-disabled' : ''}`}>
                            <button type="button" class="previous" onClick={handlePrevClick} disabled={currentIndex === 0}>Previous</button>
                            <button type="button" class="next" onClick={handleNextClick} disabled={currentIndex === questionsData.questions.length - 1}>Next</button>
                            {currentIndex === questionsData.questions.length - 1 && <button type="submit" id="submit_form" class="next" onClick={handleSubmit} disabled={false}>Submit</button>}
                        </div>
                    </div>
                </form>
            }
            {
                formSubmitting &&
                <div class="form-submit-message">

                {formSubmitMessage === '' &&
                    <>
                        <div class="loader"></div>
                        <div><p>Form is submitting...</p></div>
                    </>
                }
                {formSubmitMessage !== '' &&
                    <>
                        <p>{formSubmitMessage}</p>
                        {formSubmitSuccess && 
                        <div>
                        <button type="button" class="previous" onClick={() => location.href = questionsData.homePage} >Go to Main page</button>
                        <button type="button" class="next" onClick={() => location.href = questionsData.boatConfigArchive} >Configure More Boats</button>
                        </div>
}
{!formSubmitSuccess && 
                        <div>
                        <button type="button" class="previous" onClick={() => location.reload()} >Try Again</button>
                        </div>
}
                    </>
                }

                </div>
            }


        </>

    );
}






function validateEmail(email) {


    // Test for the minimum length the email can be
    if (email.trim().length < 6) {
        console.log('tuscias emailas');
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

