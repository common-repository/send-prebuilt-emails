<?php

/**
 * The core plugin class.
 */
class Send_Prebuilt_Emails
{
    // The loader that's responsible for maintaining and registering all hooks that power the plugin.
    protected  $loader ;
    // The unique identifier of this plugin.
    protected  $send_prebuilt_emails ;
    // The current version of the plugin.
    protected  $version ;
    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the admin-option-settings-facing side of the site.
     *
     */
    public function __construct()
    {
        
        if ( defined( 'SEND_PREBUILT_EMAILS_VERSION' ) ) {
            $this->version = SEND_PREBUILT_EMAILS_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        
        $this->send_prebuilt_emails = 'send-prebuilt-emails';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_mailsend_hooks();
        $this->define_settings_hooks();
        $option_name = 'send_prebuilt_emails_thinleek_general';
        $options = get_option( $option_name );
        if ( isset( $options['usertab'] ) && $options['usertab'] == 'checked' ) {
            $this->define_user_hooks();
        }
    }
    
    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Send_Prebuilt_Emails_Loader. Orchestrates the hooks of the plugin.
     * - Send_Prebuilt_Emails_i18n. Defines internationalization functionality.
     * - Send_Prebuilt_Emails_Admin. Defines all hooks for the admin area.
     * - Send_Prebuilt_Emails_Settings. Defines all hooks for the public side of the site.
     * - Send_Prebuilt_Emails_User. Defines all hooks for sending mails to users.
     * - Send_Prebuilt_Emails_Plain. Defines all hooks for sending plain mails.
     * - Send_Prebuilt_Emails_Mailsend. Defines all hooks for sending mails in general.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     */
    private function load_dependencies()
    {
        // The class responsible for orchestrating the actions and filters of the core plugin.
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-send-prebuilt-emails-loader.php';
        // The class responsible for defining internationalization functionality of the plugin.
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-send-prebuilt-emails-i18n.php';
        // The class responsible for defining all actions that occur in the admin area.
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-send-prebuilt-emails-admin.php';
        // The class responsible for defining all actions that occur in the send mail functionality.
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-send-prebuilt-emails-mailsend-actions.php';
        // The class responsible for defining all actions that occur in the admin-option-settings-facing side of the site.
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'settings/class-send-prebuilt-emails-settings.php';
        $option_name = 'send_prebuilt_emails_thinleek_general';
        $options = get_option( $option_name );
        if ( isset( $options['usertab'] ) && $options['usertab'] == 'checked' ) {
            // The class responsible for user mails
            require_once plugin_dir_path( dirname( __FILE__ ) ) . 'user/class-send-prebuilt-emails-user.php';
        }
        $this->loader = new Send_Prebuilt_Emails_Loader();
    }
    
    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Send_Prebuilt_Emails_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     */
    private function set_locale()
    {
        $plugin_i18n = new Send_Prebuilt_Emails_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }
    
    // Register all of the hooks related to the send plain mails functionality of the plugin.
    private function define_plain_hooks()
    {
    }
    
    // Register all of the hooks related to the sending mails to users functionality.
    private function define_user_hooks()
    {
        $option_name = 'send_prebuilt_emails_thinleek_general';
        $options = get_option( $option_name );
        
        if ( isset( $options['usertab'] ) && $options['usertab'] == 'checked' ) {
            $plugin_user = new Send_Prebuilt_Emails_User( $this->get_send_prebuilt_emails(), $this->get_version() );
            $this->loader->add_action(
                'admin_menu',
                $plugin_user,
                'add_admin_menu',
                103
            );
            $this->loader->add_action(
                'show_user_profile',
                $plugin_user,
                'spm_user_content',
                1
            );
            $this->loader->add_action(
                'edit_user_profile',
                $plugin_user,
                'spm_user_content',
                1
            );
            $this->loader->add_filter(
                'bulk_actions-users',
                $plugin_user,
                'spm_add_order_bulk_actions_user',
                20,
                1
            );
        }
    
    }
    
    // Register all of the hooks related to the admin and woocommerce order area functionality of the plugin.
    private function define_admin_hooks()
    {
        $plugin_admin = new Send_Prebuilt_Emails_Admin( $this->get_send_prebuilt_emails(), $this->get_version() );
        $this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'spm_add_metabox_to_orderedit' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );
        $this->loader->add_action(
            'admin_menu',
            $plugin_admin,
            'add_admin_menu_general_settings',
            109
        );
        $this->loader->add_action(
            'admin_menu',
            $plugin_admin,
            'add_admin_menu_help',
            110
        );
        // load css and js only when needed
        $load_js_css = 'no';
        $current_page = $_SERVER['REQUEST_URI'];
        
        if ( strpos( $current_page, 'shop_order' ) > 0 ) {
            $load_js_css = 'yes';
        } else {
            
            if ( strpos( $current_page, 'prebuilt-emails' ) > 0 ) {
                $load_js_css = 'yes';
            } else {
                
                if ( strpos( $current_page, 'users.php' ) > 0 || strpos( $current_page, 'user-edit.php' ) > 0 ) {
                    $load_js_css = 'yes';
                } else {
                    
                    if ( strpos( $current_page, 'post.php' ) > 0 ) {
                        global  $pagenow ;
                        if ( 'post.php' === $pagenow && isset( $_GET['post'] ) ) {
                            if ( get_post_type( $_GET['post'] ) === 'shop_order' ) {
                                $load_js_css = 'yes';
                            }
                        }
                    }
                
                }
            
            }
        
        }
        
        
        if ( $load_js_css === 'yes' ) {
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        }
        
        $this->loader->add_filter(
            'bulk_actions-edit-shop_order',
            $plugin_admin,
            'spm_add_order_bulk_actions',
            20,
            1
        );
        $this->loader->add_filter( 'manage_edit-shop_order_columns', $plugin_admin, 'spm_add_prebuiltemails_column' );
        $this->loader->add_action(
            'manage_shop_order_posts_custom_column',
            $plugin_admin,
            'spm_add_prebuiltemails_column_func',
            2
        );
        $this->loader->add_filter( 'woocommerce_shop_order_search_fields', $plugin_admin, 'spm_add_prebuiltemails_column_serach' );
    }
    
    // Register all of the hooks related to send e-mails functionality of the plugin.
    private function define_mailsend_hooks()
    {
        $plugin_mailsend = new Send_Prebuilt_Emails_Mailsend_Actions( $this->get_send_prebuilt_emails(), $this->get_version() );
        $this->loader->add_action( 'wp_ajax_sendprebuiltemails_preview_action', $plugin_mailsend, 'sendprebuiltemails_preview_action' );
        $this->loader->add_action( 'wp_ajax_sendprebuiltemails_secure_sendmail_action', $plugin_mailsend, 'sendprebuiltemails_secure_sendmail_action' );
        $this->loader->add_filter(
            'sendprebuiltemails_add_custom_placeholder',
            $plugin_mailsend,
            'spm_filter_timedata_placeholder',
            10,
            2
        );
        $this->loader->add_filter(
            'sendprebuiltemails_add_custom_user_placeholder',
            $plugin_mailsend,
            'spm_filter_additional_user_placeholder',
            10,
            2
        );
    }
    
    // Register all of the hooks related to the admin-option-settings-facing functionality of the plugin.
    private function define_settings_hooks()
    {
        
        if ( is_admin() ) {
            $plugin_settings = new Send_Prebuilt_Emails_Settings( $this->get_send_prebuilt_emails(), $this->get_version() );
            $this->loader->add_action( 'wp_ajax_sendprebuiltemails_disable_wc_mail_option_action', $plugin_settings, 'sendprebuiltemails_disable_wc_mail_option_action' );
            $this->loader->add_action( 'wp_ajax_sendprebuiltemails_save_admin_settings', $plugin_settings, 'sendprebuiltemails_save_admin_settings' );
            $this->loader->add_action( 'wp_ajax_sendprebuiltemails_save_admin_adv_settings', $plugin_settings, 'sendprebuiltemails_save_admin_adv_settings' );
            $this->loader->add_action( 'wp_ajax_sendprebuiltemails_admin_delte_template', $plugin_settings, 'sendprebuiltemails_admin_delte_template' );
        }
    
    }
    
    // Run the loader to execute all of the hooks with WordPress.
    public function run()
    {
        $this->loader->run();
    }
    
    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     */
    public function get_send_prebuilt_emails()
    {
        return $this->send_prebuilt_emails;
    }
    
    // The reference to the class that orchestrates the hooks with the plugin.
    public function get_loader()
    {
        return $this->loader;
    }
    
    // Retrieve the version number of the plugin.
    public function get_version()
    {
        return $this->version;
    }

}