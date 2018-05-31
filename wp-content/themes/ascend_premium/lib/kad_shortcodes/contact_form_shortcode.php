<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

//Shortcode for contact form
function ascend_contact_form_shortcode_function( $atts ) {
	extract(shortcode_atts(array(
		'label_name' 			=> __('Name:', 'ascend'),
		'label_email' 			=> __('Email:', 'ascend'),
		'label_subject'			=> __('Subject:', 'ascend'),
		'label_message' 		=> __('Message:', 'ascend'),
		'label_submit' 			=> __('Send Message', 'ascend'),
		'label_consent' 		=> '',
		'label_name_error' 		=> __('Please enter at least 2 characters.', 'ascend'),
		'label_consent_error' 	=> __('Please check box.', 'ascend'),
		'label_email_error' 	=> __('Please enter a valid email.', 'ascend'),
		'label_subject_error' 	=> __('Please enter at least 2 characters.', 'ascend'),
		'label_message_error' 	=> __('Please enter at least 10 characters.', 'ascend'),
		'label_math_error' 		=> __('Please check your math.', 'ascend'),
		'message_error' 		=> __('Please fill the required fields.', 'ascend'),
		'message_success' 		=> __('Thank you! Your message was sent successfully.', 'ascend'),
		'email_to' 				=> get_bloginfo('admin_email'),
		'enable_math' 			=> 'true',
		'enable_consent' 		=> 'false',
		'require_name' 			=> 'true',
		'require_subject' 		=> 'true',
		'show_required' 		=> 'false',
		'style' 				=> 'normal',
), $atts));
	global $kt_contact_has_run, $kt_contact_email_created;
	$form_data = array(
		'contactName' => '',
		'contactEmail' => '',
		'contactSubject' => '',
		'contactMath' => '',
		'contactMessage' => ''
	);
	$hasError = false;
	$emailSent = false;
	$info = '';
	if(empty($style)) {
		$style = 'normal';
	}
	if(empty($enable_math)) {
		$enable_math = 'true';
	}
	if ( $show_required == 'true' ) {
		$required_string = '<span class="contactRequiredIcon">*</span>';
		if ( 'false' != $require_name ){ 
			$name_required_string = '<span class="contactRequiredIcon">*</span>';
		} else {
			$name_required_string = '';
		}
		if ( 'false' != $require_subject ){ 
			$subject_required_string = '<span class="contactRequiredIcon">*</span>';
		} else {
			$subject_required_string = '';
		}
	} else {
		$required_string = '';
		$name_required_string = '';
		$subject_required_string = '';
	}
	if ( $enable_consent == 'true' ) {
		if ( empty( $label_consent ) ) {
			if ( function_exists( 'the_privacy_policy_link' ) ) {
				$privacy_link = get_the_privacy_policy_link();
			}
			if( ! empty( $privacy_link ) ) {
				$label_consent = sprintf( __('Please check to consent to our %s.', 'ascend'), $privacy_link);
			} else {
				$label_consent = __('Please check to consent to our privacy policy.', 'ascend');
			}
		}
	}
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['as_contact_send']) ) {

		// Sanitize content
		$post_data = array(
			'contactName' => sanitize_text_field($_POST['contactName']),
			'contactEmail' => sanitize_email($_POST['contactEmail']),
			'contactSubject' => sanitize_text_field($_POST['contactSubject']),
			'contactMessage' => wp_kses_post($_POST['contactMessage']),
		);
		if ( $enable_math != 'false' ) {
			$post_data['contactMath'] = absint($_POST['contactMath']);
			$post_data['hacv'] = sanitize_text_field($_POST['hacv']);
			
		}
		if ( $enable_consent == 'true' ) {
			if ( isset( $_POST['contactConsent'] ) ) {
				$post_data['contactConsent'] = sanitize_text_field( $_POST['contactConsent'] );
			} else {
				$post_data['contactConsent'] = '';
			}
		}
		// Validate name
		$value = $post_data['contactName'];
		if ( 'false' != $require_name && strlen($value)<2 ) {
			$error_class['contactName'] = true;
			$haserror = true;
			$result = $message_error;
		}
		$form_data['contactName'] = $value;

		// Validate email
		$value = $post_data['contactEmail'];
		if ( empty($value) ) {
			$error_class['contactEmail'] = true;
			$hasError = true;
			$result = $message_error;
		}
		$form_data['contactEmail'] = $value;

		// Validate subject	
		$value = $post_data['contactSubject'];
		if ( 'false' != $require_subject && strlen($value)<2 ) {
			$error_class['contactSubject'] = true;
			$hasError = true;
			$result = $message_error;
		}
		$form_data['contactSubject'] = $value;

		// Validate message
		$value = $post_data['contactMessage'];
		if ( strlen($value)<10 ) {
			$error_class['contactMessage'] = true;
			$hasError = true;
			$result = $message_error;
		}
		$form_data['contactMessage'] = $value;
		if($enable_math != 'false') {
			// Validate Math
			$value 			= $post_data['contactMath'];
			$math_answer 	= $post_data['hacv'];
			if( $math_answer != md5($value) ) {
				$error_class['contactMath'] = true;
				$hasError = true;
				$result = $message_error;
			}
			$form_data['contactMath'] = $value;
		}
		if ( $enable_consent == 'true' ) {
			// Validate consent
			$value 	= $post_data['contactConsent'];
			if( 'on' != $value ) {
				$error_class['contactConsent'] = true;
				$hasError = true;
				$result = $message_error;
			}
			$form_data['contactConsent'] = $value;
		}

		// Sending message to admin
		if ($hasError == false && $kt_contact_has_run != 'yes') {
			$kt_contact_has_run = 'yes';
			$to = $email_to;
			$subject = "(".get_bloginfo('name').") " . $form_data['contactSubject'];
			$message = $form_data['contactName'] . "\r\n\r\n" . $form_data['contactEmail'] . "\r\n\r\n" . $form_data['contactMessage'] . "\r\n\r\n"; 
			$headers = "Content-Type: text/plain; charset=UTF-8" . "\r\n";
			$headers .= "Content-Transfer-Encoding: 8bit" . "\r\n";
			$headers .= "From: ".$form_data['contactName']." <".$form_data['contactEmail'].">" . "\r\n";
			$headers .= "Reply-To: <".$form_data['contactEmail'].">" . "\r\n";
			wp_mail($to, $subject, $message, $headers);
			$kt_contact_email_created = $message_success;
			$emailSent = true;
		}

	}
	if ( ! empty( $kt_contact_email_created ) ) {
		$info = '<p class="kt-contact-form-info">'.esc_html( $kt_contact_email_created ).'</p>';
	}
	$one = rand(5, 50);
	$two = rand(1, 9);
	$mathresult = md5($one + $two);
	$email_form = '<form class="kt-contact-form kt-formstyle-'.esc_attr($style).'" method="post">';
	$email_form .= '<p>
						<label for="contactName">'.esc_html($label_name).' '. $name_required_string .' <span class="'.(isset($error_class['contactName']) ? "kt-label-error" : "kt-hide").'" >'.esc_html($label_name_error).'</span></label>
						<input type="text" name="contactName" id="contactName" '.(isset($error_class['contactName']) ? ' class="kt-error"' : '').' maxlength="50" value="'.esc_attr($form_data['contactName']).'" />
					</p>';
		
	$email_form .= '<p>
						<label for="contactEmail">'.esc_html($label_email).' '.$required_string .' <span class="'.(isset($error_class['contactEmail']) ? "kt-label-error" : "kt-hide").'" >'.esc_html($label_email_error).'</span></label>
						<input type="text" name="contactEmail" id="contactEmail" '.(isset($error_class['contactEmail']) ? ' class="kt-error"' : '').' maxlength="50" value="'.esc_attr($form_data['contactEmail']).'" />
					</p>';
		
	$email_form .= '<p>
						<label for="contactSubject">'.esc_html($label_subject).' '.$subject_required_string.' <span class="'.(isset($error_class['contactSubject']) ? "kt-label-error" : "kt-hide").'" >'.esc_html($label_subject_error).'</span></label>
						<input type="text" name="contactSubject" id="contactSubject" '.(isset($error_class['contactSubject']) ? ' class="kt-error"' : '').' maxlength="50" value="'.esc_attr($form_data['contactSubject']).'" />
					</p>';
	if ( $style != 'light' && $enable_math != 'false' ) {
		$email_form .= '<p class="cmath-section">
					<label for="contactMath">'.esc_html( $one .' + '. $two .' =').' '.$required_string.' <span class="'.(isset($error_class['contactMath']) ? "kt-label-error" : "kt-hide").'" >'.esc_html($label_math_error).'</span></label>
					<input type="text" name="contactMath" id="contactMath" '.(isset($error_class['contactMath']) ? ' class="kt-error"' : '').' maxlength="50" value="'.esc_attr($form_data['contactMath']).'" />
					<input type="hidden" name="hacv" id="hacv" value="'.esc_attr($mathresult).'" />
				</p>';
	}

		
	$email_form .= '<p>
					<label for="contactMessage">'.esc_html($label_message).' '.$required_string.' <span class="'.(isset($error_class['contactMessage']) ? "kt-label-error" : "kt-hide").'" >'.esc_html($label_message_error).'</span></label>
					<textarea name="contactMessage" id="contactMessage" rows="10" '.(isset($error_class['contactMessage']) ? ' class="kt-error"' : '').'>'.esc_textarea(wp_kses_post($form_data['contactMessage'])).'</textarea>
				</p>';
	if ( $style == 'light' && $enable_math != 'false' ) {
	$email_form .= '<p class="cmath-section">
					<label for="contactMath">'.esc_html( $one .' + '. $two .' =').' '.$required_string.' <span class="'.(isset($error_class['contactMath']) ? "kt-label-error" : "kt-hide").'" >'.esc_html($label_math_error).'</span></label>
					<input type="text" name="contactMath" id="contactMath" '.(isset($error_class['contactMath']) ? ' class="kt-error"' : '').' maxlength="50" value="'.esc_attr($form_data['contactMath']).'" />
					<input type="hidden" name="hacv" id="hacv" value="'.esc_attr($mathresult).'" />
				</p>';
	}
		if ( $enable_consent == 'true' ) {
			$email_form .= '<p>
					<input type="checkbox" name="contactConsent" id="contactConsent" />
					<label for="contactConsent" class="contact_consent_label">'.wp_kses_post($label_consent).' '.$required_string.' <span class="'.(isset($error_class['contactConsent']) ? "kt-label-error" : "kt-hide").'" >'.esc_html($label_consent_error).'</span></label>
				</p>';
		}
	$email_form .= '<p class="csubmit-section">
					<input type="submit" value="'.esc_html($label_submit).'" class="btn" name="as_contact_send" id="as_contact_send" />
				</p>
	</form>';

	if(isset($emailSent) && $emailSent == true) {
		return $info;
	} else {
		return $info . $email_form;
	}
}