<?php

/**
 * The admin-option-settings-facing functionality of the plugin.
 */
class Send_Prebuilt_Emails_Settings
{
    // The ID of this plugin.
    private  $send_prebuilt_emails ;
    // The version of this plugin.
    private  $version ;
    /**
     * Initialize the class and set its properties.
     */
    public function __construct( $send_prebuilt_emails, $version )
    {
        $this->send_prebuilt_emails = $send_prebuilt_emails;
        $this->version = $version;
    }
    
    /**
     * Register the stylesheets for the public-facing side of the site.
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->send_prebuilt_emails,
            plugin_dir_url( __FILE__ ) . 'css/send-prebuilt-emails-public.css',
            array(),
            $this->version,
            'all'
        );
    }
    
    /**
     * Register the JavaScript for the public-facing side of the site.
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            $this->send_prebuilt_emails,
            plugin_dir_url( __FILE__ ) . 'js/send-prebuilt-emails-public.js',
            array( 'jquery' ),
            $this->version,
            false
        );
    }
    
    /**
     * display accordion like tr in table
     */
    public function spm_admin_settings_accordeon(
        $class,
        $title,
        $updown,
        $border
    )
    {
        $class_name = 'spm_tr_part_' . $class;
        $style_border = 'border-top: 1px solid #cdcdcd;';
        if ( $border == 'no' ) {
            $style_border = '';
        }
        ?><tr>
				<th colspan="2" style="<?php 
        echo  esc_attr( $style_border ) ;
        ?>padding:10px!important;background:none!important;"></th>
			</tr>
			<tr class="thinleek-tr-head thinleek-pointer" onclick="sendprebuiltemails_tr_klapp(this,'<?php 
        echo  esc_attr( $class_name ) ;
        ?>')">
				<th colspan="2">
					<span class="dashicons dashicons-arrow-<?php 
        echo  esc_attr( $updown ) ;
        ?>"></span><?php 
        echo  esc_html( $title ) ;
        ?>
				</th>
			</tr>
		<?php 
    }
    
    /**
     * email header address preview
     */
    public function spm_admin_settings_addressheader_preview( $single_identifier, $nav )
    {
        
        if ( !isset( $nav ) || strlen( $nav ) < 3 ) {
            $nav = '';
            $to_default = '{billing-email}';
        } else {
            $nav = $nav . '_';
            $to_default = '{user-email}';
        }
        
        ?><span class="thinleek-example-div">
		<?php 
        // get options for current template
        $option_name = 'send_prebuilt_emails_' . $nav . 'thinleek_' . $single_identifier;
        $options = get_option( $option_name );
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
        // define from name
        $option_key = 'from_name';
        $from_name_valid = '';
        
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            $val = $options[$option_key];
            $from_name_valid = '<b>' . stripslashes( $val ) . '</b> • ';
        }
        
        // define from email
        $option_key = 'from_email';
        
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            $from_email_valid = $options[$option_key];
            if ( !is_email( $from_email_valid ) ) {
                $from_email_valid = get_option( 'woocommerce_email_from_address' );
            }
        } else {
            $from_email_valid = get_option( 'woocommerce_email_from_address' );
        }
        
        ?><span class="thinleek-div-header-ex"><?php 
        echo  esc_html__( 'From', 'send-prebuilt-emails' ) ;
        ?>:</span><?php 
        echo  wp_kses_post( $from_name_valid ) . esc_attr( $from_email_valid ) ;
        ?><br><?php 
        // define to email
        $option_key = 'to_email';
        $to_valid = '';
        
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            $to_valid = $options[$option_key];
            
            if ( strlen( $to_valid ) > 1 ) {
                ?><span class="thinleek-div-header-ex"><?php 
                echo  esc_html__( 'to', 'send-prebuilt-emails' ) ;
                ?>:</span><?php 
                echo  esc_attr( $to_valid ) ;
                ?><br><?php 
            } else {
                ?><span class="thinleek-div-header-ex"><?php 
                echo  esc_html__( 'to', 'send-prebuilt-emails' ) ;
                ?>:</span><?php 
                echo  esc_attr( $to_default ) ;
                ?><br><?php 
            }
        
        } else {
            ?><span class="thinleek-div-header-ex"><?php 
            echo  esc_html__( 'to', 'send-prebuilt-emails' ) ;
            ?>:</span><?php 
            echo  esc_attr( $to_default ) ;
            ?><br><?php 
        }
        
        // define reply to name
        $option_key = 'reply_to_name';
        $reply_to_name_valid = '';
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            $reply_to_name_valid = '<b>' . stripslashes( $options[$option_key] ) . '</b> • ';
        }
        // define reply to email
        $option_key = 'reply_to_email';
        $reply_to_email_valid = '';
        
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            $reply_to_email_valid = $options[$option_key];
            ?><span class="thinleek-div-header-ex"><?php 
            esc_html__( 'reply to', 'send-prebuilt-emails' );
            ?>:</span><?php 
            echo  wp_kses_post( $reply_to_name_valid ) . esc_html( $reply_to_email_valid ) ;
            ?><br><?php 
        }
        
        // define cc email
        $option_key = 'cc';
        $cc_valid = '';
        
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            $cc_valid = $options[$option_key];
            ?><span class="thinleek-div-header-ex"><?php 
            echo  esc_html__( 'cc', 'send-prebuilt-emails' ) ;
            ?>:</span><?php 
            echo  esc_html( $cc_valid ) ;
            ?><br><?php 
        }
        
        // define bcc email
        $option_key = 'bcc';
        $bcc_valid = '';
        
        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
            $bcc_valid = $options[$option_key];
            ?><span class="thinleek-div-header-ex"><?php 
            echo  esc_html__( 'bcc', 'send-prebuilt-emails' ) ;
            ?>:</span><?php 
            echo  esc_html( $bcc_valid ) ;
            ?><br><?php 
        }
        
        ?>
			</span>
			<?php 
    }
    
    /**
     * create admin template overview table
     */
    public function sendprebuiltemails_create_admin_overview_table( $nav )
    {
        
        if ( !isset( $nav ) || strlen( $nav ) < 3 ) {
            $nav_para = '';
        } else {
            $nav_para = $nav . '_';
        }
        
        ?>
		<table width="100%" border="1" style="border-collapse: collapse" class="wp-list-table widefat fixed striped table-view-list thinleek-table">
			<thead>
				<tr>
					<th style="width:65px"><?php 
        echo  esc_html__( 'Preview', 'send-prebuilt-emails' ) ;
        ?></td>
					<th class="manage-column"><?php 
        echo  esc_html__( 'Template Name', 'send-prebuilt-emails' ) ;
        ?></td>
					<th class="manage-column"><?php 
        echo  esc_html__( 'Subject', 'send-prebuilt-emails' ) ;
        ?></td>
		<?php 
        
        if ( !isset( $nav ) || strlen( $nav ) < 3 ) {
            ?><th class="manage-column"><?php 
            echo  esc_html__( 'New Order Status', 'send-prebuilt-emails' ) ;
            ?></td><?php 
        }
        
        ?>
					<th class="manage-column"></td>
				</tr>
			</thead>
		<?php 
        // get all identifiers
        $spm_advanced_settings = get_option( 'send_prebuilt_emails_thinleek_setup' );
        $all_identifiers = ( isset( $spm_advanced_settings['identifiers'] ) ? $spm_advanced_settings['identifiers'] : array() );
        $at_least_one = 0;
        foreach ( $all_identifiers as $single_identifier ) {
            // get options for current template
            $option_name = 'send_prebuilt_emails_' . $nav_para . 'thinleek_' . $single_identifier;
            $options = get_option( $option_name );
            // check if template is set up
            
            if ( !isset( $options ) ) {
                $unused_letters[] = $single_identifier;
                continue;
            }
            
            // get template name
            $key = 'name';
            $mail_template_name = ( isset( $options[$key] ) ? $options[$key] : '' );
            // get template subject
            $key = 'subject';
            $mail_template_subject = ( isset( $options[$key] ) ? $options[$key] : '' );
            // allow max 60 chars. for preview content
            if ( strlen( $mail_template_subject ) > 60 ) {
                $mail_template_subject = substr( $mail_vorlage_inhalt, 0, 60 ) . '...';
            }
            
            if ( isset( $mail_template_name ) && strlen( $mail_template_name ) > 0 ) {
                $name = 'SEND_PREBUILT_EMAILS_VERSION';
                $version = '1.0.0';
                $spm_admin_class = new Send_Prebuilt_Emails_Admin( $name, $version );
                $sendpbm_valid_feedback = $spm_admin_class->spm_is_template_valid( $single_identifier, $nav );
                $sendpbm_valid_feedback_class = '';
                $sendpbm_valid_feedback_txt = '';
                
                if ( $sendpbm_valid_feedback !== 'valid' ) {
                    $sendpbm_valid_feedback_txt = '<span class="spm-valid-fb-span">' . esc_attr( $sendpbm_valid_feedback ) . '</span>';
                    $sendpbm_valid_feedback_class = ' style="position:relative;border-left:4px solid red !important" ';
                }
                
                $at_least_one++;
                // create row for template overview
                ?>
			<tr>
				<td<?php 
                echo  wp_kses_post( $sendpbm_valid_feedback_class ) ;
                ?>><?php 
                echo  wp_kses_post( $sendpbm_valid_feedback_txt ) ;
                ?>
					<a onclick="sendprebuiltemails_ajax_preview_function('<?php 
                echo  esc_attr( $single_identifier ) ;
                ?>','last',1,'vorschau')" class="dashicons dashicons-visibility"></a>
				</td>
				<td class="name column-name has-row-actions column-primary">
					<a id="sendpbm_vorschau_name_id_<?php 
                echo  esc_attr( $single_identifier ) ;
                ?>" class="row-title" onclick="sendprebuiltemails_whichtemplate_letter('<?php 
                echo  esc_attr( $single_identifier ) ;
                ?>')"><?php 
                echo  esc_attr( stripslashes( $mail_template_name ) ) ;
                ?></a>		
				</td>
			
				<td class="column-content"><?php 
                echo  esc_html( stripslashes( $mail_template_subject ) ) ;
                ?></td><?php 
                
                if ( !isset( $nav ) || strlen( $nav ) < 3 ) {
                    $option_key = 'staus';
                    $option_value = 'no';
                    $new_status_name = '-';
                    
                    if ( $option_value !== 'no' ) {
                        $new_status = $option_value;
                        $order_statuses = wc_get_order_statuses();
                        if ( isset( $order_statuses[$new_status] ) && strlen( $order_statuses[$new_status] ) > 0 ) {
                            $new_status_name = $order_statuses[$new_status];
                        }
                    }
                    
                    ?><td class="column-content"><?php 
                    echo  esc_attr( $new_status_name ) ;
                    ?></td><?php 
                }
                
                ?>
				<td class="column-edit" align="center">
					<a onclick="sendprebuiltemails_whichtemplate_letter('<?php 
                echo  esc_attr( $single_identifier ) ;
                ?>')" class="mtopten button-secondary view-saved-tab-button"><?php 
                echo  esc_html__( 'edit', 'send-prebuilt-emails' ) ;
                ?>
					</a>

					<a id="sendpbm_vorlage_<?php 
                echo  esc_attr( $single_identifier ) ;
                ?>" onclick="ml_sendpbm_confirm('<?php 
                echo  esc_attr( $single_identifier ) ;
                ?>')" class="button-secondary view-saved-tab-button thinleek-delete-btn"><?php 
                echo  esc_html__( 'delete', 'send-prebuilt-emails' ) ;
                ?>
					</a>
					
					<form  name="sendprebuiltemails_template_delete_form" method="post">
						<input type="hidden" name="sendprebuiltemails_hidden_nav" value="<?php 
                echo  esc_attr( $nav ) ;
                ?>">
						<input type="hidden" name="sendprebuiltemails_delete_letter"  value="<?php 
                echo  esc_attr( $single_identifier ) ;
                ?>">
						<input type="hidden" name="sendprebuiltemails_delete_template" value="sendprebuiltemails_delete">
						<input type="hidden" name="action" value="sendprebuiltemails_admin_delte_template">
						<input type="submit" id="sendprebuiltemails_delete_form_submit<?php 
                echo  esc_attr( $single_identifier ) ;
                ?>" style="display:none!important">
					</form>
				</td>
			</tr><?php 
            } else {
                // store unsed template in array
                $unused_letters[] = $single_identifier;
            }
        
        }
        
        if ( $at_least_one == 0 ) {
            ?><tr>
				<td colspan=4"><?php 
            echo  esc_html__( 'No E-Mail templates created.', 'send-prebuilt-emails' ) ;
            ?></td>
			</tr><?php 
        }
        
        ?></table>
			<?php 
        // find identifier for "new tamplate"
        
        if ( isset( $unused_letters ) && sizeof( $unused_letters ) > 0 ) {
            $single_identifier = $unused_letters[0];
            ?>
			<a style="margin-top:20px" class="button button-primary" onclick="sendprebuiltemails_whichtemplate_letter('<?php 
            echo  esc_attr( $single_identifier ) ;
            ?>')"><?php 
            echo  esc_html__( 'create template', 'send-prebuilt-emails' ) ;
            ?>
			</a><?php 
        } else {
            ?>
			<a style="margin-top:20px" class="button button-primary disabled"><?php 
            echo  esc_html__( 'create template', 'send-prebuilt-emails' ) ;
            ?>
			</a>																
			
			<span class="thinleek-desc"><?php 
            echo  esc_html( sizeof( $all_identifiers ) ) . esc_html__( ' of ', 'send-prebuilt-emails' ) . esc_html( sizeof( $all_identifiers ) ) . esc_html__( ' templates created.', 'send-prebuilt-emails' ) ;
            ?>
				</span><?php 
        }
    
    }
    
    /**
     * create bulk part in advanced settings
     */
    public function sendprebuiltemails_advancesettings_bulk( $nav )
    {
        
        if ( !isset( $nav ) || strlen( $nav ) < 3 ) {
            $nav_para = '';
        } else {
            $nav_para = $nav . '_';
        }
        
        // use class
        $name = 'SEND_PREBUILT_EMAILS_VERSION';
        $version = '1.0.0';
        $spm_settings_class = new Send_Prebuilt_Emails_Settings( $name, $version );
        $class = 'bulk';
        $title = __( 'Bulk Settings', 'send-prebuilt-emails' );
        $updown = 'up';
        $border = 'no';
        $spm_settings_class->spm_admin_settings_accordeon(
            $class,
            $title,
            $updown,
            $border,
            $nav
        );
        // echo describing row for bulk actions
        ?>
		<tr class="spm_tr_part_bulk spm-lr-border">
			<th class="thinleek-th-bright"><span class="spm-desc"></span></th>
			<td class="thinleek-nopadd">
				<span class="thinleek-desc"><?php 
        echo  esc_html__( 'You can use all selected templates via order bulk action. So it is easy to send you pre-built E-Mails to 
			multiple recipients.', 'send-prebuilt-emails' ) ;
        ?>
				</span>
			</td>
		</tr>


		<tr class="spm_tr_part_bulk spm-lr-border">
			<th class="thinleek-th-bright"><?php 
        echo  esc_html__( 'Order Bulk Actions', 'send-prebuilt-emails' ) ;
        ?>
			</th><?php 
        // get advanced settings
        $admin_option_name = 'send_prebuilt_emails_' . $nav_para . 'thinleek_advanced';
        $all_advanced_settings = get_option( $admin_option_name );
        // get setup settings
        $spm_setup_settings = get_option( 'send_prebuilt_emails_thinleek_setup' );
        $all_identifiers = ( isset( $spm_setup_settings['identifiers'] ) ? $spm_setup_settings['identifiers'] : array() );
        // count loops and check if at least one template is valid for being displayed
        $at_least_one = 0;
        $count_loops = 0;
        foreach ( $all_identifiers as $single_identifier ) {
            // get options for current template
            $get_option_identifier = 'send_prebuilt_emails_' . $nav_para . 'thinleek_' . $single_identifier;
            $all_identifier_settings = get_option( $get_option_identifier );
            // continue if empty
            if ( !isset( $all_identifier_settings ) ) {
                continue;
            }
            $name = 'SEND_PREBUILT_EMAILS_VERSION';
            $version = '1.0.0';
            $spm_admin_class = new Send_Prebuilt_Emails_Admin( $name, $version );
            // check if template is valid
            $template_valid = $spm_admin_class->spm_is_template_valid( $single_identifier, $nav );
            // continue if not valid
            if ( $template_valid !== 'valid' ) {
                continue;
            }
            $count_loops++;
            $template_name = ( isset( $all_identifier_settings['name'] ) ? $all_identifier_settings['name'] : '' );
            // continue if name not korrekt
            if ( strlen( $template_name ) < 1 ) {
                continue;
            }
            $option_key = 'bulk';
            $key_two = $single_identifier;
            $admin_option_name = 'send_prebuilt_emails_' . $nav_para . 'thinleek_advanced';
            $option_name_next = $admin_option_name . '[' . $option_key . '][' . $key_two . ']';
            // check if bulk checkbox is checked
            $check_check = '';
            if ( isset( $all_advanced_settings[$option_key][$key_two] ) && strlen( $all_advanced_settings[$option_key][$key_two] ) > 0 ) {
                $check_check = ' checked';
            }
            //first loop only has one column
            
            if ( $count_loops == 1 ) {
                $at_least_one = 1;
                ?>
					<td>
						<input value="checked" name="<?php 
                echo  esc_attr( $option_name_next ) ;
                ?>" type="checkbox"<?php 
                echo  esc_attr( $check_check ) ;
                ?>><?php 
                echo  esc_html__( 'Template "', 'send-prebuilt-emails' ) . esc_html( stripslashes( $template_name ) ) . esc_html__( '" to Bulk Action', 'send-prebuilt-emails' ) ;
                ?>
					</td>
				</tr><?php 
            } else {
                ?>
				<tr class="spm_tr_part_bulk spm-lr-border">
					<th class="thinleek-th-bright"></th>
					<td>
						<input value="checked" name="<?php 
                echo  esc_attr( $option_name_next ) ;
                ?>" type="checkbox"<?php 
                echo  esc_attr( $check_check ) ;
                ?>><?php 
                echo  esc_html__( 'Template "', 'send-prebuilt-emails' ) . esc_html( stripslashes( $template_name ) ) . esc_html__( '" to Bulk Actions', 'send-prebuilt-emails' ) ;
                ?>
					</td>
				</tr><?php 
            }
        
        }
        // display empty column if no bulk action is valid for selection
        
        if ( $at_least_one == 0 ) {
            ?><td><?php 
            echo  esc_html__( 'Your created templates will be listet here.', 'send-prebuilt-emails' ) ;
            ?>
					</td>
				</tr><?php 
        }
    
    }
    
    /**
     * settings input field
     */
    public function spm_admin_settings_fields(
        $val,
        $name,
        $class,
        $single_identifier,
        $display,
        $nav
    )
    {
        
        if ( isset( $nav ) && strlen( $nav ) > 1 ) {
            $nav_para = $nav . '_';
        } else {
            $nav_para = '';
        }
        
        // name class to make javascript display toggle work
        $class_name = 'spm-lr-border spm_tr_part_' . $class;
        // get settings for template
        $option_name = 'send_prebuilt_emails_' . $nav_para . 'thinleek_' . $single_identifier;
        $options = get_option( $option_name );
        $option_value = ( isset( $options[$val] ) ? $options[$val] : '' );
        // add description to "to_email" or "heading"
        $default_toaddress = '';
        
        if ( $val === 'to_email' && $nav === 'user' ) {
            $default_toaddress = '<span class="thinleek-desc">' . __( 'default: user E-Mail', 'send-prebuilt-emails' ) . '</span>';
        } else {
            
            if ( $val === 'to_email' ) {
                $default_toaddress = '<span class="thinleek-desc">' . __( 'default: customer billing E-Mail', 'send-prebuilt-emails' ) . '</span>';
            } else {
                if ( $val === 'heading' ) {
                    $default_toaddress = '<span class="thinleek-desc">' . __( 'default: subject of this template', 'send-prebuilt-emails' ) . '</span>';
                }
            }
        
        }
        
        // echo row
        ?><tr style="display:<?php 
        echo  esc_attr( $display ) ;
        ?>" class="<?php 
        echo  esc_attr( $class_name ) ;
        ?>">
			<th class="thinleek-th-bright"><?php 
        echo  esc_attr( $name ) ;
        ?>
		<?php 
        // add link to faq because from email settings can be overridden by wp mail smtp
        
        if ( $val === 'from_email' ) {
            ?><span class="spm-desc">
					<a tabindex="-1" href="https://thinleek-plugins.com/en/docs/send-pre-built-emails/faq/#faq5" target="_blank"><?php 
            echo  esc_html__( 'Information', 'send-prebuilt-emails' ) ;
            ?>
					</a>
				</span><?php 
        }
        
        ?></th>
			<td><input class="thinleek-fullwidth" type="text" name="<?php 
        echo  esc_attr( $option_name ) ;
        ?>[<?php 
        echo  esc_attr( stripslashes( $val ) ) ;
        ?>]" value="<?php 
        echo  esc_attr( stripslashes( $option_value ) ) ;
        ?>" autocomplete="nope"><?php 
        echo  wp_kses_post( $default_toaddress ) ;
        ?></td>
		</tr><?php 
    }
    
    /**
     * select field with all active templates set up
     */
    public function spm_admin_select_templates( $send_identifier, $nav )
    {
        
        if ( !isset( $nav ) || strlen( $nav ) < 3 ) {
            $nav_para = '';
        } else {
            $nav_para = $nav . '_';
        }
        
        // if no identifier use "a"
        if ( !isset( $send_identifier ) ) {
            $send_identifier = 'a';
        }
        $unused_count = 0;
        // get identifiers
        $spm_advanced_settings = get_option( 'send_prebuilt_emails_thinleek_setup' );
        $all_identifiers = ( isset( $spm_advanced_settings['identifiers'] ) ? $spm_advanced_settings['identifiers'] : array() );
        ?><select id="sendprebuiltemails-select-id" name="sendprebuiltemails_formsubmit_activletter" onchange="sendprebuiltemails_whichtemplate()"><?php 
        
        if ( $send_identifier == 'choose' ) {
            ?><option value="choose" selected><?php 
            echo  esc_html__( 'choose E-Mail Template', 'send-prebuilt-emails' ) ;
            ?> …</option><?php 
        } else {
            ?><option value="choose"><?php 
            echo  esc_html__( 'choose E-Mail Template', 'send-prebuilt-emails' ) ;
            ?> …</option><?php 
        }
        
        foreach ( $all_identifiers as $single_identifier ) {
            // check if option has to be selected
            $selectcheck = '';
            if ( $send_identifier == $single_identifier ) {
                $selectcheck = ' selected';
            }
            // get options of current template
            $option_name = 'send_prebuilt_emails_' . $nav_para . 'thinleek_' . $single_identifier;
            $options = get_option( $option_name );
            // continue if no option found
            
            if ( !isset( $options ) ) {
                $unused_letters[] = $single_identifier;
                continue;
            }
            
            // get template name
            $key = 'name';
            $mail_template = ( isset( $options[$key] ) ? $options[$key] : '' );
            // echo option for select if template name is correct
            
            if ( strlen( $mail_template ) > 0 ) {
                ?><option value="<?php 
                echo  esc_attr( $single_identifier ) ;
                ?>"<?php 
                echo  esc_attr( $selectcheck ) ;
                ?>><?php 
                echo  esc_attr( stripslashes( $mail_template ) ) ;
                ?></option><?php 
            } else {
                $unused_count++;
                $unused_letters[] = $single_identifier;
            }
        
        }
        // if there are availubale templates to add show add new (five templates in free version)
        
        if ( $unused_count > 0 ) {
            ?><option value="<?php 
            echo  esc_attr( $unused_letters[0] ) ;
            ?>">+ <?php 
            echo  esc_html__( 'new template', 'send-prebuilt-emails' ) ;
            ?></option><?php 
        }
        
        ?></select>
		<?php 
    }
    
    /**
     * display selected placeholders in admin settings
     */
    public function sendprebuiltemails_display_selected_placeholders( $nav )
    {
        
        if ( !isset( $nav ) || strlen( $nav ) < 3 ) {
            $nav_para = '';
        } else {
            $nav_para = $nav . '_';
        }
        
        // get all placeholder from wp_options
        $spm_advanced_settings_adv = get_option( 'send_prebuilt_emails_' . $nav_para . 'thinleek_advanced' );
        
        if ( isset( $spm_advanced_settings_adv['placeholder'] ) ) {
            $placeholders = $spm_advanced_settings_adv['placeholder'];
            if ( isset( $placeholders ) && is_countable( $placeholders ) && sizeof( $placeholders ) > 0 ) {
                foreach ( $placeholders as $placeholder ) {
                    
                    if ( isset( $placeholder ) && strlen( $placeholder ) > 0 ) {
                        // echo buttons to copy placeholder in template edit page
                        ?>
					<input value="{<?php 
                        echo  esc_attr( $placeholder ) ;
                        ?>}" onclick="sendprebuiltemails_copy(this)" 
					type="text" class="ed_button button button-small spm-placeholder"><?php 
                    }
                
                }
            }
        }
    
    }
    
    /**
     * Function to find wc disabled mail
     */
    public function sendprebuiltemails_disable_wc_mail_option_function( $identifier, $new_status )
    {
        $option_name = 'send_prebuilt_emails_thinleek_' . $identifier;
        $options = get_option( $option_name );
        // get all order status
        $order_statuses = wc_get_order_statuses();
        foreach ( $order_statuses as $status_slug => $status_name ) {
            $change_slug = str_replace( 'wc-', 'customer_', $status_slug );
            $change_slug = str_replace( '-', '_', $change_slug );
            $change_slug = $change_slug . '_order';
            $wc_email_status_id[$status_slug] = $change_slug;
        }
        $already_echo = 'no';
        
        if ( $new_status === 'no' ) {
            echo  esc_attr( __( 'No "new order status" selected.', 'send-prebuilt-emails' ) ) ;
            ?>
		<span class="thinleek-desc" style="margin-top:10px"><?php 
            echo  esc_html__( 'If you select a new order status Send Prebuilt E-Mails will check if it is possible to disable the woocommerce 
			standard E-Mail for this status.', 'send-prebuilt-emails' ) ;
            ?>
		</span>
		<?php 
            $already_echo = 'yes';
        } else {
            
            if ( $new_status !== 'no' ) {
                $new_mail_to_disable = ( isset( $wc_email_status_id[$new_status] ) ? $wc_email_status_id[$new_status] : '' );
                
                if ( isset( $new_mail_to_disable ) && strlen( $new_mail_to_disable ) > 0 ) {
                    $wc_emails = wc()->mailer()->emails;
                    foreach ( $wc_emails as $mail_key => $mail_value ) {
                        $wc_email_id = $mail_value->id;
                        $all_wc_emails[] = $wc_email_id;
                    }
                }
                
                if ( isset( $new_mail_to_disable ) && strlen( $new_mail_to_disable ) > 0 ) {
                    
                    if ( isset( $wc_email_status_id[$new_status] ) && in_array( $wc_email_status_id[$new_status], $all_wc_emails ) ) {
                        $cb_disabled = '';
                        $option_key = 'disablemail';
                        $option_name_next = $option_name . '[' . $option_key . ']';
                        $check_check = '';
                        if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
                            $check_check = 'checked';
                        }
                        ?>
			<input value="checked" name="<?php 
                        echo  esc_attr( $option_name_next ) ;
                        ?>" type="checkbox"<?php 
                        echo  esc_attr( $check_check ) . esc_attr( $cb_disabled ) ;
                        ?>><?php 
                        echo  esc_html__( 'disable woocommerce', 'send-prebuilt-emails' ) ;
                        ?> "<?php 
                        echo  esc_attr( $wc_email_status_id[$new_status] ) ;
                        ?>" <?php 
                        echo  esc_html__( 'E-Mail after sending this pre-built E-Mail', 'send-prebuilt-emails' ) ;
                        ?>
			<span class="thinleek-desc" style="margin-top:10px"><?php 
                        echo  esc_html__( 'The standard woocommerce E-Mail', 'send-prebuilt-emails' ) ;
                        ?> "<?php 
                        echo  esc_attr( $wc_email_status_id[$new_status] ) ;
                        ?>
				" <?php 
                        echo  esc_html__( 'is disabled if the order status will be changed while sending this pre-built E-Mail. 
				If the order status is changed otherwise the standard woocommerce E-Mail will be send.', 'send-prebuilt-emails' ) ;
                        ?>
			</span>
			<?php 
                        $already_echo = 'yes';
                    }
                
                }
            }
        
        }
        
        
        if ( $already_echo === 'no' ) {
            // if no echo echo disabled version
            $option_name = 'send_prebuilt_emails_thinleek_' . $identifier;
            $option_key = '';
            $option_name_next = '';
            $check_check = '';
            $cb_disabled = ' disbaled';
            echo  esc_html__( 'not possible to disable woocommerce standard E-Mail for selected status', 'send-prebuilt-emails' ) ;
            ?>
			<span class="thinleek-desc" style="margin-top:10px"><?php 
            echo  esc_html__( 'Two possible reasons:<br>1. there is no woocommerce standard E-Mail for the selected new order status<br>
				2. no support from Send Prebuilt E-Mails for the selected order status E-Mail', 'send-prebuilt-emails' ) ;
            ?>
			</span>
			<?php 
        }
    
    }
    
    /**
     * Action to find wc disabled mail
     */
    public function sendprebuiltemails_disable_wc_mail_option_action()
    {
        
        if ( !isset( $_POST['identifier'] ) || !isset( $_POST['new_status'] ) ) {
            echo  esc_html__( 'No "new order status" selected.', 'send-prebuilt-emails' ) ;
            ?>
			<span class="thinleek-desc" style="margin-top:10px"><?php 
            echo  esc_html__( 'If you select a new order status Send Prebuilt E-Mails will check if it is possible to disable the woocommerce 
				standard E-Mail for this status.', 'send-prebuilt-emails' ) ;
            ?>
			</span>
			<?php 
            echo  esc_html( '__spm__disabled' ) ;
            wp_die();
        }
        
        $identifier = ( isset( $_POST['identifier'] ) ? sanitize_text_field( $_POST['identifier'] ) : '' );
        $new_status = ( isset( $_POST['new_status'] ) ? sanitize_text_field( $_POST['new_status'] ) : '' );
        $option_name = 'send_prebuilt_emails_thinleek_' . $identifier;
        $options = get_option( $option_name );
        // set disable E-Mail checkbox to unchecked to prevent changes "by accident"
        $options['disablemail'] = '';
        // update settings
        update_option( $option_name, $options );
        // get all order status
        $order_statuses = wc_get_order_statuses();
        foreach ( $order_statuses as $status_slug => $status_name ) {
            $change_slug = str_replace( 'wc-', 'customer_', $status_slug );
            $change_slug = str_replace( '-', '_', $change_slug );
            $change_slug = $change_slug . '_order';
            $wc_email_status_id[$status_slug] = $change_slug;
        }
        // check if mail fitting to status
        
        if ( $new_status === 'no' ) {
            echo  esc_html__( 'No "new order status" selected.', 'send-prebuilt-emails' ) ;
            ?>
		<span class="thinleek-desc" style="margin-top:10px"><?php 
            echo  esc_html__( 'If you select a new order status Send Prebuilt E-Mails will check if it is possible to disable the woocommerce 
			standard E-Mail for this status.', 'send-prebuilt-emails' ) ;
            ?>
		</span>
		<?php 
            echo  esc_attr( '__spm__disabled' ) ;
            wp_die();
        } else {
            
            if ( $new_status !== 'no' ) {
                $new_mail_to_disable = ( isset( $wc_email_status_id[$new_status] ) ? $wc_email_status_id[$new_status] : '' );
                
                if ( isset( $new_mail_to_disable ) && strlen( $new_mail_to_disable ) > 0 ) {
                    $wc_emails = wc()->mailer()->emails;
                    foreach ( $wc_emails as $mail_key => $mail_value ) {
                        $wc_email_id = $mail_value->id;
                        $all_wc_emails[] = $wc_email_id;
                    }
                }
                
                if ( isset( $new_mail_to_disable ) && strlen( $new_mail_to_disable ) > 0 ) {
                    
                    if ( in_array( $wc_email_status_id[$new_status], $all_wc_emails ) ) {
                        $option_name = 'send_prebuilt_emails_thinleek_' . $identifier;
                        $option_key = 'disablemail';
                        $option_name_next = $option_name . '[' . $option_key . ']';
                        $check_check = '';
                        $cb_disabled = '';
                        ?>
			<input value="checked" name="<?php 
                        echo  esc_attr( $option_name_next ) ;
                        ?>" type="checkbox"<?php 
                        echo  esc_attr( $check_check ) . esc_attr( $cb_disabled ) ;
                        ?>><?php 
                        echo  esc_html__( 'disable woocommerce', 'send-prebuilt-emails' ) ;
                        ?> "<?php 
                        echo  esc_attr( $wc_email_status_id[$new_status] ) ;
                        ?>" <?php 
                        echo  esc_html__( 'E-Mail after sending this pre-built E-Mail', 'send-prebuilt-emails' ) ;
                        ?>
			<span class="thinleek-desc" style="margin-top:10px"><?php 
                        echo  esc_html__( 'The standard woocommerce E-Mail', 'send-prebuilt-emails' ) ;
                        ?> "<?php 
                        echo  esc_html( $wc_email_status_id[$new_status] ) ;
                        ?>
				" <?php 
                        echo  esc_html__( 'is disabled if the order status will be changed while sending this pre-built E-Mail. 
				If the order status is changed otherwise the standard woocommerce E-Mail will be send.', 'send-prebuilt-emails' ) ;
                        ?>
			</span>
			<?php 
                        echo  esc_html( '__spm__true' ) ;
                        wp_die();
                    }
                
                }
            }
        
        }
        
        // if no echo echo disabled version
        $option_name = 'send_prebuilt_emails_thinleek_' . $identifier;
        $option_key = '';
        $option_name_next = '';
        $check_check = '';
        $cb_disabled = ' disbaled';
        echo  esc_html__( 'not possible to disable woocommerce standard E-Mail for selected status', 'send-prebuilt-emails' ) ;
        ?>
			<span class="thinleek-desc" style="margin-top:10px"><?php 
        echo  esc_html__( 'Two possible reasons:<br>1. there is no woocommerce standard E-Mail for the selected new order status<br>
				2. no support from Send Prebuilt E-Mails for the selected order status E-Mail', 'send-prebuilt-emails' ) ;
        ?>
			</span>
			<?php 
        echo  esc_html( '__spm__disabled' ) ;
        wp_die();
    }
    
    /**
     * Action to save admin settings
     */
    public function sendprebuiltemails_save_admin_settings()
    {
        // use settings class
        $name = 'SEND_PREBUILT_EMAILS_VERSION';
        $version = '1.0.0';
        $spm_pulic_class = new Send_Prebuilt_Emails_Settings( $name, $version );
        // check if submitbutton name is send
        
        if ( isset( $_POST['sendprebuiltemails_einstellungen_submit'] ) && $_POST['sendprebuiltemails_einstellungen_submit'] == 'sendprebuiltemails_save' ) {
            
            if ( !isset( $_POST['sendprebuiltemails_hidden_nav'] ) || strlen( $_POST['sendprebuiltemails_hidden_nav'] ) < 3 ) {
                $nav_para = '';
                $nav = '';
            } else {
                $nav_para_post = ( isset( $_POST['sendprebuiltemails_hidden_nav'] ) ? sanitize_text_field( $_POST['sendprebuiltemails_hidden_nav'] ) : '' );
                $nav_para = $nav_para_post . '_';
                $nav = $nav_para_post;
            }
            
            // get setup options
            $spm_advanced_settings = get_option( 'send_prebuilt_emails_thinleek_setup' );
            $all_identifiers = ( isset( $spm_advanced_settings['identifiers'] ) ? $spm_advanced_settings['identifiers'] : array() );
            // array to check doubled values
            $doubled_check_array = array();
            foreach ( $all_identifiers as $single_identifier ) {
                // get all values for current identifier from form
                $option_name = 'send_prebuilt_emails_' . $nav_para . 'thinleek_' . $single_identifier;
                if ( !isset( $_POST[$option_name] ) ) {
                    continue;
                }
                $template_name = ( isset( $_POST[$option_name]['name'] ) ? sanitize_text_field( $_POST[$option_name]['name'] ) : '' );
                // dont allow doubled values
                if ( strlen( $template_name ) > 0 ) {
                    
                    if ( !in_array( strtoupper( $template_name ), $doubled_check_array ) ) {
                        $doubled_check_array[] = strtoupper( $template_name );
                    } else {
                        $template_name = $template_name . ' copy';
                    }
                
                }
                // Removes special chars.
                $template_name = preg_replace( '/[^A-Za-z0-9\\- ]/', '', $template_name );
                // Allow max 40 chars.
                if ( strlen( $template_name ) > 40 ) {
                    $template_name = substr( $template_name, 0, 40 );
                }
                // update name
                $values_to_update['name'] = $template_name;
                $from_to = array(
                    'from_email',
                    'to_email',
                    'reply_to_email',
                    'cc',
                    'bcc'
                );
                foreach ( $from_to as $part ) {
                    // sanitize subject
                    $to_sanitize = ( isset( $_POST[$option_name][$part] ) ? sanitize_text_field( $_POST[$option_name][$part] ) : '' );
                    // replace spaces
                    $to_sanitize = str_replace( ' ', '', $to_sanitize );
                    if ( strlen( $to_sanitize ) > 1000 ) {
                        $to_sanitize = substr( $to_sanitize, 0, 1000 );
                    }
                    // allow {placeholders}
                    
                    if ( strpos( $to_sanitize, '{' ) > -1 && strpos( $to_sanitize, '}' ) > -1 ) {
                        $values_to_update[$part] = $to_sanitize;
                    } else {
                        
                        if ( is_email( $to_sanitize ) ) {
                            // if it is not a placeholder allow only valid emails
                            $values_to_update[$part] = sanitize_email( $to_sanitize );
                        } else {
                            // save empty value
                            $values_to_update[$part] = '';
                        }
                    
                    }
                
                }
                $from_to_names = array( 'from_name', 'reply_to_name' );
                foreach ( $from_to_names as $part ) {
                    // sanitize names
                    $to_sanitize = ( isset( $_POST[$option_name][$part] ) ? sanitize_text_field( $_POST[$option_name][$part] ) : '' );
                    if ( strlen( $to_sanitize ) > 100 ) {
                        $to_sanitize = substr( $to_sanitize, 0, 100 );
                    }
                    // allow {placeholders}
                    
                    if ( strpos( $to_sanitize, '{' ) > -1 && strpos( $to_sanitize, '}' ) > -1 ) {
                        $values_to_update[$part] = $to_sanitize;
                    } else {
                        // allow letters, numbers and spaces if it is not a placeholder
                        $values_to_update[$part] = preg_replace( '/[^a-zA-Z0-9\\s]/', '', $to_sanitize );
                    }
                
                }
                // sanitize subject
                $to_sanitize = ( isset( $_POST[$option_name]['subject'] ) ? sanitize_text_field( $_POST[$option_name]['subject'] ) : '' );
                if ( strlen( $to_sanitize ) > 200 ) {
                    $to_sanitize = substr( $to_sanitize, 0, 200 );
                }
                $values_to_update['subject'] = $to_sanitize;
                // sanitize heading
                $to_sanitize = ( isset( $_POST[$option_name]['heading'] ) ? sanitize_text_field( $_POST[$option_name]['heading'] ) : '' );
                if ( strlen( $to_sanitize ) > 300 ) {
                    $to_sanitize = substr( $to_sanitize, 0, 300 );
                }
                $values_to_update['heading'] = $to_sanitize;
                // sanitize content
                $option_name_extra = $option_name . '_content';
                $option_value_extra = ( isset( $_POST[$option_name_extra] ) ? wp_kses_post( $_POST[$option_name_extra] ) : '' );
                if ( strlen( $option_value_extra ) > 10000 ) {
                    $option_value_extra = substr( $option_value_extra, 0, 10000 );
                }
                $values_to_update['content'] = $option_value_extra;
                // sanitize content_two
                $option_name_extra = $option_name . '_contenttwo';
                $option_value_extra = ( isset( $_POST[$option_name_extra] ) ? wp_kses_post( $_POST[$option_name_extra] ) : '' );
                if ( strlen( $option_value_extra ) > 10000 ) {
                    $option_value_extra = substr( $option_value_extra, 0, 10000 );
                }
                $values_to_update['contenttwo'] = $option_value_extra;
                // sanitize orderdetails
                $to_sanitize = ( isset( $_POST[$option_name]['orderdetails'] ) ? sanitize_text_field( $_POST[$option_name]['orderdetails'] ) : '' );
                // allow only one value: orderdetails
                if ( $to_sanitize !== 'orderdetails' ) {
                    $to_sanitize = '';
                }
                $values_to_update['orderdetails'] = $to_sanitize;
                // sanitize address
                $to_sanitize = ( isset( $_POST[$option_name]['address'] ) ? sanitize_text_field( $_POST[$option_name]['address'] ) : '' );
                // allow only one value: address
                if ( $to_sanitize !== 'address' ) {
                    $to_sanitize = '';
                }
                $values_to_update['address'] = $to_sanitize;
                // sanitize footer
                $to_sanitize = ( isset( $_POST[$option_name]['footer'] ) ? sanitize_text_field( $_POST[$option_name]['footer'] ) : '' );
                // allow only one value: footer
                if ( $to_sanitize !== 'footer' ) {
                    $to_sanitize = '';
                }
                if ( strlen( $to_sanitize ) > 100 ) {
                    $to_sanitize = substr( $to_sanitize, 0, 100 );
                }
                $values_to_update['footer'] = $to_sanitize;
                // sanitize attachment_a
                $to_sanitize = ( isset( $_POST[$option_name]['attachment_a'] ) ? sanitize_text_field( $_POST[$option_name]['attachment_a'] ) : '' );
                if ( strlen( $to_sanitize ) > 2000 ) {
                    $to_sanitize = substr( $to_sanitize, 0, 2000 );
                }
                $values_to_update['attachment_a'] = str_replace( ' ', '', $to_sanitize );
                // sanitize attachment_b
                $to_sanitize = ( isset( $_POST[$option_name]['attachment_b'] ) ? sanitize_text_field( $_POST[$option_name]['attachment_b'] ) : '' );
                if ( strlen( $to_sanitize ) > 2000 ) {
                    $to_sanitize = substr( $to_sanitize, 0, 2000 );
                }
                $values_to_update['attachment_b'] = str_replace( ' ', '', $to_sanitize );
                // sanitize attachment_c
                $to_sanitize = ( isset( $_POST[$option_name]['attachment_c'] ) ? sanitize_text_field( $_POST[$option_name]['attachment_c'] ) : '' );
                if ( strlen( $to_sanitize ) > 2000 ) {
                    $to_sanitize = substr( $to_sanitize, 0, 2000 );
                }
                $values_to_update['attachment_c'] = str_replace( ' ', '', $to_sanitize );
                // sanitize status
                $to_sanitize = ( isset( $_POST[$option_name]['status'] ) ? sanitize_text_field( $_POST[$option_name]['status'] ) : '' );
                if ( strlen( $to_sanitize ) > 2000 ) {
                    $to_sanitize = substr( $to_sanitize, 0, 2000 );
                }
                $values_to_update['status'] = $to_sanitize;
                // sanitize disablemail
                $to_sanitize = ( isset( $_POST[$option_name]['disablemail'] ) ? sanitize_text_field( $_POST[$option_name]['disablemail'] ) : '' );
                if ( strlen( $to_sanitize ) > 2000 ) {
                    $to_sanitize = substr( $to_sanitize, 0, 2000 );
                }
                $values_to_update['disablemail'] = $to_sanitize;
                // delete template settings if template name doesnt exist
                
                if ( !isset( $_POST[$option_name]['name'] ) ) {
                    delete_option( $option_name );
                    continue;
                } else {
                    
                    if ( strlen( $_POST[$option_name]['name'] ) < 1 ) {
                        delete_option( $option_name );
                        continue;
                    }
                
                }
                
                // update settings
                update_option( $option_name, $values_to_update );
            }
        }
        
        // define selected template after ajax form submit
        $active_send_identifier = 'a';
        
        if ( isset( $_POST['sendprebuiltemails_formsubmit_activletter'] ) ) {
            // get active identifier from formsubmit
            $post_get_activletter = ( isset( $_POST['sendprebuiltemails_formsubmit_activletter'] ) ? sanitize_text_field( $_POST['sendprebuiltemails_formsubmit_activletter'] ) : '' );
            $active_send_identifier = $post_get_activletter;
        }
        
        // send back updated html for select mail template
        echo  wp_kses_post( $spm_pulic_class->spm_admin_select_templates( $active_send_identifier, $nav ) ) ;
        // send back unique text to split response
        echo  esc_html( 'sendprebuiltemails_split_response_njJKdjkNJK' ) ;
        // send back updated html for admin template overview table
        echo  wp_kses_post( $spm_pulic_class->sendprebuiltemails_create_admin_overview_table( $nav ) ) ;
        // send back unique text to split response
        echo  esc_html( 'sendprebuiltemails_split_response_njJKdjkNJK' ) ;
        // send back updated html for advanced bulk settings
        echo  wp_kses_post( $spm_pulic_class->sendprebuiltemails_advancesettings_bulk( $nav ) ) ;
        $spm_advanced_settings = get_option( 'send_prebuilt_emails_thinleek_setup' );
        $all_identifiers = ( isset( $spm_advanced_settings['identifiers'] ) ? $spm_advanced_settings['identifiers'] : array() );
        foreach ( $all_identifiers as $single_identifier ) {
            // send back unique text to split response
            echo  esc_html( 'sendprebuiltemails_split_response_njJKdjkNJK' ) ;
            // send back updated html for address settings
            echo  wp_kses_post( $spm_pulic_class->spm_admin_settings_addressheader_preview( $single_identifier, $nav ) ) ;
        }
        wp_die();
    }
    
    /**
     * Action to save advanced admin settings
     */
    public function sendprebuiltemails_save_admin_adv_settings()
    {
        // check if submitbutton name is send
        
        if ( isset( $_POST['sendprebuiltemails_adv_einstellungen_submit'] ) && $_POST['sendprebuiltemails_adv_einstellungen_submit'] == 'sendprebuiltemails_adv_save' ) {
            
            if ( !isset( $_POST['sendprebuiltemails_hidden_nav'] ) || strlen( $_POST['sendprebuiltemails_hidden_nav'] ) < 3 ) {
                $nav_para = '';
                $nav = '';
            } else {
                $nav_para_post = ( isset( $_POST['sendprebuiltemails_hidden_nav'] ) ? sanitize_text_field( $_POST['sendprebuiltemails_hidden_nav'] ) : '' );
                $nav_para = $nav_para_post . '_';
                $nav = $nav_para_post;
            }
            
            // get data from form
            $spm_advanced_settings_name = 'send_prebuilt_emails_' . $nav_para . 'thinleek_advanced';
            
            if ( isset( $_POST[$spm_advanced_settings_name] ) ) {
                
                if ( isset( $_POST[$spm_advanced_settings_name]['placeholder'] ) ) {
                    $placeholder_array = ( isset( $_POST[$spm_advanced_settings_name]['placeholder'] ) ? array_map( 'sanitize_text_field', $_POST[$spm_advanced_settings_name]['placeholder'] ) : array() );
                    if ( isset( $placeholder_array ) && sizeof( $placeholder_array ) > 0 ) {
                        foreach ( $placeholder_array as $option_key => $option_val ) {
                            if ( strlen( $option_val ) > 300 ) {
                                $option_val = substr( $option_val, 0, 300 );
                            }
                            $values_to_update['placeholder'][$option_key] = str_replace( ' ', '', sanitize_text_field( $option_val ) );
                        }
                    }
                }
                
                
                if ( isset( $_POST[$spm_advanced_settings_name]['default']['placeholder'] ) ) {
                    $to_sanitize = ( isset( $_POST[$spm_advanced_settings_name]['default']['placeholder'] ) ? sanitize_text_field( $_POST[$spm_advanced_settings_name]['default']['placeholder'] ) : '' );
                    if ( strlen( $to_sanitize ) > 300 ) {
                        $to_sanitize = substr( $to_sanitize, 0, 300 );
                    }
                    $values_to_update['default']['placeholder'] = $to_sanitize;
                }
                
                
                if ( isset( $_POST[$spm_advanced_settings_name]['bulk'] ) ) {
                    $bulk_loop = ( isset( $_POST[$spm_advanced_settings_name]['bulk'] ) ? array_map( 'sanitize_text_field', $_POST[$spm_advanced_settings_name]['bulk'] ) : array() );
                    foreach ( $bulk_loop as $letter => $checked ) {
                        // letter only allowed one letter or 'plain'
                        if ( strlen( $letter ) == 1 || $letter == 'plain' ) {
                            // only allowed if value = 'checked'
                            
                            if ( $checked == 'checked' ) {
                                $values_to_update['bulk'][$letter] = 'checked';
                            } else {
                                $values_to_update['bulk'][$letter] = '';
                            }
                        
                        }
                    }
                }
                
                // update settings
                update_option( $spm_advanced_settings_name, $values_to_update );
            }
        
        }
        
        // get the class
        $name = 'SEND_PREBUILT_EMAILS_VERSION';
        $version = '1.0.0';
        $spm_settings_class = new Send_Prebuilt_Emails_Settings( $name, $version );
        // send back updated selected placeholder for edit mail templates
        echo  wp_kses_post( $spm_settings_class->sendprebuiltemails_display_selected_placeholders( $nav ) ) ;
        wp_die();
    }
    
    /**
     * action to delete send prebuilt emails template
     *
     * delte wp_option that include the selected template information
     */
    public function sendprebuiltemails_admin_delte_template()
    {
        // check if submitbutton name is send
        $submittbutton = ( isset( $_POST['sendprebuiltemails_delete_template'] ) ? sanitize_text_field( $_POST['sendprebuiltemails_delete_template'] ) : '' );
        
        if ( $submittbutton == 'sendprebuiltemails_delete' ) {
            $hiddennav = ( isset( $_POST['sendprebuiltemails_hidden_nav'] ) ? sanitize_text_field( $_POST['sendprebuiltemails_hidden_nav'] ) : '' );
            
            if ( strlen( $hiddennav ) < 3 ) {
                $nav_para = '';
            } else {
                $nav_para = $hiddennav . '_';
            }
            
            // get identifier to delete from form
            $delete_identifier = ( isset( $_POST['sendprebuiltemails_delete_letter'] ) ? sanitize_text_field( $_POST['sendprebuiltemails_delete_letter'] ) : '' );
            
            if ( strlen( $delete_identifier ) == 1 ) {
                // delete it
                $option_name = 'send_prebuilt_emails_' . $nav_para . 'thinleek_' . $delete_identifier;
                delete_option( $option_name );
            }
            
            // send feedback
            echo  esc_html( 'success' ) ;
        }
    
    }

}
// END class