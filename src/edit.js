/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, BlockControls, AlignmentToolbar, useBlockProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

import { TextControl, Flex, FlexBlock, FlexItem, Button, Icon, PanelBody, PanelRow, SelectControl, ColorPicker, Modal } from "@wordpress/components"
import { MediaUpload } from '@wordpress/block-editor';
import { useState } from 'react';


/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit(props) {

	const [accordionStates, setAccordionStates] = useState({});

	function toggleAccordion(questionIndex) {
		setAccordionStates(prevState => ({
			...prevState,
			[questionIndex]: !prevState[questionIndex]
		}));
	}


	const [colorPickerStates, setColorPickerStates] = useState(Array.from({ length: props.attributes.questions.length }, () => []));

	function openColorPicker(questionIndex, optionIndex) {
		setColorPickerStates(prevState => {
			const newState = [...prevState];
			newState[questionIndex][optionIndex] = !prevState[questionIndex][optionIndex];
			return newState;
		});
	}

	const blockProps = useBlockProps({
		className: "boat-config-edit-block",
	})

	function updateModel(value) {
		props.setAttributes({ model: value })
	}

	function deleteQuestion(indexToDelete) {
		const newQuestions = props.attributes.questions.filter(function (x, index) {
			return index != indexToDelete
		})
		props.setAttributes({ questions: newQuestions })

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
				return { ...question, options: newOptions };
			}
			return question;
		});
		props.setAttributes({ questions: newQuestions });

	}

	function addNewQuestion() {

		props.setAttributes({
			questions: props.attributes.questions.concat([{
				"text": "",
				"options": [{ "text": "", "imgUrl": "", "color": "" }]
			}])
		})
		setColorPickerStates(prevState => [...prevState, []]);
	}

	function addNewOption(questionIndex) {

		// Get the current options for the specified question index
		const currentOptions = props.attributes.questions[questionIndex].options;

		// Create a new array of options by concatenating a new empty option object
		const newOptions = [...currentOptions, { "text": "", "imgUrl": "", "color": "" }];

		// Update the questions attribute with the new options array
		props.setAttributes({
			questions: props.attributes.questions.map((question, index) => {
				if (index === questionIndex) {
					return { ...question, options: newOptions };
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
				props.setAttributes({ questions: newQuestions });
			}
		} else {
			if (questionIndex < props.attributes.questions.length - 1) {
				const newQuestions = [...props.attributes.questions];
				[newQuestions[questionIndex], newQuestions[questionIndex + 1]] = [newQuestions[questionIndex + 1], newQuestions[questionIndex]];
				props.setAttributes({ questions: newQuestions });
			}
		}
	}

	return (
		<>
			<div {...useBlockProps()}>
				{/* <BlockControls>
					<AlignmentToolbar value={props.attributes.theAlignment} onChange={x => props.setAttributes({ theAlignment: x })} />
				</BlockControls>
				<InspectorControls>
					<PanelBody title="Background Color" initialOpen={true}>
						<PanelRow>
							<ChromePicker color={props.attributes.bgColor} onChangeComplete={x => props.setAttributes({ bgColor: x.hex })} disableAlpha={true} />
						</PanelRow>
					</PanelBody>
				</InspectorControls> */}
				<label class="input-bc-custom">
					<input
						class="input-bc-custom__field"
						type="text" placeholder=" "
						value={props.attributes.model}
						onChange={(event) => updateModel(event.target.value)}
						style={{ fontSize: "20px" }}
					/>
					<span class="input-bc-custom__label">Model:</span>
				</label>
				{/* <TextControl label="Model:" value={props.attributes.model} onChange={updateModel} style={{ fontSize: "20px" }} /> */}
				<p style={{ fontSize: "13px", margin: "20px 0 8px 0", paddingLeft: "1.4em", color: "#b0afaf" }}>Questions:</p>

				{props.attributes.questions.map(function (question, questionIndex) {

					const isActive = accordionStates[questionIndex] || false;
					return (
						<Flex>
							<FlexItem style={{ flex: 20 }}>
								<div key={questionIndex} class="accordion">
									<div class={`accordion-header ${!isActive ? 'closed' : ''}`} >
										<Flex>
											<Flex className="question-header" >
												<FlexBlock className="stacked">
													<FlexItem className="question-arrows">
														{questionIndex > 0 ? <span class="dashicons dashicons-arrow-up-alt2" onClick={() => moveQuestion(questionIndex, true)}></span> : <span class="dashicons dashicons-arrow-up-alt2" style={{ color: "#dfdfdf" }}></span>}
													</FlexItem>
													<FlexItem className="question-arrows">
														{questionIndex < props.attributes.questions.length - 1 ? <span class="dashicons dashicons-arrow-down-alt2" onClick={() => moveQuestion(questionIndex)}></span> : <span class="dashicons dashicons-arrow-down-alt2" style={{ color: "#dfdfdf" }}></span>}
													</FlexItem>
												</FlexBlock>
												<FlexItem className="question-header" onClick={() => toggleAccordion(questionIndex)}>
													<FlexItem>
														{questionIndex + 1}
													</FlexItem>
													<FlexItem>
														{question.text}
													</FlexItem>
												</FlexItem>
											</Flex>
											<Flex className="question-expand">
												<FlexItem>
													<span class={`dashicons dashicons-${isActive ? 'minus' : 'plus'}`} onClick={() => toggleAccordion(questionIndex)}></span>
												</FlexItem>
											</Flex>
										</Flex>
									</div>
									{isActive &&
										<div className="accordion-content">
											<Flex className="question-container">

												<FlexBlock>
													<label class="input-bc-custom">
														<input
															class="input-bc-custom__field"
															type="text"
															placeholder=" "
															value={question.text}
															onChange={(event) => {
																const newQuestions = [...props.attributes.questions]; // Create a copy of the questions array
																newQuestions[questionIndex].text = event.target.value; // Update the text of the question at the specified index
																props.setAttributes({ questions: newQuestions }); // Set the updated questions array in the attributes
															}}
															style={{ fontSize: "15px" }} />
														<span class="input-bc-custom__label question">Question text:</span>
													</label>

													<div class="container">

														<div class="container">
															{question.options.map((option, optionIndex) => {

																return (
																	<div class="card">
																		<span class="dashicons dashicons-no delete-option" onClick={() => deleteOption(questionIndex, optionIndex)}></span>
																		<div class="top-text">
																			<div class="option">
																				<label class="input-bc-custom">
																					<input
																						class="input-bc-custom__field"
																						type="text"
																						placeholder=" "
																						value={option.optionText}
																						onChange={(event) => {
																							const newQuestions = [...props.attributes.questions];
																							newQuestions[questionIndex].options[optionIndex].optionText = event.target.value;
																							props.setAttributes({ questions: newQuestions });
																						}}
																						style={{ fontSize: "15px" }} />
																					<span class="input-bc-custom__label">Option text:</span>
																				</label>
																			</div>
																		</div>
																		<div>
																			<MediaUpload
																				onSelect={(image) => {
																					const newQuestions = [...props.attributes.questions];
																					newQuestions[questionIndex].options[optionIndex].imgUrl = image.url;
																					newQuestions[questionIndex].options[optionIndex].color = '';
																					props.setAttributes({ questions: newQuestions });
																				}}
																				allowedTypes={['image']}
																				render={({ open }) => (
																					<span class="dashicons dashicons-format-image" onClick={open}></span>
																				)}
																			/>
																			<span class="dashicons dashicons-color-picker" onClick={() => openColorPicker(questionIndex, optionIndex)}></span>
																			{colorPickerStates[questionIndex][optionIndex] && (
																				<Modal title="Pick the color" onRequestClose={() => openColorPicker(questionIndex, optionIndex)}>
																					<ColorPicker
																						color={option.color}
																						onChange={(newColor) => {
																							const newQuestions = [...props.attributes.questions];
																							newQuestions[questionIndex].options[optionIndex].imgUrl = '';
																							newQuestions[questionIndex].options[optionIndex].color = newColor;
																							props.setAttributes({ questions: newQuestions });
																						}}
																					/>
																				</Modal>
																			)}
																		</div>
																		<div class="img">
																			{option.imgUrl && <img src={option.imgUrl} alt={option.text} />}
																			{option.color && <div style={{ background: option.color, height: '100%', width: '100%' }}></div>}

																		</div>
																	</div>
																);
															})}
														</div>

														<div class="card-plus">
															<span class="dashicons dashicons-insert add-option" onClick={() => addNewOption(questionIndex)}></span>
														</div>
													</div>
												</FlexBlock>
											</Flex>
										</div>
									}
								</div>
							</FlexItem>
							<FlexItem className="delete-question" style={{ flex: 1 }}>
								<span class="dashicons dashicons-trash delete-btn" onClick={() => deleteQuestion(questionIndex)}></span>
							</FlexItem>
						</Flex>

					)
				})}

				<Button onClick={() => addNewQuestion()}>Add another question</Button>

			</div>
		</>
	)
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