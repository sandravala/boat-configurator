/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "react-dom":
/*!***************************!*\
  !*** external "ReactDOM" ***!
  \***************************/
/***/ ((module) => {

module.exports = window["ReactDOM"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*********************!*\
  !*** ./src/view.js ***!
  \*********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "react-dom");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);



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
  react_dom__WEBPACK_IMPORTED_MODULE_1___default().render((0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(BoatConfig, {
    ...questionsData
  }), bcDiv);
}
function BoatConfig(questionsData) {
  const privacyPolicyUrl = questionsData.privacyPolicy;
  const [currentIndex, setCurrentIndex] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(0);
  const [question, setQuestion] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(questionsData.questions[0]);
  const [progress, setProgress] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(0);
  const [answers, setAnswers] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)({
    agreePolicies: true,
    subscribe: true
  });
  const [formSubmitting, setFormSubitting] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [formSubmitMessage, setFormSubmitMessage] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)('');
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    setQuestion(questionsData.questions[currentIndex]);
    setProgress(currentIndex / (questionsData.questions.length - 1) * 100);
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
  const handleSubmit = e => {
    e.preventDefault();
    var formData = jQuery('#bc-form').serialize();
    setFormSubitting(true);
    jQuery.ajax({
      url: questionsData.ajaxUrl,
      type: 'POST',
      data: {
        action: 'handle_form_submission',
        security: questionsData.feNonce,
        // Include nonce in the data payload
        form_data: formData
      },
      success: function (response) {
        if (response.success) {
          console.log('success: ', response.data.text);
          setFormSubmitMessage('Data submitted successfully!');
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
  };
  const countryOptions = [{
    value: "US",
    text: "United States"
  }, {
    value: "CA",
    text: "Canada"
  }, {
    value: "Afghanistan",
    text: "Afghanistan"
  }, {
    value: "Albania",
    text: "Albania"
  }, {
    value: "Algeria",
    text: "Algeria"
  }, {
    value: "Andorra",
    text: "Andorra"
  }, {
    value: "Angola",
    text: "Angola"
  }, {
    value: "Antigua & Deps",
    text: "Antigua & Deps"
  }, {
    value: "Argentina",
    text: "Argentina"
  }, {
    value: "Armenia",
    text: "Armenia"
  }, {
    value: "Australia",
    text: "Australia"
  }, {
    value: "Austria",
    text: "Austria"
  }, {
    value: "Azerbaijan",
    text: "Azerbaijan"
  }, {
    value: "Bahamas",
    text: "Bahamas"
  }, {
    value: "Bahrain",
    text: "Bahrain"
  }, {
    value: "Bangladesh",
    text: "Bangladesh"
  }, {
    value: "Barbados",
    text: "Barbados"
  }, {
    value: "Belarus",
    text: "Belarus"
  }, {
    value: "Belgium",
    text: "Belgium"
  }, {
    value: "Belize",
    text: "Belize"
  }, {
    value: "Benin",
    text: "Benin"
  }, {
    value: "Bhutan",
    text: "Bhutan"
  }, {
    value: "Bolivia",
    text: "Bolivia"
  }, {
    value: "Bosnia",
    text: "Bosnia"
  }, {
    value: "Herzegovina",
    text: "Herzegovina"
  }, {
    value: "Botswana",
    text: "Botswana"
  }, {
    value: "Brazil",
    text: "Brazil"
  }, {
    value: "Brunei",
    text: "Brunei"
  }, {
    value: "Bulgaria",
    text: "Bulgaria"
  }, {
    value: "Burkina",
    text: "Burkina"
  }, {
    value: "Burundi",
    text: "Burundi"
  }, {
    value: "Cambodia",
    text: "Cambodia"
  }, {
    value: "Cameroon",
    text: "Cameroon"
  }, {
    value: "Cape Verde",
    text: "Cape Verde"
  }, {
    value: "Central African Rep",
    text: "Central African Rep"
  }, {
    value: "Chad",
    text: "Chad"
  }, {
    value: "Chile",
    text: "Chile"
  }, {
    value: "China",
    text: "China"
  }, {
    value: "Colombia",
    text: "Colombia"
  }, {
    value: "Comoros",
    text: "Comoros"
  }, {
    value: "Congo",
    text: "Congo"
  }, {
    value: "Congo (Democratic Rep)",
    text: "Congo (Democratic Rep)"
  }, {
    value: "Costa Rica",
    text: "Costa Rica"
  }, {
    value: "Croatia",
    text: "Croatia"
  }, {
    value: "Cuba",
    text: "Cuba"
  }, {
    value: "Cyprus",
    text: "Cyprus"
  }, {
    value: "Czech Republic",
    text: "Czech Republic"
  }, {
    value: "Denmark",
    text: "Denmark"
  }, {
    value: "Djibouti",
    text: "Djibouti"
  }, {
    value: "Dominica",
    text: "Dominica"
  }, {
    value: "Dominican Republic",
    text: "Dominican Republic"
  }, {
    value: "East Timor",
    text: "East Timor"
  }, {
    value: "Ecuador",
    text: "Ecuador"
  }, {
    value: "Egypt",
    text: "Egypt"
  }, {
    value: "El Salvador",
    text: "El Salvador"
  }, {
    value: "Equatorial Guinea",
    text: "Equatorial Guinea"
  }, {
    value: "Eritrea",
    text: "Eritrea"
  }, {
    value: "Estonia",
    text: "Estonia"
  }, {
    value: "Ethiopia",
    text: "Ethiopia"
  }, {
    value: "Fiji",
    text: "Fiji"
  }, {
    value: "Finland",
    text: "Finland"
  }, {
    value: "France",
    text: "France"
  }, {
    value: "Gabon",
    text: "Gabon"
  }, {
    value: "Gambia",
    text: "Gambia"
  }, {
    value: "Georgia",
    text: "Georgia"
  }, {
    value: "Germany",
    text: "Germany"
  }, {
    value: "Ghana",
    text: "Ghana"
  }, {
    value: "Greece",
    text: "Greece"
  }, {
    value: "Grenada",
    text: "Grenada"
  }, {
    value: "Guatemala",
    text: "Guatemala"
  }, {
    value: "Guinea",
    text: "Guinea"
  }, {
    value: "Guinea-Bissau",
    text: "Guinea-Bissau"
  }, {
    value: "Guyana",
    text: "Guyana"
  }, {
    value: "Haiti",
    text: "Haiti"
  }, {
    value: "Honduras",
    text: "Honduras"
  }, {
    value: "Hungary",
    text: "Hungary"
  }, {
    value: "Iceland",
    text: "Iceland"
  }, {
    value: "India",
    text: "India"
  }, {
    value: "Indonesia",
    text: "Indonesia"
  }, {
    value: "Iran",
    text: "Iran"
  }, {
    value: "Iraq",
    text: "Iraq"
  }, {
    value: "Ireland (Republic)",
    text: "Ireland (Republic)"
  }, {
    value: "Israel",
    text: "Israel"
  }, {
    value: "Italy",
    text: "Italy"
  }, {
    value: "Ivory Coast",
    text: "Ivory Coast"
  }, {
    value: "Jamaica",
    text: "Jamaica"
  }, {
    value: "Japan",
    text: "Japan"
  }, {
    value: "Jordan",
    text: "Jordan"
  }, {
    value: "Kazakhstan",
    text: "Kazakhstan"
  }, {
    value: "Kenya",
    text: "Kenya"
  }, {
    value: "Kiribati",
    text: "Kiribati"
  }, {
    value: "Korea North",
    text: "Korea North"
  }, {
    value: "Korea South",
    text: "Korea South"
  }, {
    value: "Kosovo",
    text: "Kosovo"
  }, {
    value: "Kuwait",
    text: "Kuwait"
  }, {
    value: "Kyrgyzstan",
    text: "Kyrgyzstan"
  }, {
    value: "Laos",
    text: "Laos"
  }, {
    value: "Latvia",
    text: "Latvia"
  }, {
    value: "Lebanon",
    text: "Lebanon"
  }, {
    value: "Lesotho",
    text: "Lesotho"
  }, {
    value: "Liberia",
    text: "Liberia"
  }, {
    value: "Libya",
    text: "Libya"
  }, {
    value: "Liechtenstein",
    text: "Liechtenstein"
  }, {
    value: "Lithuania",
    text: "Lithuania"
  }, {
    value: "Luxembourg",
    text: "Luxembourg"
  }, {
    value: "Macedonia",
    text: "Macedonia"
  }, {
    value: "Madagascar",
    text: "Madagascar"
  }, {
    value: "Malawi",
    text: "Malawi"
  }, {
    value: "Malaysia",
    text: "Malaysia"
  }, {
    value: "Maldives",
    text: "Maldives"
  }, {
    value: "Mali",
    text: "Mali"
  }, {
    value: "Malta",
    text: "Malta"
  }, {
    value: "Marshall Islands",
    text: "Marshall Islands"
  }, {
    value: "Mauritania",
    text: "Mauritania"
  }, {
    value: "Mexico",
    text: "Mexico"
  }, {
    value: "Micronesia",
    text: "Micronesia"
  }, {
    value: "Moldova",
    text: "Moldova"
  }, {
    value: "Monaco",
    text: "Monaco"
  }, {
    value: "Mongolia",
    text: "Mongolia"
  }, {
    value: "Montenegro",
    text: "Montenegro"
  }, {
    value: "Morocco",
    text: "Morocco"
  }, {
    value: "Mozambique",
    text: "Mozambique"
  }, {
    value: "Myanmar (Burma)",
    text: "Myanmar (Burma)"
  }, {
    value: "Namibia",
    text: "Namibia"
  }, {
    value: "Nauru",
    text: "Nauru"
  }, {
    value: "Nepal",
    text: "Nepal"
  }, {
    value: "Netherlands",
    text: "Netherlands"
  }, {
    value: "New Zealand",
    text: "New Zealand"
  }, {
    value: "Nicaragua",
    text: "Nicaragua"
  }, {
    value: "Niger",
    text: "Niger"
  }, {
    value: "Nigeria",
    text: "Nigeria"
  }, {
    value: "Norway",
    text: "Norway"
  }, {
    value: "Oman",
    text: "Oman"
  }, {
    value: "Pakistan",
    text: "Pakistan"
  }, {
    value: "Palau",
    text: "Palau"
  }, {
    value: "Panama",
    text: "Panama"
  }, {
    value: "Papua New Guinea",
    text: "Papua New Guinea"
  }, {
    value: "Paraguay",
    text: "Paraguay"
  }, {
    value: "Peru",
    text: "Peru"
  }, {
    value: "Philippines",
    text: "Philippines"
  }, {
    value: "Poland",
    text: "Poland"
  }, {
    value: "Portugal",
    text: "Portugal"
  }, {
    value: "Qatar",
    text: "Qatar"
  }, {
    value: "Romania",
    text: "Romania"
  }, {
    value: "Rwanda",
    text: "Rwanda"
  }, {
    value: "St Kitts & Nevis",
    text: "St Kitts & Nevis"
  }, {
    value: "St Lucia",
    text: "St Lucia"
  }, {
    value: "Saint Vincent & the Grenadines",
    text: "Saint Vincent & the Grenadines"
  }, {
    value: "Samoa",
    text: "Samoa"
  }, {
    value: "San Marino",
    text: "San Marino"
  }, {
    value: "Sao Tome & Principe",
    text: "Sao Tome & Principe"
  }, {
    value: "Saudi Arabia",
    text: "Saudi Arabia"
  }, {
    value: "Senegal",
    text: "Senegal"
  }, {
    value: "Serbia",
    text: "Serbia"
  }, {
    value: "Seychelles",
    text: "Seychelles"
  }, {
    value: "Sierra Leone",
    text: "Sierra Leone"
  }, {
    value: "Singapore",
    text: "Singapore"
  }, {
    value: "Slovakia",
    text: "Slovakia"
  }, {
    value: "Slovenia",
    text: "Slovenia"
  }, {
    value: "Solomon Islands",
    text: "Solomon Islands"
  }, {
    value: "Somalia",
    text: "Somalia"
  }, {
    value: "South Africa",
    text: "South Africa"
  }, {
    value: "South Sudan",
    text: "South Sudan"
  }, {
    value: "Spain",
    text: "Spain"
  }, {
    value: "Sri Lanka",
    text: "Sri Lanka"
  }, {
    value: "Sudan",
    text: "Sudan"
  }, {
    value: "Suriname",
    text: "Suriname"
  }, {
    value: "Swaziland",
    text: "Swaziland"
  }, {
    value: "Sweden",
    text: "Sweden"
  }, {
    value: "Switzerland",
    text: "Switzerland"
  }, {
    value: "Syria",
    text: "Syria"
  }, {
    value: "Taiwan",
    text: "Taiwan"
  }, {
    value: "Tajikistan",
    text: "Tajikistan"
  }, {
    value: "Tanzania",
    text: "Tanzania"
  }, {
    value: "Thailand",
    text: "Thailand"
  }, {
    value: "Togo",
    text: "Togo"
  }, {
    value: "Tonga",
    text: "Tonga"
  }, {
    value: "Trinidad & Tobago",
    text: "Trinidad & Tobago"
  }, {
    value: "Tunisia",
    text: "Tunisia"
  }, {
    value: "Turkey",
    text: "Turkey"
  }, {
    value: "Turkmenistan",
    text: "Turkmenistan"
  }, {
    value: "Tuvalu",
    text: "Tuvalu"
  }, {
    value: "Uganda",
    text: "Uganda"
  }, {
    value: "Ukraine",
    text: "Ukraine"
  }, {
    value: "United Arab Emirates",
    text: "United Arab Emirates"
  }, {
    value: "United Kingdom",
    text: "United Kingdom"
  }, {
    value: "Uruguay",
    text: "Uruguay"
  }, {
    value: "Uzbekistan",
    text: "Uzbekistan"
  }, {
    value: "Vanuatu",
    text: "Vanuatu"
  }, {
    value: "Vatican City",
    text: "Vatican City"
  }, {
    value: "Venezuela",
    text: "Venezuela"
  }, {
    value: "Vietnam",
    text: "Vietnam"
  }, {
    value: "Yemen",
    text: "Yemen"
  }, {
    value: "Zambia",
    text: "Zambia"
  }, {
    value: "Zimbabwe",
    text: "Zimbabwe"
  }];
  const contactFormFields = [{
    type: 'text',
    id: 'firstName',
    label: 'First Name*',
    required: {
      required: true
    }
  }, {
    type: 'text',
    id: 'lastName',
    label: 'Last Name*',
    required: {
      required: true
    }
  }, {
    type: 'email',
    id: 'email',
    label: 'Email*',
    required: {
      required: true
    }
  }, {
    type: 'number',
    id: 'phone',
    label: 'Phone',
    required: {}
  }, {
    type: 'select',
    id: 'country',
    label: 'Country*',
    required: {
      required: true
    },
    options: countryOptions
  }, {
    type: 'text',
    id: 'city',
    label: 'City*',
    required: {
      required: true
    }
  }, {
    type: 'text',
    id: 'zip',
    label: 'Zip Code*',
    required: {
      required: true
    }
  }];
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, !formSubmitting && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("form", {
    id: "bc-form"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "bc-frontend"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "pagination-progress"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    className: "progress-label"
  }, progress.toFixed(0), " %"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "progress-bar"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    style: {
      width: `${progress}%`
    }
  }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    key: currentIndex,
    class: `question-container ${currentIndex === questionsData.questions.length - 1 ? 'contact' : ''}`
  }, currentIndex !== questionsData.questions.length - 1 ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, question.text) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Craft the future of your nautical adventures with Hendrixon. By providing your details below, a Hendrixon expert from your local dealership will extend a precise and tailored quote for your custom-built vessel. "), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: `options-container ${currentIndex === questionsData.questions.length - 1 ? 'contact' : ''}`
  }, currentIndex !== questionsData.questions.length - 1 ? question.options.map((option, optionIndex) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    key: optionIndex,
    class: "option-label"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    type: "radio",
    name: question.text,
    value: option.optionText,
    id: `${currentIndex}_${optionIndex}`,
    onChange: () => updateAnswers(question.text, option.optionText)
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "card"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "top-text"
  }, option.optionText), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "img"
  }, option.imgUrl && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
    src: option.imgUrl,
    alt: option.text
  }), option.color && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    style: {
      background: option.color
    }
  }))))) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, contactFormFields.map((field, fieldindex) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "contact-row"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "col-5"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    class: "input-bc-custom"
  }, field.type !== 'select' ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    class: "input-bc-custom__field",
    type: field.type,
    placeholder: " ",
    style: {
      fontSize: "20px"
    },
    id: field.id,
    name: field.id,
    value: answers[field.id],
    onChange: e => updateAnswers(field.id, e.target.value),
    ...field.required
  }) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("select", {
    class: "input-bc-custom__field",
    type: field.type,
    placeholder: " ",
    style: {
      fontSize: "20px"
    },
    id: field.id,
    name: field.id,
    value: answers[field.id],
    onChange: e => updateAnswers(field.id, e.target.value),
    ...field.required
  }, field.options.map((option, optionIndex) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", {
    value: option.value
  }, option.text))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "input-bc-custom__label"
  }, field.label))))), [{
    id: 'subscribe',
    text: 'Embrace the future of boating by subscribing to receive updates from Hendrixon. Be the first to learn about new product launches, exclusive events, and more. By selecting "I agree," you authorize Hendrixon and our trusted partners to utilize your personal information for marketing and promotional activities. Set sail on a journey of innovation and luxury with us—where every update brings you closer to the voyage of your dreams.'
  }, {
    id: 'agreePolicies',
    text: 'By clicking this box, I acknowledge and accept the '
  }].map((checkbox, chId) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "contact-row"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "col-5"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    class: "input-bc-custom",
    style: {
      display: 'flex',
      alignItems: 'flex-start'
    }
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    class: "input-bc-custom__field",
    type: "checkbox",
    placeholder: " ",
    style: {
      fontSize: "20px",
      width: 'auto'
    },
    id: "subscribe",
    value: answers[checkbox.id],
    onClick: e => updateAnswers(checkbox.id, e.target.checked),
    defaultChecked: "true"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    style: {
      margin: '3px 0 0 0',
      padding: '0 0 0 1em',
      fontSize: '10px'
    }
  }, checkbox.id === 'subscribe' ? checkbox.text : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, checkbox.text, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
    href: privacyPolicyUrl,
    target: "_blank",
    rel: "noopener noreferrer",
    title: "This link opens in new tab"
  }, "Policies & Terms")))))))))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: ` pagination-footer ${currentIndex === 0 ? 'previous-disabled' : ''}`
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    type: "button",
    class: "previous",
    onClick: handlePrevClick,
    disabled: currentIndex === 0
  }, "Previous"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    type: "button",
    class: "next",
    onClick: handleNextClick,
    disabled: currentIndex === questionsData.questions.length - 1
  }, "Next"), currentIndex === questionsData.questions.length - 1 && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    type: "submit",
    id: "submit_form",
    class: "next",
    onClick: handleSubmit,
    disabled: false
  }, "Submit")))), formSubmitting && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, formSubmitMessage === '' && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    class: "loader"
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Form is submitting...")), formSubmitMessage !== '' && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, formSubmitMessage))));
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
}
;
})();

/******/ })()
;
//# sourceMappingURL=view.js.map