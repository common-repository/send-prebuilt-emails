<?php
/**
 *
 * The admin-specific functionality of the plugin.
 *
 */
 
 
class Send_Prebuilt_Emails_Plain {

	/** The ID of this plugin */
	private $send_prebuilt_emails;

	/**  The version of this plugin */
	private $version;
	
	
	/** Initialize the class and set its properties. */
	public function __construct( $send_prebuilt_emails, $version ) {
		
		$this->send_prebuilt_emails = $send_prebuilt_emails;
		$this->version = $version;

	}
	
	
	
	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->send_prebuilt_emails . '_plain', plugin_dir_url( __FILE__ ) . 'css/send-prebuilt-emails-plain.css', array(), $this->version, 'all' );

	}
	
	
	/**
	 * Register the JavaScript for the admin area
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->send_prebuilt_emails . '_plain', plugin_dir_url( __FILE__ ) . 'js/send-prebuilt-emails-plain.js', array( 'jquery' ), $this->version, false );
		wp_register_script( $this->send_prebuilt_emails . '_plain', plugin_dir_url( __FILE__ ) . 'js/send-prebuilt-emails-plain.js', array( 'jquery' ), false );
			
	}
	
	
	
	

	/**
	 * action to show all placeholder
	 */
	 
	public function sendprebuiltemails_allplaceholder_action_plain() {
		
	// get placeholder from wp options
	$spm_advanced_settings_adv = get_option( 'send_prebuilt_emails_thinleek_setup' );
	
	if ( isset( $spm_advanced_settings_adv['placeholder'] ) ) {
		$placeholders = $spm_advanced_settings_adv['placeholder'];
	}
	else {
		$placeholders[] = 'order-number';
		$placeholders[] = 'billing-first_name';
		$placeholders[] = 'billing-last_name';
	}
	
	// get advanced settings
	$advanced_setting = get_option('send_prebuilt_emails_thinleek_advanced');
	
	if ( isset( $advanced_setting['placeholder'] ) ) {
		$advanced_setting_custom_placeholder = $advanced_setting['placeholder'];
	}
	else {
		$advanced_setting_custom_placeholder[] = 'order-number';
		$advanced_setting_custom_placeholder[] = 'billing-first_name';
		$advanced_setting_custom_placeholder[] = 'billing-last_name';
	}
	
	
	// add five possible custom placeholder if set up by user
	$five_custom = array( 'custom_a', 'custom_b', 'custom_c', 'custom_d', 'custom_e' );
	$placeholders = array_diff($placeholders, $five_custom);
	
	foreach ( $five_custom as $letter ) {
		if ( isset($advanced_setting_custom_placeholder[$letter]) && strlen($advanced_setting_custom_placeholder[$letter]) > 0 ) {
			$placeholders[] = $advanced_setting_custom_placeholder[$letter];
		}
	}
	
	
	// add five possible acf placeholder if set up by user
	$five_acf = array( 'acf_a', 'acf_b', 'acf_c', 'acf_d', 'acf_e' );
	$placeholders = array_diff($placeholders, $five_acf);
	
	foreach ( $five_acf as $letter ) {
		if ( isset($advanced_setting_custom_placeholder[$letter]) && strlen($advanced_setting_custom_placeholder[$letter]) > 0 ) {
			$placeholders[] = $advanced_setting_custom_placeholder[$letter];
		}
	}
	
	$placeholders = array_unique($placeholders);
	foreach ( $placeholders as $place ) {
		if ( isset($place) && strlen($place) > 0 ) {
			?><input value="{<?php echo esc_attr( $place ) ?>}" onclick="sendprebuiltemails_copy(this)" type="text" class="ed_button button button-small spm-placeholder"><?php
		}
	}
			?><a onclick="spm_run_allplaces_less()" class="spm-plain-allplaces"><?php
				echo esc_html__( 'hide placeholders', 'send-prebuilt-emails' ) ?>
			</a><?php
	
	wp_die();
	
	}
	
	
	
	
	/**
	 * Add bulk action to order list
	 */
	public function spm_add_order_bulk_actions_plain( $actions ) {
		
		// get settings
		$spm_advanced_settings = get_option( 'send_prebuilt_emails_thinleek_advanced' );

		// check if user selected it for bulk actions
		$is_bulk = isset($spm_advanced_settings['bulk']['plain']) ? $spm_advanced_settings['bulk']['plain'] : '';

		// add it to order bulk actions
		if ( $is_bulk == 'checked' ) {
			$actions['sendprebuiltemails_plain'] = __( 'write "blank" Prebuilt E-Mail', 'send-prebuilt-emails' );
		}

		return $actions;
	}



} // class END