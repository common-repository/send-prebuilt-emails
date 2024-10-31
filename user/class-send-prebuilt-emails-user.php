<?php

/**
 *
 * The admin-specific functionality of the plugin for sending mails to users.
 *
 */
 
 
class Send_Prebuilt_Emails_User {

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
	 * add amnin menu
	 */
	public function add_admin_menu() {
			
		add_submenu_page( 
			'prebuilt-emails-orders',
			__( 'User E-Mails', 'send-prebuilt-emails' ),
			__( 'User E-Mails', 'send-prebuilt-emails' ),
			'manage_options',
			'prebuilt-emails-user',
			'spm_user_settings' );
		
		function spm_user_settings(){
		

			if ( isset( $_GET['page'] ) && $_GET['page'] == 'prebuilt-emails-user' ) {
				
				// require file that displays the admin settings page
				require_once plugin_dir_path( __FILE__ ) . 'send-prebuilt-emails-admin-option-page-user.php';
			
			}
			
		
		}
	}
	
	
	
	
	
	// test raus
	public function spm_user_content() {
		
		
		
				?><div class="spm-user-wrap">
					<div class="spm-user-wrap-inner">
						<h2><?php echo esc_html__( 'send Prebuilt E-Mails', 'send-prebuilt-emails' ) ?></h2>
					</div>
				
					<div style="padding: 20px;">
					
						<ul class="order_actions submitbox">
							<li class="wide">
								<select id="sendprebuiltemails_order_edit_select_id" name="wc_order_action" style="width:100%;max-width:100%" onchange="sendprebuiltemails_btn_disabled()">
									<option value="choose"><?php echo esc_html__( 'choose mail template …', 'send-prebuilt-emails' ) ?></option><?php
			
		// get identifiers
		$spm_setup_settings = get_option( 'send_prebuilt_emails_thinleek_setup' );
		$identifier_letters = isset($spm_setup_settings['identifiers']) ? $spm_setup_settings['identifiers'] : array();	
		
		
		$post_user_id = 1;
		if ( isset($_GET['user_id']) && $_GET['user_id'] > 0 ) {
			$post_user_id_find = sanitize_text_field( $_GET['user_id'] );
			if ( $post_user_id_find > 0 ) {
				$post_user_id = $post_user_id_find;
			}
		}
			

		foreach ( $identifier_letters as $single_identifier ) {
			
			
		// use class
		$name = 'SEND_PREBUILT_EMAILS_VERSION';
		$version = '1.0.0';
		$spm_admin_class = new Send_Prebuilt_Emails_Admin($name,$version);
		
		// check if template is valid
		$valid_feedback = $spm_admin_class->spm_is_template_valid($single_identifier,'user');
			
			if ( $valid_feedback == 'valid' ) {
				
				// get template name
				$option_name = 'send_prebuilt_emails_user_thinleek_' . $single_identifier;
				$options = get_option( $option_name );
				$key = 'name';
				
				$template_value = isset($options[$key]) ? $options[$key] : '';

		
				?><option value="<?php echo esc_attr( $single_identifier ) ?>"><?php echo esc_html( stripslashes($template_value) ) ?></option><?php
				
			}
		}
						
						
						?></select>
					</li>
				</ul>
				<ul style="margin-bottom:0px!important;">
					<li class="wide" style="text-align:right">
						<div class="sendpbm_fullscreen_bg" style="display:none"></div>
						<div class="sendpbm_iframe_preview" style="display:none"></div>
						
					<input type="hidden" name="sendprebuiltemails_order_edit_orderid" value="<?php echo esc_attr( $post_user_id ) ?>">				
					<a onclick="sendprebuiltemailsordereditpreview()" id="sendprebuiltemails_order_edit_preview_id" class="disabled button button-secondary" value="preview">
						<?php echo esc_html__( 'preview', 'send-prebuilt-emails' ) ?>
					</a>
					<a onclick="sendprebuiltemails_securemailsend_func()" id="sendprebuiltemails_order_edit_send_id" class="disabled button button-primary" value="send">
						<?php echo esc_html__( 'send', 'send-prebuilt-emails' ) ?>
					</a>
						<div id="sendprebuiltemails_bulkrespond_here_id"></div>
						<div id="sendpbm_mailsend_respond_id"></div>
					</li>
				</ul>
			</div>
		</div><?php
				
					
		
		
		// function to send email via ajax
		
		?>
		<script>
		function sendprebuiltemails_securemailsend_func() {
			
			var sendbtn = document.getElementById("sendprebuiltemails_order_edit_send_id");
			
			var sendbtn_class = sendbtn.className;
			
			if ( sendbtn_class.indexOf("disabled") > -1 ) {
				var notsend = "break";
			}
			else {
				
				
				var success_popup_load = "<div class=\"spm-bg-layer\">";
				var success_popup_load = success_popup_load + "</div><div class=\"s-spm-ajax-wrap-full\"><div class=\"s-spm-ajax-wrap\">";
				var success_popup_load = success_popup_load + "<div class=\"spm-s-sendsuccess\"><div class=\"thinleek-progress\" style=\"margin-bottom:-4px;\">";
				var success_popup_load = success_popup_load + "<div class=\"thinleek-indeterminate\"></div></div><div style=\"padding:20px\">";
				var success_popup_load = success_popup_load + "<div class=\"spm-s-sendsuccess-flex\"><div class=\"spm-success-icon\">";
				var success_popup_load = success_popup_load + "<span class=\"dashicons dashicons-airplane\"></span></div><p id=\"sendprebuiltemails-success-txt-id\">";
				var success_popup_load = success_popup_load + "<b><?php echo esc_html__( 'sending', 'send-prebuilt-emails' ) ?>...</b><br><span style=\"visibility:hidden\"> 1 von 1 E-Mail erfolgreich versendet.<br>";
				var success_popup_load = success_popup_load + "</span><span style=\"visibility:hidden\" class=\"thinleek-desc-bright\">Prebuilt E-Mail</span></p>";
				var success_popup_load = success_popup_load + "</div><div style=\"visibility:hidden\" class=\"spm-s-sendsuccess_footer\">";
				var success_popup_load = success_popup_load + "<a onclick=\"sendpbm_close_popup()\" class=\"button button-primary\">OKAY</a>";
				var success_popup_load = success_popup_load + "</div></div></div></div></div>";
			
				var identifier = document.getElementById("sendprebuiltemails_order_edit_select_id").value;		
				var user_id = <?php echo esc_attr( $post_user_id ) ?>;	
			
				var ausgabe_div = document.getElementById("sendprebuiltemails_bulkrespond_here_id");
				ausgabe_div.innerHTML = success_popup_load;



				var type = "user";
				
				var data = {
					'action': 'sendprebuiltemails_secure_sendmail_action',
					'identifier': identifier,
					'order_ids': user_id,
					'type': type,
					'nonce': spm_ajax_object.spm_ajax_nonce,
				};

			
				jQuery.post("<?php echo esc_url( admin_url('admin-ajax.php') ) ?>", data, function(response) {
					
					var split_response = response.split("_spmexplodespm_");
					ausgabe_div.innerHTML = split_response[0];	
					
				});
				
			
			}
		}
		</script>
		<?php
		
		
		
		$prev_nonce = wp_create_nonce( 'spm_preview_nonce' );
		// function to preview email via ajax
		
		?>
		<script>
		function sendprebuiltemailsordereditpreview(){
				   
			var previewbtn = document.getElementById("sendprebuiltemails_order_edit_preview_id");	
			var previewbtn_class = previewbtn.className;
			
			if ( previewbtn_class.indexOf("disabled") > -1 ) {
				var notsend = "break";
			}
			else {
				
				var identifier = document.getElementById("sendprebuiltemails_order_edit_select_id").value;		
				var user_id = <?php echo esc_attr( $post_user_id ) ?>;	
				var prev= "orderedit";
				
				var ausgabe_div = document.getElementById("sendprebuiltemails_bulkrespond_here_id");
					
				var html_content = "<div style=\"position: fixed;left: 0px;right: 0px;top: 0px;bottom: 0px;z-index: 9999;background: #000;opacity: 0.7;\">";
				var html_content = html_content + "</div><div class=\"spm-ajax-wrap-full\"><div class=\"spm-ajax-wrap\">";
				var html_content = html_content + "<div class=\"sendpbm_ajax_ausgabe_inner\"><div class=\"spm-ajax-header\">";
				var html_content = html_content + "<div class=\"spm-head-txt\">E-Mail Vorschau</div>";
				var html_content = html_content + "<span onclick=\"sendpbm_close_popup()\" class=\"dashicons dashicons-no-alt spm-close-icon\">";
				var html_content = html_content + "</span></div><div class=\"spm-ajax-body\"><div id=\"sendprebuiltemails-loading-screen\">";
				var html_content = html_content + "<div class=\"thinleek-progress\"><div class=\"thinleek-indeterminate\"></div></div>";
				var html_content = html_content + "<p style=\"text-align:left\"><?php echo esc_html__( 'loading...', 'send-prebuilt-emails' ) ?></p></div>";
				var html_content = html_content + "<div style=\"height:100%;width:100%\"id=\"sendprebuiltemails_iframe_id_div\"></div>";
				var html_content = html_content + "</div></div><div class=\"spm-ajax-footer\">";
				var html_content = html_content + "<a onclick=\"sendpbm_close_popup()\" class=\"button-secondary button\">";
				var html_content = html_content + "<?php echo esc_html__( 'close', 'send-prebuilt-emails' ) ?></a><a style=\"margin-left:10px\" onclick=\"sendprebuiltemails_securemailsend_func()\" class=\"button-primary button\">";
				var html_content = html_content + "<?php echo esc_html__( 'send E-Mail', 'send-prebuilt-emails' ) ?></a></div></div>";
			
				ausgabe_div.innerHTML = html_content;
			}
			
			var data = {
					'action': 'sendprebuiltemails_preview_action',
					'identifier': identifier,
					'order': user_id,
					'prev': prev,
					'nonce': spm_ajax_object.spm_ajax_nonce,
				};
				
				
			jQuery.post("<?php echo esc_url( admin_url('admin-ajax.php') ) ?>", data, function(response) {
			
				document.getElementById("sendprebuiltemails_iframe_id_div").innerHTML = response;
				document.getElementById("sendprebuiltemails_iframe_id_div").style.overflowY = "scroll";
				document.getElementById("sendprebuiltemails-loading-screen").style.display = "none";

            
			});
		
			
		}
		</script>
		
		<?php
		// function to send email via ajax
		?>	
		
		<script>
		function sendpbm_close_popup() {
			var mailsend_res_div = document.getElementById("sendpbm_mailsend_respond_id");	
			mailsend_res_div.innerHTML = "<span style=\"display:none!important\">sendprebuiltemails closed</span>";

			var ausgabe_div = document.getElementById("sendprebuiltemails_bulkrespond_here_id");
			ausgabe_div.innerHTML = "<span style=\"display:none!important\">sendpbm closed</span>";	
		}
		</script>

		<?php
		// function to close layer
		?>
		
		<script>
		function sendpbm_close_popup_unselect() {
		
			document.getElementById("sendprebuiltemails_order_edit_select_id").value = "choose";

			var mailsend_res_div = document.getElementById("sendpbm_mailsend_respond_id");	
			mailsend_res_div.innerHTML = "<span style=\"display:none!important\">sendprebuiltemails closed</span>";

			var ausgabe_div = document.getElementById("sendprebuiltemails_bulkrespond_here_id");
			ausgabe_div.innerHTML = "<span style=\"display:none!important\">sendpbm closed</span>";	

			sendprebuiltemails_btn_disabled();
		}
		</script>

		<?php
		// function to disable preview and send button if no template selected
		?>
		
		<script>
		function sendprebuiltemails_btn_disabled() {
			var previewbtn = document.getElementById("sendprebuiltemails_order_edit_preview_id");
			var sendbtn = document.getElementById("sendprebuiltemails_order_edit_send_id");
			
			var select = document.getElementById("sendprebuiltemails_order_edit_select_id");	
			var selectvalue = select.value;
		
			if ( selectvalue.length > 0 && selectvalue !== "choose"  ) {
				previewbtn.classList.remove("disabled");	
				sendbtn.classList.remove("disabled");	
			}
			else {
				previewbtn.classList.add("disabled");	
				sendbtn.classList.add("disabled");	
			}
		}
		</script>
		
		<?php
		
		
		
	}


	
	
	/**
	 * Add action to bulk actions
	 */
	public function spm_add_order_bulk_actions_user( $actions ) {

		$nav = 'user';
		
		// get settings
		$spm_advanced_settings = get_option( 'send_prebuilt_emails_user_thinleek_advanced' );
		$spm_setup_settings = get_option( 'send_prebuilt_emails_thinleek_setup' );
		$all_identifiers = isset($spm_setup_settings['identifiers']) ? $spm_setup_settings['identifiers'] : array();	

		
		
		// use class
		$name = 'SEND_PREBUILT_EMAILS_VERSION';
		$version = '1.0.0';
		$spm_admin_class = new Send_Prebuilt_Emails_Admin($name,$version);
		
		
		foreach ( $all_identifiers as $identifier ) {
			
			
			// get all options for this template	
			$option_name = 'send_prebuilt_emails_user_thinleek_' . $identifier;
			$options = get_option( $option_name );
		
		
			// get template name
			$option_key = 'name';
			$template_name = isset($options[$option_key]) ? $options[$option_key] : '';
			
			if ( strlen($template_name) < 1 ) {
				continue;
			}
			
			// check if template is valid to make sure its a great e-mail
			$template_valid = $spm_admin_class->spm_is_template_valid($identifier,$nav);
			
			if ( $template_valid !== 'valid' ) {
				continue;
			}
					
		
				
			// check if user selected it for bulk actions
			$is_bulk = isset($spm_advanced_settings['bulk'][$identifier]) ? $spm_advanced_settings['bulk'][$identifier] : '';


			// add it to order bulk actions
			if ( $is_bulk == 'checked' ) {
				$actions['sendprebuiltemails_' . $identifier] = __( 'send Prebuilt E-Mail', 'send-prebuilt-emails' ) . ' "' . stripslashes($template_name) . '"';
			}
		
		}
		
		return $actions;
	}



	



} // class END