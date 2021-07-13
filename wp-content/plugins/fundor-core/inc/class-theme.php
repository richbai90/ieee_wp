<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class OSF_Theme_Setup
 */
class OSF_Theme_Setup {

    public function __construct() {
        add_filter('osf_customizer_buttons', array($this, 'add_customizer_buttons'));
        add_action('customize_register', array($this, 'customize_register'), 99);
        add_filter('opal_theme_sidebar', array($this, 'init_sidebar'));
        add_filter('body_class', array($this, 'add_body_class'));
        add_action('template_redirect', array($this, 'redirect_maintenance'), -1);
        add_action('wp_footer', array($this, 'render_html_back_to_top'));
        add_action('wp_footer', array($this, 'render_html_background_video'));

        // Add Background Button Editor
        add_action('init', array($this, 'editor_background_color'));
        add_filter('tiny_mce_before_init', array($this, 'customize_text_sizes'), 1);

        add_action('widgets_init', array($this, 'widgets_init'), 9);
        add_filter('oembed_dataparse', array($this, 'responsive_embed'), 10, 3);

        add_action('cmb2_admin_init', array($this, 'add_settings_page'));
    }

    public function add_settings_page() {
        /**
         * Registers main options page menu item and form.
         */
        $args = array(
            'id'           => 'api_key',
            'title'        => esc_html__('Settings', 'fundor-core'),
            'object_types' => array('options-page'),
            'option_key'   => 'opal-settings',
            'tab_group'    => 'opal_settings',
            'tab_title'    => esc_html__('API Key', 'fundor-core'),
            'parent_slug'  => 'opal-theme', // Make options page a submenu item of the themes menu.
        );
        // 'tab_group' property is supported in > 2.4.0.
        if (version_compare(CMB2_VERSION, '2.4.0')) {
            $args['display_cb'] = array($this, 'options_display_with_tabs');
        }
        $main_options = new_cmb2_box($args);
        $main_options->add_field(array(
            'name'        => esc_html__('Google API key', 'fundor-core'),
            'description' => sprintf(__('Please go to <a href="%s" target="_blank">Google developers page</a> to get API key.', 'fundor-core'), 'https://developers.google.com/maps/documentation/javascript/get-api-key'),
            'id'          => 'api_key',
            'type'        => 'text',
        ));
    }

    public function widgets_init() {
        register_sidebar(array(
            'name'          => esc_html__('Single Posts Sidebar', 'fundor-core'),
            'id'            => 'sidebar-single-post',
            'description'   => esc_html__('Add widgets here to appear in your sidebar on single posts.', 'fundor-core'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));

        register_sidebar(array(
            'name'          => esc_html__('Blog Sidebar', 'fundor-core'),
            'id'            => 'sidebar-blog',
            'description'   => esc_html__('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'fundor-core'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));

        register_sidebar(array(
            'name'          => esc_html__('Page Sidebar', 'fundor-core'),
            'id'            => 'sidebar-page',
            'description'   => esc_html__('Add widgets here to appear in your pages.', 'fundor-core'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }

    public function editor_background_color() {
        /* Add the button/option in second row */
        add_filter('mce_buttons_2', array($this, 'editor_background_color_button'), 1, 2); // 2nd row
    }

    public function editor_background_color_button($buttons, $id) {
        /* Only add this for content editor, you can remove this line to activate in all editor instance */
        if ('content' != $id) {
            return $buttons;
        }
        /* Add the button/option after 4th item */
        array_splice($buttons, 4, 0, 'backcolor');

        array_shift($buttons);
        array_unshift($buttons, 'fontsizeselect');

        return $buttons;
    }

    public function customize_text_sizes($initArray) {
        $initArray['fontsize_formats'] = "10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 32px 34px 36px 38px 40px 42px";

        return $initArray;
    }

    public function modal_login_register() {
        include_once trailingslashit(FUNDOR_CORE_PLUGIN_DIR) . 'templates/modal/login-register-form.php';
    }


    public function add_body_class($classes) {
        $classes[] = 'opal-style';
        if (is_single()) {
            $classes[] = 'opal-single-post-style';
        }
        if (osf_is_blog_archive() && ('post' == get_post_type())) {
            $classes[] = 'opal-archive-style-' . get_theme_mod('osf_blog_archive_style', 1);
            if (is_active_sidebar('sidebar-blog')) {
                $classes[] = 'opal-content-layout-2cr';
            }
        } elseif (is_singular('post') && is_active_sidebar('sidebar-single-post')) {
            $classes[] = 'opal-content-layout-2cr';
        } elseif (is_page() && osf_get_metabox(get_the_ID(), 'osf_enable_sidebar_page')) {
            $classes[] = 'opal-content-layout-2cr';
        }

        // Sidebar Skin
        if (get_theme_mod('osf_layout_sidebar_is_boxed', false)) {
            $classes[] = 'opal-sidebar-boxed';
            if (get_theme_mod('osf_layout_sidebar_title_outside', false)) {
                $classes[] = 'opal-sidebar-title-outside';
            }
        }

        //Fixed footer
        if (is_page()) {
            $fixed_footer = osf_get_metabox(get_the_ID(), 'osf_enable_fixed_footer', false);
        } else {
            $fixed_footer = get_theme_mod('osf_fixed_footer', false);
        }
        if ($fixed_footer) {
            $classes[] = 'footer-fixed';
        }

        if (get_theme_mod('osf_header_layout_is_sticky', false)) {
            $classes[] = 'header-sticky-enable';
        }

        // Check Devices
        global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
        if ($is_lynx) {
            $classes[] = 'lynx';
        } elseif ($is_gecko) {
            $classes[] = 'gecko';
        } elseif ($is_opera) {
            $classes[] = 'opera';
        } elseif ($is_NS4) {
            $classes[] = 'ns4';
        } elseif ($is_safari) {
            $classes[] = 'safari';
        } elseif ($is_chrome) {
            $classes[] = 'chrome';
        } elseif ($is_IE) {
            $classes[] = 'ie';
            if (preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version)) {
                $classes[] = 'ie' . $browser_version[1];
            }
        } else {
            $classes[] = 'unknown';
        }
        if ($is_iphone) {
            $classes[] = 'platform-iphone';
        }
        if (stristr($_SERVER['HTTP_USER_AGENT'], "mac")) {
            $classes[] = 'platform-osx';
        } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "linux")) {
            $classes[] = 'platform-linux';
        } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "windows")) {
            $classes[] = 'platform-windows';
        }

        return $classes;
    }

    public function add_search_to_main_nav($items, $args) {
        if ('top' == $args->theme_location) {
            global $osf_header;
            if ($osf_header && $osf_header instanceof WP_Post) {
                if (osf_get_metabox($osf_header->ID, 'osf_enable_search_form', false)) {
                    return $this->set_main_nav_content($items);
                }

                return $items;
            }
            if (get_theme_mod('osf_header_layout_enable_search_form_in_menu', true)) {
                return $this->set_main_nav_content($items);
            }
        }

        return $items;
    }

    private function set_main_nav_content($items) {
        $id    = wp_generate_uuid4();
        $items .= '<li class="megamenu-item menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-search" data-level="0" >';
        $items .= '<a data-search-toggle="toggle" data-target=".' . $id . '" class="fa fa-search" title="' . __("search", "fundor-core") . '"></a>';
        $items .= '<ul class="otf-dropdown search_nav sub-menu ' . $id . '"><li>';
        ob_start();
        get_template_part('template-parts/header/search-form');
        $items .= ob_get_clean();
        $items .= '</li></ul>';
        $items .= '</li>';

        return $items;
    }

    public function init_sidebar($sidebar) {
        if (is_singular('post') && is_active_sidebar('sidebar-single-post')) {
            $sidebar = 'sidebar-single-post';
        } elseif (osf_is_blog_archive() && is_active_sidebar('sidebar-blog') && ('post' == get_post_type())) {
            $sidebar = 'sidebar-blog';
        } elseif (is_page()) {
            if (osf_get_metabox($page_id = get_the_ID(), 'osf_enable_sidebar_page') == 1) {
                $sidebar_page = osf_get_metabox($page_id, 'osf_sidebar');
                if ($sidebar_page) {
                    $sidebar = $sidebar_page;
                }
            }

        }

        return $sidebar;
    }

    public function render_html_back_to_top() {
        if (get_theme_mod('osf_back_to_top_footer') == true) {
            echo <<<HTML
        <a href="#" class="scrollup"><span class="icon fa fa-angle-up"></span></a>
HTML;
        }
    }

    public function render_html_background_video() {

        $url   = empty(osf_get_metabox(get_the_ID(), 'osf_background_video')) ? get_theme_mod('osf_background_video_url') : osf_get_metabox(get_the_ID(), 'osf_background_video');
        $media = get_theme_mod('osf_background_video_media');

        if (!empty($url) || !empty($media)) {
            ?>
            <div class="osf-background-video">
                <?php
                echo '<video autoplay muted loop>';
                if (!empty($url)) {
                    echo '<source src="' . esc_url($url) . '" type="video/mp4">';
                } else {
                    echo '<source src="' . esc_url(wp_get_attachment_url($media)) . '" type="video/mp4">';
                }
                echo '</video>';
                ?>
            </div>
            <?php
        }

        $url_parallax = empty(osf_get_metabox(get_the_ID(),'osf_background_parallax')) ? wp_get_attachment_url(get_theme_mod('osf_background_parallax')) : osf_get_metabox(get_the_ID(),'osf_background_parallax');

        if (!empty($url_parallax)) {
            echo '<div class="body-background"><div class="body-background-inner" style="background-image: url(' . esc_url($url_parallax) . '); transform: translate(-50%, -50%) scale(1);"></div></div>';
        }
    }


    /**
     * @param $wp_customize WP_Customize_Manager
     */
    public function customize_register($wp_customize) {
        $wp_customize->get_setting('blogname')->transport         = 'postMessage';
        $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
        $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

        $wp_customize->get_control('background_color')->section  = 'osf_colors_general';
        $wp_customize->get_control('background_color')->priority = 5;

        $wp_customize->get_control('background_color')->section = 'osf_colors_general';

        // Move background color setting alongside Colors > General.
        $wp_customize->get_control('background_color')->section  = 'osf_colors_general';
        $wp_customize->get_control('background_color')->priority = 5;

        // Move background image setting alongside Colors > General.
        $wp_customize->get_control('background_image')->section       = 'osf_colors_general';
        $wp_customize->get_control('background_image')->priority      = 5;
        $wp_customize->get_control('background_preset')->section      = 'osf_colors_general';
        $wp_customize->get_control('background_preset')->priority     = 5;
        $wp_customize->get_control('background_position')->section    = 'osf_colors_general';
        $wp_customize->get_control('background_position')->priority   = 5;
        $wp_customize->get_control('background_size')->section        = 'osf_colors_general';
        $wp_customize->get_control('background_size')->priority       = 5;
        $wp_customize->get_control('background_repeat')->section      = 'osf_colors_general';
        $wp_customize->get_control('background_repeat')->priority     = 5;
        $wp_customize->get_control('background_attachment')->section  = 'osf_colors_general';
        $wp_customize->get_control('background_attachment')->priority = 5;

        $wp_customize->add_setting('osf_background_video_media', array(
            'transport'         => 'postMessage',
            'sanitize_callback' => 'absint'
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'osf_background_video_media', array(
            'label'     => __('Select Video', 'fundor-core'),
            'mime_type' => 'audio',
            'section'   => 'osf_colors_general',
            'priority'  => 6,
        )));

        $wp_customize->add_setting('osf_background_parallax', array(
            'transport'         => 'postMessage',
            'sanitize_callback' => 'absint'
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'osf_background_parallax', array(
            'label'     => __('Select Image', 'fundor-core'),
            'mime_type' => 'image',
            'section'   => 'osf_colors_general',
            'priority'  => 8,
        )));


    }

    public function redirect_maintenance() {
        // Check what kind of page was requested
        $maintenance = get_theme_mod('osf_maintenance', false);
        if ($maintenance && !is_user_logged_in() && !is_admin()) {
            $page = get_theme_mod('osf_maintenance_page');
            if (!empty($page) && $page != get_the_ID()) {
                wp_redirect(get_permalink($page));
                exit;
            }
        }

    }

    function responsive_embed($html, $data, $url) {
        return $html !== '' ? '<div class="embed-container">' . $html . '</div>' : '';
    }

    /**
     * @param $buttons
     *
     * @return array
     */
    public function add_customizer_buttons($buttons) {
        $buttons = wp_parse_args($buttons, array(
            'html'                                       => array(
                array(
                    'id'   => 'osf_colors_general',
                    'icon' => 'color',
                    'type' => 'section',
                ),
                array(
                    'id'   => 'osf_layout_general',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
                array(
                    'id'   => 'osf_typography_general',
                    'icon' => 'typography',
                    'type' => 'section',
                ),
            ),
            '.entry-title,.heading,.vc_separator h4'     => array(
                array(
                    'id'   => 'osf_typography_general',
                    'icon' => 'typography',
                    'type' => 'section',
                ),
            ),
            '#colophon'                                  => array(
                array(
                    'id'   => 'osf_footer',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
                array(
                    'id'   => 'osf_colors_footer',
                    'icon' => 'color',
                    'type' => 'section',
                ),
                array(
                    'id'   => 'osf_typography_footer',
                    'icon' => 'typography',
                    'type' => 'section',
                ),
            ),
            '#masthead'                                  => array(
                array(
                    'id'   => 'osf_header',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
                array(
                    'id'   => 'osf_colors_header',
                    'icon' => 'color',
                    'type' => 'section',
                ),
            ),
            '#opal-canvas-menu'                          => array(
                array(
                    'id'   => 'osf_mobile',
                    'icon' => 'default',
                    'type' => 'section',
                ),
            ),
            'blockquote'                                 => array(
                array(
                    'id'   => 'osf_typography_quotes',
                    'icon' => 'typography',
                    'type' => 'section',
                ),
                array(
                    'id'   => 'osf_colors_quotes',
                    'icon' => 'color',
                    'type' => 'section',
                ),
            ),
            'aside#secondary'                            => array(
                array(
                    'id'   => 'osf_colors_sidebar',
                    'icon' => 'color',
                    'type' => 'section',
                ),
                array(
                    'id'   => 'osf_typography_sidebar',
                    'icon' => 'typography',
                    'type' => 'section',
                ),
                array(
                    'id'   => 'osf_layout_sidebar',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
            ),
            '.page-title-bar'                            => array(
                array(
                    'id'   => 'osf_colors_page_title',
                    'icon' => 'color',
                    'type' => 'section',
                ),
            ),
            '#comments .comment-list'                    => array(
                array(
                    'id'      => 'osf_comment_template_skin',
                    'icon'    => 'layout',
                    'type'    => 'control',
                    'trigger' => '.button-change-image|click',
                ),
            ),
            '#commentform'                               => array(
                array(
                    'id'      => 'osf_comment_template_form',
                    'icon'    => 'layout',
                    'type'    => 'control',
                    'trigger' => '.button-change-image|click',
                ),
            ),
            '.nav-links'                                 => array(
                array(
                    'id'      => 'osf_blog_single_navigation',
                    'icon'    => 'layout',
                    'type'    => 'control',
                    'trigger' => '.button-change-image|click',
                ),
            ),
            '.single-post #content'                      => array(
                array(
                    'id'   => 'osf_blog_single',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
            ),
            'body.blog #content, body.category #content' => array(
                array(
                    'id'   => 'osf_blog_archive',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
            ),
            'body.error404 #content'                     => array(
                array(
                    'id'   => 'osf_404_page_setting',
                    'icon' => 'layout',
                    'type' => 'section',
                ),
            ),
            '.mainmenu-container .top-menu'              => array(
                array(
                    'id'   => 'osf_typography_mainmenu',
                    'icon' => 'typography',
                    'type' => 'section',
                ),
            )
        ));

        return $buttons;
    }
}

new OSF_Theme_Setup();

