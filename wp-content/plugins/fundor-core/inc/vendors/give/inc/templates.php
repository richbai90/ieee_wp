<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class OSF_Give_Templates {
    public function __construct() {
        $this->hooks_single();

        $this->template = trailingslashit(FUNDOR_CORE_PLUGIN_DIR) . 'templates/give';

        add_action('wp_enqueue_scripts', array($this, 'add_scripts'), 100);

        add_action('wp_ajax_get_fundor_gallery', array($this, 'ajax_gallery'));
        add_action('wp_ajax_nopriv_get_fundor_gallery', array($this, 'ajax_gallery'));

        add_action('wp_ajax_get_fundor_video', array($this, 'ajax_video'));
        add_action('wp_ajax_nopriv_get_fundor_video', array($this, 'ajax_video'));

        // Wrapper
        add_filter('give_default_wrapper_start', [$this, 'template_wrapper_start']);

        // Donation Confirm
        add_action('give_email_access_form_login', [$this, 'email_access_form_login']);

        remove_action('give_single_form_summary', 'give_template_single_title', 5);
        remove_action('give_single_form_summary', 'give_get_donation_form', 10);
        remove_action('give_pre_form', 'give_show_goal_progress', 10);

        add_action('give_before_single_form_summary', [$this, 'hooks_after_sidebar'], 10);
        add_action('hooks_after_sidebar', 'give_show_goal_progress', 10);
//        add_action('hooks_after_sidebar', [$this, 'single_give_creator'], 20);
        add_action('hooks_after_sidebar', [$this, 'single_give_donor_wall'], 30);

        add_action('give_single_form_summary', 'give_get_donation_form', 300);

        add_action('pre_get_posts', [$this, 'set_posts_per_page']);

    }

	/**
	 * @param $query WP_Query
	 */
    public function set_posts_per_page($query) {
        if ($query->is_main_query() && is_post_type_archive('give_forms')) {
            $query->set('posts_per_page', '12');
        }
    }

    public function remove_default_progress_goal_color($args) {
        foreach ($args as $key => $val) {
            if (isset($val['id']) && $val['id'] === '_give_goal_color') {
                unset($args[$key]['default']);
            }
        }
        return $args;
    }

    public function add_scripts() {
        $dev_mode = get_theme_mod('osf_dev_mode', false);
        wp_enqueue_script('otf-give-script', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/give/main.js', array('jquery'), false, true);
        wp_localize_script('otf-give-script', 'fundor', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'confirm' => esc_html__('Are you sure you want to delete this item?', 'fundor-core'),
        ));

        wp_enqueue_script('osf-raphael', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/js/give/raphael-min.js', array('jquery'), false, true);

        if (class_exists('Give') && !$dev_mode) {
            wp_enqueue_style('osf-give-core', trailingslashit(FUNDOR_CORE_PLUGIN_URL) . 'assets/css/give/style.css', array(
                'fundor-style'
            ), FUNDOR_CORE_VERSION);
        }
    }


    private function hooks_single() {
        add_action('give_single_form_summary', [$this, 'single_start_form_summary'], 1);
        add_action('give_single_form_summary', [$this, 'show_form_images'], 3);
        add_action('give_single_form_summary', [$this, 'single_end_form_summary'], 6);
        add_action('give_single_form_summary', [$this, 'tab_after_summary'], 200);
        add_filter('single_give_form_large_thumbnail_size', [$this, 'update_featured_image_size']);


        remove_action('give_pre_form_output', 'give_form_content', 10);
//        add_action('give_pre_form_output', [$this, 'give_form_the_except'], 40);

        //remove default Color Process Goal
        add_filter('give_forms_donation_goal_metabox_fields', [$this, 'remove_default_progress_goal_color']);
    }

    public function hooks_after_sidebar() {

        do_action('hooks_after_sidebar', get_the_ID());

    }

    public function single_give_donor_wall() {
        ?>
        <div class="sidebar-donor-wall">
            <?php
            echo '<h2 class="widget-title">' . esc_html__('Backers', 'fundor-core') . '</h2>';
            echo do_shortcode('[give_donor_wall form_id="' . get_the_ID() . '" comment_length="20"]');
            ?>
        </div>
        <?php
    }

    public function single_give_creator() {
        $creator_id = get_the_author_meta('ID');
        $creator    = new Opal_Give_Creator($creator_id);

        ?>
        <div class="sidebar-creator">
            <?php
            echo '<h2 class="widget-title">' . esc_html__('Creator', 'fundor-core') . '</h2>';
            ?>
            <div class="d-flex align-items-center">
                <div class="creator-avatar"><?php echo $creator->get_avatar(); ?></div>
                <div class="creator-info">
                    <span class="author-name"><?php the_author(); ?></span>
                    <span class="campaigns-count"><?php echo $creator->get_donner_count() . esc_html__(' campaigns', 'fundor-core'); ?></span>
                </div>
            </div><!-- .entry-meta -->
            <div class="creator-description">
                <?php echo $creator->description; ?>
            </div>
        </div>
        <?php
    }


    public function ajax_video() {
        $give_id = $_POST['give_id'];
        $video   = osf_get_metabox($give_id, 'osf_give_video');
        wp_send_json($video);
    }

    public function ajax_gallery() {
        $give_id = $_POST['give_id'];
        $gallery = osf_get_metabox($give_id, 'osf_give_gallery');;
        wp_send_json($gallery);
    }

    public function give_form_the_except() {
        echo '<div class="give-execpt">';
        the_excerpt();
        echo '</div>';
    }


    public function tab_after_summary() {
        wp_enqueue_script("jquery-ui-tabs");
        $gallery = osf_get_metabox(get_the_ID(), 'osf_give_gallery');
        $video   = osf_get_metabox(get_the_ID(), 'osf_give_video');
        ?>
        <div id="give-form-single-tab" class="give-form-tabs">
            <ul>
                <li><a href="#tabs-1"><?php echo esc_html__('description', 'fundor-core'); ?></a></li>
                <?php if ($video) {
                    echo '<li><a href="#tabs-3">' . esc_html__('video', 'fundor-core') . '</a></li>';
                } ?>
                <?php if ($gallery) {
                    echo '<li><a href="#tabs-4">' . esc_html__('gallery', 'fundor-core') . '</a></li>';
                } ?>
            </ul>
            <div id="tabs-1">
                <?php give_form_display_content(get_the_ID(), []); ?>
            </div>

            <?php if ($video) {
                $url = esc_url(get_post_meta(get_the_ID(), 'osf_give_video', 1));
                echo '<div id="tabs-3">' . wp_oembed_get($url) . '</div>';
            }
            ?>
            <?php if ($gallery) {
                echo '<div id="tabs-4">' . do_shortcode('[gallery link="file" columns="3"  size="fundor-featured-image-small" ids="' . implode(", ", array_keys($gallery)) . '"]') . '</div>';
            }
            ?>
        </div>
        <?php
    }

    public function email_access_form_login() {
        ?>
        <div class="opal-give-message give-form">
            <div class="img-give-form">
                <i class="fa fa-envelope-o" aria-hidden="true"></i>
            </div>
            <p>
                <?php
                echo esc_html(apply_filters('give_email_access_welcome_message', __('Please verify your email to access your donation history.', 'fundor-core')));
                ?>
            </p>
        </div>
        <?php
    }

    public function template_wrapper_start() {
        return '<div id="give-wrap" class="give-wrap"><div class="give-wrap-inner">';
    }

    public function single_start_form_summary() {
        echo '<div class="summary-inner"><div class="opal-give-single-media">';
    }

    public function single_end_form_summary() {
        echo '</div></div>';
    }


    public function update_featured_image_size() {
        return 'fundor-give-single';
    }

    public function show_form_images() {
        give_get_template_part('single-give-form/featured-image');
    }
}

return new OSF_Give_Templates();