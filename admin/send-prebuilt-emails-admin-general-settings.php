<?php
	/**
	* General Settings Page
	*/	
	
	
	
	/**
	 * save form settings
	 */
	 
	// check if submitbutton name is send
	if ( isset( $_POST['sendprebuiltemails_general_submit'] ) && isset( $_POST['send_prebuilt_emails_thinleek_general'] ) ) {
	if( $_POST['sendprebuiltemails_general_submit'] == 'sendprebuiltemails_general_save') {	
	
		// get data from form
		$spm_general_settings_name = 'send_prebuilt_emails_thinleek_general';
		
		$option_key = 'usertab';
		$option_value = isset($_POST[$spm_general_settings_name][$option_key]) ? sanitize_text_field( $_POST[$spm_general_settings_name][$option_key] ) : '';
		
		// allow only one value: checked
		if ( $option_value !== 'checked' ) {
			$option_value = '';
		}
		$value_to_update[$option_key] = $option_value;
		
		$option_key = 'note';
		$option_value = isset($_POST[$spm_general_settings_name][$option_key]) ? sanitize_text_field( $_POST[$spm_general_settings_name][$option_key] ) : '';
		
		// allow only one value: checked
		if ( $option_value !== 'checked' ) {
			$option_value = '';
		}
		$value_to_update[$option_key] = $option_value;
		
		$option_key = 'testaddress';
		$option_value = isset($_POST[$spm_general_settings_name][$option_key]) ? sanitize_email( $_POST[$spm_general_settings_name][$option_key] ) : '';
		
		// allow only valid email addresses
		if ( !is_email( $option_value ) ) {
			$option_value = '';
		}
		
		$value_to_update[$option_key] = $option_value;
	
			
		// update settings
		update_option( $spm_general_settings_name, $value_to_update );
		header('Refresh:0');
	
	} 
	} // END save settings
	else {
 
 
 
	// get settings class
	$name = 'SEND_PREBUILT_EMAILS_VERSION';
	$version = '1.0.0';
	$spm_settings_class = new Send_Prebuilt_Emails_Settings($name,$version);

	$option_name = 'send_prebuilt_emails_thinleek_general';
	$options = get_option( $option_name );

	

	?>		
	<div class="wrap">
		<h2><?php
			echo esc_html__( 'Prebuilt E-Mails settings', 'send-prebuilt-emails' ) ?>
		</h2>
	</div> 
	
	
	<section tabindex="0" role="tabpanel" class="ml-nav-tabs-section wrap">
		<div class="wrap thinleek-setting-wrap" style="max-width:1000px">	

		<form name="sendprebuiltemails_admin_general_settings_form" method="post" action="">
		
			<table class="form-table thinleek-table" role="presentation" style="margin-bottom:0px!important">
	
			<?php
			
			
	/**
	 * option dropdown: general Settings
	 */
	$class = 'general';
	$title = __( 'general settings', 'send-prebuilt-emails' );
	$updown = 'up';
	$border = 'no';
	$spm_settings_class->spm_admin_settings_accordeon($class,$title,$updown,$border);
	
	
	
			
	/**
	 * option field: show User Tab
	 */
	$option_key = 'usertab';
	$option_name_next = $option_name . '[' . $option_key . ']';

	$check_check = '';
	if ( isset($options[$option_key]) && strlen($options[$option_key]) > 0 ) {
		$check_check = 'checked';
	}


	?>
	<tr class="spm_tr_part_general spm-lr-border">
		<th class="thinleek-th-bright"><?php
			echo esc_html__( 'User functionality', 'send-prebuilt-emails' ) ?>
		</th>
		<td><input value="checked" name="<?php echo esc_attr( $option_name_next ) ?>" type="checkbox"<?php echo esc_attr( $check_check ) ?>><?php
			echo esc_html__( 'use Prebuilt E-Mails for Users functionality', 'send-prebuilt-emails' ) ?>
				<span class="thinleek-desc" style="margin-top:10px"><?php 
				echo esc_html__( 'Functionality: send pre-built E-Mails from user edit page and user bulk actions. 
				If checkbox is not selected the functionality including the "Send Prebuilt E-Mails User Tab" of this 
				plugin will disappear.', 'send-prebuilt-emails' ) ?>
				</span>
		</td>
	</tr>
	<?php
	
	
	/**
	 * option field: save order mails in customer notes
	 */
	$option_key = 'note';
	$option_name_next = $option_name . '[' . $option_key . ']';

	$check_check = '';
	if ( isset($options[$option_key]) && strlen($options[$option_key]) > 0 ) {
		$check_check = 'checked';
	}


	?>
	<tr class="spm_tr_part_general spm-lr-border">
		<th class="thinleek-th-bright"><?php
			echo esc_html__( 'Order notes', 'send-prebuilt-emails' ) ?>
		</th>
		<td><input value="checked" name="<?php echo esc_attr( $option_name_next ) ?>" type="checkbox"<?php echo esc_attr( $check_check ) ?>><?php
			echo esc_html__( 'add note to "order notes"', 'send-prebuilt-emails' ) ?>
				<span class="thinleek-desc" style="margin-top:10px"><?php 
				echo esc_html__( 'The order notes are only visible for you. If the checkbox is selected there will be a order note 
				created on sending E-Mails. You can see the note at order edit page.', 'send-prebuilt-emails' ) ?>
				</span>
		</td>
	</tr>
	
	
	
	<?php
	/**
	 * option field: test mail
	 */
	$class = 'testemail';
	$title = __( 'Test E-Mail settings', 'send-prebuilt-emails' );
	$updown = 'up';
	$border = 'top';
	$spm_settings_class->spm_admin_settings_accordeon($class,$title,$updown,$border);
	
	
	?>
	<tr class="spm_tr_part_testemail spm-lr-border">
		<th class="thinleek-th-bright"></th>
		<td class="thinleek-nopadd">
			<span class="thinleek-desc"><?php
			echo esc_html__( 'Define E-Mail address for test E-Mails. You can also change the test E-Mail address before sending a 
			test E-Mail. Default: Your woocommerce from address.', 'send-prebuilt-emails' )?>
			</span>
		</td>
	</tr><?php
	


	/**
	 * default test address
	 */
	$option_key = 'testaddress';

	$option_name_next = $option_name . '[' . $option_key . ']';
	$default_value = get_option( 'woocommerce_email_from_address' );	

	$placeholder_value = isset($options[$option_key]) ? $options[$option_key] : '';

			
	if ( !is_email($placeholder_value) )  {
		$placeholder_value = $default_value;	
	}
			
	if ( !is_email($placeholder_value) )  {
		$placeholder_value = '';	
	}


	?>
	<tr class="spm_tr_part_testemail spm-lr-border">
		<th class="thinleek-th-bright"><?php 
			echo esc_html__( 'Test E-Mail address', 'send-prebuilt-emails' ) ?>
		</th>
		<td>
			<input style="width:100%;max-width:350px" value="<?php echo esc_attr( $placeholder_value ) ?>" name="<?php echo esc_attr( $option_name_next ) ?>" type="text">
			<span class="thinleek-desc"><?php 
				echo esc_html__( 'default:', 'send-prebuilt-emails' ) ?> "<?php echo esc_html( $default_value ) ?>"
			</span>
		</td>
	</tr>




	<tr>
		<th colspan="2" style="border-top: 1px solid #cdcdcd;padding:10px!important;background:none!important;"></th>
	</tr>
	
		
	</table>
	
	
	<input type="hidden" name="sendprebuiltemails_general_submit" value="sendprebuiltemails_general_save">

	<div id="spm_save_and_preview_btn">
		
		<div style="width: fit-content;">
			<input id="sendpbm_admin_adv_settings_save_btn" type="submit" name="quickmals_submit" class="sendpbm_transition_css 
			button button-primary" value="<?php echo esc_html__( 'save settings', 'send-prebuilt-emails' )?>" style="margin-top:20px">

			<div id="sendpbm_admin_adv_settings_save_progress"></div>
			<div id="sendpbm_admin_adv_settings_saved_banner" style="visibility:hidden" class="thinleek-green-notice">
				<div style="padding-left: 8px;">
					<span class="dashicons dashicons-yes" style="vertical-align: middle;padding-right: 2px;"></span><?php
						echo esc_html__( 'saved', 'send-prebuilt-emails' ) ?>
				</div>

			</div>

		</div>



	</div>

	</form>
	
	
	
	
		</div>
	</section>
	<?php
	} // if form not send
		
