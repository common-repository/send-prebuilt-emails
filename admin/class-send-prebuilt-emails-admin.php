<?php

/**
 *
 * The admin-specific functionality of the plugin.
 *
 */
class Send_Prebuilt_Emails_Admin
{
    /** The ID of this plugin */
    private  $send_prebuilt_emails ;
    /**  The version of this plugin */
    private  $version ;
    /** Initialize the class and set its properties. */
    public function __construct( $send_prebuilt_emails, $version )
    {
        $this->send_prebuilt_emails = $send_prebuilt_emails;
        $this->version = $version;
    }
    
    /**
     * Register the stylesheets for the admin area.
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->send_prebuilt_emails,
            plugin_dir_url( __FILE__ ) . 'css/send-prebuilt-emails-admin.css',
            array(),
            $this->version,
            'all'
        );
    }
    
    /**
     * Register the JavaScript for the admin area including spm_ajax_url and spm_ajax_nonce
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            $this->send_prebuilt_emails,
            plugin_dir_url( __FILE__ ) . 'js/send-prebuilt-emails-admin.js',
            array( 'jquery' ),
            $this->version,
            false
        );
        wp_register_script(
            $this->send_prebuilt_emails,
            plugin_dir_url( __FILE__ ) . 'js/send-prebuilt-emails-admin.js',
            array( 'jquery' ),
            $this->version,
            false
        );
        wp_localize_script( $this->send_prebuilt_emails, 'spm_ajax_object', array(
            'spm_ajax_url'   => admin_url( 'admin-ajax.php' ),
            'spm_ajax_nonce' => wp_create_nonce( 'secure_send_prebuilt_emails' ),
        ) );
        wp_localize_script( $this->send_prebuilt_emails, 'spm_lang_object', array(
            'spm_close'         => __( 'close', 'send-prebuilt-emails' ),
            'spm_closeprev'     => __( 'close preview', 'send-prebuilt-emails' ),
            'spm_preview'       => __( 'preview', 'send-prebuilt-emails' ),
            'spm_subject'       => __( 'Subject', 'send-prebuilt-emails' ),
            'spm_heading'       => __( 'Heading', 'send-prebuilt-emails' ),
            'spm_content'       => __( 'Content', 'send-prebuilt-emails' ),
            'spm_orderdetails'  => __( 'show orderdetails in E-Mail', 'send-prebuilt-emails' ),
            'spm_address'       => __( 'show customer addresses in E-Mail', 'send-prebuilt-emails' ),
            'spm_additional'    => __( 'Additional content', 'send-prebuilt-emails' ),
            'spm_footer'        => __( 'show woocommerce footer in E-Mail', 'send-prebuilt-emails' ),
            'spm_attachment'    => __( 'Attachment', 'send-prebuilt-emails' ),
            'spm_fromto'        => __( 'E-Mail "from" and "to" settings (optional)', 'send-prebuilt-emails' ),
            'spm_from_name'     => __( '"From" Name', 'send-prebuilt-emails' ),
            'spm_from_mail'     => __( '"From" E-Mail', 'send-prebuilt-emails' ),
            'spm_to'            => __( '"To" E-Mail', 'send-prebuilt-emails' ),
            'spm_replyto_name'  => __( '"Reply to" Name', 'send-prebuilt-emails' ),
            'spm_replyto_mail'  => __( '"Reply to" E-Mail', 'send-prebuilt-emails' ),
            'spm_blank'         => __( 'Blank E-Mail', 'send-prebuilt-emails' ),
            'spm_placeholder'   => __( 'Placeholder', 'send-prebuilt-emails' ),
            'spm_placecopied'   => __( 'Placeholder copied.', 'send-prebuilt-emails' ),
            'spm_allplace'      => __( 'all placeholder', 'send-prebuilt-emails' ),
            'spm_sending'       => __( 'sending...', 'send-prebuilt-emails' ),
            'spm_loading'       => __( 'loading...', 'send-prebuilt-emails' ),
            'spm_prevorder'     => __( 'E-Mail preview for order', 'send-prebuilt-emails' ),
            'spm_prevuser'      => __( 'E-Mail preview for user', 'send-prebuilt-emails' ),
            'spm_sendmail'      => __( 'send E-Mail', 'send-prebuilt-emails' ),
            'spm_sendplural'    => __( 'send ordercount E-Mails', 'send-prebuilt-emails' ),
            'spm_sendsing'      => __( 'send ordercount E-Mail', 'send-prebuilt-emails' ),
            'spm_sure'          => __( 'Are you sure you want to delete the template "changetemplatename"?', 'send-prebuilt-emails' ),
            'spm_deleting'      => __( 'deleting...', 'send-prebuilt-emails' ),
            'spm_delete'        => __( 'delete', 'send-prebuilt-emails' ),
            'spm_areyousure'    => __( 'Send ordercount E-Mail?', 'send-prebuilt-emails' ),
            'spm_areyousures'   => __( 'Send ordercount E-Mails?', 'send-prebuilt-emails' ),
            'spm_send'          => __( 'send', 'send-prebuilt-emails' ),
            'spm_cancel'        => __( 'cancel', 'send-prebuilt-emails' ),
            'spm_maxallowed'    => __( 'Max. 10 E-Mails allowed in free version!', 'send-prebuilt-emails' ),
            'spm_pleaseupgrade' => __( 'Please Upgrade Send Prebuilt E-Mails to send unlimited E-Mails.', 'send-prebuilt-emails' ),
        ) );
    }
    
    /**
     * add custom column to admin order page
     */
    public function spm_add_prebuiltemails_column( $columns )
    {
        $columns['sendprebuiltemails_column_log_id'] = __( 'last Prebuilt E-Mail', 'send-prebuilt-emails' );
        return $columns;
    }
    
    /**
     * display content in admin order page column
     */
    public function spm_add_prebuiltemails_column_func( $column )
    {
        
        if ( $column == 'sendprebuiltemails_column_log_id' ) {
            global  $post ;
            
            if ( isset( $post ) ) {
                $order_id = $post->ID;
                $get_order_meta = get_post_meta( $order_id, 'send_prebuilt_emails', true );
                
                if ( isset( $get_order_meta ) && strlen( $get_order_meta ) > 0 ) {
                    $explode_comments = explode( ',', $get_order_meta );
                    $explode_comments = array_reverse( $explode_comments );
                    $counter = 0;
                    foreach ( $explode_comments as $comment ) {
                        $counter++;
                        if ( isset( $comment ) && strlen( $comment ) > 0 ) {
                            
                            if ( $counter < 2 ) {
                                echo  esc_attr( $comment ) ;
                                ?><br><?php 
                            } else {
                                break;
                            }
                        
                        }
                    }
                }
            
            }
        
        }
    
    }
    
    /**
     * search custom column
     */
    public function spm_add_prebuiltemails_column_serach( $search_fields )
    {
        $search_fields[] = 'send_prebuilt_emails';
        return $search_fields;
    }
    
    /**
     * add amnin menu
     */
    public function add_admin_menu()
    {
        add_menu_page(
            __( 'Prebuilt E-Mails', 'send-prebuilt-emails' ),
            __( 'Prebuilt E-Mails', 'send-prebuilt-emails' ),
            'manage_options',
            'prebuilt-emails-orders',
            'spm_admin_settings',
            'dashicons-email-alt'
        );
        add_submenu_page(
            'prebuilt-emails-orders',
            __( 'Order E-Mails', 'send-prebuilt-emails' ),
            __( 'Order E-Mails', 'send-prebuilt-emails' ),
            'manage_options',
            'prebuilt-emails-orders',
            'spm_admin_settings'
        );
        function spm_admin_settings()
        {
            // only include admin option functionality if page is relevant
            if ( isset( $_GET['page'] ) && $_GET['page'] == 'prebuilt-emails-orders' ) {
                // require file that displays the admin settings page
                require_once plugin_dir_path( __FILE__ ) . 'send-prebuilt-emails-admin-option-page.php';
            }
        }
    
    }
    
    /**
     * add amnin menu general settings
     */
    public function add_admin_menu_general_settings()
    {
        add_submenu_page(
            'prebuilt-emails-orders',
            __( 'Settings', 'send-prebuilt-emails' ),
            __( 'Settings', 'send-prebuilt-emails' ),
            'manage_options',
            'prebuilt-emails-settings',
            'spm_admin_general_settings'
        );
        function spm_admin_general_settings()
        {
            if ( isset( $_GET['page'] ) && $_GET['page'] == 'prebuilt-emails-settings' ) {
                // require file that displays the admin settings page
                require_once plugin_dir_path( __FILE__ ) . 'send-prebuilt-emails-admin-general-settings.php';
            }
        }
    
    }
    
    /**
     * add amnin menu help
     */
    public function add_admin_menu_help()
    {
        add_submenu_page(
            'prebuilt-emails-orders',
            __( 'Help', 'send-prebuilt-emails' ),
            __( 'Help', 'send-prebuilt-emails' ),
            'manage_options',
            'prebuilt-emails-help',
            'spm_admin_help'
        );
        function spm_admin_help()
        {
            if ( isset( $_GET['page'] ) && $_GET['page'] == 'prebuilt-emails-help' ) {
                // require file that displays the admin settings page
                require_once plugin_dir_path( __FILE__ ) . 'send-prebuilt-emails-admin-help.php';
            }
        }
    
    }
    
    /**
     * add meta box to order edit page
     */
    public function spm_add_metabox_to_orderedit()
    {
        global  $post ;
        add_meta_box(
            'sendprebuiltemails-box',
            __( 'send Prebuilt E-Mail', 'send-prebuilt-emails' ),
            'spm_run_metabox_func',
            'shop_order',
            'side'
        );
        function spm_run_metabox_func()
        {
            $name = 'SEND_PREBUILT_EMAILS_VERSION';
            $version = '1.0.0';
            $spm_admin_class = new Send_Prebuilt_Emails_Admin( $name, $version );
            echo  wp_kses_post( $spm_admin_class->spm_metabox_content() ) ;
        }
    
    }
    
    /**
     * content in order edit meta box
     */
    public function spm_metabox_content()
    {
        global  $post ;
        $post_order_id = $post->ID;
        $post_order = wc_get_order( $post_order_id );
        // get the class
        $name = 'SEND_PREBUILT_EMAILS_VERSION';
        $version = '1.0.0';
        $spm_admin_class = new Send_Prebuilt_Emails_Admin( $name, $version );
        ?><ul class="order_actions submitbox">
					<li class="wide">
						<select id="sendprebuiltemails_order_edit_select_id" name="wc_order_action" style="width:100%;" onchange="sendprebuiltemails_btn_disabled()">
							<option value="choose"><?php 
        echo  esc_html__( 'choose E-Mail …', 'send-prebuilt-emails' ) ;
        ?></option><?php 
        // get identifiers
        $spm_setup_settings = get_option( 'send_prebuilt_emails_thinleek_setup' );
        $identifier_letters = ( isset( $spm_setup_settings['identifiers'] ) ? $spm_setup_settings['identifiers'] : array() );
        foreach ( $identifier_letters as $single_identifier ) {
            // check if template is valid
            $nav = '';
            $valid_feedback = $spm_admin_class->spm_is_template_valid( $single_identifier, $nav );
            
            if ( $valid_feedback == 'valid' ) {
                // get template name
                $option_name = 'send_prebuilt_emails_thinleek_' . $single_identifier;
                $options = get_option( $option_name );
                $key = 'name';
                $template_value = ( isset( $options[$key] ) ? $options[$key] : '' );
                ?><option value="<?php 
                echo  esc_attr( $single_identifier ) ;
                ?>"><?php 
                echo  esc_html( stripslashes( $template_value ) ) ;
                ?></option><?php 
            }
        
        }
        ?></select>
					</li>
				</ul>
				<ul style="margin-bottom:0px!important;">
					<li class="wide" style="text-align:right">
						<div class="sendpbm_fullscreen_bg" style="display:none"></div>
						<div class="sendpbm_iframe_preview" style="display:none"></div>
						
					<input type="hidden" name="sendprebuiltemails_order_edit_orderid" value="<?php 
        echo  esc_attr( $post_order_id ) ;
        ?>">				
					<a onclick="sendprebuiltemailsordereditpreview()" id="sendprebuiltemails_order_edit_preview_id" class="disabled button button-secondary" value="preview">
						<?php 
        echo  esc_html__( 'preview', 'send-prebuilt-emails' ) ;
        ?></a>
					<a onclick="sendprebuiltemails_securemailsend_func()" id="sendprebuiltemails_order_edit_send_id" class="disabled button button-primary" value="send">
						<?php 
        echo  esc_html__( 'send', 'send-prebuilt-emails' ) ;
        ?></a>
					 <a onclick="spm_layer_for_writemail(' . esc_attr( $post_order_id ) . ');" id="sendprebuiltemails_order_write_send_id" style="display:none" class="button button-primary" value="write">
						<?php 
        echo  esc_html__( 'write E-Mail', 'send-prebuilt-emails' ) ;
        ?></a>
						<div id="sendprebuiltemails_bulkrespond_here_id"></div>
						<div id="sendpbm_mailsend_respond_id"></div>
					</li>
				</ul><?php 
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
			var success_popup_load = success_popup_load + "<b><?php 
        echo  esc_html__( 'sending', 'send-prebuilt-emails' ) ;
        ?>...</b><br><span style=\"visibility:hidden\"> 1 von 1 E-Mail erfolgreich versendet.<br>";
			var success_popup_load = success_popup_load + "</span><span style=\"visibility:hidden\" class=\"thinleek-desc-bright\">Prebuilt E-Mail</span></p>";
			var success_popup_load = success_popup_load + "</div><div style=\"visibility:hidden\" class=\"spm-s-sendsuccess_footer\">";
			var success_popup_load = success_popup_load + "<a onclick=\"sendpbm_close_popup()\" class=\"button button-primary\">OKAY</a>";
			var success_popup_load = success_popup_load + "</div></div></div></div></div>";
				
			var identifier = document.getElementById("sendprebuiltemails_order_edit_select_id").value;		
			var order_id = <?php 
        echo  esc_attr( $post_order_id ) ;
        ?>;	
			var type = "orderedit";
		
			// sendpbm_mailsend_respond_id
			var respond_div = document.getElementById("sendprebuiltemails_bulkrespond_here_id");
			var ausgabe_div = document.getElementById("sendprebuiltemails_bulkrespond_here_id");
			//ausgabe_div.innerHTML = "";
			respond_div.innerHTML = success_popup_load;

			var data = {
				'action': 'sendprebuiltemails_secure_sendmail_action',
				'identifier': identifier,
				'order_ids': order_id,
				'type': type,
				'nonce': spm_ajax_object.spm_ajax_nonce,
				};

						jQuery.post("<?php 
        echo  esc_url( admin_url( 'admin-ajax.php' ) ) ;
        ?>", data, function(response) {
							
							var split_response = response.split("_spmexplodespm_");
							respond_div.innerHTML = split_response[0];	
								
							(function($) {
							
								if ( split_response[3] !== "none" ) {
									$( '#woocommerce-order-notes ul.order_notes' ).prepend( split_response[3] );
								}
								
								if ( split_response[4].length > 10 ) {
									document.getElementById("sendprebuiltemail_okay_button_id").innerHTML = split_response[4];
									location.reload();
								}
								
							})(jQuery);
							
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
			var order_id = ' . esc_attr( $post_order_id ) . ';	
			var prev = "orderedit";
			
			var ausgabe_div = document.getElementById("sendprebuiltemails_bulkrespond_here_id");
				


			contenthtml = "<div class=\"spm-bg-layer\"></div><div class=\"spm-ajax-wrap-full\">";
			contenthtml = contenthtml + "<div class=\"spm-ajax-wrap\"><div class=\"sendpbm_ajax_ausgabe_inner\">";
			contenthtml = contenthtml + "<div class=\"spm-ajax-header\"><div class=\"spm-head-txt\">";
			contenthtml = contenthtml + "<?php 
        echo  esc_attr( __( 'E-Mail preview', 'send-prebuilt-emails' ) ) ;
        ?></div><span onclick=\"sendpbm_close_popup()\" class=\"dashicons dashicons-no-alt spm-close-icon\">";
			contenthtml = contenthtml + "</span></div><div class=\"spm-ajax-body\"><div id=\"sendprebuiltemails-loading-screen\">";
			contenthtml = contenthtml + "<div class=\"thinleek-progress\"><div class=\"thinleek-indeterminate\"></div></div>";
			contenthtml = contenthtml + "<p style=\"text-align:left\"><?php 
        echo  esc_attr( __( 'loading...', 'send-prebuilt-emails' ) ) ;
        ?></p></div>";
			contenthtml = contenthtml + "<div style=\"height:100%;width:100%\"id=\"sendprebuiltemails_iframe_id_div\">";
			contenthtml = contenthtml + "</div></div></div><div class=\"spm-ajax-footer\">";
			contenthtml = contenthtml + "<a onclick=\"sendpbm_close_popup()\" class=\"button-secondary button\">";
			contenthtml = contenthtml + "<?php 
        echo  esc_attr( __( 'close', 'send-prebuilt-emails' ) ) ;
        ?></a><a style=\"margin-left:10px\" onclick=\"sendprebuiltemails_securemailsend_func()\" class=\"button-primary button\">";
			contenthtml = contenthtml + "<?php 
        echo  esc_attr( __( 'send E-Mail', 'send-prebuilt-emails' ) ) ;
        ?></a></div></div>";
			ausgabe_div.innerHTML = contenthtml;
			
			var data = {
					'action': 'sendprebuiltemails_preview_action',
					'identifier': identifier,
					'order': order_id,
					'prev': prev,
					'nonce': spm_ajax_object.spm_ajax_nonce,
				};
				
				
			jQuery.post("<?php 
        echo  esc_url( admin_url( 'admin-ajax.php' ) ) ;
        ?>", data, function(response) {
			
				document.getElementById("sendprebuiltemails_iframe_id_div").innerHTML = response;
				document.getElementById("sendprebuiltemails_iframe_id_div").style.overflowY = "scroll";
				document.getElementById("sendprebuiltemails-loading-screen").style.display = "none";

            
			});
		
		}
		
		
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
		var writebtn = document.getElementById("sendprebuiltemails_order_write_send_id");
		
		var select = document.getElementById("sendprebuiltemails_order_edit_select_id");	
		var selectvalue = select.value;
		
		if ( selectvalue == "sendprebuiltemails_plain" ) {
			sendbtn.style.display = "none";	
			previewbtn.style.display = "none";	
			previewbtn.classList.remove("disabled");	
			sendbtn.classList.remove("disabled");	
			writebtn.style.display = "";	
		}
		else {
			sendbtn.style.display = "";	
			previewbtn.style.display = "";	
			writebtn.style.display = "none";	
	
			if ( selectvalue.length > 0 && selectvalue !== "choose"  ) {
				previewbtn.classList.remove("disabled");	
				sendbtn.classList.remove("disabled");	
			}
			else {
				previewbtn.classList.add("disabled");	
				sendbtn.classList.add("disabled");	
			}
		}
	}
	</script>
	<?php 
    }
    
    /**
     * Add bulk actions to order list
     */
    public function spm_add_order_bulk_actions( $actions )
    {
        $nav = '';
        // get settings
        $spm_advanced_settings = get_option( 'send_prebuilt_emails_thinleek_advanced' );
        $spm_setup_settings = get_option( 'send_prebuilt_emails_thinleek_setup' );
        $all_identifiers = ( isset( $spm_setup_settings['identifiers'] ) ? $spm_setup_settings['identifiers'] : array() );
        // get the class
        $name = 'SEND_PREBUILT_EMAILS_VERSION';
        $version = '1.0.0';
        $spm_admin_class = new Send_Prebuilt_Emails_Admin( $name, $version );
        foreach ( $all_identifiers as $identifier ) {
            // check if template is valid to make sure its a great e-mail
            $template_valid = $spm_admin_class->spm_is_template_valid( $identifier, $nav );
            if ( $template_valid !== 'valid' ) {
                continue;
            }
            // get all options for this template
            $option_name = 'send_prebuilt_emails_thinleek_' . $identifier;
            $options = get_option( $option_name );
            // get template name
            $option_key = 'name';
            $template_name = ( isset( $options[$option_key] ) ? $options[$option_key] : '' );
            // check if user selected it for bulk actions
            $is_bulk = '';
            if ( isset( $spm_advanced_settings['bulk'][$identifier] ) ) {
                $is_bulk = $spm_advanced_settings['bulk'][$identifier];
            }
            // add it to order bulk actions
            if ( $is_bulk == 'checked' ) {
                $actions['sendprebuiltemails_' . $identifier] = __( 'send Prebuilt E-Mail', 'send-prebuilt-emails' ) . ' "' . stripslashes( $template_name ) . '"';
            }
        }
        return $actions;
    }
    
    /**
     * check if template is set up correctly
     */
    public function spm_is_template_valid( $single_identifier, $nav )
    {
        
        if ( !isset( $nav ) || strlen( $nav ) < 3 ) {
            $nav = '';
        } else {
            $nav = $nav . '_';
        }
        
        $setting_field_names = array(
            'name',
            'subject',
            'content',
            'orderdetails',
            'address',
            'contenttwo',
            'footer'
        );
        $check_count = 0;
        // get options for current identifier
        $option_name = 'send_prebuilt_emails_' . $nav . 'thinleek_' . $single_identifier;
        $options = get_option( $option_name );
        // check if options found
        
        if ( !isset( $options ) ) {
            return 'not found';
            wp_die();
        }
        
        $key = 'name';
        $option_value = ( isset( $options[$key] ) ? $options[$key] : '' );
        // check template name
        
        if ( strlen( $option_value ) > 0 ) {
            $check_count++;
        } else {
            $error_check[] = 'no template name';
            return __( 'missing template name', 'send-prebuilt-emails' );
            wp_die();
        }
        
        // check subject
        $key = 'subject';
        $option_value = ( isset( $options[$key] ) ? $options[$key] : '' );
        
        if ( strlen( $option_value ) > 0 ) {
            $subject_valid = 'yes';
            $check_count++;
        } else {
            $error_check[] = 'no subject';
            return __( 'missing subject', 'send-prebuilt-emails' );
            wp_die();
        }
        
        // check content
        $key = 'content';
        $option_value = '';
        
        if ( isset( $options[$key] ) && strlen( $options[$key] ) > 0 ) {
            $content_valid = 'yes';
            $check_count++;
        }
        
        // if name, subject and content is correct return valid else further checks
        
        if ( $check_count == 3 ) {
            return 'valid';
            wp_die();
        } else {
            // name and subject are correct, now we need content
            // check additional content to make it valid
            $key = 'contenttwo';
            $option_value = '';
            
            if ( isset( $options[$key] ) && strlen( $options[$key] ) > 0 ) {
                $contenttwo_valid = 'yes';
                return 'valid';
                wp_die();
            }
            
            // not jet valid...check order details
            $key = 'orderdetails';
            
            if ( isset( $options[$key] ) && strlen( ${$options[$key]} ) > 0 ) {
                $orderdetails_valid = 'yes';
                return 'valid';
                wp_die();
            }
            
            // there is no content...return error message
            $error_check[] = __( 'missing content', 'send-prebuilt-emails' );
            return join( ', ', $error_check );
            wp_die();
        }
    
    }

}
// class END