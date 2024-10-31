<?php

/**
 * Admin Settings Page
 */
// get settings class
$name = 'SEND_PREBUILT_EMAILS_VERSION';
$version = '1.0.0';
$spm_settings_class = new Send_Prebuilt_Emails_Settings( $name, $version );
$spm_advanced_settings = get_option( 'send_prebuilt_emails_thinleek_setup' );
$all_identifiers = ( isset( $spm_advanced_settings['identifiers'] ) ? $spm_advanced_settings['identifiers'] : array() );
?>		
	<div class="wrap">
		<h2><?php 
echo  esc_html__( 'Prebuilt E-Mails for Orders', 'send-prebuilt-emails' ) ;
?>
		</h2>
	</div> 

	<header role="tablist" aria-label="Einstellungen Abschnitte" class="nav-tab-wrapper">
		<button onclick="mlarea(this.id)" type="button" role="tab" class="ml-nav-tabs nav-tab nav-tab-active" aria-selected="true" aria-controls="templates-tab-area" id="templates-btn"><?php 
echo  esc_html__( 'Templates', 'send-prebuilt-emails' ) ;
?>
		</button>
		
		<button onclick="sendprebuiltemails_whichtemplate_letter('choose');mlarea(this.id)" type="button" role="tab" class="ml-nav-tabs nav-tab" aria-selected="false" aria-controls="edit-tab-area" id="edit-btn" tntabindex="-1"><?php 
echo  esc_html__( 'edit Templates', 'send-prebuilt-emails' ) ;
?> 
		</button>
		
		
		<button onclick="mlarea(this.id)" type="button" role="tab" class="ml-nav-tabs nav-tab" aria-selected="false" aria-controls="advanced-tab-area" id="advanced-btn" tabindex="-1"><?php 
echo  esc_html__( 'Advanced', 'send-prebuilt-emails' ) ;
?>
		</button>
	</header><?php 
/** 
 * Section: Templates 
 */
?>
	<section tabindex="0" role="tabpanel" id="templates-btn-section" class="ml-nav-tabs-section wrap">
		<div class="wrap" style="max-width:1000px">
			<h2><?php 
echo  esc_html__( 'Templates', 'send-prebuilt-emails' ) ;
?>
			</h2>	
				
			<div id="spm_table_template_overview_progress_id" style="margin-top:30px"></div>
	
			<div id="spm_overview_table_herein_div"><?php 
/**
 * display template table
 */
echo  wp_kses_post( $spm_settings_class->sendprebuiltemails_create_admin_overview_table( 0 ) ) ;
?>
			</div>
		</div>
	</section><?php 
/**
 * Section: Edit Templates
 */
?>
	<section tabindex="0" role="tabpanel" id="edit-btn-section" class="ml-nav-tabs-section wrap" style="display:none">
		<div class="wrap thinleek-setting-wrap" style="max-width:1000px">
			<h2 style="margin-bottom:30px"><?php 
echo  esc_html__( 'edit E-Mail template', 'send-prebuilt-emails' ) ;
?>
			</h2>	


<form name="spm_admin_settings_form" method="post">

	<table class="form-table thinleek-table" role="presentation" style="margin-bottom:0px!important">

		<tr id="spm_tr_choose_template_id" class="spm-tr-part-template" style="border-top:1px solid #cdcdcd !important">
			<th class="thinleek-th-bright"><?php 
echo  esc_html__( 'Choose template', 'send-prebuilt-emails' ) ;
?>
			</th>
			
			<td id="spm_selecttemplete_select_id"><?php 
/**
 * display select for template selection
 */
echo  wp_kses_post( $spm_settings_class->spm_admin_select_templates( 'choose', 0 ) ) ;
?>
			</td>
		</tr>
	</table><?php 
/**
 * create options form
 */
foreach ( $all_identifiers as $single_identifier ) {
    $option_name = 'send_prebuilt_emails_thinleek_' . $single_identifier;
    $options = get_option( $option_name );
    ?>
	<table style="display:none" id="ml_sendpbm_table_<?php 
    echo  $single_identifier ;
    ?>" class="form-table thinleek-table spm-template-tables" role="presentation">

		<tr class="spm-tr-part-template" style="border-bottom:1px solid #cdcdcd !important" class="spm-tr-part-template">
			<th class="thinleek-th-bright"><?php 
    echo  esc_html__( 'Template name', 'send-prebuilt-emails' ) ;
    ?>
				<span class="spm-desc"><?php 
    echo  esc_html__( 'only visible for you', 'send-prebuilt-emails' ) ;
    ?>
				</span>
			</th><?php 
    /**
     * option field: name
     */
    $option_key = 'name';
    $option_name_next = $option_name . '[' . $option_key . ']';
    $option_value = ( isset( $options[$option_key] ) ? $options[$option_key] : '' );
    ?>
			<td>
				<input maxlength="40" onchange="sendprebuiltemails_templatename_check()" onkeyup="sendprebuiltemails_templatename_check()" id="spm_selecttemplete_nameinput_id_<?php 
    echo  $single_identifier ;
    ?>" name="<?php 
    echo  $option_name_next ;
    ?>" value="<?php 
    echo  $option_value ;
    ?>" style="width:100%;max-width:350px" class="sendpbm-full" type="text">
			</td>
		</tr><?php 
    /**
     * option dropdown: category mail headers
     */
    $class = 'headers';
    $title = __( 'E-Mail "from" and "to" settings (optional)', 'send-prebuilt-emails' );
    $updown = 'down';
    $border = 'top';
    echo  wp_kses_post( $spm_settings_class->spm_admin_settings_accordeon(
        $class,
        $title,
        $updown,
        $border
    ) ) ;
    ?><tr style="display:none" class="spm-lr-border spm_tr_part_headers">
		<th class="thinleek-th-bright"><?php 
    echo  esc_html__( 'Preview', 'send-prebuilt-emails' ) ;
    ?>
			<span class="spm-desc"><?php 
    echo  esc_html__( 'shows preview with saved settings', 'send-prebuilt-emails' ) ;
    ?>
			</span>
		</th>
		<td>
			<span class="spm_address_email_header_preview_here_class"><?php 
    /**
     * preview mail address header
     */
    echo  wp_kses_post( $spm_settings_class->spm_admin_settings_addressheader_preview( $single_identifier, 0 ) ) ;
    ?></span>
		

			<span class="thinleek-example-headline"><?php 
    echo  esc_html__( 'If you do not change anything, 
				all E-Mails will be send with WooCommerce default settings (Woocommerce - Settings - E-Mails). 
				All settings of this part are optional.', 'send-prebuilt-emails' ) ;
    ?><br><br><b><?php 
    echo  esc_html__( 'One E-Mail address per field allowed.', 'send-prebuilt-emails' ) ;
    ?></b>
			</span>
			</td>
		</tr><?php 
    /**
     * option fields: header mail addresses
     */
    $val = array(
        'from_name',
        'from_email',
        'to_email',
        'reply_to_name',
        'reply_to_email',
        'cc',
        'bcc'
    );
    $name = array();
    $name[] = __( '"From" name', 'send-prebuilt-emails' );
    $name[] = __( '"From" E-Mail', 'send-prebuilt-emails' );
    $name[] = __( '"To" E-Mail', 'send-prebuilt-emails' );
    $name[] = __( '"Reply to" name', 'send-prebuilt-emails' );
    $name[] = __( '"Reply to" E-Mail', 'send-prebuilt-emails' );
    $name[] = __( 'Cc', 'send-prebuilt-emails' );
    $name[] = __( 'Bcc', 'send-prebuilt-emails' );
    $class = 'headers';
    $display = 'none';
    
    if ( sendprebuiltemails_fs()->is_not_paying() ) {
        $pro_feature_bubble = '<a href="' . esc_url( sendprebuiltemails_fs()->get_upgrade_url() ) . '" target="_blank" class="thinleek-pro-bubble-small">PREMIUM FEATURE</a>';
        for ( $i = 0 ;  $i < sizeof( $val ) ;  $i++ ) {
            ?>
			<tr style="display:none" class="spm-lr-border spm_tr_part_headers thinleektrdisabled">
				<th class="thinleek-th-bright"><?php 
            echo  esc_attr( $name[$i] ) . wp_kses_post( $pro_feature_bubble ) ;
            ?></th>
				<td><input style="width:100%" type="text" disabled></td>
			</tr>
			<?php 
        }
    }
    
    /**
     * option dropdown: content
     */
    $class = 'content';
    $title = __( 'E-Mail Content', 'send-prebuilt-emails' );
    $updown = 'up';
    $border = 'top';
    echo  wp_kses_post( $spm_settings_class->spm_admin_settings_accordeon(
        $class,
        $title,
        $updown,
        $border
    ) ) ;
    ?>
		<tr class="spm_tr_part_content spm-lr-border">
			<th class="thinleek-th-bright"><?php 
    echo  esc_html__( 'Placeholder', 'send-prebuilt-emails' ) ;
    ?>
				<span class="spm-desc"><?php 
    echo  esc_html__( 'You can use all placeholders in all parts instead of the template name.', 'send-prebuilt-emails' ) ;
    ?>
				</span>
			</th>
			<td>

			<span class="spm-placeholder_response_here"><?php 
    /**
     * display selected placholder
     */
    echo  wp_kses_post( $spm_settings_class->sendprebuiltemails_display_selected_placeholders( 0 ) ) ;
    ?>
			</span>
			<p class="thinleek-copied-txt" style="visibility:hidden"><?php 
    echo  esc_html__( 'placeholder copied.', 'send-prebuilt-emails' ) ;
    ?>
			</p>
		</td>
	<tr><?php 
    /**
     * option field: subject
     */
    $val = 'subject';
    $name = __( 'Subject', 'send-prebuilt-emails' );
    $class = 'content';
    $display = '';
    echo  wp_kses_post( $spm_settings_class->spm_admin_settings_fields(
        $val,
        $name,
        $class,
        $single_identifier,
        $display,
        0
    ) ) ;
    /**
     * option field: heading
     */
    $val = 'heading';
    $name = __( 'Heading', 'send-prebuilt-emails' );
    $class = 'content';
    $display = '';
    echo  wp_kses_post( $spm_settings_class->spm_admin_settings_fields(
        $val,
        $name,
        $class,
        $single_identifier,
        $display,
        0
    ) ) ;
    ?>
	<tr class="spm_tr_part_content spm-lr-border">
		<th class="thinleek-th-bright"><?php 
    echo  esc_html__( 'E-Mail Content', 'send-prebuilt-emails' ) ;
    ?>
		</th>
		<td style="padding-top: 0px;"><?php 
    /**
     * option field: wp_editor content
     */
    $option_key = 'content';
    $option_name_next = $option_name . '_' . $option_key;
    $option_value = ( isset( $options[$option_key] ) ? $options[$option_key] : '' );
    echo  wp_editor( wp_kses_post( stripslashes( $option_value ) ), esc_attr( $option_name_next ), $settings = array(
        'textarea_name' => esc_attr( $option_name_next ),
        'editor_height' => 400,
        'media_buttons' => false,
    ) ) ;
    ?>
		</td>
	</tr><?php 
    /**
     * option field: orderdetails checkbox
     */
    $option_key = 'orderdetails';
    $option_name_next = $option_name . '[' . $option_key . ']';
    $check_check = '';
    if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
        $check_check = 'checked';
    }
    ?>
	<tr class="spm_tr_part_content spm-lr-border">
		<th class="thinleek-th-bright"><?php 
    echo  esc_html__( 'Order Details', 'send-prebuilt-emails' ) ;
    ?>
		</th>
		<td><input value="orderdetails" name="<?php 
    echo  esc_attr( $option_name_next ) ;
    ?>" type="checkbox"<?php 
    echo  esc_attr( $check_check ) ;
    ?>><?php 
    echo  esc_html__( 'show orderdetails in E-Mail', 'send-prebuilt-emails' ) ;
    ?>
		</td>
	</tr><?php 
    /**
     * option field: address from order checkbox
     */
    $option_key = 'address';
    $option_name_next = $option_name . '[' . $option_key . ']';
    $check_check = '';
    if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
        $check_check = 'checked';
    }
    ?>
	<tr class="spm_tr_part_content spm-lr-border">
		<th class="thinleek-th-bright"><?php 
    echo  esc_html__( 'Invoice/Shipping address', 'send-prebuilt-emails' ) ;
    ?>
		</th>
		<td>
			<input value="address" name="<?php 
    echo  $option_name_next ;
    ?>" type="checkbox"<?php 
    echo  esc_attr( $check_check ) ;
    ?>><?php 
    echo  esc_html__( 'show addresses in E-Mail', 'send-prebuilt-emails' ) ;
    ?>
		</td>
	</tr>




	<tr class="spm_tr_part_content spm-lr-border">
		<th class="thinleek-th-bright"><?php 
    echo  esc_html__( 'Additional content', 'send-prebuilt-emails' ) ;
    ?></th><td style="padding-top: 0px;"><?php 
    /**
     * option field: wp_editor content two (additional content)
     */
    $option_key = 'contenttwo';
    $option_name_next = $option_name . '_' . $option_key;
    $option_value = ( isset( $options[$option_key] ) ? $options[$option_key] : '' );
    echo  wp_editor( wp_kses_post( stripslashes( $option_value ) ), esc_attr( $option_name_next ), $settings = array(
        'textarea_name' => esc_attr( $option_name_next ),
        'editor_height' => 200,
        'media_buttons' => false,
    ) ) ;
    ?></td></tr><?php 
    /**
     * option field: footer checkbox
     */
    $option_key = 'footer';
    $option_name_next = $option_name . '[' . $option_key . ']';
    $check_check = '';
    if ( isset( $options[$option_key] ) && strlen( $options[$option_key] ) > 0 ) {
        $check_check = 'checked';
    }
    ?>
	<tr class="spm_tr_part_content spm-lr-border">
		<th class="thinleek-th-bright"><?php 
    echo  esc_html__( 'Footer', 'send-prebuilt-emails' ) ;
    ?>
		</th>
		<td>
			<input value="footer" name="<?php 
    echo  esc_attr( $option_name_next ) ;
    ?>" type="checkbox"<?php 
    echo  esc_attr( $check_check ) ;
    ?>><?php 
    echo  esc_html__( 'show woocommerce footer in E-Mails', 'send-prebuilt-emails' ) ;
    ?>
		</td>
	</tr><?php 
    /**
     * option field: attachment
     */
    $attach_disabled = ' disabled';
    $premium_disabled_trclass = ' thinleektrdisabled';
    $pro_feature_bubble = '<a href="' . sendprebuiltemails_fs()->get_upgrade_url() . '" target="_blank" class="thinleek-pro-bubble">PREMIUM FEATURE</a>';
    $select_disabled_options = ' disabled';
    $select_ajax_func = '';
    $home_url = get_home_url();
    ?>
	<tr class="spm-lr-border spm_tr_part_content<?php 
    echo  esc_attr( $premium_disabled_trclass ) ;
    ?>">
		<th class="thinleek-th-bright"><?php 
    echo  esc_html__( 'Attachments', 'send-prebuilt-emails' ) ;
    ?>
				<span class="spm-desc"><?php 
    echo  esc_html__( 'placeholder in filepath allowed', 'send-prebuilt-emails' ) . wp_kses_post( $pro_feature_bubble ) ;
    ?>
				</span>
		</th>
		<td><?php 
    $allowed_attachments = array( 'a', 'b', 'c' );
    foreach ( $allowed_attachments as $atta ) {
        $option_key = 'attachment_' . $atta;
        $option_name_next = '';
        $option_value = '';
        ?>
		
		<input class="thinleek-fullwidth spm-attachment-input" type="text"<?php 
        echo  esc_attr( $option_name_next ) ;
        ?> value="<?php 
        echo  esc_attr( $option_value ) ;
        ?>"<?php 
        echo  esc_attr( $attach_disabled ) ;
        ?>>
		<span class="thinleek-desc"><?php 
        echo  esc_attr( $home_url ) ;
        ?>...</span>
	<?php 
    }
    ?>
	</td>
	</tr>
	
	<?php 
    /**
     * option dropdown: category mail status
     */
    $class = 'status';
    $title = __( 'Order status options (optional)', 'send-prebuilt-emails' );
    $updown = 'down';
    $border = 'top';
    echo  wp_kses_post( $spm_settings_class->spm_admin_settings_accordeon(
        $class,
        $title,
        $updown,
        $border
    ) ) ;
    ?>
	<tr style="display:none" class="spm-lr-border spm_tr_part_status">
		<th class="thinleek-th-bright"><?php 
    echo  esc_html__( 'Order staus Change after E-Mail sent', 'send-prebuilt-emails' ) ;
    ?>
		</th>
		<td><?php 
    echo  esc_html__( 'You have the possibility to change the order status after sending this pre-built E-Mail. 
			Check the checkbox "disable standard woocommerce E-Mail after sending this pre-built E-Mail" if you do not 
			want woocommerce to send the standard E-Mail after changing the status.', 'send-prebuilt-emails' ) ;
    ?><br><br>
		</td>
	</tr>
	<?php 
    // start status change field
    $option_key = 'staus';
    $option_name_next = '';
    $option_value = 'no';
    // get all order status
    $order_statuses = wc_get_order_statuses();
    $disable_mail_tr = ' thinleektrdisabled';
    $status_select = '<select name="' . esc_attr( $option_name_next ) . '" id="sendprebuiltemails_select_newstatus_id_' . esc_attr( $single_identifier ) . '" style="width:300px"' . esc_attr( $select_ajax_func ) . '>';
    $status_select .= '<option value="no">' . __( 'no order status change', 'send-prebuilt-emails' ) . '</option>';
    foreach ( $order_statuses as $status_slug => $status_name ) {
        $change_slug = str_replace( 'wc-', 'customer_', $status_slug );
        $change_slug = str_replace( '-', '_', $change_slug );
        $change_slug = $change_slug . '_order';
        $wc_email_status_id[$status_slug] = $change_slug;
        $allowed_email_ids[] = $change_slug;
        
        if ( $status_slug == $option_value ) {
            $disable_mail_tr = '';
            $status_select .= '<option value="' . esc_attr( $status_slug ) . '" selected>' . esc_attr( $status_name ) . '</option>';
        } else {
            $status_select .= '<option value="' . esc_attr( $status_slug ) . '"' . esc_attr( $select_disabled_options ) . '>' . esc_attr( $status_name ) . '</option>';
        }
    
    }
    $status_select .= '</select>';
    $status_changed_selection = $option_value;
    ?>
	<tr style="display:none" class="spm-lr-border spm_tr_part_status<?php 
    echo  esc_attr( $premium_disabled_trclass ) ;
    ?>">
		<th class="thinleek-th-bright"><?php 
    echo  esc_html__( 'New Order Status', 'send-prebuilt-emails' ) . wp_kses_post( $pro_feature_bubble ) ;
    ?>
		</th>
		<td><?php 
    echo  wp_kses_post( $status_select ) ;
    ?>			
		</td>
	</tr>
	

	
	<tr>
		<td colspan="2" style="padding: 0px !important;margin: 0px !important;">
			<div id="sendprebuiltemails_disable_wc_id_<?php 
    echo  esc_attr( $single_identifier ) ;
    ?>"></div>
		</td>
	</tr>
	
	
	<tr id="sendprebuiltemails_disable_wc_tr_id_<?php 
    echo  esc_attr( $single_identifier ) ;
    ?>" class="spm_tr_part_status spm-lr-border<?php 
    echo  esc_attr( $disable_mail_tr ) ;
    ?>" style="display:none">
		<th class="thinleek-th-bright">
			<?php 
    echo  esc_html__( 'Disable Woocommerce Standard E-Mail on status change', 'send-prebuilt-emails' ) . wp_kses_post( $pro_feature_bubble ) ;
    ?>
			<span class="spm-desc" style="margin-top:10px"><?php 
    echo  esc_html__( 'only possible if "new order status" is selected', 'send-prebuilt-emails' ) ;
    ?>
			</span>
		</th>
		<td>
		<div id="sendprebuiltemails_div_wcmail_option_<?php 
    echo  esc_attr( $single_identifier ) ;
    ?>">
		
		<?php 
    echo  wp_kses_post( $spm_settings_class->sendprebuiltemails_disable_wc_mail_option_function( $single_identifier, $status_changed_selection ) ) ;
    ?>
			
		</div>
		</td>
	</tr><?php 
    // END status change field
    ?>
	

	
	<tr>
		<th colspan="2" style="border-top: 1px solid #cdcdcd;padding:10px!important;"></th>
	</tr>

</table><?php 
}
// END foreach loop for option fields
?>

	<input type="hidden" name="sendprebuiltemails_einstellungen_submit" value="sendprebuiltemails_save">
	<input type="hidden" name="action" value="sendprebuiltemails_save_admin_settings">

	<div id="spm_save_and_preview_btn">
		<div class="thinleek-red-notice" id="sendpbm_admin_settings_save_btn_topdiv" style="display:none">
			<div style="padding-left:8px"><?php 
echo  esc_html__( 'No Name given in selected template. Without name the template will not be saved.', 'send-prebuilt-emails' ) ;
?>
			</div>
		</div>

		<div style="width: fit-content;">
			<input id="sendpbm_admin_settings_save_btn" type="submit" name="quickmals_submit" class="sendpbm_transition_css 
			button button-primary" value="<?php 
echo  esc_html__( 'save changes', 'send-prebuilt-emails' ) ;
?>" style="margin-top:20px">

			<div id="sendpbm_admin_settings_save_progress"></div>
			<div id="sendpbm_admin_settings_saved_banner" style="visibility:hidden" class="thinleek-green-notice">
				<div style="padding-left: 8px;">
					<span class="dashicons dashicons-yes" style="vertical-align: middle;padding-right: 2px;"></span><?php 
echo  esc_html__( 'saved', 'send-prebuilt-emails' ) ;
?>
				</div>

			</div>

		</div>


		<a target="_blank" id="sendpbm_admin_settings_preview_btn" onclick="sendprebuiltemails_ajax_preview_function('z','last',1,'prev')" class="button button-secondary"style="margin-top: 5px;"><?php 
echo  esc_html__( 'E-Mail preview', 'send-prebuilt-emails' ) ;
?>
		</a>
		<span class="spm-desc-inline" style="vertical-align: bottom;padding-left: 8px;"><?php 
echo  esc_html__( 'shows preview with saved settings.', 'send-prebuilt-emails' ) ;
?>
		</span>


	</div>

	</form>
		
	</div>	 


	</section><?php 
/**
 * Section: Advanced Settings
 */
?>
	<section tabindex="0" role="tabpanel" id="advanced-btn-section" class="ml-nav-tabs-section wrap" style="display:none">
		<div class="wrap thinleek-setting-wrap" style="max-width:1000px">
			<h2 style="margin-bottom:30px"><?php 
echo  esc_html__( 'advanced settings', 'send-prebuilt-emails' ) ;
?>
			</h2>
	
			<p class="thinleek_opener"><?php 
echo  esc_html__( 'Make further settings to tailor Prebuilt E-Mails even further to your needs. 
				You can find tips and tricks in the ', 'send-prebuilt-emails' ) ;
?>
			<a href="https://thinleek-plugins.com/en/documentation/" target="_blank"><?php 
echo  esc_html__( 'documentation', 'send-prebuilt-emails' ) ;
?>
			</a>.
			</p>
	
		<form name="sendprebuiltemails_admin_adv_settings_form" method="post">

			<table class="form-table thinleek-table" role="presentation" style="margin-bottom:0px!important"><?php 
/**
 * get advanced settings
 */
$admin_option_name = 'send_prebuilt_emails_thinleek_advanced';
$all_advanced_settings = get_option( $admin_option_name );
?>
	<tbody id="spm_admin_settings_bulk_here_id"><?php 
/**
 * display bulk fields (checkbox)
 */
echo  wp_kses_post( $spm_settings_class->sendprebuiltemails_advancesettings_bulk( 0 ) ) ;
?>
	</tbody><?php 
/**
 * option dropdown: placeholder
 */
$class = 'placeholders';
$title = __( 'Manage placeholder', 'send-prebuilt-emails' );
$updown = 'down';
$border = 'top';
echo  wp_kses_post( $spm_settings_class->spm_admin_settings_accordeon(
    $class,
    $title,
    $updown,
    $border
) ) ;
?>
	<tr class="spm_tr_part_placeholders spm-lr-border" style="display:none">
		<th class="thinleek-th-bright"></th>
		<td class="thinleek-nopadd">
			<span class="thinleek-desc"><?php 
echo  esc_html__( 'You can use all placeholders in every templated even if you do not select them. The selected 
			placeholders will be shown in "edit template" part so it is easier to copy them.', 'send-prebuilt-emails' ) ;
?>
			</span>
		</td>
	</tr><?php 
/**
 * option field: fallback placeholder value
 */
$option_key = 'default';
$key_two = 'placeholder';
$option_name_next = $admin_option_name . '[' . $option_key . '][' . $key_two . ']';
$placeholder_value = '';
if ( isset( $all_advanced_settings[$option_key][$key_two] ) ) {
    $placeholder_value = $all_advanced_settings[$option_key][$key_two];
}
?>
	<tr class="spm_tr_part_placeholders spm-lr-border" style="display:none">
		<th class="thinleek-th-bright"><?php 
echo  esc_html__( 'Placeholder Fallback', 'send-prebuilt-emails' ) ;
?>
		</th>
		<td>
			<input style="width:100%;max-width:350px" value="<?php 
echo  esc_attr( $placeholder_value ) ;
?>" name="<?php 
echo  esc_attr( $option_name_next ) ;
?>" type="text">
			<span class="thinleek-desc"><?php 
echo  esc_html__( 'default: empty (example: "Text {order-date_completed}" will be "Text "', 'send-prebuilt-emails' ) ;
?>
			</span>
		</td>
	</tr>


	<tr class="spm_tr_part_placeholders spm-lr-border" style="display:none">
		<th class="thinleek-th-bright"><?php 
echo  esc_html__( 'Order Data', 'send-prebuilt-emails' ) ;
?>
		</th>
		<td><?php 
/**
 * option field: order placeholder
 */
$option_key = 'placeholder';
$placeholder_order = array();
$placeholder_order[] = 'order-id';
$placeholder_order[] = 'order-number';
$placeholder_order[] = 'order-date_created';
$placeholder_order[] = 'order-date_paid';
$placeholder_order[] = 'order-date_completed';
$placeholder_order[] = 'order-total';
$placeholder_order[] = 'order-status';
$placeholder_order[] = 'order_discount_total';
$placeholder_order[] = 'order-shipping_total';
$placeholder_order[] = 'order-customer_id';
$placeholder_order[] = 'order-payment_method';
$placeholder_order[] = 'order-payment_method_title';
foreach ( $placeholder_order as $placeholder ) {
    $option_name_next = $admin_option_name . '[' . $option_key . '][' . $placeholder . ']';
    $placeholder_value = '';
    if ( isset( $all_advanced_settings[$option_key][$placeholder] ) ) {
        $placeholder_value = $all_advanced_settings[$option_key][$placeholder];
    }
    $placeholder_checked = '';
    if ( isset( $placeholder_value ) && strlen( $placeholder_value ) > 0 ) {
        $placeholder_checked = ' checked';
    }
    ?><span class="thinleek-checkbox-list"><input value="<?php 
    echo  esc_attr( $placeholder ) ;
    ?>" name="<?php 
    echo  esc_attr( $option_name_next ) ;
    ?>" type="checkbox"<?php 
    echo  esc_attr( $placeholder_checked ) ;
    ?>>{<?php 
    echo  esc_attr( $placeholder ) ;
    ?>}</span><?php 
}
?>
		</td>
	</tr>
	
	
	<tr class="spm_tr_part_placeholders spm-lr-border" style="display:none">
		<th class="thinleek-th-bright"><?php 
echo  esc_html__( 'Billing Address', 'send-prebuilt-emails' ) ;
?>
		</th>
		<td><?php 
/**
 * option field: billing placeholder
 */
$option_key = 'placeholder';
$placeholder_billing = array();
$placeholder_billing[] = 'billing-first_name';
$placeholder_billing[] = 'billing-last_name';
$placeholder_billing[] = 'billing-company';
$placeholder_billing[] = 'billing-address_1';
$placeholder_billing[] = 'billing-address_2';
$placeholder_billing[] = 'billing-city';
$placeholder_billing[] = 'billing-postcode';
$placeholder_billing[] = 'billing-country';
$placeholder_billing[] = 'billing-email';
$placeholder_billing[] = 'billing-phone';
foreach ( $placeholder_billing as $placeholder ) {
    $option_name_next = $admin_option_name . '[' . $option_key . '][' . $placeholder . ']';
    $placeholder_value = '';
    if ( isset( $all_advanced_settings[$option_key][$placeholder] ) ) {
        $placeholder_value = $all_advanced_settings[$option_key][$placeholder];
    }
    $placeholder_checked = '';
    if ( isset( $placeholder_value ) && strlen( $placeholder_value ) > 0 ) {
        $placeholder_checked = ' checked';
    }
    ?><span class="thinleek-checkbox-list"><input value="<?php 
    echo  esc_attr( $placeholder ) ;
    ?>" name="<?php 
    echo  esc_attr( $option_name_next ) ;
    ?>" type="checkbox"<?php 
    echo  esc_attr( $placeholder_checked ) ;
    ?>>{<?php 
    echo  esc_attr( $placeholder ) ;
    ?>}</span><?php 
}
?>
		</td>
	</tr>
	
	
	
	<tr class="spm_tr_part_placeholders spm-lr-border" style="display:none">
		<th class="thinleek-th-bright"><?php 
echo  esc_html__( 'Shipping Address', 'send-prebuilt-emails' ) ;
?>
		</th>
		<td><?php 
/**
 * option field: shipping placeholder
 */
$option_key = 'placeholder';
$placeholder_shipping = array();
$placeholder_shipping[] = 'shipping-first_name';
$placeholder_shipping[] = 'shipping-last_name';
$placeholder_shipping[] = 'shipping-company';
$placeholder_shipping[] = 'shipping-address_1';
$placeholder_shipping[] = 'shipping-address_2';
$placeholder_shipping[] = 'shipping-city';
$placeholder_shipping[] = 'shipping-postcode';
$placeholder_shipping[] = 'shipping-country';
foreach ( $placeholder_shipping as $placeholder ) {
    $option_name_next = $admin_option_name . '[' . $option_key . '][' . $placeholder . ']';
    $placeholder_value = '';
    if ( isset( $all_advanced_settings[$option_key][$placeholder] ) ) {
        $placeholder_value = $all_advanced_settings[$option_key][$placeholder];
    }
    $placeholder_checked = '';
    if ( isset( $placeholder_value ) && strlen( $placeholder_value ) > 0 ) {
        $placeholder_checked = ' checked';
    }
    ?><span class="thinleek-checkbox-list"><input value="<?php 
    echo  esc_attr( $placeholder ) ;
    ?>" name="<?php 
    echo  esc_attr( $option_name_next ) ;
    ?>" type="checkbox"<?php 
    echo  esc_attr( $placeholder_checked ) ;
    ?>>{<?php 
    echo  esc_attr( $placeholder ) ;
    ?>}</span><?php 
}
?>
		</td>
	</tr>
	
	
	<tr class="spm_tr_part_placeholders spm-lr-border" style="display:none">
		<th class="thinleek-th-bright"><?php 
echo  esc_html__( 'User Data', 'send-prebuilt-emails' ) ;
?>
		</th>
		<td><?php 
/**
 * option field: user placeholder
 */
$option_key = 'placeholder';
$placeholder_user = array();
$placeholder_user[] = 'user-nickname';
$placeholder_user[] = 'user-first_name';
$placeholder_user[] = 'user-last_name';
$placeholder_user[] = 'user-_order_count';
$placeholder_user[] = 'user-_last_order';
foreach ( $placeholder_user as $placeholder ) {
    $option_name_next = $admin_option_name . '[' . $option_key . '][' . $placeholder . ']';
    $placeholder_value = '';
    if ( isset( $all_advanced_settings[$option_key][$placeholder] ) ) {
        $placeholder_value = $all_advanced_settings[$option_key][$placeholder];
    }
    $placeholder_checked = '';
    if ( isset( $placeholder_value ) && strlen( $placeholder_value ) > 0 ) {
        $placeholder_checked = ' checked';
    }
    ?><span class="thinleek-checkbox-list"><input value="<?php 
    echo  esc_attr( $placeholder ) ;
    ?>" name="<?php 
    echo  esc_attr( $option_name_next ) ;
    ?>" type="checkbox"<?php 
    echo  esc_attr( $placeholder_checked ) ;
    ?>>{<?php 
    echo  esc_attr( $placeholder ) ;
    ?>}</span><?php 
}
?>
		</td>
	</tr>
	
	
	
	
	<tr class="spm_tr_part_placeholders spm-lr-border" style="display:none">
		<th class="thinleek-th-bright"><?php 
echo  esc_html__( 'Time Data', 'send-prebuilt-emails' ) ;
?>
		</th>
		<td><?php 
/**
 * option field: user placeholder
 */
$option_key = 'placeholder';
$placeholder_time = array();
$placeholder_time[] = 'today';
$placeholder_time[] = 'tomorrow';
$placeholder_time[] = 'in_7_days';
$placeholder_time[] = 'in_14_days';
$placeholder_time[] = 'next_monday';
$placeholder_time[] = 'next_tuesday';
$placeholder_time[] = 'next_wednesday';
$placeholder_time[] = 'next_thursday';
$placeholder_time[] = 'next_friday';
$placeholder_time[] = 'next_saturday';
$placeholder_time[] = 'next_sunday';
foreach ( $placeholder_time as $placeholder ) {
    $option_name_next = $admin_option_name . '[' . $option_key . '][' . $placeholder . ']';
    $placeholder_value = '';
    if ( isset( $all_advanced_settings[$option_key][$placeholder] ) ) {
        $placeholder_value = $all_advanced_settings[$option_key][$placeholder];
    }
    $placeholder_checked = '';
    if ( isset( $placeholder_value ) && strlen( $placeholder_value ) > 0 ) {
        $placeholder_checked = ' checked';
    }
    ?><span class="thinleek-checkbox-list"><input value="<?php 
    echo  esc_attr( $placeholder ) ;
    ?>" name="<?php 
    echo  esc_attr( $option_name_next ) ;
    ?>" type="checkbox"<?php 
    echo  esc_attr( $placeholder_checked ) ;
    ?>>{<?php 
    echo  esc_attr( $placeholder ) ;
    ?>}</span><?php 
}
?>
		</td>
	</tr>
	
	
	
	
		
	<tr class="spm_tr_part_placeholders spm-lr-border" style="display:none">
		<th class="thinleek-th-bright"><?php 
echo  esc_html__( 'Order Meta Data', 'send-prebuilt-emails' ) ;
?>
			<span class="thinleek-desc-bright"><?php 
echo  esc_html__( 'Example:', 'send-prebuilt-emails' ) ;
?>
				<br>ordermeta-metaname
				<br>ordermeta-metaname-curr
				<br>ordermeta-metaname-date
				<br><a href="https://thinleek-plugins.com/en/docs/send-pre-built-emails/create-placeholders/" target="_blank"><?php 
echo  esc_html__( 'detailed explanation', 'send-prebuilt-emails' ) ;
?></a>
			</span>
		</th>
		<td><?php 
/**
 * option field: acf placeholder
 */
$option_key = 'placeholder';
$placeholder_custom = array(
    'meta_a',
    'meta_b',
    'meta_c',
    'meta_d',
    'meta_e'
);
foreach ( $placeholder_custom as $placeholder ) {
    $option_name_next = $admin_option_name . '[' . $option_key . '][' . $placeholder . ']';
    $placeholder_value = '';
    if ( isset( $all_advanced_settings[$option_key][$placeholder] ) ) {
        $placeholder_value = $all_advanced_settings[$option_key][$placeholder];
    }
    ?><span class="thinleek-checkbox-list">
			<span class="spm-placeholder-before"><input value="<?php 
    echo  esc_attr( $placeholder_value ) ;
    ?>" name="<?php 
    echo  esc_attr( $option_name_next ) ;
    ?>" type="input"></span></span><?php 
}
?>
	
	<tr class="spm_tr_part_placeholders spm-lr-border" style="display:none">
		<th class="thinleek-th-bright"><?php 
echo  esc_html__( 'ACF Placeholder', 'send-prebuilt-emails' ) ;
?>
			<span class="thinleek-desc-bright"><?php 
echo  esc_html__( 'Example:', 'send-prebuilt-emails' ) ;
?>
				<br>acf-trackingnr-order
				<br>acf-birthday-user
				<br><a href="https://thinleek-plugins.com/en/docs/send-pre-built-emails/create-placeholders/" target="_blank"><?php 
echo  esc_html__( 'detailed explanation', 'send-prebuilt-emails' ) ;
?></a>
			</span>
		</th>
		<td><?php 
/**
 * option field: acf placeholder
 */
$option_key = 'placeholder';
$placeholder_custom = array(
    'acf_a',
    'acf_b',
    'acf_c',
    'acf_d',
    'acf_e'
);
foreach ( $placeholder_custom as $placeholder ) {
    $option_name_next = $admin_option_name . '[' . $option_key . '][' . $placeholder . ']';
    $placeholder_value = '';
    if ( isset( $all_advanced_settings[$option_key][$placeholder] ) ) {
        $placeholder_value = $all_advanced_settings[$option_key][$placeholder];
    }
    ?><span class="thinleek-checkbox-list">
			<span class="spm-placeholder-before"><input value="<?php 
    echo  esc_attr( $placeholder_value ) ;
    ?>" name="<?php 
    echo  esc_attr( $option_name_next ) ;
    ?>" type="input"></span></span><?php 
}
?>
	<tr class="spm_tr_part_placeholders spm-lr-border" style="display:none">
		<th class="thinleek-th-bright"><?php 
echo  esc_html__( 'Custom Placeholder', 'send-prebuilt-emails' ) ;
?>
			<span class="thinleek-desc-bright"><?php 
echo  esc_html__( 'see code examples to integrate in the child themes functions.php', 'send-prebuilt-emails' ) ;
?>
			<br><a href="https://thinleek-plugins.com/en/docs/send-pre-built-emails/create-placeholders/" target="_blank"><?php 
echo  esc_html__( 'detailed explanation', 'send-prebuilt-emails' ) ;
?></a>
			</span>
		</th>
		<td><?php 
/**
 * option field: custom placeholder
 */
$option_key = 'placeholder';
$placeholder_custom = array(
    'custom_a',
    'custom_b',
    'custom_c',
    'custom_d',
    'custom_e'
);
foreach ( $placeholder_custom as $placeholder ) {
    $option_name_next = $admin_option_name . '[' . $option_key . '][' . $placeholder . ']';
    $placeholder_value = '';
    if ( isset( $all_advanced_settings[$option_key][$placeholder] ) ) {
        $placeholder_value = $all_advanced_settings[$option_key][$placeholder];
    }
    ?><span class="thinleek-checkbox-list">
			<span class="spm-placeholder-before"><input value="<?php 
    echo  esc_attr( $placeholder_value ) ;
    ?>" name="<?php 
    echo  esc_attr( $option_name_next ) ;
    ?>" type="input"></span></span><?php 
}
?>
		</td>
	</tr>
	
	<tr>
		<th colspan="2" style="border-top: 1px solid #cdcdcd;padding:10px!important;"></th>
	</tr>

	
</table>
	<input type="hidden" name="sendprebuiltemails_adv_einstellungen_submit" value="sendprebuiltemails_adv_save">
	<input type="hidden" name="action" value="sendprebuiltemails_save_admin_adv_settings">


	<div style="width: fit-content;">
		<input id="sendpbm_admin_adv_settings_save_btn" type="submit" name="quickmals_submit" class="sendpbm_transition_css button button-primary" value="<?php 
echo  esc_html__( 'save advanced settings', 'send-prebuilt-emails' ) ;
?>" style="margin-top:20px">

		<div id="sendpbm_admin_adv_settings_save_progress"></div>
		<div id="sendpbm_admin_adv_settings_saved_banner" style="visibility:hidden" class="thinleek-green-notice">
			<div style="padding-left: 8px;">
				<span class="dashicons dashicons-yes" style="vertical-align: middle;padding-right: 2px;"></span><?php 
echo  esc_html__( 'saved', 'send-prebuilt-emails' ) ;
?>
			</div>

		</div>

	</div>


</form>
</div>
</section>
	
	
		<div id="sendprebuiltemails_bulkrespond_here_id"></div>
		<div id="sendpbm_mailsend_respond_id"></div><?php 
/**
 * option field: default test mail address
 */
$general_options_name = 'send_prebuilt_emails_thinleek_general';
$general_options = get_option( $general_options_name );
$default_value = get_option( 'woocommerce_email_from_address' );
$test_email_address = '';

if ( isset( $general_options['testaddress'] ) ) {
    $general_testaddress = $general_options['testaddress'];
    $test_email_address = $general_testaddress;
}

if ( !is_email( $test_email_address ) ) {
    $test_email_address = $default_value;
}
if ( !is_email( $test_email_address ) ) {
    $test_email_address = '';
}
/**
 * get last ten orders and create select for preview
 */
$preview_order_ten = '';
$query = new WC_Order_Query( array(
    'limit'   => 10,
    'orderby' => 'date',
    'type'    => 'shop_order',
    'order'   => 'DESC',
    'return'  => 'ids',
) );

if ( isset( $query ) ) {
    $ten_orders = $query->get_orders();
    $last_order_id = $ten_orders[0];
    $preview_order_ten .= '<select id=\\"sendprebuiltemails-preview-select-id\\" onchange=\\"sendprebuiltemails_ajax_preview_function(\'z\',this.value,1,\'newprev\')\\">';
    foreach ( $ten_orders as $ten_order ) {
        
        if ( $last_order_id == $ten_order ) {
            $preview_order_ten .= '<option value=\\"' . esc_attr( $ten_order ) . '\\" selected>#' . esc_attr( $ten_order ) . '</option>';
        } else {
            $preview_order_ten .= '<option value=\\"' . esc_attr( $ten_order ) . '\\">#' . esc_attr( $ten_order ) . '</option>';
        }
    
    }
    $preview_order_ten .= '</select>';
}

$prev_nonce = wp_create_nonce( 'spm_preview_nonce' );
?>
	<script>
	function sendprebuiltemails_ajax_preview_function(identifier,order_id,close,prev){
		
               
		if ( identifier == "z" ) {
			var identifier = document.getElementById("sendprebuiltemails-select-id").value;	
		}
	
		if ( order_id == "last" ) {
			order_id = "<?php 
echo  esc_attr( $last_order_id ) ;
?>";
		}
		else {
			var order_id = document.getElementById("sendprebuiltemails-preview-select-id").value;	
		}
	
		var ausgabe_div = document.getElementById("sendprebuiltemails_bulkrespond_here_id");
		
		
		if ( close == 1 ) {	
		
		var test_email_input = "<input type=\"text\" value=\"<?php 
echo  esc_attr( $test_email_address ) ;
?>\" id=\"sendprebuiltemails-test-email-id\">";
		
		var layer_html = "<div class=\"spm-bg-layer\"></div><div class=\"spm-ajax-wrap-full\">";
		var layer_html = layer_html + "<div class=\"spm-ajax-wrap\"><div class=\"sendpbm_ajax_ausgabe_inner\">";
		var layer_html = layer_html + "<span style=\"display:none!important\" id=\"sendprebuiltemails_identifier_hidden\">" + identifier + "</span>";
		var layer_html = layer_html + "<div class=\"spm-ajax-header\"><div class=\"spm-head-txt\">";
		var layer_html = layer_html + "<?php 
echo  esc_html__( 'E-Mail preview for order', 'send-prebuilt-emails' ) . $preview_order_ten ;
?></div>";
		var layer_html = layer_html + "<span onclick=\"sendprebuiltemails_ajax_preview_function(0,0,0,0)\" class=\"dashicons dashicons-no-alt spm-close-icon\"></span>";
		var layer_html = layer_html + "</div><div class=\"spm-ajax-body\"><div id=\"sendprebuiltemails-loading-screen\">";
		var layer_html = layer_html + "<div class=\"thinleek-progress\"><div class=\"thinleek-indeterminate\"></div></div><p>";
		var layer_html = layer_html + "<?php 
echo  esc_html__( 'loading...', 'send-prebuilt-emails' ) ;
?></p></div>";
		var layer_html = layer_html + "<div id=\"sendprebuiltemails_iframe_id_div\"></div></div></div>";
		var layer_html = layer_html + "<div class=\"spm-ajax-footer\">" + test_email_input + "<a style=\"float:left;margin-right:10px\" onclick=\"sendprebuiltemails_mailsend_func(\'" + identifier + "\',\'selected\')\" class=\"button-secondary button\">";
		var layer_html = layer_html + "<?php 
echo  esc_html__( 'send test E-Mail', 'send-prebuilt-emails' ) ;
?></a>";
		var layer_html = layer_html + "<a onclick=\"sendprebuiltemails_ajax_preview_function(0,0,0,0)\" class=\"button-primary button\">";
		var layer_html = layer_html + "<?php 
echo  esc_html__( 'close', 'send-prebuilt-emails' ) ;
?></a></div></div>";

		if ( prev !== "newprev" ) {
			ausgabe_div.innerHTML = layer_html;
		}
		else {
			document.getElementById("sendprebuiltemails-loading-screen").style.display = "";
			identifier = document.getElementById("sendprebuiltemails_identifier_hidden").innerHTML;
			document.getElementById("sendprebuiltemails_iframe_id_div").style.overflowY = "";
			document.getElementById("sendprebuiltemails_iframe_id_div").innerHTML = "";
		}

			var data = {
					'action': 'sendprebuiltemails_preview_action',
					'identifier': identifier,
					'order': order_id,
					'nonce': spm_ajax_object.spm_ajax_nonce,
				};
				
				
			jQuery.post("<?php 
echo  esc_url( admin_url( 'admin-ajax.php' ) ) ;
?>", data, function(response) {
				
				var to_response_div = document.getElementById("sendprebuiltemails_iframe_id_div");
			
				if (typeof(to_response_div) != "undefined" && to_response_div != null) {
					to_response_div.innerHTML = response;
					to_response_div.style.overflowY = "scroll";
					document.getElementById("sendprebuiltemails-loading-screen").style.display = "none";
				}
			
				

            
			});
		}
		else {
			ausgabe_div.innerHTML = "<span style=\"display:none!important\">sendpbm closed</span>";	
		}
		
		
    }
	</script>
	
	<script>
	function sendprebuiltemails_mailsend_func(identifier,order_id){

		if ( order_id == "last" ) {
			order_id = "<?php 
echo  esc_attr( $last_order_id ) ;
?>";
		}
		else {
			var order_id = document.getElementById("sendprebuiltemails-preview-select-id").value;	
		}
		
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
	
		var respond_div = document.getElementById("sendprebuiltemails_bulkrespond_here_id");
		var testemail = document.getElementById("sendprebuiltemails-test-email-id").value;
		respond_div.innerHTML = success_popup_load;

				var type = "orderedit";
				
				var data = {
					'action': 'sendprebuiltemails_secure_sendmail_action',
					'identifier': identifier,
					'order_ids': order_id,
					'type': type,
					'testemail': testemail,
					'nonce': spm_ajax_object.spm_ajax_nonce,
				};
				
				
			jQuery.post("<?php 
echo  esc_url( admin_url( 'admin-ajax.php' ) ) ;
?>", data, function(response) {
			
				respond_div.innerHTML = response;	
            
			});
		
    
	}
	</script>
	