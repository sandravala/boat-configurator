/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./src/front-end/multistep-form.js ***!
  \*****************************************/
// import React from 'react';
// import ReactDOM from 'react-dom';

// console.log( 'Hello World! (from multistep-form.js)' );
// /* eslint-enable no-console */

document.addEventListener('DOMContentLoaded', function () {

  //     const testBtn = document.getElementById('testing-render');
  //     testBtn.addEventListener('click', function(){
  //         console.log(questionsData);
  //         });

  //     const bcDiv = document.getElementsByClassName('update-me')[0];
  //     ReactDOM.render(<BoatConfig questionsData/>, bcDiv);
  //     bcDiv.classList.remove('update-me');
});

// function BoatConfig(questionsData) {

//     return (
//         <div className='bc-frontend'>
//             {    questionsData.forEach(q => {
//         return (
//             <p>{q}</p>
//         )
//     })}
//         </div>
//     )
// }

{/* <form method="POST" action="https://go.pardot.com/l/70842/2020-07-14/8kyx24" enctype="application/x-www-form-urlencoded" class="cmp-form aem-Grid aem-Grid--8 aem-Grid--default--8 boat-configurator-form" novalidate="">
    <input type="hidden" name=":formstart" value="/content/brunswick/bayliner/na/global/en/references/boat-configurator-form/jcr:content/root/container_v2">
        <input type="hidden" name="_charset_" value="utf-8">
             <div class="text-v2 text aem-GridColumn aem-GridColumn--default--8">
                <div class="cmp-form-text" data-cmp-is="formText" data-cmp-required-message="Please enter your full first name">
                    <label for="form-text-94100198">FIRST NAME *</label>
 
                    <input class="cmp-form-text__text form-control" data-cmp-hook-form-text="input" aria-label="FIRST NAME *" type="text" id="form-text-94100198" title="Please enter your full first name" name="firstName" required="" pattern=".{1,20}">
                         <div class="invalid-feedback">* Please enter your full first name</div>
                 </div>
            </div>
            <div class="text-v2 text aem-GridColumn aem-GridColumn--default--8">
                <div class="cmp-form-text" data-cmp-is="formText" data-cmp-required-message="Please enter your full last name">
                    <label for="form-text-1817043417">LAST NAME *</label>
 
                    <input class="cmp-form-text__text form-control" data-cmp-hook-form-text="input" aria-label="LAST NAME *" type="text" id="form-text-1817043417" title="Please enter your full last name" name="lastName" required="" pattern=".{1,20}">
                         <div class="invalid-feedback">* Please enter your full last name</div>
                 </div>
            </div>
            <div class="text-v2 text aem-GridColumn aem-GridColumn--default--8">
                <div class="cmp-form-text" data-cmp-is="formText" data-cmp-required-message="Please enter a valid email address">
                    <label for="form-text-648432596">EMAIL *</label>
 
                    <input class="cmp-form-text__text form-control" data-cmp-hook-form-text="input" aria-label="EMAIL *" type="email" id="form-text-648432596" title="Please enter a valid email address" name="email" required="">
                         <div class="invalid-feedback">* Please enter a valid email address</div>
                 </div>
            </div>
            <div class="text-v2 text aem-GridColumn aem-GridColumn--default--8">
                <div class="cmp-form-text" data-cmp-is="formText" data-cmp-required-message="Field is required">
                    <label for="form-text-2004271001">PHONE</label>
 
                    <input class="cmp-form-text__text form-control" data-cmp-hook-form-text="input" aria-label="PHONE" type="number" id="form-text-2004271001" name="phone" maxlength=".{1,20}">
                         <div class="invalid-feedback">* Field is required</div>
                 </div>
            </div>
            <div class="text-v2 text aem-GridColumn aem-GridColumn--default--8">
                <div class="cmp-form-text" data-cmp-is="formText" data-cmp-required-message="Please enter your city">
                    <label for="form-text-1524946933">CITY *</label>
 
                    <input class="cmp-form-text__text form-control" data-cmp-hook-form-text="input" aria-label="CITY *" type="text" id="form-text-1524946933" title="Please enter your city" name="city" required="" pattern=".{1,20}">
                         <div class="invalid-feedback">* Please enter your city</div>
                 </div>
            </div>
            <div class="text-v2 text aem-GridColumn aem-GridColumn--default--8">
                <div class="cmp-form-text" data-cmp-is="formText" data-cmp-required-message="Please enter your ZIP/Postal code">
                    <label for="form-text-1157759940">ZIP CODE *</label>
 
                    <input class="cmp-form-text__text form-control" data-cmp-hook-form-text="input" aria-label="ZIP CODE *" type="text" id="form-text-1157759940" title="Please enter your ZIP/Postal code" name="postalCode" required="" pattern=".{1,20}" maxlength="6">
                         <div class="invalid-feedback">* Please enter your ZIP/Postal code</div>
                 </div>
            </div>
            <div class="options-v2 options aem-GridColumn aem-GridColumn--default--8">
                 <fieldset class="cmp-form-options cmp-form-options--drop-down">
 
                    <label class="cmp-form-options__label" for="form-options-2057230317">COUNTRY *</label>
                    <div class="selectWrapper">
                        <select class="cmp-form-options__field cmp-form-options__field--drop-down form-control" name="country" aria-label="COUNTRY *" id="form-options-2057230317" title="Please select your country" required="required"><option value="" selected="" disabled="">Choose</option>
                            
                        </select>
                         <div class="invalid-feedback">* Please select your country</div>
                     </div>
 
                 </fieldset>
 
 
            </div>
             <div class="text-v2 text aem-GridColumn aem-GridColumn--default--8">
                <div class="cmp-form-text" data-cmp-is="formText" data-cmp-required-message="Field is required">
                    <label for="form-text-342932082">COMMENTS</label>
                     <textarea class="cmp-form-text__textarea" data-cmp-hook-form-text="input" id="form-text-342932082" name="comments" rows="2" pattern=".{0,200}"></textarea>
 
                    <div class="invalid-feedback">* Field is required</div>
                 </div>
            </div>
            <div class="text aem-GridColumn aem-GridColumn--default--8">
                <div>
                    <div class=" cmp-text c-link      ">
                        <p style="text-align: right;">*Required Fields</p>
                     </div>
 
                 </div></div>
            <div class="options-v2 options aem-GridColumn aem-GridColumn--default--8">
                 <fieldset class="cmp-form-options cmp-form-options--checkbox">
                     <legend class="cmp-form-options__legend">Join our mailing list</legend>
                    <label class="cmp-form-options__field-label is-dirty">
                        <input class="cmp-form-options__field cmp-form-options__field--checkbox form-control hiddenInp" type="checkbox" name="optIn" aria-label="optIn" value="yes" checked="" tabindex="-1">
                            <span class=""></span>
                            <span class="cmp-form-options__field-description bayliner" tabindex="0"></span>
                     </label>
 
                     <div class="cmp-form-options__help-message"><p>Receive periodic updates from Bayliner on new product launches, boat shows, owner events and more! By selecting I agree to allow Bayliner and any identified third party vendors to use my personal information for marketing and sales activities.</p>
                    </div>
                </fieldset>
 
 
            </div>
            <div class="options-v2 options aem-GridColumn aem-GridColumn--default--8">
                 <fieldset class="cmp-form-options cmp-form-options--checkbox">
                     <legend class="cmp-form-options__legend">I Agree*</legend>
                    <label class="cmp-form-options__field-label is-dirty">
                        <input class="cmp-form-options__field cmp-form-options__field--checkbox form-control hiddenInp" type="checkbox" name="gdprDataStorageConsent" aria-label="gdprDataStorageConsent" value="Granted" required="required" tabindex="-1">
                            <span class=""></span>
                            <span class="cmp-form-options__field-description bayliner" title="Please agree to the terms to submit the form" tabindex="0"></span>
                             <div class="invalid-feedback">* Please agree to the terms to submit the form</div>
                     </label>
 
                     <div class="cmp-form-options__help-message"><p>By clicking this box, I acknowledge and accept the <a href="/global/en/policies.html" target="_blank" title="This link opens in new tab">Policies &amp; Terms</a>, and agree that my information may be transferred to the U.S. if I am outside the U.S.</p>
                    </div>
                </fieldset>
 
 
            </div>
            <div class="button-v2 button aem-GridColumn aem-GridColumn--default--8">
                <button type="SUBMIT" class="cmp-form-button" name="send" aria-label="SEND TO DEALER" value="send to dealer" id="submitIForm">SEND TO DEALER</button>
            </div>
            <div class="hidden-v2 hidden aem-GridColumn aem-GridColumn--default--8">
                <input type="hidden" id="model" name="model" aria-label="area-model">
 
            </div>
            <div class="hidden-v2 hidden aem-GridColumn aem-GridColumn--default--8">
                <input type="hidden" id="url" name="url" aria-label="area-url">
 
            </div>
 
 </form> */}
/******/ })()
;
//# sourceMappingURL=multistep-form.js.map