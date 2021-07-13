<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Give')) {
    return;
}

use Elementor\Controls_Manager;

class OSF_Elementor_Give_Campain extends OSF_Elementor_Carousel_Base {

    public function get_name() {
        return 'opal-give-campain';
    }

    public function get_title() {
        return __('Opal Give Form Grid', 'fundor-core');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_give_form',
            [
                'label' => __('Give Form Grid', 'fundor-core'),
            ]
        );

        $this->add_control(
            'form_id',
            [
                'label'       => __('Form ids', 'fundor-core'),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $this->get_form_ids(),
                'multiple'    => true,
                'description' => __('Enter a comma-separated list of form IDs. If empty, all published forms are displayed.', 'fundor-core'),
            ]
        );

        $this->add_control(
            'excluded_form_id',
            [
                'label'       => __('Excluded Form IDs', 'fundor-core'),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $this->get_form_ids(),
                'multiple'    => true,
                'description' => __('Enter a comma-separated list of form IDs to exclude those from the grid.', 'fundor-core'),
            ]
        );
        $enable_category = give_is_setting_enabled(give_get_option('categories', 'disabled'));
        if ($enable_category) {
            $this->add_control(
                'cats',
                [
                    'label'    => __('Category IDs', 'fundor-core'),
                    'type'     => Controls_Manager::SELECT2,
                    'options'  => $this->get_form_taxonomy(),
                    'multiple' => true,
                ]
            );
        }

        $this->add_control(
            'style',
            [
                'label'        => __('Style', 'fundor-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'style-1' => __('Style 1', 'fundor-core'),
                    'style-2' => __('Style 2', 'fundor-core'),
                ],
                'default'      => 'style-1',
                'prefix_class' => 'campain-grid-'
            ]
        );

        $this->add_control(
            'columns',
            [
                'label'       => __('Columns', 'fundor-core'),
                'type'        => Controls_Manager::SELECT,
                'options'     => [
                    '1' => __('1', 'fundor-core'),
                    '2' => __('2', 'fundor-core'),
                    '3' => __('3', 'fundor-core'),
                    '4' => __('4', 'fundor-core'),
                ],
                'default'     => 4,
                'description' => __('Sets the number of forms per row.', 'fundor-core'),
                'condition' => [
                    'style'         => 'style-1',
                    'enable_carousel'    => '',
//                    'show_paged'    => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'columns_carousel',
            [
                'label'       => __('Columns', 'fundor-core'),
                'type'        => Controls_Manager::SELECT,
                'options'     => [
                    '1' => __('1', 'fundor-core'),
                    '2' => __('2', 'fundor-core'),
                    '3' => __('3', 'fundor-core'),
                    '4' => __('4', 'fundor-core'),
                ],
                'default'     => 4,
                'description' => __('Sets the number of forms per row.', 'fundor-core'),
                'condition' => [
                    'style'         => 'style-1',
                    'enable_carousel'    => 'yes',
                    'show_paged'    => ''
                ],
            ]
        );

        $this->add_control(
            'forms_per_page',
            [
                'label'   => __('Forms Per Page', 'fundor-core'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 12,
            ]
        );

        $this->add_control(
            'show_paged',
            [
                'label'     => __('Enables/Disables pagination', 'fundor-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => 'Hide',
                'label_off' => 'Show',
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'show_goal',
            [
                'label'       => __('Show Goal', 'fundor-core'),
                'type'        => Controls_Manager::SWITCHER,
                'label_on'    => 'Hide',
                'label_off'   => 'Show',
                'default'     => 'yes',
                'description' => __('Do you want to display the goal\'s progress bar?', 'fundor-core'),
            ]
        );
        $this->add_control(
            'show_excerpt',
            [
                'label'     => __('Show Excerpt', 'fundor-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => 'Hide',
                'label_off' => 'Show',
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'   => __('Excerpt Length', 'fundor-core'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 25,
                'condition'   => [
                    'show_excerpt' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();
        $this->add_control_carousel([
            'show_paged' => ''
        ]);
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $atts = [
            'columns'             => $settings['columns'],
            'show_goal'           => $settings['show_goal'],
            'show_excerpt'        => $settings['show_excerpt'],
            'forms_per_page'      => $settings['forms_per_page'],
            'paged'               => $settings['show_paged'],
            'excerpt_length'      => $settings['excerpt_length'],
            'image_size'          => 'fundor-featured-image-large'
        ];
        if ($settings['style'] == 'style-2') {
            $atts['columns'] = 1;
        }
        if ($settings['columns'] <= 2) {
            $atts['image_size'] = 'full';
        }
        if (!empty($settings['form_id'])) {
            $atts['ids'] = implode(',', $settings['form_id']);
        }
        if (!empty($settings['form_id'])) {
            $atts['exclude'] = implode(',', $settings['excluded_form_id']);
        }
        if (!empty($settings['cats'])) {
            $atts['cats'] = implode(',', $settings['cats']);
        }
        $code = '';
        foreach ($atts as $key => $value) {
            $code .= $key . '="' . (empty($value) ? 'false' : $value) . '" ';
        }

        if ($settings['enable_carousel'] === 'yes') {
            $this->add_render_attribute('wrap', 'class', 'carousel-activate');
            $carousel_settings = array(
                'navigation'         => $settings['navigation'],
                'autoplayHoverPause' => $settings['pause_on_hover'] === 'yes' ? 'true' : 'false',
                'autoplay'           => $settings['autoplay'] === 'yes' ? 'true' : 'false',
                'autoplayTimeout'    => $settings['autoplay_speed'],
                'items'              => $settings['columns_carousel'],
                'items_tablet'       => $settings['columns_carousel_tablet'],
                'items_mobile'       => $settings['columns_carousel_mobile'],
                'loop'               => $settings['infinite'] === 'yes' ? 'true' : 'false',
                'margin'             => 40

            );
            if ($settings['style'] == 'style-2') {
                $carousel_settings['items'] = 1;
                $carousel_settings['items_tablet'] = 1;
                $carousel_settings['items_mobile'] = 1;
            }
            $this->add_render_attribute('wrap', 'data-settings', wp_json_encode($carousel_settings));
        }
        if ($settings['enable_carousel'] === 'yes') {
            echo '<div ' . $this->get_render_attribute_string('wrap') . '>';
        }

        echo do_shortcode('[give_form_grid ' . $code . ' ]');

        if ($settings['enable_carousel'] === 'yes') {
            echo '</div>';
        }
    }

    private function get_form_ids() {
        $args = array(
            'post_type'      => 'give_forms',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );
        $give_form_ids = array();
        $give_forms = get_posts($args);
        foreach ($give_forms as $give_form) {
            $form_title = empty($give_form->post_title) ? sprintf(__('Untitled (#%s)', 'fundor-core'), $give_form->ID) : $give_form->post_title;
            $give_form_ids[$give_form->ID] = $form_title;
        }
        return $give_form_ids;
    }

    private function get_form_taxonomy() {
        $enable_category = give_is_setting_enabled(give_get_option('categories', 'disabled'));
        if ($enable_category) {
            $args = array(
                'hide_empty' => false,
                'orderby'    => 'name',
                'order'      => 'ASC',
                'number'     => 0,
            );
            $terms = get_terms('give_forms_category', $args);
            $give_form_taxonomy = array();
            foreach ($terms as $term) {
                $give_form_taxonomy[$term->term_id] = $term->name;
            }
            return $give_form_taxonomy;
        }
    }
}

$widgets_manager->register_widget_type(new OSF_Elementor_Give_Campain());