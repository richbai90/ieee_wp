<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Give')) {
    return;
}


class OSF_Elementor_Give_Form extends Widget_Base {

    public function get_name() {
        return 'opal-give-form';
    }

    public function get_title() {
        return __('Opal Give Single Form', 'fundor-core');
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
                'label'       => __('Form', 'fundor-core'),
                'type'        => Controls_Manager::SELECT,
                'options'     => $this->get_form_ids(),
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'     => __('Show Title', 'fundor-core'),
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
            'show_content',
            [
                'label'   => __('Show Content', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'above' => __('Above', 'fundor-core'),
                    'below' => __('Below', 'fundor-core'),
                    'none'  => __('None', 'fundor-core'),
                ],
                'default' => 'none'
            ]
        );

        $this->add_control(
            'display_style',
            [
                'label'   => __('Display Style', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'onpage' => __('Onpage', 'fundor-core'),
                    'modal'  => __('Modal', 'fundor-core'),
                    'reveal' => __('Reveal', 'fundor-core'),
                    'button' => __('Button', 'fundor-core'),
                ],
                'default' => 'onpage'
            ]
        );

        $this->end_controls_section();
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

    protected function render() {
        $settings = $this->get_settings_for_display();
        if (empty($settings['form_id'])) {
            return;
        }
        $atts = [
            'id'            => $settings['form_id'],
            'show_title'    => $settings['show_title'],
            'show_goal'     => $settings['show_goal'],
            'show_content'  => $settings['show_content'],
            'display_style' => $settings['display_style'],
        ];

        $code = '';
        foreach ($atts as $key => $value) {
            $code .= $key . '="' . (empty($value) ? 'false' : $value) . '" ';
        }
        echo do_shortcode('[give_form ' . $code . ' ]');

    }
}

$widgets_manager->register_widget_type(new OSF_Elementor_Give_Form());