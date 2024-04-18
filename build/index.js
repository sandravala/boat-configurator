/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/edit.js":
/*!*********************!*\
  !*** ./src/edit.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./editor.scss */ "./src/editor.scss");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */


/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */


/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */





/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
function Edit(props) {
  const [accordionStates, setAccordionStates] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)({});
  function toggleAccordion(questionIndex) {
    setAccordionStates(prevState => ({
      ...prevState,
      [questionIndex]: !prevState[questionIndex]
    }));
  }
  const [colorPickerStates, setColorPickerStates] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(Array.from({
    length: props.attributes.questions.length
  }, () => []));
  function openColorPicker(questionIndex, optionIndex) {
    setColorPickerStates(prevState => {
      const newState = [...prevState];
      newState[questionIndex][optionIndex] = !prevState[questionIndex][optionIndex];
      return newState;
    });
  }
  const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps)({
    className: "boat-config-edit-block"
  });
  function updateModel(value) {
    props.setAttributes({
      model: value
    });
  }
  function deleteQuestion(indexToDelete) {
    const newQuestions = props.attributes.questions.filter(function (x, index) {
      return index != indexToDelete;
    });
    props.setAttributes({
      questions: newQuestions
    });
    setColorPickerStates(prevState => {
      // Filter out the array at the index of the question you want to delete
      const newState = prevState.filter((_, indexState) => indexState !== indexToDelete);
      return newState;
    });
  }
  function deleteOption(questionIndex, optionIndexToDelete) {
    const newQuestions = props.attributes.questions.map((question, index) => {
      if (index === questionIndex) {
        // If this is the question that contains the option to delete
        const newOptions = question.options.filter((option, optionIndex) => {
          return optionIndex !== optionIndexToDelete;
        });
        return {
          ...question,
          options: newOptions
        };
      }
      return question;
    });
    props.setAttributes({
      questions: newQuestions
    });
  }
  function addNewQuestion() {
    props.setAttributes({
      questions: props.attributes.questions.concat([{
        "text": "",
        "options": [{
          "text": "",
          "imgUrl": "",
          "color": ""
        }]
      }])
    });
    setColorPickerStates(prevState => [...prevState, []]);
  }
  function addNewOption(questionIndex) {
    // Get the current options for the specified question index
    const currentOptions = props.attributes.questions[questionIndex].options;

    // Create a new array of options by concatenating a new empty option object
    const newOptions = [...currentOptions, {
      "text": "",
      "imgUrl": "",
      "color": ""
    }];

    // Update the questions attribute with the new options array
    props.setAttributes({
      questions: props.attributes.questions.map((question, index) => {
        if (index === questionIndex) {
          return {
            ...question,
            options: newOptions
          };
        }
        return question;
      })
    });
  }
  function moveQuestion(questionIndex, moveUpBoolean) {
    if (moveUpBoolean) {
      if (questionIndex > 0) {
        const newQuestions = [...props.attributes.questions];
        [newQuestions[questionIndex], newQuestions[questionIndex - 1]] = [newQuestions[questionIndex - 1], newQuestions[questionIndex]];
        props.setAttributes({
          questions: newQuestions
        });
      }
    } else {
      if (questionIndex < props.attributes.questions.length - 1) {
        const newQuestions = [...props.attributes.questions];
        [newQuestions[questionIndex], newQuestions[questionIndex + 1]] = [newQuestions[questionIndex + 1], newQuestions[questionIndex]];
        props.setAttributes({
          questions: newQuestions
        });
      }
    }
  }
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ...(0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps)()
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    class: "input-bc-custom"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
    class: "input-bc-custom__field",
    type: "text",
    placeholder: " ",
    value: props.attributes.model,
    onChange: event => updateModel(event.target.value),
    style: {
      fontSize: "20px"
    }
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    class: "input-bc-custom__label"
  }, "Model:")), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    style: {
      fontSize: "13px",
      margin: "20px 0 8px 0",
      paddingLeft: "1.4em",
      color: "#b0afaf"
    }
  }, "Questions:"), props.attributes.questions.map(function (question, questionIndex) {
    const isActive = accordionStates[questionIndex] || false;
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Flex, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FlexItem, {
      style: {
        flex: 20
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      key: questionIndex,
      class: "accordion"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      class: `accordion-header ${!isActive ? 'closed' : ''}`
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Flex, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Flex, {
      className: "question-header"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FlexBlock, {
      className: "stacked"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FlexItem, {
      className: "question-arrows"
    }, questionIndex > 0 ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      class: "dashicons dashicons-arrow-up-alt2",
      onClick: () => moveQuestion(questionIndex, true)
    }) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      class: "dashicons dashicons-arrow-up-alt2",
      style: {
        color: "#dfdfdf"
      }
    })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FlexItem, {
      className: "question-arrows"
    }, questionIndex < props.attributes.questions.length - 1 ? (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      class: "dashicons dashicons-arrow-down-alt2",
      onClick: () => moveQuestion(questionIndex)
    }) : (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      class: "dashicons dashicons-arrow-down-alt2",
      style: {
        color: "#dfdfdf"
      }
    }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FlexItem, {
      className: "question-header",
      onClick: () => toggleAccordion(questionIndex)
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FlexItem, null, questionIndex + 1), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FlexItem, null, question.text))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Flex, {
      className: "question-expand"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FlexItem, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      class: `dashicons dashicons-${isActive ? 'minus' : 'plus'}`,
      onClick: () => toggleAccordion(questionIndex)
    }))))), isActive && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "accordion-content"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Flex, {
      className: "question-container"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FlexBlock, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
      class: "input-bc-custom"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      class: "input-bc-custom__field",
      type: "text",
      placeholder: " ",
      value: question.text,
      onChange: event => {
        const newQuestions = [...props.attributes.questions]; // Create a copy of the questions array
        newQuestions[questionIndex].text = event.target.value; // Update the text of the question at the specified index
        props.setAttributes({
          questions: newQuestions
        }); // Set the updated questions array in the attributes
      },
      style: {
        fontSize: "15px"
      }
    }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      class: "input-bc-custom__label question"
    }, "Question text:")), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      class: "container"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      class: "container"
    }, question.options.map((option, optionIndex) => {
      return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        class: "card"
      }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
        class: "dashicons dashicons-no delete-option",
        onClick: () => deleteOption(questionIndex, optionIndex)
      }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        class: "top-text"
      }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        class: "option"
      }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
        class: "input-bc-custom"
      }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
        class: "input-bc-custom__field",
        type: "text",
        placeholder: " ",
        value: option.optionText,
        onChange: event => {
          const newQuestions = [...props.attributes.questions];
          newQuestions[questionIndex].options[optionIndex].optionText = event.target.value;
          props.setAttributes({
            questions: newQuestions
          });
        },
        style: {
          fontSize: "15px"
        }
      }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
        class: "input-bc-custom__label"
      }, "Option text:")))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.MediaUpload, {
        onSelect: image => {
          const newQuestions = [...props.attributes.questions];
          newQuestions[questionIndex].options[optionIndex].imgUrl = image.url;
          newQuestions[questionIndex].options[optionIndex].color = '';
          props.setAttributes({
            questions: newQuestions
          });
        },
        allowedTypes: ['image'],
        render: ({
          open
        }) => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
          class: "dashicons dashicons-format-image",
          onClick: open
        })
      }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
        class: "dashicons dashicons-color-picker",
        onClick: () => openColorPicker(questionIndex, optionIndex)
      }), colorPickerStates[questionIndex][optionIndex] && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Modal, {
        title: "Pick the color",
        onRequestClose: () => openColorPicker(questionIndex, optionIndex)
      }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.ColorPicker, {
        color: option.color,
        onChange: newColor => {
          const newQuestions = [...props.attributes.questions];
          newQuestions[questionIndex].options[optionIndex].imgUrl = '';
          newQuestions[questionIndex].options[optionIndex].color = newColor;
          props.setAttributes({
            questions: newQuestions
          });
        }
      }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        class: "img"
      }, option.imgUrl && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
        src: option.imgUrl,
        alt: option.text
      }), option.color && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        style: {
          background: option.color,
          height: '100%',
          width: '100%'
        }
      }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        style: {
          background: option.color,
          height: '50px'
        }
      })));
    })), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      class: "card-plus"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      class: "dashicons dashicons-insert add-option",
      onClick: () => addNewOption(questionIndex)
    })))))))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.FlexItem, {
      className: "delete-question",
      style: {
        flex: 1
      }
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
      class: "dashicons dashicons-trash delete-btn",
      onClick: () => deleteQuestion(questionIndex)
    })));
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    onClick: () => addNewQuestion()
  }, "Add another question")));
}

//5. Laivo konfiguracijos pasirinkimai:

// Konkrečių dar neturime. Tad surašau preleminarius
// Variklis
// 50ag
// 100ag
// 150ag
// Stogelis
// Sulankstomas
// nėra stogelio
// Vidaus medžiagos spalva
// Gelsva
// Pilka
// Rožinė
// Garso aparatūra
// Nėra
// Bazinė
// Pagerinta
// Navigacija
// Garmin
// Kinietiška

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./src/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./save */ "./src/save.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./block.json */ "./src/block.json");
/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */


/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * Internal dependencies
 */




/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_4__.name, {
  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_2__["default"],
  /**
   * @see ./save.js
   */
  save: _save__WEBPACK_IMPORTED_MODULE_3__["default"]
});

/***/ }),

/***/ "./src/save.js":
/*!*********************!*\
  !*** ./src/save.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ save)
/* harmony export */ });
/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
function save() {
  return null;
}

/***/ }),

/***/ "./src/editor.scss":
/*!*************************!*\
  !*** ./src/editor.scss ***!
  \*************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/style.scss":
/*!************************!*\
  !*** ./src/style.scss ***!
  \************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./src/block.json":
/*!************************!*\
  !*** ./src/block.json ***!
  \************************/
/***/ ((module) => {

module.exports = /*#__PURE__*/JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"create-block/boat-configurator","version":"0.1.0","title":"Boat Configurator","category":"text","icon":"admin-generic","description":"Example block scaffolded with Create Block tool.","example":{},"supports":{"html":false},"textdomain":"boat-configurator","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css","viewScript":"file:./view.js","attributes":{"model":{"type":"string"},"questions":{"type":"array","default":[{"text":"","options":[{"text":"","imgUrl":"","color":""}]}],"items":{"type":"object","properties":{"text":{"type":"string"},"options":{"type":"array","items":{"type":"object","properties":{"text":{"type":"string"},"imgUrl":{"type":"string"},"color":{"type":"string"}}}}}}}},"render":"file:./render.php"}');

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
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
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
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"./style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = globalThis["webpackChunkboat_configurator"] = globalThis["webpackChunkboat_configurator"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], () => (__webpack_require__("./src/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map