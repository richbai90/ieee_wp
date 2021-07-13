<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once "inc/object/creator.php";

class OSF_Give {
	/**
	 * @var $installer OSF_Give_Installer
	 */
	public $installer;

	public function __construct() {

//		$this->installer = require "inc/installer.php";

		add_action( 'give_init', array( $this, 'give_init' ), 10 );
//		add_filter( 'give-settings_get_settings_pages', [ $this, 'add_settings' ] );
//		add_action( 'init', [ $this, 'init' ], 4 );
        add_action( 'widgets_init', array($this,'init_sidebar' ));
        add_filter('opal_theme_sidebar', array($this,'set_sidebar' ));
//		register_activation_hook( FUNDOR_CORE_PLUGIN_FILE, array( $this, 'plugin_activate' ) );
	}

	public function set_sidebar(){
	    $name = '';
	    if (is_post_type_archive('give_forms') || is_tax('give_forms_category')){
	        $name = 'sidebar-give';
        }
	    return $name;
    }

	public function init() {
		require "inc/media.php";
	}

	public function plugin_activate() {

		$this->installer->do_install();

		flush_rewrite_rules();
	}

	public function add_settings( $settings ) {
		$settings[] = require "inc/settings.php";
	}

	public function give_init() {
		require "inc/functions.php";
//		require "inc/request-form.php";
//		require "inc/admin.php";

		$this->template  = require "inc/templates.php";
//		$this->shortcode = require "inc/shortcodes.php";
//		$this->rewrites  = require "inc/rewrites.php";
		$this->metaForm  = require "inc/meta-form.php";
//		$this->pay       = require "inc/payment.php";
//		$this->user      = require "inc/user.php";
//		$this->campaigns = require "inc/campaigns.php";
	}

	public function init_sidebar(){
        register_sidebar(array(
            'name'          => esc_html__('Give Archive Sidebar', 'fundor-core'),
            'id'            => 'sidebar-give',
            'description'   => esc_html__('Add widgets here to appear in your Give.', 'fundor-core'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }
}

return new OSF_Give();