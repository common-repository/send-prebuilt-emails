<?php

/**
 * Welcome to Send Prebuilt E-Mails
 *
 *
 * @link              https://thinleek-plugins.com
 * @since             1.0.0
 * @package           Send_Prebuilt_Emails
 *
 * @wordpress-plugin
 * Plugin Name: Send Prebuilt E-Mails
 * Plugin URI:        https://thinleek-plugins.com/en/plugins/send-prebuilt-emails/
 * Description:       With Send Prebuilt E-Mails you can create additional E-Mail templates (text and content not design) in woocommerce. Don't waste time in typing the same E-Mails again and again. Use placeholder to create dynamic templates and send your E-Mails via click.
 * Version:           1.0.0
 * Author:            thinleek plugins
 * Author URI:        https://thinleek-plugins.com/en/home/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       send-prebuilt-emails
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
/* Freemeius logic */

if ( function_exists( 'sendprebuiltemails_fs' ) ) {
    sendprebuiltemails_fs()->set_basename( false, __FILE__ );
} else {
    // DO NOT REMOVE THIS IF, IT IS ESSENTIAL FOR THE `function_exists` CALL ABOVE TO PROPERLY WORK.
    
    if ( !function_exists( 'sendprebuiltemails_fs' ) ) {
        /* Freemius SDK */
        
        if ( !function_exists( 'sendprebuiltemails_fs' ) ) {
            // Create a helper function for easy SDK access.
            function sendprebuiltemails_fs()
            {
                global  $sendprebuiltemails_fs ;
                
                if ( !isset( $sendprebuiltemails_fs ) ) {
                    // Include Freemius SDK.
                    require_once dirname( __FILE__ ) . '/freemius/start.php';
                    $sendprebuiltemails_fs = fs_dynamic_init( array(
                        'id'             => '8167',
                        'slug'           => 'send-prebuilt-emails',
                        'type'           => 'plugin',
                        'public_key'     => 'pk_dfc9f53247b2cb1750cf2e22b138c',
                        'is_premium'     => false,
                        'premium_suffix' => 'Premium',
                        'has_addons'     => false,
                        'has_paid_plans' => true,
                        'trial'          => array(
                        'days'               => 7,
                        'is_require_payment' => false,
                    ),
                        'menu'           => array(
                        'slug'       => 'prebuilt-emails-orders',
                        'first-path' => 'admin.php?page=prebuilt-emails-orders',
                        'contact'    => false,
                        'support'    => false,
                    ),
                        'is_live'        => true,
                    ) );
                }
                
                return $sendprebuiltemails_fs;
            }
            
            // Init Freemius.
            sendprebuiltemails_fs();
            // Signal that SDK was initiated.
            do_action( 'sendprebuiltemails_fs_loaded' );
        }
        
        /* END Freemius SDK */
    }
    
    /* END Freemus logic */
    /* Freemius uninstall action */
    function sendprebuiltemails_fs_uninstall_cleanup()
    {
        // Delete option
        delete_option( 'send_prebuilt_emails_thinleek_version' );
        // Delete option
        delete_option( 'send_prebuilt_emails_thinleek_advanced' );
        // Delete option
        delete_option( 'send_prebuilt_emails_user_thinleek_advanced' );
        // Delete option
        delete_option( 'send_prebuilt_emails_thinleek_general' );
        // Delete option
        delete_option( 'send_prebuilt_emails_thinleek_plain' );
        // Delete all identifier options
        $spm_setup_settings = get_option( 'send_prebuilt_emails_thinleek_setup' );
        $all_identifiers = ( isset( $spm_setup_settings['identifiers'] ) ? $spm_setup_settings['identifiers'] : array() );
        foreach ( $all_identifiers as $single_identifier ) {
            $option_name = 'send_prebuilt_emails_thinleek_' . $single_identifier;
            $get_identifier_option = get_option( $option_name );
            if ( isset( $get_identifier_option ) ) {
                delete_option( $option_name );
            }
            $option_name = 'send_prebuilt_emails_user_thinleek_' . $single_identifier;
            $get_identifier_option = get_option( $option_name );
            if ( isset( $get_identifier_option ) ) {
                delete_option( $option_name );
            }
        }
        // Delete option
        delete_option( 'send_prebuilt_emails_thinleek_setup' );
    }
    
    sendprebuiltemails_fs()->add_action( 'after_uninstall', 'sendprebuiltemails_fs_uninstall_cleanup' );
    /* END Freemius uninstall action */
    /* add wp options if premium is activated or delete if not activatet */
    $setup_options = get_option( 'send_prebuilt_emails_thinleek_setup' );
    $setup_options_identifiers = ( isset( $setup_options['identifiers'] ) ? $setup_options['identifiers'] : array() );
    
    if ( sendprebuiltemails_fs()->is_not_paying() ) {
        
        if ( sizeof( $setup_options_identifiers ) > 6 ) {
            $setup_identifiers[] = 'a';
            $setup_identifiers[] = 'b';
            $setup_identifiers[] = 'c';
            $setup_identifiers[] = 'd';
            $setup_identifiers[] = 'e';
            $setup_options['identifiers'] = $setup_identifiers;
            // update setup values in wp options
            update_option( 'send_prebuilt_emails_thinleek_setup', $setup_options );
        }
    
    } else {
        
        if ( sizeof( $setup_options_identifiers ) < 10 ) {
            $setup_identifiers[] = 'a';
            $setup_identifiers[] = 'b';
            $setup_identifiers[] = 'c';
            $setup_identifiers[] = 'd';
            $setup_identifiers[] = 'e';
            $setup_identifiers[] = 'f';
            $setup_identifiers[] = 'g';
            $setup_identifiers[] = 'h';
            $setup_identifiers[] = 'i';
            $setup_identifiers[] = 'j';
            $setup_identifiers[] = 'k';
            $setup_identifiers[] = 'l';
            $setup_identifiers[] = 'm';
            $setup_identifiers[] = 'n';
            $setup_identifiers[] = 'o';
            $setup_identifiers[] = 'p';
            $setup_identifiers[] = 'q';
            $setup_identifiers[] = 'r';
            $setup_identifiers[] = 's';
            $setup_identifiers[] = 't';
            $setup_options['identifiers'] = $setup_identifiers;
            // update setup values in wp options
            update_option( 'send_prebuilt_emails_thinleek_setup', $setup_options );
        }
    
    }
    
    /* END Premium wp options */
    /**
     * Currently plugin version:
     * version 1.0.0
     */
    define( 'SEND_PREBUILT_EMAILS_VERSION', '1.0.0' );
    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-send-prebuilt-emails-activator.php
     */
    function activate_send_prebuilt_emails()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-send-prebuilt-emails-activator.php';
        Send_Prebuilt_Emails_Activator::activate();
    }
    
    register_activation_hook( __FILE__, 'activate_send_prebuilt_emails' );
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path( __FILE__ ) . 'includes/class-send-prebuilt-emails.php';
    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * Check if Woocommerce is activ
     */
    // Must include plugin.php to use is_plugin_active().
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    
    if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
        $plugin = new Send_Prebuilt_Emails();
        $plugin->run();
    } else {
        // Deactivate the plugin, and display our error notification.
        deactivate_plugins( '/send-prebuilt-emails/send-prebuilt-emails.php' );
        add_action( 'admin_notices', 'sendprebuiltemails_woo_not_activ' );
    }
    
    /**
     * Display our error admin notice if WooCommerce is not installed + active.
     */
    function sendprebuiltemails_woo_not_activ()
    {
        ?>	
		<!-- hide the 'Plugin Activated' default message -->
		<style>
		#message.updated {
			display: none;
		}
		</style>
		<!-- display our error message -->
		<div class="error">
			<p>
				<?php 
        esc_html_e( 'Send Prebuilt E-Mails could not be activated because WooCommerce is not installed and active.', 'send-prebuilt-emails' );
        ?>
				</p>
			<p>
				<?php 
        /* translators: The placeholder is a URL to the WooCommerce plugin. */
        echo  sprintf( esc_html( 'Please install and activate %1s before activating the plugin.', 'send-prebuilt-emails' ), '<a href="' . esc_url( admin_url( 'plugin-install.php?tab=search&type=term&s=WooCommerce' ) ) . '" title="WooCommerce">WooCommerce</a>' ) ;
        ?>
			</p>
		</div>
	<?php 
    }

}

// END Freemius logic