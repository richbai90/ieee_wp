<?php

class OSF_WP_Widget_Recent_Posts extends WP_Widget_Recent_Posts {

    public function widget($args, $instance) {
        if (!isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }

        $title = (!empty($instance['title'])) ? $instance['title'] : __('Recent Posts', 'fundor-core');

        $title = apply_filters('widget_title', $title, $instance, $this->id_base);

        $number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
        if (!$number) {
            $number = 5;
        }
        $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;

        $r = new WP_Query(apply_filters('widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
        ), $instance));

        if (!$r->have_posts()) {
            return;
        }
        ?>
        <?php echo $args['before_widget']; ?>
        <?php
        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        ?>
        <ul>
            <?php foreach ($r->posts as $recent_post) : ?>
                <?php
                $post_title = get_the_title($recent_post->ID);
                $title      = (!empty($post_title)) ? $post_title : __('(no title)', 'fundor-core');
                ?>
                <li class="item-recent-post">
                    <?php if (has_post_thumbnail($recent_post->ID)): ?>
                        <div class="thumbnail-post"><?php echo get_the_post_thumbnail($recent_post->ID, 'fundor-thumbnail'); ?></div>
                    <?php endif; ?>
                    <div class="title-post">
                        <?php if ($show_date) : ?>
                            <span class="post-date"><?php echo get_the_date('', $recent_post->ID); ?></span>
                        <?php endif; ?>
                        <a href="<?php the_permalink($recent_post->ID); ?>"><?php echo $title; ?></a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }
}

class OSF_Event_Organizer_Widget extends WP_Widget {
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'osf_widget_event',
            'description'                 => __('Display Event Organizer', 'fundor-core'),
            'customize_selective_refresh' => true,
        );
        parent::__construct('osf_widget_event_organizer', __('OSF Event Organizer', 'fundor-core'), $widget_ops);
        $this->alt_option_name = 'osf_widget_event_organizer';
    }

    public function widget($args, $instance) {

        echo $args['before_widget'];

        ?>

        <div class="osf-event-items">
            <?php if (
                !empty(osf_get_metabox(get_the_ID(), 'osf_event_organizer_phone'))
                || !empty(osf_get_metabox(get_the_ID(), 'osf_event_organizer_mail'))
                || !empty(osf_get_metabox(get_the_ID(), 'osf_event_organizer_web'))
            ): ?>
                <div class="osf-event-item">
                    <h2 class="osf-event-title widget-title">
                        <span><?php echo __('Organizer', 'fundor-core'); ?></span>
                    </h2>
                    <div class="osf-event-content">
                        <ul>
                            <?php if (!empty(osf_get_metabox(get_the_ID(), 'osf_event_organizer_phone'))): ?>
                                <li>
                                    <span class="label"><?php echo __('Phone', 'fundor-core'); ?></span>
                                    <div>
                                        <?php echo osf_get_metabox(get_the_ID(), 'osf_event_organizer_phone');
                                        ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty(osf_get_metabox(get_the_ID(), 'osf_event_organizer_mail'))): ?>
                                <li>
                                    <span class="label"><?php echo __('Email', 'fundor-core'); ?></span>
                                    <div>
                                        <?php echo osf_get_metabox(get_the_ID(), 'osf_event_organizer_mail');
                                        ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty(osf_get_metabox(get_the_ID(), 'osf_event_organizer_web'))): ?>
                                <li>
                                    <span class="label"><?php echo __('Website', 'fundor-core'); ?></span>
                                    <div>
                                        <?php echo osf_get_metabox(get_the_ID(), 'osf_event_organizer_web');
                                        ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>

                </div>
            <?php endif; ?>
        </div>
        <?php
        echo $args['after_widget'];
    }
}

class OSF_Event_Detail_Widget extends WP_Widget {
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'osf_widget_event',
            'description'                 => __('Display Event Detail', 'fundor-core'),
            'customize_selective_refresh' => true,
        );
        parent::__construct('osf_widget_event_detail', __('OSF Event Detail', 'fundor-core'), $widget_ops);
        $this->alt_option_name = 'osf_widget_event_detail';
    }

    public function widget($args, $instance) {

        echo $args['before_widget'];
        ?>

        <div class="osf-event-items">
            <div class="osf-event-item">
                <h2 class="osf-event-title widget-title"><span><?php echo __('Details', 'fundor-core'); ?></span>
                </h2>

                <div class="osf-event-content">
                    <ul>
                        <?php if (!empty(osf_get_metabox(get_the_ID(), 'osf_event_day'))): ?>
                            <li>
                                <span class="label"><?php echo __('Start Day', 'fundor-core'); ?></span>
                                <div>
                                    <?php
                                    echo sprintf('<time class="entry-date" datetime="%1$s">%2$s</time>', date(DATE_W3C, osf_get_metabox(get_the_ID(), 'osf_event_day')), date('D, d M Y', osf_get_metabox(get_the_ID(), 'osf_event_day')));
                                    ?>
                                </div>

                            </li>
                        <?php endif; ?>
                        <?php if (!empty(osf_get_metabox(get_the_ID(), 'osf_event_date'))): ?>
                            <li>
                                <span class="label"><?php echo __('Start Time', 'fundor-core'); ?></span>
                                <div>
                                    <?php
                                    echo sprintf('<time class="entry-date" datetime="%1$s">%2$s</time>', osf_get_metabox(get_the_ID(), 'osf_event_date'), osf_get_metabox(get_the_ID(), 'osf_event_date'));
                                    ?>
                                </div>

                            </li>
                        <?php endif; ?>

                        <?php if (!empty(osf_get_metabox(get_the_ID(), 'osf_event_date_end')) && !empty(osf_get_metabox(get_the_ID(), 'osf_event_date'))): ?>
                            <li>
                                <span class="label"><?php echo __('End Time', 'fundor-core'); ?></span>
                                <div>
                                    <?php
                                    echo sprintf('<time class="entry-date" datetime="%1$s">%2$s</time>', osf_get_metabox(get_the_ID(), 'osf_event_date_end'), osf_get_metabox(get_the_ID(), 'osf_event_date_end'));
                                    ?>
                                </div>
                            </li>
                        <?php endif; ?>
                        <li>
                            <span class="label"><?php echo __('Event Category', 'fundor-core'); ?></span>
                            <div><?php the_terms(get_the_ID(), 'osf_event_category', '', ', ', '') ?></div>
                        </li>
                    </ul>

                </div>

            </div>
        </div>

        <?php
        echo $args['after_widget'];
    }
}

class OSF_Event_Venue_Widget extends WP_Widget {
    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'osf_widget_event',
            'description'                 => __('Display Event Venue', 'fundor-core'),
            'customize_selective_refresh' => true,
        );
        parent::__construct('osf_widget_event_venue', __('OSF Event Venue', 'fundor-core'), $widget_ops);
        $this->alt_option_name = 'osf_widget_event_venue';
    }

    public function widget($args, $instance) {

        echo $args['before_widget'];
        ?>

        <div class="osf-event-items">
            <?php if (
                !empty(osf_get_metabox(get_the_ID(), 'osf_event_venue_add'))
                || !empty(osf_get_metabox(get_the_ID(), 'osf_event_venue_phone'))
                || !empty(osf_get_metabox(get_the_ID(), 'osf_event_venue_web'))
            ): ?>
                <div class="osf-event-item">
                    <h2 class="osf-event-title widget-title"><span><?php echo __('Venue', 'fundor-core'); ?></span>
                    </h2>

                    <div class="osf-event-content">
                        <ul>

                            <?php if (!empty(osf_get_metabox(get_the_ID(), 'osf_event_venue_add'))): ?>
                                <li class="event_venue_add">
                                    <?php echo osf_get_metabox(get_the_ID(), 'osf_event_venue_add');
                                    ?>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty(osf_get_metabox(get_the_ID(), 'osf_event_venue_phone'))): ?>
                                <li>
                                    <span class="label"><?php echo __('Phone', 'fundor-core'); ?></span>
                                    <div>
                                        <?php echo osf_get_metabox(get_the_ID(), 'osf_event_venue_phone');
                                        ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty(osf_get_metabox(get_the_ID(), 'osf_event_venue_web'))): ?>
                                <li>
                                    <span class="label"><?php echo __('Website', 'fundor-core'); ?></span>
                                    <div>
                                        <?php echo osf_get_metabox(get_the_ID(), 'osf_event_venue_web');
                                        ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>

                </div>
            <?php endif; ?>
        </div>

        <?php
        echo $args['after_widget'];
    }
}

class OSF_Categories_Campaign_Widget extends WP_Widget {
    public function __construct() {

        $widget_ops = array(
            'classname'                   => 'osf_widget_campaign',
            'description'                 => __('Display Categories Campaign', 'fundor-core'),
            'customize_selective_refresh' => true,
        );
        parent::__construct('osf_widget_campaign_categories', __('OSF Categories Campaign', 'fundor-core'), $widget_ops);
        $this->alt_option_name = 'osf_widget_campaign_categories';
    }

    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Campaign Categories', 'fundor-core');

        echo $args['before_widget'];

        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $args_campaign = array(
            'taxonomy'   => 'give_forms_category',
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => 0
        );

        $cats = get_categories($args_campaign);


        if (give_is_setting_enabled(give_get_option('categories')) && !is_wp_error($cats)) {
            ?>
            <ul>
                <?php
                foreach ((array)$cats as $cat) {
                    $term_item = get_term($cat->term_id, 'give_forms_category');
                    ?>
                    <li class="cate-item">
                        <a href="<?php echo esc_attr(get_term_link($cat->term_id, 'give_forms_category')); ?>"><?php echo $cat->name; ?></a>

                        <?php
                        if (isset($instance['count'])) {
                            echo $term_item->count;
                        }
                        ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $instance = wp_parse_args((array)$instance, array('title' => ''));
        $count    = isset($instance['count']) ? (bool)$instance['count'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'fundor-core'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($instance['title']); ?>"/></p>
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked($count); ?> />
        <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show post counts', 'fundor-core'); ?></label>
        <br/>
        <?php
    }
}

class OSF_Widget_Recent_Post extends WP_Widget {

    public function __construct() {
        $widget_ops = array(
            'classname'                   => 'osf_widget_recent_post',
            'description'                 => __('Show list of recent post', 'fundor-core'),
            'customize_selective_refresh' => true,
        );
        parent::__construct('osf_recent_post', __('OSF Recent Posts Widget', 'fundor-core'), $widget_ops);
        $this->alt_option_name = 'osf_recent_post';
    }

    public function widget($args, $instance) {
        extract($args);
        extract($instance);

        $title      = !empty($instance['title']) ? $instance['title'] : __('Recent Post', 'fundor-core');
        $show_date  = $instance['show_date'] ? 'true' : 'false';
        $show_admin = $instance['show_admin'] ? 'true' : 'false';
        //Check

//        $tpl = WPOPAL_THEMER_TEMPLATES_DIR .'widgets/recent_post/default.php';
        $tpl_default = FUNDOR_CORE_PLUGIN_DIR . 'templates/widgets/recent_post/default.php';

//        if(  is_file($tpl) ) {
//            $tpl_default = $tpl;
//        }
        require $tpl_default;
    }

    public function update($new_instance, $old_instance) {
        $instance                = $old_instance;
        $instance['title']       = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['number_post'] = (!empty($new_instance['number_post'])) ? strip_tags($new_instance['number_post']) : '';
        $instance['show_date']   = isset($new_instance['show_date']) ? (bool)$new_instance['show_date'] : false;
        $instance['show_admin']  = isset($new_instance['show_admin']) ? (bool)$new_instance['show_admin'] : false;
        return $instance;

    }

    // Widget Backend
    public function form($instance) {
        $defaults = array('title'       => 'Latest Post',
                          'number_post' => '4',
                          'post_type'   => 'post',
        );
        $instance = wp_parse_args((array)$instance, $defaults);

        $show_date  = isset($instance['show_date']) ? (bool)$instance['show_date'] : false;
        $show_admin = isset($instance['show_admin']) ? (bool)$instance['show_admin'] : false;

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'fundor-core'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number_post')); ?>"><?php esc_html_e('Num Posts:', 'fundor-core'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number_post')); ?>" name="<?php echo esc_attr($this->get_field_name('number_post')); ?>" type="text" value="<?php echo esc_attr($instance['number_post']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>"><?php esc_html_e('Show Date', 'fundor-core'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('show_date')); ?>" name="<?php echo esc_attr($this->get_field_name('show_date')); ?>" type="checkbox" <?php checked($show_date); ?> />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_admin')); ?>"><?php esc_html_e('Show Admin', 'fundor-core'); ?></label>
            <input id="<?php echo esc_attr($this->get_field_id('show_admin')); ?>" name="<?php echo esc_attr($this->get_field_name('show_admin')); ?>" type="checkbox" <?php checked($show_admin); ?> />
        </p>
    <?php }

}

function osf_widget_registration() {
    register_widget('OSF_WP_Widget_Recent_Posts');
    register_widget('OSF_Event_Detail_Widget');
    register_widget('OSF_Event_Organizer_Widget');
    register_widget('OSF_Event_Venue_Widget');
    if (class_exists('Give')) {
        register_widget('OSF_Categories_Campaign_Widget');
    }

    register_widget('OSF_Widget_Recent_Post');
}

add_action('widgets_init', 'osf_widget_registration');