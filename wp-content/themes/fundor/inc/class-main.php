<?php

/**
 * Class fundor_setup_theme'
 */
class fundor_setup_theme {
    function __construct() {
        add_action('after_setup_theme', array($this, 'setup'));
        add_action('wp_enqueue_scripts', array($this, 'add_scripts'), 20);
        add_action('wp_head', array($this, 'pingback_header'));

        add_filter('body_class', array($this, 'add_body_class'));
        add_filter('excerpt_more', array($this, 'excerpt_more'), 1);
        add_filter('frontpage_template', array($this, 'front_page_template'));

        add_filter('wp_resource_hints', array($this, 'resource_hints'), 10, 2);

        add_action('opal_end_wrapper', array($this, 'render_menu_canvas'));
        add_filter('comment_form_default_fields', array($this, 'fundor_comment_fields'));
        add_filter('the_content_more_link', array($this, 'fundor_morelink'), 10, 2);
    }

    /**
     * Enqueue scripts and styles.
     */
    public function add_scripts() {
        $deps = [];
        if (!get_theme_mod('osf_dev_mode', false)) {
            wp_enqueue_style('fundor-opal-icon', get_theme_file_uri('assets/css/opal-icons.css'));

            wp_enqueue_style('fundor-carousel', get_theme_file_uri('assets/css/carousel.css'));

            wp_enqueue_style('fundor-boostrap', get_theme_file_uri('assets/css/opal-boostrap.css'));
            $deps = ['fundor-boostrap'];

            if (!class_exists('OSF_Scripts')) {
                wp_enqueue_style('fundor-colors', get_theme_file_uri('assets/css/color.css'), array('fundor-style'));
            }
        }

        if (fundor_is_elementor_activated()) {
            $deps[] = 'elementor-frontend';
        }
        // Add custom fonts, used in the main stylesheet.
        wp_enqueue_style('fundor-style', get_parent_theme_file_uri('style.css'), $deps);

        if (!class_exists('OSF_Scripts')) {
            $google_fonts_url = get_theme_mod('osf_theme_google_fonts', esc_url('//fonts.googleapis.com/css?family=Barlow:100,200,300,400,500,600,700,800,900|Bebas+Neue:400'));
            if ($google_fonts_url) {
                wp_enqueue_style('fundor-google-fonts', $google_fonts_url, array(), null);
            }
            wp_add_inline_style('fundor-style', get_theme_mod('osf_theme_custom_style', ''));
        }

        // Owl Carousel
        wp_enqueue_script('owl-carousel', get_theme_file_uri('/assets/js/libs/owl.carousel.js'), array('jquery'), '2.2.1', true);

        // MainJs
        wp_enqueue_script('fundor-theme-js', get_theme_file_uri('/assets/js/theme.js'), array('jquery'), '1.0', true);
        wp_localize_script('fundor-theme-js', 'osfAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

        // Sticky Sidebar
        wp_enqueue_script('fundor-theme-sticky-layout-js', get_theme_file_uri('/assets/js/sticky-layout.js'), array(
            'jquery',
            'wp-util'
        ), false, true);

        wp_register_script('pushmenu', get_theme_file_uri('/assets/js/libs/mlpushmenu.js'), array(), false, true);
        wp_register_script('pushmenu-classie', get_theme_file_uri('/assets/js/libs/classie.js'), array(), false, true);
        wp_register_script('modernizr', get_theme_file_uri('/assets/js/libs/modernizr.custom.js'), array(), false, false);

        $opal_l10n = array(
            'quote'          => '<i class="fa-quote-right"></i>',
            'smoothCallback' => '',
        );

        // ================================================================================
        // ================================================================================
        // ================================================================================
        if (has_nav_menu('top')) {
            wp_enqueue_script('pushmenu');
            wp_enqueue_script('pushmenu-classie');
            wp_enqueue_script('modernizr');
            wp_enqueue_script('fundor-navigation', get_theme_file_uri('/assets/js/navigation.js'), array('jquery'), '1.0', true);
            $opal_l10n['expand']   = esc_html__('Expand child menu', 'fundor');
            $opal_l10n['collapse'] = esc_html__('Collapse child menu', 'fundor');
            $opal_l10n['icon']     = '<i class="fa fa-angle-down"></i>';
        }

        wp_localize_script('fundor-theme-js', 'fundorJS', $opal_l10n);


        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

    }

    /**
     * Add preconnect for Google Fonts.
     *
     *
     * @param array $urls URLs to print for resource hints.
     * @param string $relation_type The relation type the URLs are printed.
     *
     * @return array $urls           URLs to print for resource hints.
     */
    public function resource_hints($urls, $relation_type) {
        if (wp_style_is('otf-fonts', 'queue') && 'preconnect' === $relation_type) {
            $urls[] = array(
                'href' => '//fonts.gstatic.com',
                'crossorigin',
            );
        }

        return $urls;
    }

    /**
     * Adds custom classes to the array of body classes.
     *
     * @param array $classes Classes for the body element.
     *
     * @return array
     */
    public function add_body_class($classes) {

        $layoutMode = get_theme_mod('osf_layout_general_layout_mode', 'wide');
        $classes[]  = 'opal-layout-' . $layoutMode;

        // Pagination
//        $classes[] = 'opal-pagination-' . get_theme_mod('osf_layout_pagination_style', '1');

        // Page Title
        $classes[] = 'opal-page-title-' . get_theme_mod('osf_layout_page_title_style', 'left-right');

        // Footer Skin
        $classes[] = 'opal-footer-skin-' . get_theme_mod('osf_colors_footer_skin', 'light');

        // Add class of group-blog to blogs with more than 1 published author.
        if (is_multi_author()) {
            $classes[] = 'group-blog';
        }

        // Add class of hfeed to non-singular pages.
        if (!is_singular()) {
            $classes[] = 'hfeed';
        }

        // Add class on front page.
        if (is_front_page() && 'posts' !== get_option('show_on_front')) {
            $classes[] = 'fundor-front-page';
        }

        if (has_nav_menu('top')) {
            $classes[] = 'opal-has-menu-top';
        }

        return $classes;
    }

    /**
     * Replaces "[...]" (appended to automatically generated excerpts) with ... and
     * a 'Continue reading' link.
     *
     * @param string $link Link to single post/page.
     *
     * @return string 'Continue reading' link prepended with an ellipsis.
     */
    public function excerpt_more($link) {
        if (is_admin()) {
            return $link;
        }

        $link = sprintf('<span class="more-link-wrap"><a href="%1$s" class="more-link">%2$s</a></span>',
            esc_url(get_permalink(get_the_ID())),
            /* translators: %s: Name of current post */
            sprintf(__('Read More <span class="screen-reader-text"> "%s"</span>', 'fundor'), get_the_title(get_the_ID()))
        );

        return ' &hellip; ' . $link;
    }

    /**
     * Add a pingback url auto-discovery header for singularly identifiable articles.
     */
    public function pingback_header() {
        if (is_singular() && pings_open()) {
            printf('<link rel="pingback" href="%s">' . "\n", get_bloginfo('pingback_url'));
        }
    }

    /**
     * Use front-page.php when Front page displays is set to a static page.
     *
     * @param string $template front-page.php.
     *
     * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
     */
    public function front_page_template($template) {
        return is_home() ? '' : $template;
    }

    public function setup() {
        load_theme_textdomain('fundor', get_template_directory() . '/languages');
        load_theme_textdomain('fundor', get_stylesheet_directory() . '/languages');

        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');

        // Set the default content width.
        $GLOBALS['content_width'] = 600;

        // This theme uses wp_nav_menu() in two locations. ex: 'social'     => __('Social Links Menu', 'poeme'),
        register_nav_menus(array(
            'top' => esc_html__('Top Menu', 'fundor'),
        ));

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, and column width.
          */
        add_editor_style(array('assets/css/editor-style.css'));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'audio',
            'status',
        ));

        // Add theme support for Custom Logo.
        add_theme_support('custom-logo', array(
            'width'       => 250,
            'height'      => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ));

        add_image_size('fundor-featured-image-full', 1400, 700, true);
        add_image_size('fundor-featured-image-large', 850, 580, true);
        add_image_size('fundor-featured-image-small', 400, 400, true);
        add_image_size('fundor-gallery-image', 400, 9999, false);
        add_image_size('fundor-avatar', 160, 160, true);
        add_image_size('fundor-thumbnail', 100, 100, true);

        // This theme allows users to set a custom background.
        add_theme_support('custom-background', array(
            'default-color' => 'fff',
        ));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        add_theme_support('opal-customize-css');
        add_theme_support('opal-admin-menu');
        add_theme_support('opal-custom-page-field');
        add_theme_support('opal-portfolio');
        add_theme_support('opal-footer-builder');
        add_theme_support('opal-header-builder');
    }

    public function render_menu_canvas() {
        echo '<nav id="opal-canvas-menu" class="opal-menu-canvas mp-menu">';
        $args = array(
            'theme_location'  => 'top',
            'menu_id'         => 'offcanvas-menu',
            'menu_class'      => 'offcanvas-menu menu menu-canvas-default',
            'container_class' => 'mainmenu'
        );
        wp_nav_menu($args);
        echo '</nav>';
    }

    public function fundor_comment_fields($fields) {
        $commenter = wp_get_current_commenter();
        $req       = get_option('require_name_email');
        $html_req  = ($req ? " required='required'" : '');

        $fields = array(
            'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" placeholder="' . esc_attr__("Name", "fundor") . '" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245"' . $html_req . ' /></p>',
            'email'  => '<p class="comment-form-email"><input id="email" name="email" type="email"  placeholder="' . esc_attr__("Email", "fundor") . '" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $html_req . ' /></p>',
            'url'    => '<p class="comment-form-url"><input id="url" name="url" type="url"  placeholder="' . esc_attr__("Website", "fundor") . '" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" /></p>',
        );

        if ( has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ) {
            $consent           = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
            $fields['cookies'] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" ' . $consent . ' />' .
                                 '<label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.','fundor' ) . '</label></p>';

            // Ensure that the passed fields include cookies consent.
            if ( isset( $args['fields'] ) && ! isset( $args['fields']['cookies'] ) ) {
                $args['fields']['cookies'] = $fields['cookies'];
            }
        }

        return $fields;
    }

    public function fundor_morelink($more_link, $more_link_text) {
        return '<span class="more-link-wrap">' . wp_kses_post($more_link) . '</span>';
    }
}

return new fundor_setup_theme();