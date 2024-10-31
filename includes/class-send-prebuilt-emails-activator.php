<?php

/**
 * Fired during plugin activation
 *
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 */
class Send_Prebuilt_Emails_Activator {

	/**
	 * set up options necessary for functionality of this plugin to wp_options
	 */
	public static function activate() {


		// get advanced options for isset checks
		$get_advanced_options = get_option( 'send_prebuilt_emails_thinleek_advanced' );
		
		// get advanced options for isset checks
		$get_advanced_user_options = get_option( 'send_prebuilt_emails_user_thinleek_advanced' );
		

		// get general options for isset checks
		$get_general_options = get_option( 'send_prebuilt_emails_thinleek_general' );



		/**
		 * Set Up Plugin Version
		 */
		 
		update_option( 'send_prebuilt_emails_thinleek_version', '1.0.0' );
		
		
		/**
		 * Set Up General Options
		 */
	
		if ( !isset( $get_general_options['usertab'] ) ) {
			$general_options['usertab'] = 'checked';
		}
		
		if ( !isset( $get_general_options['note'] ) ) {
			$general_options['note'] = 'checked';
		}
		  
		if ( !isset( $get_general_options['testaddress'] ) ) {
		
		// default e-mail addres	
		$default_wc_address = get_option( 'woocommerce_email_from_address' );

			if ( isset($default_wc_address) )  {
				if ( is_email($default_wc_address) ) {
					$default_testemail_address = $default_wc_address;
				}	
				else {
					$default_testemail_address = get_option( 'admin_email' );	
				}
			}
			else {
				$default_testemail_address = get_option( 'admin_email' );
			}
		$general_options['testaddress'] = $default_testemail_address;
		}
		 
		update_option( 'send_prebuilt_emails_thinleek_general', $general_options );



		/*
		 * Set Up Identifiers (5 in Free Version)
		 */
		$setup_identifiers[] = 'a';
		$setup_identifiers[] = 'b';
		$setup_identifiers[] = 'c';
		$setup_identifiers[] = 'd';
		$setup_identifiers[] = 'e';
			
		
		$setup_values['identifiers'] = $setup_identifiers;
		
		
		
			
		/*
		 * Set Up Placeholder
		 */
		$setup_placeholder[] = 'order-number';
		$setup_placeholder[] = 'billing-first_name';
		$setup_placeholder[] = 'billing-last_name';
		$setup_placeholder[] = 'order-date_created';
		$setup_placeholder[] = 'order-date_completed';
		$setup_placeholder[] = 'order-customer_id';
		$setup_placeholder[] = 'order-total';
		$setup_placeholder[] = 'order-status';
		$setup_placeholder[] = 'order-payment_method';
		$setup_placeholder[] = 'custom_a';
		$setup_placeholder[] = 'custom_b';
		$setup_placeholder[] = 'custom_c';
		$setup_placeholder[] = 'custom_d';
		$setup_placeholder[] = 'custom_e';
		$setup_placeholder[] = 'acf_a';
		$setup_placeholder[] = 'acf_b';
		$setup_placeholder[] = 'acf_c';
		$setup_placeholder[] = 'acf_d';
		$setup_placeholder[] = 'acf_e';
		$setup_placeholder[] = 'user-first_name';
		$setup_placeholder[] = 'user-last_name';
		$setup_placeholder[] = 'user-_order_count';
		$setup_placeholder[] = 'user-_last_order';
		$setup_placeholder[] = 'shipping-postcode';
		$setup_placeholder[] = 'shipping-country';
		$setup_placeholder[] = 'shipping-first_name';
		$setup_placeholder[] = 'shipping-last_name';
		$setup_placeholder[] = 'shipping-company';
		$setup_placeholder[] = 'shipping-address_1';
		$setup_placeholder[] = 'shipping-address_2';
		$setup_placeholder[] = 'shipping-city';
		$setup_placeholder[] = 'billing-postcode';
		$setup_placeholder[] = 'billing-country';
		$setup_placeholder[] = 'billing-email';
		$setup_placeholder[] = 'billing-phone';
		$setup_placeholder[] = 'billing-company';
		$setup_placeholder[] = 'billing-address_1';
		$setup_placeholder[] = 'billing-address_2';
		$setup_placeholder[] = 'billing-city';
		$setup_placeholder[] = 'order-id';
		$setup_placeholder[] = 'order-shipping_total';
		$setup_placeholder[] = 'order-date_paid';
		$setup_placeholder[] = 'order-order_discount_total';
		$setup_placeholder[] = 'orderpayment_method_titletotal';

		$setup_values['placeholder'] = $setup_placeholder;

		// update setup values in wp options
		update_option( 'send_prebuilt_emails_thinleek_setup', $setup_values );
		
		
		
		
		/*
		 * Bulk Actions checked for all identifiers
		 */
		 
		foreach ( $setup_identifiers as $single_identifier ) {
			$option_key = 'bulk';
			$key_two = $single_identifier;
			
			$advanced_values[$option_key][$key_two] = 'checked';		
		}
		$advanced_values[$option_key]['plain'] = 'checked';
		 


		
		/*
		 * Default checked Placeholder
		 */  
		 if ( !isset( $get_advanced_options['placeholder'] ) ) {
		
		// setup default checked placeholder
		$checked_placeholder[] = 'order-number';
		$checked_placeholder[] = 'billing-first_name';
		$checked_placeholder[] = 'billing-last_name';
		$checked_placeholder[] = 'order-date_created';
		$checked_placeholder[] = 'order-date_completed';
		$checked_placeholder[] = 'order-customer_id';
		$checked_placeholder[] = 'order-total';
		$checked_placeholder[] = 'order-status';
		$checked_placeholder[] = 'order-payment_method';
		
		foreach ( $checked_placeholder as $checked ) {
				$advanced_values['placeholder'][$checked] = $checked;
		}

		
		// update setup values in wp options
		update_option( 'send_prebuilt_emails_thinleek_advanced', $advanced_values );
		
		 }
		
			
		
		
		
		/*
		 * Example E-Mail for orders
		 */
  
		// check if mail templates exist
		$setup_exist = 'no';
		foreach ( $setup_identifiers as $single_identifier ) {
			$option_name = 'send_prebuilt_emails_thinleek_' . $single_identifier;
			$get_identifier_value = get_option( $option_name );
				if ( isset($get_identifier_value) && strlen($get_identifier_value) > 0 ) {
						$setup_exist = 'yes';
				}
		}
		
		
		// setup example prebuilt e-mail
		if ( $setup_exist == 'no' ) {
			
			$blog_name = get_option( 'blogname' );
				if ( !isset($blog_name) ) {
					$blog_name = 'us';
				}
				
			$example_mail['name'] = __( 'Example Leave Review', 'send-prebuilt-emails' );
			$example_mail['subject'] = __( 'Did you enjoy ', 'send-prebuilt-emails' );
			$example_mail['subject'].= esc_attr( $blog_name ) . '?';
			$example_mail['heading'] = __( 'Please leave a review', 'send-prebuilt-emails' );
			$example_mail['content'] = __( 'Hi {billing-first_name} {billing-last_name},

Positive reviews from awesome customers like you help others to feel confident about choosing ', 'send-prebuilt-emails' ) . $blog_name . ' ';
			$example_mail['content'].= __( 'too. Could you take 60 seconds to go to [link to review platform] and share your happy experiences?
			
We will be forever grateful.', 'send-prebuilt-emails' );
			$example_mail['from_name'] = '';
			$example_mail['from_email'] = '';
			$example_mail['to_email'] = '';
			$example_mail['reply_to_name'] = '';
			$example_mail['reply_to_email'] = '';
			$example_mail['cc'] = '';
			$example_mail['bcc'] = '';
			$example_mail['orderdetails'] = 'orderdetails';
			$example_mail['footer'] = 'footer';
			$example_mail['contenttwo'] = __( 'Thank you in advance for helping us out!', 'send-prebuilt-emails' );

			// update setup version in wp options
			update_option( 'send_prebuilt_emails_thinleek_a', $example_mail );
		
		}
		
		
		
		
		/*
		 * Example E-Mail for orders
		 */
  
		// check if mail templates exist
		$setup_exist = 'no';
		foreach ( $setup_identifiers as $single_identifier ) {
			
			$option_name = 'send_prebuilt_emails_user_thinleek_' . $single_identifier;
			$get_identifier_value = get_option( $option_name );
			
				if ( isset($get_identifier_value) && strlen($get_identifier_value) > 0 ) {
						$setup_exist = 'yes';
				}
		}
		
		
		// setup example prebuilt e-mail
		if ( $setup_exist == 'no' ) {
			
			$blog_name = get_option( 'blogname' );
				if ( !isset($blog_name) ) {
					$blog_name = 'our shop';
				}
				
			$example_mail['name'] = __( 'Example Reseller Approved', 'send-prebuilt-emails' );
			$example_mail['subject'] = __( 'You are now reseller', 'send-prebuilt-emails' ) . ' ';
			$example_mail['subject'].= __( 'at', 'send-prebuilt-emails' ) . ' ' . esc_attr( $blog_name ) . '!';
			$example_mail['heading'] = __( 'Start reselling!', 'send-prebuilt-emails' );
		$example_mail['content'] = __( 'Hi {user-first_name},

we are glad to say that you are approved as reseller. See all information <a href="">here</a>.

Best regards', 'send-prebuilt-emails');
			$example_mail['from_name'] = '';
			$example_mail['from_email'] = '';
			$example_mail['to_email'] = '';
			$example_mail['reply_to_name'] = '';
			$example_mail['reply_to_email'] = '';
			$example_mail['cc'] = '';
			$example_mail['bcc'] = '';
			$example_mail['footer'] = 'footer';

			// update setup version in wp options
			update_option( 'send_prebuilt_emails_user_thinleek_a', $example_mail );
		
		}
		
		
		
		/*
		 * Bulk Actions checked for all identifiers
		 */
		 
		foreach ( $setup_identifiers as $single_identifier ) {
			$option_key = 'bulk';
			$key_two = $single_identifier;
			
			$advanced_user_values[$option_key][$key_two] = 'checked';		
		}
		 


		
		/*
		 * Default checked Placeholder
		 */  
		 if ( !isset( $get_advanced_user_options['placeholder'] ) ) {
		
		// setup default checked placeholder
		$checked_placeholder_users[] = 'userid';
		$checked_placeholder_users[] = 'user-first_name';
		$checked_placeholder_users[] = 'user-last_name';
		$checked_placeholder_users[] = 'user-_order_count';
		$checked_placeholder_users[] = 'today';
		$checked_placeholder_users[] = 'tomorrow';
		$checked_placeholder_users[] = 'in_7_days';
		
		foreach ( $checked_placeholder_users as $checked ) {
				$advanced_user_values['placeholder'][$checked] = $checked;
		}

		
		// update setup values in wp options
		update_option( 'send_prebuilt_emails_user_thinleek_advanced', $advanced_user_values );
		
		 }
		 


	}

}
