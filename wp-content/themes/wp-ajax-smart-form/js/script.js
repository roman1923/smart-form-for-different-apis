jQuery(function($) {
	var form = $('#form');
	if (form) {
		$('#form input, #form textarea').on('blur', function () {
				$('#form input, #form textarea').removeClass('error');
				$('.notification').remove();
		});

		var options = {
				url: ajax_form_object.url,
				data: {
						action: 'ajax_form_action',
						nonce: ajax_form_object.nonce
				},
				type: 'POST',
				dataType: 'json',
				beforeSubmit: function (xhr) {
						$('.custom-spinner').css('display', 'inline-block').addClass('spin'); // Show and start spinner animation
						$('#form_submit').prop('disabled', true).css('cursor', 'not-allowed');
				},
				success: function (response) {
						if (response.success === true) {
								$('.modal-section').css('display', 'flex');
								$('#form')[0].reset(); // Reset form after successful submission
						} else {
								$.each(response.data, function (key, val) {
										$('.form_' + key).addClass('error').after('<div class="notification notification_warning notification_warning_' + key + '">' + val + '</div>');
								});
						}
				},
				complete: function() {
						$('#form_submit').prop('disabled', false).css('cursor', 'pointer');
						$('.custom-spinner').removeClass('spin'); // Stop spinner animation
				}
		};

		form.on('submit', function (event) {
				event.preventDefault();
				$(this).ajaxSubmit(options);
				return false;
		});
	}
});


jQuery(function($) {
	// Get the selectedDialCodeElement
	const selectedDialCodeElement = $('.iti__selected-dial-code').parent()[0];
	if (selectedDialCodeElement) {
		// Get the formDialCodeInput element
		const formDialCodeInput = $('#form_dial_code');
		formDialCodeInput.val($('.iti__selected-dial-code').text());
		// Create a MutationObserver instance
		const observer = new MutationObserver(mutationsList => {
				mutationsList.forEach(mutation => {
						// Check if the mutation is related to the aria-expanded attribute
						if (mutation.attributeName === 'aria-expanded') {
								const ariaExpandedValue = selectedDialCodeElement.getAttribute('aria-expanded');
								if (ariaExpandedValue === 'false') {
										formDialCodeInput.val($('.iti__selected-dial-code').text());
								}
						}
				});
		});

		// Start observing changes to the text content of the selected dial code element
		observer.observe(selectedDialCodeElement, { attributes: true });
	}
});

jQuery(function($) {
	// Click event handler for the cross icon
	if($('.cross-block')) {
		$('.cross-block').on('click', function() {
				// Hide the modal section
				$('.modal-section').css('display', 'none');
		});
	}
});

document.addEventListener('DOMContentLoaded', function() {

	// Select the container element
	const selectedFlag = document.querySelector('.iti__selected-flag');

	if (selectedFlag) {

		// Select the child elements to reorder
		const flag = selectedFlag.querySelector('.iti__flag');
		const dialCode = selectedFlag.querySelector('.iti__selected-dial-code');
		const arrow = selectedFlag.querySelector('.iti__arrow');

		// Remove all children from the container
		while (selectedFlag.firstChild) {
				selectedFlag.removeChild(selectedFlag.firstChild);
		}

		// Append the children in the desired order
		selectedFlag.appendChild(flag);
		selectedFlag.appendChild(arrow);
		selectedFlag.appendChild(dialCode);
	}
});

const input = document.querySelector("#form_tel");
if (input) {
	window.intlTelInput(input, {
		showSelectedDialCode: true,
		initialCountry: "UA",
	});
}
