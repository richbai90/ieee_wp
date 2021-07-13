<?php

class OSF_Import {
	private $config, $path_rev, $homepage, $blogpage, $settings, $templates;

	public function __construct() {
		if ( is_admin() ) {
			$this->path_rev = trailingslashit( wp_upload_dir()['basedir'] ) . 'opal_rev_sliders_import/';
			add_action( 'after_setup_theme', array( $this, 'init' ) );
		}
	}

	public function init() {
		$this->init_hooks();
		add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
	}

	public function init_hooks() {
		if ( get_option( 'otf-oneclick-first-import', 'yes' ) === 'yes' ) {
			add_filter( 'pt-ocdi/import_files', array( $this, 'import_file_base' ) );
			add_action( 'pt-ocdi/after_import', array( $this, 'after_import_setup' ) );
			add_action( 'pt-ocdi/after_import', array( $this, 'after_import_setup_base' ), 20 );
		} else {
			add_filter( 'pt-ocdi/import_files', array( $this, 'import_files' ) );
			add_action( 'pt-ocdi/after_import', array( $this, 'after_import_setup' ) );
			add_filter( 'pt-ocdi/enable_grid_layout_import_popup_confirmation', '__return_false' );
			add_filter( 'otf-ocdi/reload_page', '__return_false' );
		}
	}

	public function import_file_base() {
		$this->init_data();
		if ( function_exists( 'give_update_option' ) ) {
			give_update_option( 'categories', 'enabled' );
			give_update_option( 'tags', 'enabled' );
		}
		$imports   = array();
		$import    = array(
			'import_file_name'  => 'Home 1',
			'local_import_file' => trailingslashit( FUNDOR_CORE_PLUGIN_DIR ) . 'dummy-data/content.xml',
			'import_notice'     => 'Basic import includes default version from our demo and a few products, blog posts and portfolio projects. It is a required minimum to see how our theme built and to be able to import additional versions or pages.',
			'slug'              => '1',
			'customizer'        => trailingslashit( FUNDOR_CORE_PLUGIN_DIR ) . 'dummy-data/customizer.json',
			'elementor'         => trailingslashit( FUNDOR_CORE_PLUGIN_DIR ) . 'dummy-data/elementor.json',
			'settings'          => trailingslashit( FUNDOR_CORE_PLUGIN_DIR ) . 'dummy-data/settings.json',
		);
		$imports[] = $import;

		return $imports;
	}

	public function import_files() {
		$this->init_data();
		$imports = array();
		foreach ( $this->config as $key => $item ) {
			$import = array(
				'import_file_name'         => $item['name'],
				'import_preview_image_url' => $item['screenshot'],
				'slug'                     => $key,
				'settings'                 => trailingslashit( FUNDOR_CORE_PLUGIN_DIR ) . 'dummy_data/settings.json',
				'elementor'                => trailingslashit( FUNDOR_CORE_PLUGIN_DIR ) . 'dummy_data/elementor.json',
			);
			if ( isset( $item['xml'] ) ) {
				$import['local_import_file'] = trailingslashit( FUNDOR_CORE_PLUGIN_DIR ) . 'dummy-data/' . $item['xml'];
			}

			$imports[] = $import;
		}

		return $imports;
	}

	private function init_data() {
		$this->config   = $this->get_remote_json( trailingslashit( FUNDOR_CORE_PLUGIN_URL ) . 'dummy-data/config.json', true );
		$this->blogpage = get_page_by_title( 'Blog' );
	}

	public function after_import_setup_base( $selected_import ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', ( ( $this->homepage instanceof WP_Post ) ? $this->homepage->ID : 0 ) );
		update_option( 'page_for_posts', ( ( $this->blogpage instanceof WP_Post ) ? $this->blogpage->ID : 0 ) );
		update_option( 'otf-oneclick-first-import', 'no' );

		// Setup Customizer
		$thememods = $this->get_remote_json( $selected_import['customizer'], true );
		foreach ( $thememods as $mod => $value ) {
			set_theme_mod( $mod, $value );
		}

		// Setup Elementor
		$this->settings = $this->get_remote_json( $selected_import['settings'], true );
		$elementor      = $this->get_remote_json( $selected_import['elementor'], true );

		// Breadcrumb
		update_option( 'bcn_options', $this->settings['breadcrumb'] );

        if (osf_is_elementor_activated()) {
            $this->updateElementor();

            // UPGRADE FOR ELEMENTOR 3.x
            $elementor_version = get_option('elementor_version', (defined('ELEMENTOR_VERSION') ? ELEMENTOR_VERSION : false));
            if ($elementor_version && version_compare($elementor_version, '3.0', '>=')) {
                $active_kit_id = \Elementor\Plugin::$instance->kits_manager->get_active_id();
                // current active kit settings;
                if ($active_kit_id) {
                    update_post_meta($active_kit_id, '_elementor_page_settings', $elementor['elementor_active_kit_settings']);
                }
                // unset `elementor_active_kit_settings` setting key
                unset($elementor['elementor_active_kit_settings']);
            }
            // END UPGRADE FOR ELEMENTOR 3.x
            foreach ($elementor as $key => $value) {
                update_option($key, $value);
            }
            $global = new Elementor\Core\Files\CSS\Global_CSS('global.css');
            $global->update_file();
        }

		$this->set_give_thumbnail();
	}

	public function after_import_setup( $selected_import ) {
		if ( isset( $this->config[ $selected_import['slug'] ] ) ) {

			$this->homepage = get_page_by_title( $selected_import['import_file_name'] );

			$setup = $this->config[ $selected_import['slug'] ];
			// REVSLIDER
			if ( $sliders = $setup['rev_sliders'] ) {
				if ( class_exists( 'RevSliderAdmin' ) ) {
					if ( ! file_exists( $this->path_rev ) ) {
						wp_mkdir_p( $this->path_rev );
					}
					foreach ( $sliders as $slider ) {
						$this->add_revslider( $slider );
					}
				}
			}

			$this->settings  = $this->get_remote_json( $selected_import['settings'], true );
			$this->templates = $this->settings['templates'];

			$this->setup_home_page( $selected_import['slug'] );
			$this->set_logo();

			// Setup Home page
			update_option( 'page_on_front', ( ( $this->homepage instanceof WP_Post ) ? $this->homepage->ID : 0 ) );

			// Mailchimp
			$mailchimp = get_page_by_title( 'Opal MailChimp', OBJECT, 'mc4wp-form' );
			if ( $mailchimp ) {
				update_option( 'mc4wp_default_form_id', $mailchimp->ID );
			}

			if ( osf_is_elementor_activated() ) {
				$this->update_url_elementor();
				\Elementor\Plugin::$instance->files_manager->clear_cache();
			}

		}
		set_theme_mod( 'osf_dev_mode', false );
	}

	private function add_revslider( $slider ) {
		$dest_rev = $this->path_rev . basename( $slider );
		if ( ! file_exists( $dest_rev ) ) {
			file_put_contents( $dest_rev, fopen( $slider, 'r' ) );
			$_FILES['import_file']['error']    = UPLOAD_ERR_OK;
			$_FILES['import_file']['tmp_name'] = $dest_rev;

			$revslider = new RevSlider();
			$revslider->importSliderFromPost( true, 'none' );
		}
	}

	private function setup_home_page( $slug ) {
		set_theme_mod( 'osf_theme_custom_style', osf_theme_custom_css() );
		set_theme_mod( 'osf_theme_google_fonts', osf_get_fonts_url() );
	}

	/**
	 * @param $link
	 *
	 * @return object|boolean
	 */
	private function get_remote_json( $link, $assoc = false ) {
		$content = file_get_contents( $link );
		if ( ! $content ) {
			return false;
		}

		return json_decode( $content, $assoc );
	}

	public function reset_theme_mods() {
		$mods = json_decode( file_get_contents( trailingslashit( FUNDOR_CORE_PLUGIN_DIR ) . 'reset-theme-mods.json' ) );
		foreach ( $mods as $mod ) {
			remove_theme_mod( $mod );
		}
	}

	private function updateElementor() {
		$query = new WP_Query( array(
			'post_type'      => [
				'page',
				'elementor_library',
				'header',
				'footer'
			],
			'posts_per_page' => - 1
		) );
		while ( $query->have_posts() ): $query->the_post();
			$postid = get_the_ID();
			if ( get_post_meta( $postid, '_elementor_edit_mode', true ) === 'builder' ) {
				$data = json_decode( get_post_meta( $postid, '_elementor_data', true ), true );
				$data = $this->updateElementorData( $data );
				update_post_meta( $postid, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
			}
		endwhile;
		wp_reset_postdata();
	}

	private function updateElementorData( $datas ) {
		if ( count( $datas ) <= 0 ) {
			return $datas;
		}
		foreach ( $datas as $key => $data ) {

			// Contact Form
			if ( ! empty( $data['widgetType'] ) && $data['widgetType'] === 'opal-contactform7' ) {
				$data['settings']['cf_id'] = $this->get_contact_form_id( absint( $data['settings']['cf_id'] ) );
			}

			if ( ! empty( $data['elements'] ) ) {
				$data['elements'] = $this->updateElementorData( $data['elements'] );
			}
			$datas[ $key ] = $data;
		}

		return $datas;
	}

	private function set_logo( $name = 'logo' ) {


		set_theme_mod( 'custom_logo', $this->get_image() );
	}

	private function get_image($name = 'logo'){
		$args = array(
			'posts_per_page' => 1,
			'post_type'      => 'attachment',
			'name'           => trim( $name ),
		);

		$get_attachment = new WP_Query( $args );

		if ( ! $get_attachment || ! isset( $get_attachment->posts, $get_attachment->posts[0] ) ) {
			return false;
		}

		return $get_attachment->posts[0]->ID;
	}

	private function get_contact_form_id( $id ) {
		$contact = get_page_by_title( $this->settings['contact'][ $id ], OBJECT, 'wpcf7_contact_form' );
		if ( $contact ) {
			return $contact->ID;
		}

		return $id;
	}

	private function get_image_id( $image_url ) {
		global $wpdb;
		$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );

		return $attachment[0];
	}

	private function update_url_elementor() {
		$from          = 'http://source.wpopal.com/unity';
		$to            = site_url();
		$is_valid_urls = ( filter_var( $from, FILTER_VALIDATE_URL ) && filter_var( $to, FILTER_VALIDATE_URL ) );
		if ( ! $is_valid_urls ) {
			return false;
		}

		if ( $from === $to ) {
			return false;
		}

		global $wpdb;

		// @codingStandardsIgnoreStart cannot use `$wpdb->prepare` because it remove's the backslashes
		$rows_affected = $wpdb->query(
			"UPDATE {$wpdb->postmeta} " .
			"SET `meta_value` = REPLACE(`meta_value`, '" . str_replace( '/', '\\\/', $from ) . "', '" . str_replace( '/', '\\\/', $to ) . "') " .
			"WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE '[%' ;" ); // meta_value LIKE '[%' are json formatted
		// @codingStandardsIgnoreEnd

	}

	private function set_give_thumbnail() {
		$params = array(
			'posts_per_page' => - 1,
			'post_type'      => [
				'give_forms'
			],
		);
		$thumbnail = $this->get_image('placeholder');
		$query  = new WP_Query( $params );
		while ( $query->have_posts() ): $query->the_post();
			set_post_thumbnail( get_the_ID(), $thumbnail );
		endwhile;
	}
}

return new OSF_Import();