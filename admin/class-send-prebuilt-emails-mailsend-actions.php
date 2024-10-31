<?php

/**
 *
 * The admin-specific functionality of the plugin for sending and previewing mails.
 *
 */
class Send_Prebuilt_Emails_Mailsend_Actions
{
    /* The ID of this plugin */
    private  $send_prebuilt_emails ;
    /*  The version of this plugin */
    private  $version ;
    /* Initialize the class and set its properties. */
    public function __construct( $send_prebuilt_emails, $version )
    {
        $this->send_prebuilt_emails = $send_prebuilt_emails;
        $this->version = $version;
    }
    
    /**
     * add time data placeholders via filter to send prebuilt emails
     */
    public function spm_filter_timedata_placeholder( $my_placeholders, $order_id )
    {
        $date_format = get_option( 'date_format' );
        $today = date( $date_format );
        $my_placeholders['today'] = $today;
        $my_placeholders['tomorrow'] = date( $date_format, strtotime( $today . '+ 1 days' ) );
        $my_placeholders['next_monday'] = date( $date_format, strtotime( 'next monday' ) );
        $my_placeholders['next_tuesday'] = date( $date_format, strtotime( 'next tuesday' ) );
        $my_placeholders['next_wednesday'] = date( $date_format, strtotime( 'next wednesday' ) );
        $my_placeholders['next_thursday'] = date( $date_format, strtotime( 'next thursday' ) );
        $my_placeholders['next_friday'] = date( $date_format, strtotime( 'next friday' ) );
        $my_placeholders['next_saturday'] = date( $date_format, strtotime( 'next saturday' ) );
        $my_placeholders['next_sunday'] = date( $date_format, strtotime( 'next sunday' ) );
        $my_placeholders['in_7_days'] = date( $date_format, strtotime( $today . '+ 7 days' ) );
        $my_placeholders['in_14_days'] = date( $date_format, strtotime( $today . '+ 14 days' ) );
        return $my_placeholders;
    }
    
    /**
     * add user placeholders via filter to send prebuilt emails
     */
    public function spm_filter_additional_user_placeholder( $my_placeholders, $user_id )
    {
        $date_format = get_option( 'date_format' );
        $today = date( $date_format );
        $my_placeholders['today'] = $today;
        $my_placeholders['tomorrow'] = date( $date_format, strtotime( $today . '+ 1 days' ) );
        $my_placeholders['next_monday'] = date( $date_format, strtotime( 'next monday' ) );
        $my_placeholders['next_tuesday'] = date( $date_format, strtotime( 'next tuesday' ) );
        $my_placeholders['next_wednesday'] = date( $date_format, strtotime( 'next wednesday' ) );
        $my_placeholders['next_thursday'] = date( $date_format, strtotime( 'next thursday' ) );
        $my_placeholders['next_friday'] = date( $date_format, strtotime( 'next friday' ) );
        $my_placeholders['next_saturday'] = date( $date_format, strtotime( 'next saturday' ) );
        $my_placeholders['next_sunday'] = date( $date_format, strtotime( 'next sunday' ) );
        $my_placeholders['in_7_days'] = date( $date_format, strtotime( $today . '+ 7 days' ) );
        $my_placeholders['in_14_days'] = date( $date_format, strtotime( $today . '+ 14 days' ) );
        $my_placeholders['userid'] = $user_id;
        return $my_placeholders;
    }
    
    /**
     * create e-mail header
     */
    public function spm_email_header( $options, $order_id )
    {
        // get class
        $name = 'SEND_PREBUILT_EMAILS_VERSION';
        $version = '1.0.0';
        $spm_mailsend_class = new Send_Prebuilt_Emails_Mailsend_Actions( $name, $version );
        /* clear options if not premium */
        
        if ( sendprebuiltemails_fs()->is_not_paying() ) {
            $options['from_name'] = '';
            $options['from_email'] = '';
            $options['to_email'] = '';
            $options['reply_to_name'] = '';
            $options['reply_to_name'] = '';
            $options['cc'] = '';
            $options['bcc'] = '';
        }
        
        /* END clear options if not premium */
        $headers = 'Content-Type: text/html' . "\r\n";
        /* add from name and e-mail to e-mail header */
        $option_key = 'from_name';
        $from_name_valid = '';
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            $from_name_valid = $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id );
        }
        $option_key = 'from_email';
        
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            $from_email_valid = $options[$option_key];
            
            if ( is_email( $from_email_valid ) ) {
                $from_email_valid = $from_email_valid;
            } else {
                
                if ( is_email( $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id ) ) ) {
                    $from_email_valid = $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id );
                } else {
                    if ( !is_email( $from_email_valid ) ) {
                        $from_email_valid = get_option( 'woocommerce_email_from_address' );
                    }
                }
            
            }
        
        } else {
            $from_email_valid = get_option( 'woocommerce_email_from_address' );
        }
        
        $headers .= 'From: ' . $from_name_valid . ' <' . $from_email_valid . '>' . "\r\n";
        /* add reply to name and e-mail to e-mail header */
        $option_key = 'reply_to_name';
        $reply_to_name_valid = '';
        
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            $reply_to_name_valid = $options[$option_key];
            $reply_to_name_valid = $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id );
        }
        
        $option_key = 'reply_to_email';
        $reply_to_email_valid = '';
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            
            if ( is_email( $options[$option_key] ) ) {
                $reply_to_email_valid = $options[$option_key];
                $headers .= 'Reply-To: ' . $reply_to_name_valid . ' <' . $reply_to_email_valid . '>' . "\r\n";
            } else {
                
                if ( is_email( $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id ) ) ) {
                    $reply_to_email_valid = $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id );
                    $headers .= 'Reply-To: ' . $reply_to_name_valid . ' <' . $reply_to_email_valid . '>' . "\r\n";
                }
            
            }
        
        }
        /* add cc to e-mail header */
        $option_key = 'cc';
        $cc_valid = '';
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            
            if ( is_email( $options[$option_key] ) ) {
                $cc_valid = $options[$option_key];
                $headers .= 'Cc: ' . $cc_valid . "\r\n";
            } else {
                
                if ( is_email( $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id ) ) ) {
                    $cc_valid = $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id );
                    $headers .= 'Cc: ' . $cc_valid . "\r\n";
                }
            
            }
        
        }
        /* add bcc to e-mail header */
        $option_key = 'bcc';
        $bcc_valid = '';
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            
            if ( is_email( $options[$option_key] ) ) {
                $bcc_valid = $options[$option_key];
                $headers .= 'Bcc: ' . $bcc_valid . "\r\n";
            } else {
                
                if ( is_email( $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id ) ) ) {
                    $bcc_valid = $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id );
                    $headers .= 'Bcc: ' . $bcc_valid . "\r\n";
                }
            
            }
        
        }
        $header_info['header'] = $headers;
        $from_name_valid = ( isset( $from_name_valid ) ? $from_name_valid : '' );
        $header_info['from_name'] = preg_replace( '/[^a-zA-Z0-9\\s]/', '', sanitize_text_field( $from_name_valid ) );
        $from_email_valid = ( isset( $from_email_valid ) ? $from_email_valid : '' );
        $header_info['from_email'] = $from_email_valid;
        $reply_to_name_valid = ( isset( $reply_to_name_valid ) ? $reply_to_name_valid : '' );
        $header_info['reply_to_name'] = preg_replace( '/[^a-zA-Z0-9\\s]/', '', sanitize_text_field( $reply_to_name_valid ) );
        $reply_to_email_valid = ( isset( $reply_to_email_valid ) ? $reply_to_email_valid : '' );
        $header_info['reply_to_email'] = $reply_to_email_valid;
        $cc_valid = ( isset( $cc_valid ) ? $cc_valid : '' );
        $header_info['cc'] = $cc_valid;
        $bcc_valid = ( isset( $bcc_valid ) ? $bcc_valid : '' );
        $header_info['bcc'] = $bcc_valid;
        return $header_info;
    }
    
    /*
     * sanitize inputs from blank mail
     */
    public function spm_sanitize_blank_inputs( $options )
    {
        $sanitize_content = array( 'content', 'contenttwo' );
        foreach ( $options as $key => $val ) {
            
            if ( in_array( $key, $sanitize_content ) ) {
                $options[$key] = wp_filter_post_kses( $val );
            } else {
                $options[$key] = sanitize_text_field( $val );
            }
        
        }
        return $options;
    }
    
    /**
     * mail preview action
     */
    public function sendprebuiltemails_preview_action()
    {
        
        if ( !isset( $_POST['nonce'] ) || !isset( $_POST['order'] ) || !isset( $_POST['identifier'] ) ) {
            ?>
			<style>body { margin:0px !important; }</style>
			<div style="padding:10px;background:#fff;height:100%"><?php 
            echo  esc_html__( 'Sorry, to less arguments passed to the preview action. Please reload the page and try again.', 'send-prebuilt-emails' ) ;
            ?>
			</div><?php 
            wp_die();
        }
        
        // use class
        $name = 'SEND_PREBUILT_EMAILS_VERSION';
        $version = '1.0.0';
        $spm_mailsend_class = new Send_Prebuilt_Emails_Mailsend_Actions( $name, $version );
        // get current identifier
        $identifier = ( isset( $_POST['identifier'] ) ? sanitize_text_field( $_POST['identifier'] ) : '' );
        // get order
        $order_id = ( isset( $_POST['order'] ) ? sanitize_text_field( $_POST['order'] ) : '' );
        // get nonce
        $nonce = ( isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '' );
        // security check
        $nonce_check = 0;
        if ( !wp_verify_nonce( $nonce, 'spm_preview_nonce' ) ) {
            $nonce_check = 1;
        }
        // security check
        if ( check_ajax_referer( 'secure_send_prebuilt_emails', 'nonce', false ) === false ) {
            $nonce_check = 1;
        }
        
        if ( $nonce_check < 1 ) {
            ?><style>body { margin:0px !important; }</style>
			<div style="padding:10px;background:#fff;height:100%"><?php 
            echo  esc_html__( 'A WordPress security key for your session has expired. Please reload the page and it 
			will work.', 'send-prebuilt-emails' ) ;
            ?>
			</div><?php 
            wp_die();
        }
        
        // load the mailer class
        $mailer = WC()->mailer();
        // get identifiers
        $spm_setup_settings = get_option( 'send_prebuilt_emails_thinleek_setup' );
        $identifier_letters = ( isset( $spm_setup_settings['identifiers'] ) ? $spm_setup_settings['identifiers'] : array() );
        
        if ( get_post_type( $order_id ) == 'shop_order' ) {
            $order = wc_get_order( $order_id );
            $order_data = $order->get_data();
            // get default to address
            $default_to_address = '';
            if ( isset( $order_data['billing']['email'] ) ) {
                $default_to_address = $order_data['billing']['email'];
            }
            $nav_para = '';
            $nav = '0';
        } else {
            
            if ( $order_id === 'plain' && isset( $_POST['inputs'] ) ) {
                $plain_inputs = ( isset( $_POST['inputs'] ) ? array_map( 'wp_filter_post_kses', $_POST['inputs'] ) : array() );
                foreach ( $plain_inputs as $input ) {
                    $input_expl = explode( '__spm__', $input );
                    $options[$input_expl[0]] = $input_expl[1];
                }
                $options = $spm_mailsend_class->spm_sanitize_blank_inputs( $options );
                $order_id = ( isset( $options['first_order'] ) ? $options['first_order'] : '' );
                
                if ( get_post_type( $order_id ) !== 'shop_order' ) {
                    ?><style>body { margin:0px !important; }</style>
					<div style="padding:10px;background:#fff;height:100%"><?php 
                    echo  esc_html__( 'No data found for selected ID.', 'send-prebuilt-emails' ) ;
                    ?>
					</div><?php 
                    wp_die();
                }
                
                $order = wc_get_order( $order_id );
                $nav_para = '';
                $nav = '0';
            } else {
                // get user
                $user_id = $order_id;
                $user_info = get_userdata( $user_id );
                
                if ( !isset( $user_info ) ) {
                    ?><style>body { margin:0px !important; }</style>
				<div style="padding:10px;background:#fff;height:100%"><?php 
                    echo  esc_html__( 'No data found for selected ID.', 'send-prebuilt-emails' ) ;
                    ?>
				</div><?php 
                    wp_die();
                }
                
                // for other functions user_id is used as order_id
                $order_id = $user_id;
                $order = $user_id;
                // get default to address
                $default_to_address = '';
                if ( isset( $user_info->user_email ) ) {
                    $default_to_address = $user_info->user_email;
                }
                $nav_para = 'user_';
                $nav = 'user';
            }
        
        }
        
        
        if ( isset( $_POST['inputs'] ) && $identifier === 'plain' ) {
            $plain_inputs = ( isset( $_POST['inputs'] ) ? array_map( 'wp_filter_post_kses', $_POST['inputs'] ) : array() );
            foreach ( $plain_inputs as $input ) {
                $input_expl = explode( '__spm__', $input );
                $options[$input_expl[0]] = $input_expl[1];
            }
            $options = $spm_mailsend_class->spm_sanitize_blank_inputs( $options );
        } else {
            // get all options for current template
            $option_name = 'send_prebuilt_emails_' . $nav_para . 'thinleek_' . $identifier;
            $options = get_option( $option_name );
        }
        
        // get subjext
        $option_key = 'subject';
        $subject = ( isset( $options[$option_key] ) ? $options[$option_key] : '' );
        /**
         * get to address: check if user set up to address correctly and deside if default address is used
         */
        $option_key = 'to_email';
        $to_email_valid = '';
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            
            if ( is_email( $options[$option_key] ) ) {
                $to_email_valid = $options[$option_key];
            } else {
                if ( is_email( $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id ) ) ) {
                    $to_email_valid = $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id );
                }
            }
        
        }
        if ( !is_email( $to_email_valid ) ) {
            $to_email_valid = $default_to_address;
        }
        if ( !is_email( $to_email_valid ) ) {
            $to_email_valid = __( 'no valid E-Mail found', 'send-prebuilt-emails' );
        }
        $recipient = $to_email_valid;
        // get mail header and addresses
        $header_info = $spm_mailsend_class->spm_email_header( $options, $order_id );
        if ( isset( $header_info['header'] ) ) {
            $headers = $header_info['header'];
        }
        $from_name_valid = ( isset( $header_info['from_name'] ) ? $header_info['from_name'] : '' );
        $from_email_valid = ( isset( $header_info['from_email'] ) ? $header_info['from_email'] : '' );
        $reply_to_name_valid = ( isset( $header_info['reply_to_name'] ) ? $header_info['reply_to_name'] : '' );
        $reply_to_email_valid = ( isset( $header_info['reply_to_email'] ) ? $header_info['reply_to_email'] : '' );
        $cc_valid = ( isset( $header_info['cc'] ) ? $header_info['cc'] : '' );
        $bcc_valid = ( isset( $header_info['bcc'] ) ? $header_info['bcc'] : '' );
        // check if filter woocommerce_email_styles is used
        
        if ( has_filter( 'woocommerce_email_styles' ) ) {
            $css = apply_filters( 'woocommerce_email_styles', ob_get_clean(), '' );
        } else {
            ob_start();
            wc_get_template( 'emails/email-styles.php' );
            $css = ob_get_contents();
            ob_end_clean();
        }
        
        // check if custom filter exists
        if ( has_filter( 'sendprebuiltemails_custom_css_preview' ) ) {
            $css = apply_filters( 'sendprebuiltemails_custom_css_preview', $css );
        }
        // echo style
        ?><style><?php 
        $unset_css_for = array(
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6'
        );
        foreach ( $unset_css_for as $element ) {
            ?>#sendpbm_ajax_iframe_wrap <?php 
            echo  esc_html( $element ) ;
            ?> { all:unset; }<?php 
        }
        ?>#template_header_image_container { 
					width: 100% 
				}
				#template_container {
					width: 100%;
					background: #fff;
				}
				#sendpbm_ajax_iframe_wrap #wrapper {
				padding-top: 0px !important;
				padding-bottom: 50px !important;				
				}<?php 
        echo  esc_attr( str_replace( '}', '} #sendpbm_ajax_iframe_wrap ', $css ) ) ;
        ?></style><?php 
        // show extra html if it is bulk preview
        
        if ( isset( $_POST['ordercount'] ) && $_POST['ordercount'] > 0 ) {
            ?><style>
				.spp-plain-prev-top {
					width: 100%;
					margin-top: 0px !important;
					padding-top: 10px;
					padding-bottom: 10px;
					background: #e0ffe0;
				}
				.spp-plain-prev-top span {
					max-width: 600px;
					margin: auto;
					display: block;
				}
				body {
					padding-bottom: 50px;
				}
				</style><?php 
            $post_ordercount = ( isset( $_POST['ordercount'] ) ? sanitize_text_field( $_POST['ordercount'] ) : '' );
            
            if ( $nav === 'user' && $post_ordercount > 0 ) {
                ?><div class="spp-plain-prev-top">
								<span><?php 
                echo  esc_html__( 'preview for User ID #', 'send-prebuilt-emails' ) . esc_attr( $order_id ) . esc_html__( ' (1 of ', 'send-prebuilt-emails' ) . esc_attr( $post_ordercount ) . esc_html__( ' choosen Users', 'send-prebuilt-emails' ) ;
                ?>)</span>
							</div><?php 
            } else {
                ?><div class="spp-plain-prev-top">
									<span><?php 
                echo  esc_html__( 'preview for #', 'send-prebuilt-emails' ) . esc_attr( $order_id ) . esc_html__( ' (1 of ', 'send-prebuilt-emails' ) . esc_attr( $post_ordercount ) . esc_html__( ' choosen Orders', 'send-prebuilt-emails' ) ;
                ?>)</span>
								</div><?php 
            }
        
        }
        
        // change receipient
        
        if ( has_filter( 'sendprebuiltemails_change_recipient' ) ) {
            $recipient_filter = apply_filters( 'sendprebuiltemails_change_recipient', $recipient, $template_name );
            if ( is_email( $recipient_filter ) ) {
                $recipient = $recipient_filter;
            }
        }
        
        ?><div id="sendpbm_ajax_iframe_wrap">
					<div id="wrapper" style="padding-top:5px!important;padding-bottom: 10px!important;border-bottom: 1px solid #ccc;background: #fff;">
					<table style="max-width: 600px;margin: auto;width: 100%;text-align: left;">
						<tbody>
							<tr>
								<td style="width:80px"><?php 
        echo  esc_html__( 'From:', 'send-prebuilt-emails' ) ;
        ?>
								</td>
								<td><b><?php 
        echo  wp_kses_post( stripslashes( $from_name_valid ) ) ;
        ?></b> <?php 
        echo  esc_html( stripslashes( $from_email_valid ) ) ;
        ?>
								</td>
							</tr> 
							<tr>
								<td style="width:80px"><?php 
        echo  esc_html__( 'To:', 'send-prebuilt-emails' ) ;
        ?>
								</td>
								<td><?php 
        echo  esc_html( stripslashes( $recipient ) ) ;
        ?></td>
							</tr><?php 
        
        if ( strlen( $reply_to_email_valid ) > 0 ) {
            ?><tr>
						<td style="width:80px"><?php 
            echo  esc_html__( 'Reply to:', 'send-prebuilt-emails' ) ;
            ?>
						</td>
						<td><b><?php 
            echo  wp_kses_post( stripslashes( $reply_to_name_valid ) ) ;
            ?></b> <?php 
            echo  esc_html( stripslashes( $reply_to_email_valid ) ) ;
            ?></td>
					</tr><?php 
        }
        
        
        if ( strlen( $cc_valid ) > 0 ) {
            ?><tr>
						<td style="width:80px"><?php 
            echo  esc_html__( 'Cc:', 'send-prebuilt-emails' ) ;
            ?>
						</td>
						<td><?php 
            echo  esc_html( stripslashes( $cc_valid ) ) ;
            ?></td>
					</tr><?php 
        }
        
        
        if ( strlen( $bcc_valid ) > 0 ) {
            ?><tr>
						<td style="width:80px"><?php 
            echo  esc_html__( 'Bcc:', 'send-prebuilt-emails' ) ;
            ?>
						</td>
						<td><?php 
            echo  esc_html( stripslashes( $bcc_valid ) ) ;
            ?></td>
					</tr><?php 
        }
        
        $subject = $spm_mailsend_class->spm_replace_placeholder( $subject, $order_id );
        // change subject
        if ( has_filter( 'sendprebuiltemails_change_subject' ) ) {
            $subject = apply_filters( 'sendprebuiltemails_change_subject', $subject, $template_name );
        }
        
        if ( strlen( $subject ) > 0 ) {
            ?><tr>
						<td style="width:80px"><?php 
            echo  esc_html__( 'Subject:', 'send-prebuilt-emails' ) ;
            ?>
						</td>
						<td><?php 
            echo  esc_html( stripslashes( $subject ) ) ;
            ?></td>
					</tr><?php 
        }
        
        // get homepath and url to replace it if neccessary
        $home_path = get_home_path();
        $home_url = get_home_url();
        // loop thorugh 3 possible attachments
        $allowed_attachments = array( 'a', 'b', 'c' );
        $count_attach = 0;
        foreach ( $allowed_attachments as $atta ) {
            $option_key = 'attachment_' . $atta;
            
            if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
                $get_attachment = $options[$option_key];
            } else {
                continue;
            }
            
            // check filter for attachment path change
            if ( has_filter( 'sendprebuiltemails_change_attachment_path' ) ) {
                $get_attachment = apply_filters( 'sendprebuiltemails_change_attachment_path', $get_attachment );
            }
            /* clear attachments if not premium */
            if ( sendprebuiltemails_fs()->is_not_paying() ) {
                $get_attachment = array();
            }
            /* END attachments options if not premium */
            
            if ( isset( $get_attachment ) && strlen( $get_attachment ) > 0 ) {
                $get_attachment = $spm_mailsend_class->spm_replace_placeholder( $get_attachment, $order_id );
                $get_attachment = str_replace( $home_url, $home_path, $get_attachment );
                // check if file exists
                
                if ( file_exists( $get_attachment ) ) {
                    $count_attach++;
                    $find_filename = explode( '/', $get_attachment );
                    $file_name = $find_filename[round( sizeof( $find_filename ) - 1 )];
                    
                    if ( $count_attach == 1 ) {
                        ?><tr>
										<td style="width:80px"><?php 
                        echo  esc_html__( 'Attachment:', 'send-prebuilt-emails' ) ;
                        ?>
										</td>
										<td><?php 
                        echo  esc_html( $file_name ) ;
                        ?></td>
									</tr><?php 
                    } else {
                        ?><tr>
										<td style="width:80px">
										</td>
										<td><?php 
                        echo  esc_html( $file_name ) ;
                        ?></td>
									</tr><?php 
                    }
                
                }
            
            }
        
        }
        ?></tbody>
			</table>
		</div><?php 
        // get mail content
        $content = $spm_mailsend_class->spm_get_email_content( $options, $order, $nav );
        ?>
		<div class="spm-mail-content-wrap">
		
		<?php 
        echo  wp_kses_post( $content ) ;
        ?>
		</div>
		</div>
		<?php 
        wp_die();
    }
    
    // END Action to Preview E-Mail and use this as iframe
    /**
     * get e-mail content
     */
    public function spm_get_email_content( $options, $order, $nav )
    {
        
        if ( !isset( $nav ) || strlen( $nav ) < 3 ) {
            $order_id = $order->get_id();
            
            if ( get_post_type( $order_id ) !== 'shop_order' ) {
                return __( 'no content found for order', 'send-prebuilt-emails' );
                wp_die();
            }
        
        } else {
            $order_id = $order;
        }
        
        // content starts empty
        $content = '';
        // get class
        $name = 'SEND_PREBUILT_EMAILS_VERSION';
        $version = '1.0.0';
        $spm_mailsend_class = new Send_Prebuilt_Emails_Mailsend_Actions( $name, $version );
        // get woocommerce mailer
        $mailer = WC()->mailer();
        // get heading: if empty use subject as heading
        $option_key = 'heading';
        $value = '';
        
        if ( !isset( $options[$option_key] ) || strlen( $options[$option_key] ) < 1 ) {
            $option_key = 'subject';
            $value = ( isset( $options[$option_key] ) ? $options[$option_key] : '' );
        } else {
            $option_key = 'heading';
            $value = ( isset( $options[$option_key] ) ? $options[$option_key] : '' );
        }
        
        // replace placeholder in subject
        $subject = $spm_mailsend_class->spm_replace_placeholder( $value, $order_id );
        // variables for further functions
        $email = $mailer;
        $sent_to_admin = false;
        $plain_text = false;
        // content: mail header
        ob_start();
        do_action( 'woocommerce_email_header', $subject, $email );
        $content .= ob_get_contents();
        ob_end_clean();
        // content: mail content from wp_editor field
        $option_key = 'content';
        $value = ( isset( $options[$option_key] ) ? $options[$option_key] : '' );
        $content .= apply_filters( 'the_content', $spm_mailsend_class->spm_replace_placeholder( $value, $order_id ) );
        // content: orderdetails table if user selected checkbox
        if ( !isset( $nav ) || strlen( $nav ) < 3 ) {
            
            if ( isset( $options['orderdetails'] ) && $options['orderdetails'] == 'orderdetails' ) {
                ob_start();
                do_action(
                    'woocommerce_email_order_details',
                    $order,
                    $sent_to_admin,
                    $plain_text,
                    $email
                );
                $content .= ob_get_contents();
                ob_end_clean();
                ob_start();
                do_action(
                    'woocommerce_email_order_meta',
                    $order,
                    $sent_to_admin,
                    $plain_text,
                    $email
                );
                $content .= ob_get_contents();
                ob_end_clean();
            }
        
        }
        // content: addresses if user selected checkbox
        if ( !isset( $nav ) || strlen( $nav ) < 3 ) {
            
            if ( isset( $options['address'] ) && $options['address'] == 'address' ) {
                ob_start();
                do_action(
                    'woocommerce_email_customer_details',
                    $order,
                    $sent_to_admin,
                    $plain_text,
                    $email
                );
                $content .= ob_get_contents();
                ob_end_clean();
            }
        
        }
        // content: additional content if is not empty
        $option_key = 'contenttwo';
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            $content .= apply_filters( 'the_content', $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id ) );
        }
        // content: footer if user selected checkbox
        
        if ( isset( $options['footer'] ) && $options['footer'] == 'footer' ) {
            ob_start();
            do_action( 'woocommerce_email_footer', $email );
            $content .= ob_get_contents();
            ob_end_clean();
        }
        
        // return content
        // change content
        if ( has_filter( 'sendprebuiltemails_change_content' ) ) {
            $content = apply_filters( 'sendprebuiltemails_change_content', $content, $template_name );
        }
        return stripslashes( $content );
    }
    
    /*
     * replace placeholders
     */
    public function spm_replace_placeholder( $value, $order_id )
    {
        // get order data
        
        if ( get_post_type( $order_id ) == 'shop_order' ) {
            $order = wc_get_order( $order_id );
            $order_data = $order->get_data();
            $nav_para = '';
        } else {
            $nav_para = 'user_';
        }
        
        // get placeholder from wp options
        $spm_advanced_settings_adv = get_option( 'send_prebuilt_emails_thinleek_setup' );
        $placeholders = ( isset( $spm_advanced_settings_adv['placeholder'] ) ? $spm_advanced_settings_adv['placeholder'] : array() );
        // get advanced settings
        $advanced_setting = get_option( 'send_prebuilt_emails_' . $nav_para . 'thinleek_advanced' );
        
        if ( isset( $advanced_setting['placeholder'] ) ) {
            $advanced_setting_custom_placeholder = $advanced_setting['placeholder'];
        } else {
            return $value;
            wp_die();
        }
        
        // get fallback value for not found placeholder
        $advanced_setting_default_value = '';
        if ( isset( $advanced_setting['default']['placeholder'] ) ) {
            $advanced_setting_default_value = $advanced_setting['default']['placeholder'];
        }
        // add five possible order meta data
        $five_meta = array(
            'meta_a',
            'meta_b',
            'meta_c',
            'meta_d',
            'meta_e'
        );
        foreach ( $five_meta as $letter ) {
            if ( isset( $advanced_setting_custom_placeholder[$letter] ) && strlen( $advanced_setting_custom_placeholder[$letter] ) > 0 ) {
                $placeholders[] = $advanced_setting_custom_placeholder[$letter];
            }
        }
        // add five possible acf placeholder if set up by user
        $five_acf = array(
            'acf_a',
            'acf_b',
            'acf_c',
            'acf_d',
            'acf_e'
        );
        foreach ( $five_acf as $letter ) {
            if ( isset( $advanced_setting_custom_placeholder[$letter] ) && strlen( $advanced_setting_custom_placeholder[$letter] ) > 0 ) {
                $placeholders[] = $advanced_setting_custom_placeholder[$letter];
            }
        }
        // the value for replacing placeholder
        $rdy_to_mail_value = $value;
        $my_placeholders = array();
        // check placeholders created via filter
        
        if ( get_post_type( $order_id ) == 'shop_order' ) {
            
            if ( has_filter( 'sendprebuiltemails_add_custom_placeholder' ) ) {
                $my_placeholders = apply_filters( 'sendprebuiltemails_add_custom_placeholder', $my_placeholders, $order_id );
                if ( isset( $my_placeholders ) && sizeof( $my_placeholders ) > 0 ) {
                    foreach ( $my_placeholders as $added_key => $added_val ) {
                        
                        if ( strpos( $rdy_to_mail_value, $added_key ) > -1 ) {
                            $placeholder_brakets = '{' . $added_key . '}';
                            $rdy_to_mail_value = str_replace( $placeholder_brakets, $added_val, $rdy_to_mail_value );
                        }
                    
                    }
                }
            }
        
        } else {
            if ( get_post_type( $order_id ) !== 'shop_order' ) {
                
                if ( has_filter( 'sendprebuiltemails_add_custom_user_placeholder' ) ) {
                    $my_placeholders = apply_filters( 'sendprebuiltemails_add_custom_user_placeholder', $my_placeholders, $order_id );
                    if ( isset( $my_placeholders ) && sizeof( $my_placeholders ) > 0 ) {
                        foreach ( $my_placeholders as $added_key => $added_val ) {
                            
                            if ( strpos( $rdy_to_mail_value, $added_key ) > -1 ) {
                                $placeholder_brakets = '{' . $added_key . '}';
                                $rdy_to_mail_value = str_replace( $placeholder_brakets, $added_val, $rdy_to_mail_value );
                            }
                        
                        }
                    }
                }
            
            }
        }
        
        // get date format
        $date_format = get_option( 'date_format' );
        // lets replace placeholder
        foreach ( $placeholders as $placeholder_val ) {
            $placeholder_value = '';
            // first check if at least one placeholder exist in value
            
            if ( strpos( $rdy_to_mail_value, $placeholder_val ) > -1 ) {
                // check if the placeholder is one of the predefined ones
                
                if ( strpos( $placeholder_val, '-' ) > -1 ) {
                    // check first part of placeholder
                    $placeholder_to_key = explode( '-', $placeholder_val );
                    if ( get_post_type( $order_id ) == 'shop_order' ) {
                        // replace order, billing, shipping, user and acf placeholder
                        
                        if ( $placeholder_to_key[0] == 'order' ) {
                            if ( isset( $order_data[$placeholder_to_key[1]] ) ) {
                                $placeholder_value = $order_data[$placeholder_to_key[1]];
                            }
                        } else {
                            
                            if ( $placeholder_to_key[0] == 'billing' ) {
                                if ( isset( $order_data['billing'][$placeholder_to_key[1]] ) ) {
                                    $placeholder_value = $order_data['billing'][$placeholder_to_key[1]];
                                }
                            } else {
                                if ( $placeholder_to_key[0] == 'shipping' ) {
                                    if ( isset( $order_data['shipping'][$placeholder_to_key[1]] ) ) {
                                        $placeholder_value = $order_data['shipping'][$placeholder_to_key[1]];
                                    }
                                }
                            }
                        
                        }
                    
                    }
                    
                    if ( $placeholder_to_key[0] == 'user' ) {
                        
                        if ( get_post_type( $order_id ) == 'shop_order' ) {
                            if ( isset( $order_data['customer_id'] ) ) {
                                $user_id = $order_data['customer_id'];
                            }
                        } else {
                            $user_id = $order_id;
                        }
                        
                        $placeholder_value = get_user_meta( $user_id, $placeholder_to_key[1], true );
                    } else {
                        
                        if ( $placeholder_to_key[0] == 'acf_price' || $placeholder_to_key[0] == 'acf' ) {
                            $last_four_chars = substr( $placeholder_val, -4 );
                            
                            if ( $last_four_chars == 'rder' ) {
                                $replace_acfstart = $placeholder_to_key[0] . '-';
                                $acf_field = str_replace( $replace_acfstart, '', $placeholder_val );
                                $acf_field = str_replace( '-order', '', $acf_field );
                                $placeholder_value = get_field( $acf_field, $order_id );
                            } else {
                                
                                if ( $last_four_chars == 'user' ) {
                                    
                                    if ( get_post_type( $order_id ) == 'shop_order' ) {
                                        $user_id = $order_data['customer_id'];
                                    } else {
                                        $user_id = $order_id;
                                    }
                                    
                                    $user_id_acf = 'user_' . $user_id;
                                    $replace_acfstart = $placeholder_to_key[0] . '-';
                                    $acf_field = str_replace( $replace_acfstart, '', $placeholder_val );
                                    $acf_field = str_replace( '-user', '', $acf_field );
                                    $placeholder_value = get_field( $acf_field, $user_id_acf );
                                    $placeholder_value = ( isset( $placeholder_value ) ? $placeholder_value : '' );
                                }
                            
                            }
                            
                            if ( isset( $placeholder_value ) && strlen( $placeholder_value ) > 0 ) {
                                if ( $placeholder_to_key[0] == 'acf_price' ) {
                                    $placeholder_value = wc_price( $placeholder_value );
                                }
                            }
                        } else {
                            
                            if ( $placeholder_to_key[0] == 'ordermeta' && get_post_type( $order_id ) == 'shop_order' ) {
                                $order_meta_key = str_replace( 'ordermeta-', '', $placeholder_val );
                                $last_five_chars = substr( $placeholder_val, -5 );
                                if ( $last_five_chars === '-curr' || $last_five_chars == '-date' ) {
                                    $order_meta_key = str_replace( $last_five_chars, '', $order_meta_key );
                                }
                                $order_meta_value = get_post_meta( $order_id, $order_meta_key, true );
                                
                                if ( isset( $order_meta_value ) && strlen( $order_meta_value ) > 0 ) {
                                    $placeholder_value = $order_meta_value;
                                    $last_four_chars = substr( $placeholder_val, -4 );
                                    
                                    if ( $last_four_chars == 'curr' ) {
                                        $placeholder_value = wc_price( $placeholder_value );
                                    } else {
                                        if ( $last_four_chars == 'date' ) {
                                            $placeholder_value = date_format( $placeholder_value, $date_format );
                                        }
                                    }
                                
                                }
                            
                            }
                        
                        }
                    
                    }
                    
                    // check if we have to format as date or price
                    
                    if ( strpos( $placeholder_to_key[1], 'date_' ) > -1 ) {
                        if ( isset( $placeholder_value ) && strlen( $placeholder_value ) > 0 ) {
                            $placeholder_value = date_format( $placeholder_value, $date_format );
                        }
                    } else {
                        if ( strpos( $placeholder_to_key[1], 'total' ) > -1 ) {
                            if ( isset( $placeholder_value ) && strlen( $placeholder_value ) > 0 ) {
                                $placeholder_value = wc_price( $placeholder_value );
                            }
                        }
                    }
                
                }
                
                // if value to replace placeholder is found replace it else show fallback value
                
                if ( isset( $placeholder_value ) && strlen( $placeholder_value ) > 0 ) {
                    $placeholder_brakets = '{' . $placeholder_val . '}';
                    $rdy_to_mail_value = str_replace( $placeholder_brakets, $placeholder_value, $rdy_to_mail_value );
                } else {
                    $placeholder_brakets = '{' . $placeholder_val . '}';
                    $rdy_to_mail_value = str_replace( $placeholder_brakets, $advanced_setting_default_value, $rdy_to_mail_value );
                }
            
            }
        
        }
        // here is the replaced value
        return $rdy_to_mail_value;
    }
    
    /**
     * Send Mail Action
     */
    public function sendprebuiltemails_secure_sendmail_action()
    {
        $succes_popup_start = '<div class="spm-bg-layer"></div><div class="s-spm-ajax-wrap-full"><div class="s-spm-ajax-wrap">';
        $succes_popup_start .= '<div class="spm-s-sendsuccess"><div style="padding:20px"><div class="spm-s-sendsuccess-flex">';
        $succes_popup_start .= '<div class="spm-success-icon"><span class="dashicons dashicons-email-alt"></span></div>';
        $succes_popup_start .= '<p id="sendprebuiltemails-success-txt-id">';
        // great is good. turns great to die wp_die ends the function
        $die_feedback = 'great';
        // security check
        if ( check_ajax_referer( 'secure_send_prebuilt_emails', 'nonce', false ) === false ) {
            $die_feedback = 'die';
        }
        // user feedback in layer
        
        if ( $die_feedback == 'die' ) {
            $succes_popup_txt = '<b>' . __( 'No E-Mail sent!', 'send-prebuilt-emails' ) . '</b><br>' . __( 'A WordPress security key for your session has expired. Please reload the page  
								and try it again.', 'send-prebuilt-emails' );
            echo  wp_kses_post( $succes_popup_start . $succes_popup_txt ) ;
            ?></p></div><div class="spm-s-sendsuccess_footer"><div id="sendprebuiltemail_okay_button_id"><a onclick="sendpbm_close_popup_bulk()" class="button button-primary">OKAY</a></div></div></div></div></div></div><?php 
            wp_die();
        }
        
        // check if all $_POST variables exist
        if ( !isset( $_POST['identifier'] ) ) {
            $die_feedback = 'die';
        }
        if ( !isset( $_POST['order_ids'] ) ) {
            $die_feedback = 'die';
        }
        if ( !isset( $_POST['type'] ) ) {
            $die_feedback = 'die';
        }
        // user feedback in layer
        
        if ( $die_feedback == 'die' ) {
            $succes_popup_txt = '<b>' . __( 'No E-Mail sent!', 'send-prebuilt-emails' ) . '</b><br>' . __( 'Error, missing information to send E-Mails. Please refresh page and try again.', 'send-prebuilt-emails' );
            echo  wp_kses_post( $succes_popup_start . $succes_popup_txt ) ;
            ?></p></div><div class="spm-s-sendsuccess_footer"><div id="sendprebuiltemail_okay_button_id"><a onclick="sendpbm_close_popup_bulk()" class="button button-primary">OKAY</a></div></div></div></div></div></div><?php 
            wp_die();
        }
        
        $spm_advanced_settings = get_option( 'send_prebuilt_emails_thinleek_setup' );
        $identifier_letters = ( isset( $spm_advanced_settings['identifiers'] ) ? $spm_advanced_settings['identifiers'] : '' );
        // die if error
        $post_identifier = ( isset( $_POST['identifier'] ) ? sanitize_text_field( $_POST['identifier'] ) : '' );
        if ( !in_array( $post_identifier, $identifier_letters ) && $post_identifier !== 'plain' ) {
            $die_feedback = 'die';
        }
        // user feedback in layer
        
        if ( $die_feedback == 'die' ) {
            $succes_popup_txt = '<b>' . __( 'No E-Mail sent!', 'send-prebuilt-emails' ) . '</b><br>' . __( 'Error, trying to send not existing template.', 'send-prebuilt-emails' );
            echo  wp_kses_post( $succes_popup_start . $succes_popup_txt ) ;
            ?></p></div><div class="spm-s-sendsuccess_footer"><div id="sendprebuiltemail_okay_button_id"><a onclick="sendpbm_close_popup_bulk()" class="button button-primary">OKAY</a></div></div></div></div></div></div><?php 
            wp_die();
        }
        
        // use class
        $name = 'SEND_PREBUILT_EMAILS_VERSION';
        $version = '1.0.0';
        $spm_mailsend_class = new Send_Prebuilt_Emails_Mailsend_Actions( $name, $version );
        // get post values
        $identifier = ( isset( $_POST['identifier'] ) ? sanitize_text_field( $_POST['identifier'] ) : '' );
        $order_ids = ( isset( $_POST['order_ids'] ) ? sanitize_text_field( $_POST['order_ids'] ) : '' );
        $send_type = ( isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '' );
        $meta_content_for_script = 'none';
        $testemail = '';
        if ( isset( $_POST['testemail'] ) ) {
            $testemail = ( isset( $_POST['testemail'] ) ? sanitize_email( $_POST['testemail'] ) : '' );
        }
        
        if ( strpos( $order_ids, 'spm' ) > 0 ) {
            $order_id_array = explode( 'spm', $order_ids );
        } else {
            $order_id_array = array( $order_ids );
        }
        
        if ( sizeof( $order_id_array ) < 1 ) {
            $die_feedback = 'die';
        }
        // user feedback in layer
        
        if ( $die_feedback == 'die' ) {
            $succes_popup_txt = '<b>' . __( 'No E-Mail sent!', 'send-prebuilt-emails' ) . '</b><br>' . __( 'No selected order found.', 'send-prebuilt-emails' );
            echo  wp_kses_post( $succes_popup_start . $succes_popup_txt ) ;
            ?></p></div><div class="spm-s-sendsuccess_footer"><div id="sendprebuiltemail_okay_button_id"><a onclick="sendpbm_close_popup_bulk()" class="button button-primary">OKAY</a></div></div></div></div></div></div><?php 
            wp_die();
        }
        
        
        if ( sendprebuiltemails_fs()->is_not_paying() ) {
            /***** free feature only *****/
            if ( sizeof( $order_id_array ) > 10 ) {
                $die_feedback = 'die';
            }
            // user feedback in layer
            
            if ( $die_feedback == 'die' ) {
                $pro_feature_bubble = '<a href="' . sendprebuiltemails_fs()->get_upgrade_url() . '" target="_blank" class="thinleek-pro-bubble">PREMIUM FEATURE</a>';
                $succes_popup_txt = '<b>' . __( 'No E-Mail sent!', 'send-prebuilt-emails' ) . '</b><br>' . __( 'Max. 10 E-Mails allowed in free version! Please Upgrade Send Prebuilt E-Mails to send unlimited E-Mails.', 'send-prebuilt-emails' ) . $pro_feature_bubble;
                echo  wp_kses_post( $succes_popup_start . $succes_popup_txt ) ;
                ?></p></div><div class="spm-s-sendsuccess_footer"><div id="sendprebuiltemail_okay_button_id"><a onclick="sendpbm_close_popup_bulk()" class="button button-primary">OKAY</a></div></div></div></div></div></div><?php 
                wp_die();
            }
            
            /***** END free feature only *****/
        }
        
        $nav = '0';
        // check if send type is plain
        
        if ( $identifier == 'plain' ) {
            
            if ( isset( $_POST['inputs'] ) ) {
                $all_inputs = ( isset( $_POST['inputs'] ) ? array_map( 'wp_filter_post_kses', $_POST['inputs'] ) : array() );
            } else {
                $succes_popup_txt = '<b>' . __( 'No E-Mail sent!', 'send-prebuilt-emails' ) . '</b><br>' . __( 'Error, no content found for blank E-Mail.', 'send-prebuilt-emails' );
                echo  wp_kses_post( $succes_popup_start . $succes_popup_txt ) ;
                ?></p></div><div class="spm-s-sendsuccess_footer"><div id="sendprebuiltemail_okay_button_id"><a onclick="sendpbm_close_popup_bulk()" class="button button-primary">OKAY</a></div></div></div></div></div></div><?php 
                wp_die();
            }
            
            foreach ( $all_inputs as $input ) {
                $input_expl = explode( '__spm__', $input );
                $options[$input_expl[0]] = $input_expl[1];
            }
            $options = $spm_mailsend_class->spm_sanitize_blank_inputs( $options );
        } else {
            
            if ( $send_type === 'orderedit' || $send_type === 'orderbulk' ) {
                $option_name = 'send_prebuilt_emails_thinleek_' . $identifier;
                $options = get_option( $option_name );
                $order_statuses_slugs = array();
                $order_statuses = wc_get_order_statuses();
                foreach ( $order_statuses as $status_slug => $status_name ) {
                    $order_statuses_slugs[] = $status_slug;
                }
            } else {
                
                if ( $send_type === 'user' ) {
                    // get all template options
                    $option_name = 'send_prebuilt_emails_user_thinleek_' . $identifier;
                    $options = get_option( $option_name );
                    $nav = 'user';
                }
            
            }
        
        }
        
        $spm_orders_send = array();
        $spm_orders_not_send = array();
        // prevent redeclare function in loop
        $filter_to_change_sender = 0;
        foreach ( $order_id_array as $order_id ) {
            // load the mailer class
            $mailer = WC()->mailer();
            // check if send type is order
            
            if ( $send_type === 'orderedit' || $send_type === 'orderbulk' ) {
                $order = wc_get_order( $order_id );
                
                if ( !isset( $order_id ) || get_post_type( $order_id ) !== 'shop_order' ) {
                    $spm_orders_not_send[] = '#' . $order_id . ': ' . __( 'no shop order found', 'secure_send_prebuilt_emails' );
                    continue;
                }
                
                $order_data = $order->get_data();
                $default_to_address = '';
                if ( isset( $order_data['billing']['email'] ) ) {
                    $default_to_address = sanitize_email( $order_data['billing']['email'] );
                }
            } else {
                
                if ( $send_type === 'user' ) {
                    $order = $order_id;
                    $user_info = get_userdata( $order_id );
                    $default_to_address = $user_info->user_email;
                    if ( !isset( $default_to_address ) ) {
                        $default_to_address = '';
                    }
                }
            
            }
            
            /* get to address */
            $option_key = 'to_email';
            $to_email_valid = '';
            if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
                
                if ( is_email( $options[$option_key] ) ) {
                    $to_email_valid = $options[$option_key];
                } else {
                    if ( is_email( $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id ) ) ) {
                        $to_email_valid = $spm_mailsend_class->spm_replace_placeholder( $options[$option_key], $order_id );
                    }
                }
            
            }
            if ( !is_email( $to_email_valid ) ) {
                $to_email_valid = $default_to_address;
            }
            
            if ( !is_email( $to_email_valid ) ) {
                $spm_orders_not_send[] = '#' . $order_id . ': ' . __( 'no valid recipient', 'secure_send_prebuilt_emails' );
                continue;
            }
            
            $recipient = $to_email_valid;
            // get mail header and addresses
            $header_info = $spm_mailsend_class->spm_email_header( $options, $order_id );
            if ( isset( $header_info['header'] ) ) {
                $headers = $header_info['header'];
            }
            $from_name_valid = ( isset( $header_info['from_name'] ) ? $header_info['from_name'] : '' );
            $from_email_valid = ( isset( $header_info['from_email'] ) ? $header_info['from_email'] : '' );
            $reply_to_name_valid = ( isset( $header_info['reply_to_name'] ) ? $header_info['reply_to_name'] : '' );
            $reply_to_email_valid = ( isset( $header_info['reply_to_email'] ) ? $header_info['reply_to_email'] : '' );
            $cc_valid = ( isset( $header_info['cc'] ) ? $header_info['cc'] : '' );
            $bcc_valid = ( isset( $header_info['bcc'] ) ? $header_info['bcc'] : '' );
            $option_key = 'from_email';
            
            if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 && $filter_to_change_sender < 1 ) {
                $filter_to_change_sender = 1;
                global  $sendprebuiltemails_from_name ;
                $sendprebuiltemails_from_name = $from_name_valid;
                global  $sendprebuiltemails_from_email ;
                $sendprebuiltemails_from_email = $from_email_valid;
                //From email address and name
                add_filter(
                    'woocommerce_email_from_address',
                    'sendprebuiltemails_change_sender_mail',
                    10,
                    2
                );
                function sendprebuiltemails_change_sender_mail( $from_email, $wc_email )
                {
                    global  $sendprebuiltemails_from_email ;
                    return $sendprebuiltemails_from_email;
                }
                
                // Change sender name
                add_filter(
                    'woocommerce_email_from_name',
                    'sendprebuiltemails_change_sender_name',
                    10,
                    2
                );
                function sendprebuiltemails_change_sender_name( $from_name, $wc_email )
                {
                    global  $sendprebuiltemails_from_name ;
                    return $sendprebuiltemails_from_name;
                }
            
            }
            
            
            if ( $identifier == 'plain' ) {
                $template_name = __( 'Blank', 'send-prebuilt-emails' );
            } else {
                $option_key = 'name';
                $template_name = ( isset( $options[$option_key] ) ? $options[$option_key] : '' );
            }
            
            $option_key = 'subject';
            $value = ( isset( $options[$option_key] ) ? $options[$option_key] : '' );
            $subject = $spm_mailsend_class->spm_replace_placeholder( $value, $order_id );
            $option_key = 'content';
            $value = ( isset( $options[$option_key] ) ? $options[$option_key] : '' );
            $content_replaced = $spm_mailsend_class->spm_replace_placeholder( $value, $order_id );
            $content = $spm_mailsend_class->spm_get_email_content( $options, $order, $nav );
            // change headers if it is testmail. remove cc and bcc
            
            if ( strlen( $testemail ) > 3 ) {
                
                if ( !is_email( $testemail ) ) {
                    $succes_popup_txt = '<b>' . __( 'No test E-Mail sent!', 'send-prebuilt-emails' ) . '</b><br>' . __( 'test E-Mail address not valid.', 'send-prebuilt-emails' );
                    echo  wp_kses_post( $succes_popup_start . $succes_popup_txt ) ;
                    ?></p></div><div class="spm-s-sendsuccess_footer"><div id="sendprebuiltemail_okay_button_id"><a onclick="sendpbm_close_popup_bulk()" class="button button-primary">OKAY</a></div></div></div></div></div></div><?php 
                    wp_die();
                }
                
                $recipient = $testemail;
                
                if ( strpos( $headers, 'Cc:' ) > 0 ) {
                    $headers_expl = explode( 'Cc:', $headers );
                    $headers = $headers_expl[0];
                } else {
                    
                    if ( strpos( $headers, 'Bcc:' ) > 0 ) {
                        $headers_expl = explode( 'Bcc:', $headers );
                        $headers = $headers_expl[0];
                    }
                
                }
            
            }
            
            
            if ( isset( $recipient ) && strlen( $recipient ) > 0 ) {
                // create array for attachments
                $attachments = array();
                // get homepath and url to replace it if neccessary
                $home_path = get_home_path();
                $home_url = get_home_url();
                // loop thorugh 3 possible attachments
                $allowed_attachments = array( 'a', 'b', 'c' );
                foreach ( $allowed_attachments as $atta ) {
                    $option_key = 'attachment_' . $atta;
                    
                    if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
                        $get_attachment = $options[$option_key];
                    } else {
                        continue;
                    }
                    
                    // check filter for attachment path change
                    if ( has_filter( 'sendprebuiltemails_change_attachment_path' ) ) {
                        $get_attachment = apply_filters( 'sendprebuiltemails_change_attachment_path', $get_attachment );
                    }
                    
                    if ( isset( $get_attachment ) && strlen( $get_attachment ) > 0 ) {
                        $get_attachment = $spm_mailsend_class->spm_replace_placeholder( $get_attachment, $order_id );
                        $get_attachment = str_replace( $home_url, $home_path, $get_attachment );
                        // check if file exists
                        if ( file_exists( $get_attachment ) ) {
                            $attachments[] = $get_attachment;
                        }
                    }
                
                }
                // allow use of filter to modify variables
                unset( $array_data );
                $array_data['template'] = $template_name;
                $array_data['order_id'] = $order_id;
                $array_data['subject'] = $subject;
                $array_data['content'] = $content_replaced;
                // change receipient
                
                if ( has_filter( 'sendprebuiltemails_change_recipient' ) ) {
                    $recipient_filter = apply_filters( 'sendprebuiltemails_change_recipient', $recipient, $array_data );
                    if ( is_email( $recipient_filter ) ) {
                        $recipient = $recipient_filter;
                    }
                }
                
                // change subject
                if ( has_filter( 'sendprebuiltemails_change_subject' ) ) {
                    $subject = apply_filters( 'sendprebuiltemails_change_subject', $subject, $array_data );
                }
                // change attachment
                
                if ( has_filter( 'sendprebuiltemails_change_attachments' ) ) {
                    $attachments = apply_filters( 'sendprebuiltemails_change_attachments', $attachments, $array_data );
                    $attachments = str_replace( $home_url, $home_path, $attachments );
                }
                
                // allow user to integragte logic to prevent send mail via filter
                $before_send_mail = true;
                if ( has_filter( 'sendprebuiltemails_before_send_mail' ) ) {
                    $recipient = apply_filters( 'sendprebuiltemails_before_send_mail', $recipient, $array_data );
                }
                /* clear attachments if not premium */
                if ( sendprebuiltemails_fs()->is_not_paying() ) {
                    $attachments = array();
                }
                /* END attachments options if not premium */
                // send bulk mail
                
                if ( $before_send_mail == true ) {
                    // last checks before sending mail
                    
                    if ( !is_email( $recipient ) ) {
                        $spm_orders_not_send[] = '#' . $order_id . ': ' . __( 'no recipient', 'secure_send_prebuilt_emails' );
                        continue;
                    }
                    
                    $subject = sanitize_text_field( stripslashes( $subject ) );
                    // dont send if no subject
                    
                    if ( strlen( $subject ) < 1 ) {
                        $spm_orders_not_send[] = '#' . $order_id . ': ' . __( 'no subject', 'secure_send_prebuilt_emails' );
                        continue;
                    }
                    
                    // send mail
                    $mailer->send(
                        $recipient,
                        $subject,
                        $content,
                        $headers,
                        $attachments
                    );
                    // if testemail break
                    
                    if ( strlen( $testemail ) > 3 ) {
                        $succes_popup_txt = '
					<b>' . __( 'Test E-Mail sent!', 'send-prebuilt-emails' ) . '</b><br>' . __( 'Test E-Mail sent successfully.', 'send-prebuilt-emails' ) . '<br><span class="thinleek-desc-bright">' . __( 'check inbox', 'send-prebuilt-emails' ) . ': ' . $recipient . '</span>';
                        echo  wp_kses_post( $succes_popup_start . $succes_popup_txt ) ;
                        ?></p></div><div class="spm-s-sendsuccess_footer"><div id="sendprebuiltemail_okay_button_id"><a onclick="sendpbm_close_popup_bulk()" class="button button-primary">OKAY</a></div></div></div></div></div></div><?php 
                        wp_die();
                    }
                    
                    $refresh_filter = false;
                    // check if send type is order
                    if ( $send_type !== 'user' && $identifier !== 'plain' ) {
                    }
                    $reload_in_success_popup = 'no';
                    if ( $refresh_filter == true ) {
                        $reload_in_success_popup = '<h4 style="margin:0px!important;height:30px;">' . __( 'reloading page...', 'secure_send_prebuilt_emails' ) . '</h4>';
                    }
                    // update order post meta
                    
                    if ( $send_type === 'orderbulk' || $send_type === 'orderedit' ) {
                        $date_format = get_option( 'date_format' );
                        $wp_timezone = get_option( 'timezone_string' );
                        if ( isset( $wp_timezone ) && strlen( $wp_timezone ) > 0 ) {
                            date_default_timezone_set( $wp_timezone );
                        }
                        $send_date = date( $date_format );
                        $get_order_meta = get_post_meta( $order_id, 'send_prebuilt_emails', true );
                        $meta_content_for_script = $template_name . ' (' . $send_date . ')';
                        $new_meta = $template_name . ' (' . $send_date . ')';
                        
                        if ( has_filter( 'sendprebuiltemails_change_column_value' ) ) {
                            $new_meta = apply_filters( 'sendprebuiltemails_change_column_value', $send_date, $array_data );
                            $meta_content_for_script = $new_meta;
                        }
                        
                        if ( isset( $get_order_meta ) && strlen( $get_order_meta ) > 0 ) {
                            $new_meta = $get_order_meta . ',' . $new_meta;
                        }
                        update_post_meta( $order_id, 'send_prebuilt_emails', esc_attr( $new_meta ) );
                    }
                    
                    $spm_orders_send[] = $order_id;
                    $spm_send_error = 'no';
                } else {
                    $spm_send_error = 'error';
                    $spm_orders_not_send[] = '#' . $order_id . ': ' . __( 'Mail blocked via before_mail_send filter', 'secure_send_prebuilt_emails' );
                }
                
                // text for woocommerce order note
                $note = __( 'Prebuilt E-Mail', 'send-prebuilt-emails' );
                $note .= ' "' . $template_name . '" ';
                $note .= __( 'sent.', 'send-prebuilt-emails' );
                $option_name_general = 'send_prebuilt_emails_thinleek_general';
                $options_general = get_option( $option_name_general );
                if ( $send_type === 'orderbulk' ) {
                    if ( isset( $options_general['note'] ) && $options_general['note'] == 'checked' ) {
                        
                        if ( $send_type === 'orderbulk' ) {
                            $note_type = 'private';
                            $is_customer_note = ( 'customer' === $note_type ? 1 : 0 );
                            $order->add_order_note( esc_attr( $note ), $is_customer_note, true );
                        }
                    
                    }
                }
            } else {
                $spm_send_error = 'error';
                $spm_orders_not_send[] = '#' . $order_id . ': ' . __( 'no valid recipient', 'secure_send_prebuilt_emails' );
            }
        
        }
        // END if loop bulk orders
        // if testemail break
        
        if ( strlen( $testemail ) > 3 && isset( $spm_orders_not_send ) && sizeof( $spm_orders_not_send ) > 0 ) {
            $succes_popup_txt = '
			<b>' . __( 'Test E-Mail not sent!', 'send-prebuilt-emails' ) . '</b><br>' . __( 'E-Mail not sent:', 'send-prebuilt-emails' ) . ' ' . join( ', ', $spm_orders_not_send );
            echo  wp_kses_post( $succes_popup_start . $succes_popup_txt ) ;
            ?></p></div><div class="spm-s-sendsuccess_footer"><div id="sendprebuiltemail_okay_button_id"><a onclick="sendpbm_close_popup_bulk()" class="button button-primary">OKAY</a></div></div></div></div></div></div><?php 
            wp_die();
        }
        
        $count_send_mails = ( isset( $spm_orders_send ) ? sizeof( $spm_orders_send ) : 0 );
        $count_not_send_mails = ( isset( $spm_orders_not_send ) ? sizeof( $spm_orders_not_send ) : 0 );
        $count_all_mails = $count_send_mails + $count_not_send_mails;
        
        if ( isset( $spm_send_error ) && $spm_send_error == 'error' ) {
            if ( !isset( $spm_orders_send ) || sizeof( $spm_orders_send ) < 1 ) {
                $succes_popup_txt = '
					<b>0 ' . __( 'of', 'send-prebuilt-emails' ) . ' ' . $count_all_mails . ' ' . __( 'E-Mails sent!', 'send-prebuilt-emails' ) . '</b><br>' . __( 'E-Mails not sent:', 'send-prebuilt-emails' ) . ' ' . join( ', ', $spm_orders_not_send ) . ' ' . __( 'no valid recipient found.', 'send-prebuilt-emails' );
            }
            
            if ( sizeof( $spm_orders_not_send ) > 1 ) {
                $succes_popup_txt = '
					<b>' . $count_send_mails . ' ' . __( 'of', 'send-prebuilt-emails' ) . ' ' . $count_all_mails . ' ' . __( 'E-Mails sent!', 'send-prebuilt-emails' ) . '</b><br>' . __( 'E-Mails not sent:', 'send-prebuilt-emails' ) . ' ' . join( ', ', $spm_orders_not_send );
            } else {
                $succes_popup_txt = '
					<b>' . __( 'E-Mail not sent!', 'send-prebuilt-emails' ) . '
					</b><br>' . __( 'E-Mails not sent:', 'send-prebuilt-emails' ) . ' ' . join( ', ', $spm_orders_not_send );
            }
        
        } else {
            
            if ( $count_not_send_mails > 0 ) {
                $succes_popup_txt = '
					<b>' . $count_send_mails . ' ' . __( 'of', 'send-prebuilt-emails' ) . ' ' . $count_all_mails . ' ' . __( 'E-Mails sent!', 'send-prebuilt-emails' ) . '</b><br>' . __( 'E-Mails not sent: ', 'send-prebuilt-emails' ) . ' ' . join( ', ', $spm_orders_not_send );
            } else {
                
                if ( isset( $spm_orders_send ) && sizeof( $spm_orders_send ) > 1 ) {
                    $succes_popup_txt = '
					<b>' . __( 'E-Mails sent!', 'send-prebuilt-emails' ) . '</b><br>' . $count_send_mails . ' ' . __( 'of', 'send-prebuilt-emails' ) . ' ' . $count_send_mails . ' ' . __( 'E-Mails sent successfully.', 'send-prebuilt-emails' ) . '<br><span class="thinleek-desc-bright">' . __( 'Prebuilt E-Mail', 'send-prebuilt-emails' ) . ' "' . $template_name . '"</span>';
                } else {
                    $succes_popup_txt = '
					<b>' . __( 'E-Mail sent!', 'send-prebuilt-emails' ) . '</b><br>' . $count_send_mails . ' ' . __( 'of', 'send-prebuilt-emails' ) . ' ' . $count_send_mails . ' ' . __( 'E-Mail sent successfully.', 'send-prebuilt-emails' ) . '<br><span class="thinleek-desc-bright">' . __( 'Prebuilt E-Mail', 'send-prebuilt-emails' ) . ' "' . $template_name . '"</span>';
                }
            
            }
        
        }
        
        $script = 'none';
        if ( isset( $spm_orders_send ) && sizeof( $spm_orders_send ) > 0 ) {
            $script = join( 'spm', $spm_orders_send );
        }
        echo  wp_kses_post( $succes_popup_start . $succes_popup_txt ) ;
        ?></p></div><div class="spm-s-sendsuccess_footer"><div id="sendprebuiltemail_okay_button_id"><a onclick="sendpbm_close_popup_bulk()" class="button button-primary">OKAY</a></div></div></div></div></div></div><?php 
        echo  esc_html( '_spmexplodespm_' ) ;
        echo  wp_kses_post( $script ) ;
        echo  esc_html( '_spmexplodespm_' ) ;
        echo  wp_kses_post( $meta_content_for_script ) ;
        echo  esc_html( '_spmexplodespm_' ) ;
        
        if ( $send_type === 'orderedit' ) {
            
            if ( isset( $options_general['note'] ) && $options_general['note'] == 'checked' ) {
                // create order note
                $note_type = 'private';
                $is_customer_note = ( 'customer' === $note_type ? 1 : 0 );
                $comment_id = $order->add_order_note( $note, $is_customer_note, true );
                $note = wc_get_order_note( $comment_id );
                $note_classes = array( 'note' );
                $note_classes[] = ( $is_customer_note ? 'customer-note' : '' );
                $note_classes = apply_filters( 'woocommerce_order_note_class', array_filter( $note_classes ), $note );
                // echo html part for note to append via jquery in order edit page
                ?>
						<li rel="<?php 
                echo  absint( $note->id ) ;
                ?>" class="<?php 
                echo  esc_attr( implode( ' ', $note_classes ) ) ;
                ?>">
							<div class="note_content">
								<?php 
                echo  wp_kses_post( wpautop( wptexturize( make_clickable( $note->content ) ) ) ) ;
                ?>
							</div>
							<p class="meta">
								<abbr class="exact-date" title="<?php 
                echo  esc_attr( $note->date_created->date( 'y-m-d h:i:s' ) ) ;
                ?>">
									<?php 
                printf( esc_html__( 'added on %1$s at %2$s', 'woocommerce' ), esc_html( $note->date_created->date_i18n( wc_date_format() ) ), esc_html( $note->date_created->date_i18n( wc_time_format() ) ) );
                ?>
								</abbr>
								<?php 
                if ( 'system' !== $note->added_by ) {
                    printf( ' ' . esc_html__( 'by %s', 'woocommerce' ), esc_html( $note->added_by ) );
                }
                ?>
								<a href="#" class="delete_note" role="button"><?php 
                esc_html_e( 'Delete note', 'woocommerce' );
                ?></a>
							</p>
						</li>
						<?php 
            }
        
        } else {
            ?>none<?php 
        }
        
        echo  esc_html( '_spmexplodespm_' ) ;
        $reload_in_success_popup = ( isset( $reload_in_success_popup ) ? $reload_in_success_popup : 'no' );
        echo  wp_kses_post( $reload_in_success_popup ) ;
        // send mails done
        wp_die();
    }

}
// END Class