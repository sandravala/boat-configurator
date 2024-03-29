import { useState } from 'react';
import { TextControl, Button } from "@wordpress/components"

const FormBlock = ({ fields }) => {
    // State to hold the form input values
    const [formValues, setFormValues] = useState({});

    // Function to handle form submission
    const handleSubmit = (event) => {
        event.preventDefault();
        // Submit form data to backend (we'll implement this later)
        console.log('Form submitted:', formValues);
        // Clear the form values
        setFormValues({});
    };

    // Function to handle input changes
    const handleInputChange = (fieldName, value) => {
        setFormValues({
            ...formValues,
            [fieldName]: value
        });
    };

    return (
        <>
            <h2>Custom Form Block</h2>
            <form onSubmit={handleSubmit}>
                {fields.map((field, index) => (
                    <div key={index}>
                        <label>
                            {field.label}:
                            <input
                                type="text"
                                value={''}
                                onChange={(e) => handleInputChange(field.name, e.target.value)}
                            />
                        </label>
                    </div>
                ))}
                <button type="submit">Submit</button>
            </form>
        </>
    );
};

export default FormBlock;