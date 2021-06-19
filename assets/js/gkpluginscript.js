import {getEltById, listenChangeOnArray } from "./helper.js";

(function($){

    $(function() {

        class HandleForm {

            static DEFAULT_COLOR = 'red';
            static SUCCESS_COLOR = 'green';
            static REGEX_EMAIL = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            static STATUS = {
                'incomplete' : 'Veuillez saisir votre E-mail.',
                'error' : 'L\'e-mail saisi est invalide.',
                'success' : 'Votre inscription a bien été effectuée.'
            };

            constructor() {
                this.formNwlElt = getEltById('nwl-form');
                this.inputEmailNwlElt =  getEltById('nwl-email-input');
                this.msgFormNwlElt =  getEltById('nwl-validation-form-message');
                this.errors = [];
                this.bindEvents();
            }

            /**
             * Bind all EventListener
             */
            bindEvents() {
                this.inputEmailNwlElt.addEventListener( 'input', () => this.handleChangeInput() );
                this.formNwlElt.addEventListener( 'submit', (e) => this.handleSubmission(e) );
            }

            /**
             * Minimal Regex to Validate an email
             *
             * @param emailAddress
             *
             * @returns {boolean}
             */
           static validateEmail (emailAddress) {
                return !!emailAddress.match(HandleForm.REGEX_EMAIL);
           }

            /**
             * Show err or success message on form
             *
             * @param elt
             * @param msg
             * @param color
             */
           static showMessage (elt, msg, color = HandleForm.DEFAULT_COLOR) {
                elt.textContent = '';
                elt.textContent = msg;
                elt.style.color = color ;
           }

            /**
             * Simple fn to clear message on validate text input
             */
           clearFieldOnValidData() {
                HandleForm.showMessage(this.msgFormNwlElt, '', '')
                this.inputEmailNwlElt.style.borderColor = HandleForm.SUCCESS_COLOR;
           }

            /**
             * Event Listener on change input
             */
           handleChangeInput() {
               const inputValue = this.inputEmailNwlElt.value.trim();
               HandleForm.validateEmail(inputValue)  ? this.clearFieldOnValidData() : '';
           }

            /**
             * Validation on success
             */
           onSuccess(msg) {
               listenChangeOnArray(this.errors, () => {
                      this.inputEmailNwlElt.style.borderColor = HandleForm.SUCCESS_COLOR;
               });
               this.errors = [0];
               HandleForm.showMessage(this.msgFormNwlElt, msg, HandleForm.SUCCESS_COLOR );
           }
          
            /**
             * Validation on errors
             */
            onFail(msg) {
                listenChangeOnArray(this.errors, () => {
                    this.inputEmailNwlElt.style.borderColor = HandleForm.DEFAULT_COLOR;
                });

                this.errors.push(msg);
                HandleForm.showMessage(this.msgFormNwlElt, this.errors[0]);
            }

            /**
             * On Event submit form
             *
             * @param e
             */
           handleSubmission(e) {
                e.preventDefault();
                const user_email = this.inputEmailNwlElt?.value?.trim().toLowerCase() ;
                //0-re-initialize array
                this.errors = [];
                //1- check if field is empty : case email incomplete
                if ( user_email === '' || null || undefined) {
                    this.onFail(HandleForm.STATUS['incomplete']);
                }
                //2- send req. ajx wordpress
                if( user_email && HandleForm.validateEmail( user_email) ) {
                    //a-Get settings wp_localize_script from php
                    const { ajax_url, nonce } = my_ajax_obj;
                    let data = {
                        _ajax_nonce : nonce,
                        action : this.formNwlElt.getAttribute('data-action'),
                        user_email
                    }
                    //b- req.ajx
                    $.post(ajax_url, data, (res) => {
                        console.log(res)
                        !res.success
                           ? this.onFail(HandleForm.STATUS['error'])
                           : this.onSuccess(HandleForm.STATUS['success']);
                    });

                } else {
                    this.onFail(HandleForm.STATUS['error']);
                }
            }

        }

        /**
         * main script
         */
        if (document.querySelector('#nwl-form') && document.querySelector('#nwl-email-input')) {
             ( new HandleForm());
        }
      
    });
  
})(jQuery);

