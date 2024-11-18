"use strict";

// Class definition
var KTWizard7 = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizard;
	var _validations = [];

	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		_wizard = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		_wizard.on('beforeNext', function (wizard) {
			// Don't go to the next step yet
			_wizard.stop();

			// Validate form
			var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step
			validator.validate().then(function (status) {
				if (status == 'Valid') {
					

					_wizard.goNext();
					KTUtil.scrollTop();
				} else {
					Swal.fire({
						text: "Sorry, looks like there are some fields required",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light"
						}
					}).then(function () {
						KTUtil.scrollTop();
					});
				}
			});
		});

		// Change event
		_wizard.on('change', function (wizard) {
			KTUtil.scrollTop();
		});
	}

	var initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					name: {
						validators: {
							notEmpty: {
								message: 'Store name is required'
							}
						}
					},
			
				// 	code: {
				// 		validators: {
				// 			notEmpty: {
				// 				message: 'Code is required'
				// 			}
				// 		}
				// 	},
					store_type_id: {
						validators: {
							notEmpty: {
								message: 'Store Type is required'
							}
						}
					},
				phone: {
					validators: {
							notEmpty: {
								message: 'Phone Number is required'
							}
						}
					},
			
					email: {
					validators: {
							notEmpty: {
								message: 'Email is required'
							}
						}
					},
	
		


				
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 2
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					address_line_1: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},
			
					building_number: {
						validators: {
							notEmpty: {
								message: 'Building Number is required'
							}
						}
					},
					postcode: {
						validators: {
							notEmpty: {
								message: 'Postcode is required'
							}
						}
					},
				country_id: {
					validators: {
							notEmpty: {
								message: 'Country is required'
							}
						}
					},
				state_id: {
					validators: {
							notEmpty: {
								message: 'State is required'
							}
						}
					},
					city: {
					validators: {
							notEmpty: {
								message: 'City is required'
							}
						}
					},
			
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));
    // Step 3
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
			          
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));
		//step 4
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
			          		payout_group_id: {
					validators: {
							notEmpty: {
								message: 'Payout group is required'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));
		//step 5
		
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
	
			
					password: {
						validators: {
							notEmpty: {
								message: 'Password is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard_v7');
			_formEl = KTUtil.getById('kt_form');

			initWizard();
			initValidation();
		}
	};
}();

jQuery(document).ready(function () {
	KTWizard7.init();
});
