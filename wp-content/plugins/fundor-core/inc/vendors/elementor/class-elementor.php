<?php

use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class OSF_Elementor_Addons {
    public function __construct() {
        $this->include_addons();
        add_action('elementor/init', array($this, 'add_category'));
        add_action('elementor/widgets/widgets_registered', array($this, 'include_widgets'));

        add_action('wp', [$this, 'regeister_scripts_frontend']);

        add_action('elementor/frontend/after_enqueue_scripts', [$this, 'enqueue_scripts_frontend']);
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'add_scripts_editor']);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_icons'], 99);

        add_action('widgets_init', array($this, 'register_wp_widgets'));


        add_action('after_switch_theme', array($this, 'set_elementor_option'));
        add_action('customize_save_after', array($this, 'set_elementor_option'));

        add_action('init', array($this, 'setup_global_css'));

        // Custom Animation Scroll
        add_filter('elementor/controls/animations/additional_animations', [$this, 'add_animations_scroll']);

    }

    public function add_animations_scroll($animations) {
        $animations['Opal Animation'] = [
            'opal-move-up'    => 'Move Up',
            'opal-move-down'  => 'Move Down',
            'opal-move-left'  => 'Move Left',
            'opal-move-right' => 'Move Right',
            'opal-flip'       => 'Flip',
            'opal-helix'      => 'Helix',
            'opal-scale-up'   => 'Scale',
            'opal-am-popup'   => 'Popup',
        ];
        return $animations;
    }

    public function enqueue_editor_icons() {
        wp_enqueue_style(
            'fundor-editor-icon',
            trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/css/elementor/icons.css',
            [],
            FUNDOR_CORE_VERSION
        );
    }

    public function custom_shapes($additional_shapes) {
        $additional_shapes['mycustomshapesvgfilename'] = [
            'title'        => _x('Opal Shape', 'Shapes', 'fundor-core'),
            'has_negative' => true,
            'path'         => trailingslashit(FUNDOR_CORE_PLUGIN_DIR) . 'assets/images/shapes/opal-shape.svg'
        ];
        return $additional_shapes;
    }

    public function setup_global_css() {
        if (!get_transient('opal-customizer-update-color')) {
            return;
        }
        delete_transient('opal-customizer-update-color');
        $global = new Elementor\Core\Files\CSS\Global_CSS('global.css');
        $global->update_file();

    }

    public function set_elementor_option() {
        $color_primary   = get_theme_mod('osf_colors_general_primary', '#0160b4');
        $color_secondary = get_theme_mod('osf_colors_general_secondary', '#00c484');
        $body_color      = get_theme_mod('osf_colors_general_body', '#222222');
        $scheme_colors   = array_values(get_option('elementor_scheme_color'));
        if ($color_primary != $scheme_colors[0] || $color_secondary != $scheme_colors[1] || $body_color != $scheme_colors[2]) {
            update_option('elementor_scheme_color', [
                '1' => $color_primary,
                '2' => $color_secondary,
                '3' => $body_color,
                '4' => $scheme_colors[3],
            ]);
            set_transient('opal-customizer-update-color', true, MINUTE_IN_SECONDS);
        }
    }

    private function include_addons() {
        $files = glob(trailingslashit(FUNDOR_CORE_PLUGIN_DIR) . 'inc/vendors/elementor/addons/*.php');
        foreach ($files as $file) {
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }

    public function register_wp_widgets() {
        require_once 'widgets/wp_template.php';
        register_widget('Opal_WP_Template');
    }

    function regeister_scripts_frontend() {
        $dev_mode = get_theme_mod('osf_dev_mode', false);
        wp_register_style('magnific-popup', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/css/magnific-popup.css');
        wp_register_style('tooltipster-bundle', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/css/tooltipster.bundle.min.css', array(), FUNDOR_CORE_VERSION, 'all');
        wp_register_style('scrollbar', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/css/jquery.scrollbar.css', array(), FUNDOR_CORE_VERSION, 'all');

        wp_register_script('magnific-popup', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.magnific-popup.min.js', array('jquery'), false, true);
        wp_register_script('spritespin', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/spritespin.js');


        wp_register_script('tweenmax', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/TweenMax.min.js', array('jquery'), FUNDOR_CORE_VERSION, true);
        wp_register_script('parallaxmouse', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/jquery-parallax.js', array('jquery'), FUNDOR_CORE_VERSION, true);
        wp_register_script('tilt', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/universal-tilt.min.js', array('jquery'), FUNDOR_CORE_VERSION, true);
        wp_register_script('waypoints', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.waypoints.js', array('jquery'), FUNDOR_CORE_VERSION, true);

        wp_register_script('smartmenus', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.smartmenus.min.js', array('jquery'), FUNDOR_CORE_VERSION, true);
        wp_register_script('tooltipster-bundle-js', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/tooltipster.bundle.min.js', array(), FUNDOR_CORE_VERSION, true);
        wp_register_script('scrollbar', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.scrollbar.min.js', array(), FUNDOR_CORE_VERSION, true);

        wp_register_script('fullpage', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/fullpage.min.js', array('jquery'), FUNDOR_CORE_VERSION, true);

        wp_register_script('pushmenu', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/mlpushmenu.js', array(), FUNDOR_CORE_VERSION, true);
        wp_register_script('pushmenu-classie', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/classie.js', array(), FUNDOR_CORE_VERSION, true);
        wp_register_script('modernizr', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/modernizr.custom.js', array(), FUNDOR_CORE_VERSION, false);

        wp_register_script('hoverdir', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.hoverdir.js', array(), FUNDOR_CORE_VERSION, true);

        wp_register_script('imagesloaded', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/imagesloaded.pkgd.min.js', array(), FUNDOR_CORE_VERSION, true);
        wp_register_script('masonry', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/masonry.pkgd.min.js', array(), FUNDOR_CORE_VERSION, true);
        wp_register_script('anime', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/anime.min.js', array(), FUNDOR_CORE_VERSION, true);
        wp_register_script('chart', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/chart.min.js', array(), FUNDOR_CORE_VERSION, true);
        wp_register_script('isotope', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/libs/isotope.pkgd.min.js', array(), FUNDOR_CORE_VERSION, true);

        if (osf_is_elementor_activated() && !$dev_mode) {
            wp_enqueue_style('osf-elementor-addons', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/css/elementor/style.css', array(
                'fundor-style'
            ), FUNDOR_CORE_VERSION);
        }

    }

    public function add_scripts_editor() {
        wp_enqueue_script('opal-elementor-admin-editor', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/elementor/admin-editor.js', [], false, true);
    }

    public function enqueue_scripts_frontend() {
        wp_enqueue_script('opal-elementor-frontend', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/elementor/frontend.js', ['jquery'], false, true);
    }

    public function add_category() {
        Elementor\Plugin::instance()->elements_manager->add_category(
            'opal-addons',
            array(
                'title' => __('Opal Addons', 'fundor-core'),
                'icon'  => 'fa fa-plug',
            ),
            1);
    }

    /**
     * @param $widgets_manager Elementor\Widgets_Manager
     */
    public function include_widgets($widgets_manager) {
        require 'abstract/carousel.php';
        require 'abstract/button.php';
        $files = glob(trailingslashit(FUNDOR_CORE_PLUGIN_DIR) . 'inc/vendors/elementor/widgets/*.php');
        foreach ($files as $file) {
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }

}

new OSF_Elementor_Addons();