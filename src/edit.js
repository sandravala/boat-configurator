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

import { TextControl, Flex, FlexBlock, FlexItem, Button, Icon, PanelBody, PanelRow, SelectControl, ColorPicker } from "@wordpress/components"
import { ChromePicker } from "react-color"
import { MediaUpload } from '@wordpress/block-editor';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit(props) {

	const blockProps = useBlockProps({
		className: "paying-attention-edit-block",
		style: { backgroundColor: props.attributes.bgColor }
	})

	function updateModel(value) {
		props.setAttributes({ model: value })
	}

	function deleteQuestion(indexToDelete) {
		const newQuestions = props.attributes.questions.filter(function (x, index) {
			return index != indexToDelete
		})
		props.setAttributes({ questions: newQuestions })

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
				"options": [{"text":"", "imgUrl":""}]
			}])
		})
	}

	function addNewOption(questionIndex) {

		// Get the current options for the specified question index
		const currentOptions = props.attributes.questions[questionIndex].options;
    
		// Create a new array of options by concatenating a new empty option object
		const newOptions = [...currentOptions, { "text": "", "imgUrl": "" }];
	
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

	return (
		<>
			<div {...useBlockProps()} style={{ backgroundColor: props.attributes.bgColor }}>
				<BlockControls>
					<AlignmentToolbar value={props.attributes.theAlignment} onChange={x => props.setAttributes({ theAlignment: x })} />
				</BlockControls>
				<InspectorControls>
					<PanelBody title="Background Color" initialOpen={true}>
						<PanelRow>
							<ChromePicker color={props.attributes.bgColor} onChangeComplete={x => props.setAttributes({ bgColor: x.hex })} disableAlpha={true} />
						</PanelRow>
					</PanelBody>
				</InspectorControls>
				<TextControl label="Model:" value={props.attributes.model} onChange={updateModel} style={{ fontSize: "20px" }} />
				<p style={{ fontSize: "13px", margin: "20px 0 8px 0" }}>Questions:</p>

				{props.attributes.questions.map(function (question, questionIndex) {
					return (
						<Flex className="question-container">

							<FlexBlock>
								<TextControl value={question.text}
									onChange={newValue => {
										const newQuestions = [...props.attributes.questions]; // Create a copy of the questions array
										newQuestions[questionIndex].text = newValue; // Update the text of the question at the specified index
										props.setAttributes({ questions: newQuestions }); // Set the updated questions array in the attributes
									}}
								/>

								<div class="container">
									{question.options.map((option, optionIndex) => (
										<label>
											<input
												type="radio"
												name={option.optionText}
												value={option.optionText}
												id={optionIndex}
											/>
											<div class="card">
												<span class="dashicons dashicons-no delete-option" onClick={() => deleteOption(questionIndex, optionIndex)}></span>

												<div class="top-text">
													<div class="option">
														<TextControl 
															value={option.optionText}
															onChange={(newValue) => {
																const newQuestions = [...props.attributes.questions];
																newQuestions[questionIndex].options[optionIndex].optionText = newValue;
																props.setAttributes({ questions: newQuestions });
															}}
														/>
													</div>
												</div>

												<div class="img">

													<MediaUpload
														onSelect={(image) => {
															props.setAttributes({ imageURL: image.url });
														}}
														allowedTypes={['image']}
														value={props.attributes.imageURL}
														render={({ open }) => (
															<img
																src={props.attributes.imageURL || 'https://via.placeholder.com/100x100/e8e8e8/ffffff&text=add image'}
																alt="Option 2"
																style={{ cursor: 'pointer' }}
																onClick={open}
															/>
														)}
													/>

												</div>

											</div>
										</label>
									))}
									<div class="card-plus">
									<span class="dashicons dashicons-insert add-option" onClick={() => addNewOption(questionIndex)}></span>
									</div>
								</div>

							</FlexBlock>

							<FlexItem className="delete-question">
								<span class="dashicons dashicons-trash delete-btn" onClick={() => deleteQuestion(questionIndex)}></span>
								{/* <Button isLink className="attention-delete" onClick={() => deleteQuestion(questionIndex)}>Delete</Button> */}
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