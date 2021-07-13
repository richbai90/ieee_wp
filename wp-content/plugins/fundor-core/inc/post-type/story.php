<?php


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Class OSF_Custom_Post_Type_Story
 */
class OSF_Custom_Post_Type_Story extends OSF_Custom_Post_Type_Abstract {
    public $post_type = 'osf_story';
    public $taxonomy = 'osf_story_category';
    static $instance;

    public static function getInstance() {
        if (!isset(self::$instance) && !(self::$instance instanceof OSF_Custom_Post_Type_Story)) {
            self::$instance = new OSF_Custom_Post_Type_Story();
        }

        return self::$instance;
    }


    /**
     *
     */
    public function create_post_type() {

        $labels = array(
            'name'               => __('Stories', 'fundor-core'),
            'singular_name'      => __('Stories', 'fundor-core'),
            'add_new'            => __('Add Story', 'fundor-core'),
            'add_new_item'       => __('Add New Story', 'fundor-core'),
            'edit_item'          => __('Edit Story', 'fundor-core'),
            'new_item'           => __('New Story', 'fundor-core'),
            'all_items'          => __('Stories', 'fundor-core'),
            'view_item'          => __('View Story', 'fundor-core'),
            'search_items'       => __('Search Story', 'fundor-core'),
            'not_found'          => __('No Story found', 'fundor-core'),
            'not_found_in_trash' => __('No Story found in Trash', 'fundor-core'),
            'menu_name'          => __('Stories', 'fundor-core'),
        );

        $labels = apply_filters('osf_postype_story_labels', $labels);
        $slug_field = osf_get_option('story_settings', 'slug_story', 'story');
        $slug = isset($slug_field) ? $slug_field : "story";
        register_post_type($this->post_type,
            array(
                'labels'        => $labels,
                'supports'      => array('title', 'editor', 'excerpt', 'thumbnail'),
                'public'        => true,
                'has_archive'   => true,
                'rewrite'       => array('slug' => $slug),
                'menu_position' => 5,
                'categories'    => array(),
            )
        );
    }


    /**
     * @return void
     */
    public function create_taxonomy() {
        $labels = array(
            'name'              => __('Categories', "fundor-core"),
            'singular_name'     => __('Category', "fundor-core"),
            'search_items'      => __('Search Category', "fundor-core"),
            'all_items'         => __('All Categories', "fundor-core"),
            'parent_item'       => __('Parent Category', "fundor-core"),
            'parent_item_colon' => __('Parent Category:', "fundor-core"),
            'edit_item'         => __('Edit Category', "fundor-core"),
            'update_item'       => __('Update Category', "fundor-core"),
            'add_new_item'      => __('Add New Category', "fundor-core"),
            'new_item_name'     => __('New Category Name', "fundor-core"),
            'menu_name'         => __('Categories', "fundor-core"),
        );
        $slug_cat_field = osf_get_option('story_settings', 'slug_category_story', 'category-story');
        $slug_cat = isset($slug_cat_field) ? $slug_cat_field : "category-story";
        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_nav_menus' => false,
            'rewrite'           => array('slug' => $slug_cat)
        );
        // Now register the taxonomy
        register_taxonomy($this->taxonomy, array($this->post_type), $args);
    }

    /**
     *
     */


    public static function getStoryQuery($args = array()) {
        $default = array(
            'post_type' => 'osf_story',
        );

        $args = array_merge($default, $args);

        return new WP_Query($args);
    }

    public static function getStoryId($post_id = 0) {
        $post_ids = array();
        $array = array(
            'post__not_in' => array($post_id),
        );
        $sevices = self::getStoryQuery($array);
        while ($sevices->have_posts()) {
            $sevices->the_post();
            $post_ids[] = get_the_ID();
        }
        wp_reset_postdata();

        return $post_ids;
    }

    /**
     * @param $term_id is term_id in taxonomy
     * @param $post    is name post type
     * @param taxonomy  is name taxonomy
     */
    public static function get_story_by_term_id($term_id, $per_page = -1) {
        wp_reset_query();
        $args = array();
        if ($term_id == 0 || empty($term_id)) {
            $args = array(
                'posts_per_page' => $per_page,
                'post_type'      => "osf_story",
            );
        } else {
            $args = array(
                'posts_per_page' => $per_page,
                'post_type'      => "osf_story",
                'tax_query'      => array(
                    array(
                        'taxonomy' => "osf_story_category",
                        'field'    => 'term_id',
                        'terms'    => $term_id,
                        'operator' => 'IN'
                    )
                )
            );
        }

        return new WP_Query($args);
    }

    /**
     * @param $term_id is term_id in taxonomy
     * @param $post    is name post type
     * @param taxonomy  is name taxonomy
     */
    public static function get_story($per_page = -1) {
        wp_reset_query();
        $args = array(
            'posts_per_page' => $per_page,
            'post_type'      => "osf_story",
        );

        return new WP_Query($args);
    }

    /**
     *
     * @param $post is name post type
     * @param taxonomy  is name taxonomy
     */
    public static function get_the_term_filter_name($post, $taxonomy_name) {
        $terms = wp_get_post_terms($post->ID, $taxonomy_name, array("fields" => "names"));

        return $terms;
    }

    /**
     * Get All Categories
     *
     * @param $args
     */
    public static function getCategorystorys($per_page = 0) {
        $args = array(
            'hide_empty' => false,
            'orderby'    => 'name',
            'order'      => 'ASC',
            'number'     => $per_page,
        );
        $terms = get_terms('osf_story_category', $args);

        return $terms;
    }

    /**
     * @param $term_id is term_id in taxonomy
     * @param $post_id is id post type
     */
    public static function check_active_category_by_post_id($term_id, $post_id) {
        $termid = array();
        $terms = wp_get_post_terms($post_id, 'osf_story_category');
        foreach ($terms as $term) {
            $termid[] = $term->term_id;
        }
        if (in_array($term_id, $termid)) {
            return true;
        }

        return false;
    }

    public function widgets_init() {
        register_sidebar(array(
            'name'          => esc_html__('Story Sidebar', 'fundor-core'),
            'id'            => 'sidebar-story',
            'description'   => esc_html__('Add widgets here to appear in your Story.', 'fundor-core'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }

    public function set_sidebar($name) {
        if (is_singular('osf_story') && is_active_sidebar('sidebar-story')) {
            $name = 'sidebar-story';
        }
        return $name;
    }

    public function body_class($classes) {
        if (is_post_type_archive($this->post_type) || is_tax($this->taxonomy)) {
            if (in_array('opal-content-layout-2cr', $classes)) {
                $key = array_search('opal-content-layout-2cr', $classes);
                $classes[$key] = 'opal-content-layout-1c';
            }
        }
        if (is_singular($this->post_type) && is_active_sidebar('sidebar-story')) {
            $classes[] = 'opal-content-layout-2cr';
        }

        return $classes;
    }

}// end class
OSF_Custom_Post_Type_Story::getInstance();