<?php

use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

class OSF_Elementor_Team_Box extends Elementor\Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve testimonial widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'opal-team-box';
    }

    /**
     * Get widget title.
     *
     * Retrieve testimonial widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Opal Team Box', 'fundor-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-person';
    }

    public function get_categories()
    {
        return array('opal-addons');
    }

    /**
     * Register testimonial widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_team',
            [
                'label' => __('Team', 'fundor-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => __('View', 'fundor-core'),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->add_control(
            'teams',
            [
                'label' => __('Team Item', 'fundor-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Choose Image', 'fundor-core'),
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type' => Controls_Manager::MEDIA,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'name',
            [
                'label' => __('Name', 'fundor-core'),
                'default' => 'John Doe',
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __('Link Name', 'fundor-core'),
                'placeholder' => __('https://your-link.com', 'fundor-core'),
                'type' => Controls_Manager::URL,
            ]
        );

        $this->add_control(
            'job',
            [
                'label' => __('Job', 'fundor-core'),
                'default' => 'Designer',
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'fundor-core'),
                'default' => '',
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'facebook',
            [
                'label' => __('Facebook', 'fundor-core'),
                'placeholder' => __('#', 'fundor-core'),
                'default' => '#',
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'twitter',
            [
                'label' => __('Twitter', 'fundor-core'),
                'placeholder' => __('#', 'fundor-core'),
                'default' => '#',
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'youtube',
            [
                'label' => __('Youtube', 'fundor-core'),
                'placeholder' => __('#', 'fundor-core'),
                'default' => '#',
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'google',
            [
                'label' => __('Google', 'fundor-core'),
                'placeholder' => __('#', 'fundor-core'),
                'default' => '#',
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'linkedin',
            [
                'label' => __('Linkedin', 'fundor-core'),
                'placeholder' => __('#', 'fundor-core'),
                'default' => '#',
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_responsive_control(
            'team_align',
            [
                'label' => __('Alignment', 'fundor-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'fundor-core'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'fundor-core'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'fundor-core'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .elementor-teams-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Image.
        $this->start_controls_section(
            'section_style_team_image',
            [
                'label' => __('Image', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'img_space',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'img_border_radius',
            [
                'label'     => __( 'Border Radius', 'fundor-core' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px','%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Name.
        $this->start_controls_section(
            'section_style_team_name',
            [
                'label' => __('Name', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_text_color',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-teams-wrapper .elementor-team-name:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'name_text_color_hover',
            [
                'label' => __('Hover Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-teams-wrapper .elementor-team-name:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .elementor-teams-wrapper .elementor-team-name',
            ]
        );

        $this->add_responsive_control(
            'name_space',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-teams-wrapper .elementor-team-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Job.
        $this->start_controls_section(
            'section_style_team_job',
            [
                'label' => __('Job', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'job_text_color',
            [
                'label' => __('Text Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-teams-wrapper .elementor-team-job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'job_typography',
                'selector' => '{{WRAPPER}} .elementor-teams-wrapper .elementor-team-job',
            ]
        );

        $this->add_responsive_control(
            'job_space',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-teams-wrapper .elementor-team-job' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

        // Description.
        $this->start_controls_section(
            'section_style_team_description',
            [
                'label' => __('Description', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_text_color',
            [
                'label' => __('Text Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-teams-wrapper .elementor-team-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .elementor-teams-wrapper .elementor-team-job',
            ]
        );

        $this->add_responsive_control(
            'description_space',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-teams-wrapper .elementor-team-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

        // Icon Social.
        $this->start_controls_section(
            'section_style_icon_social',
            [
                'label' => __('Icon Social', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->start_controls_tabs('tabs_icon_social_style');

        $this->start_controls_tab(
            'tab_icon_social_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );

        $this->add_control(
            'color_icon_social',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',

                'selectors' => [
                    '{{WRAPPER}} .team-icon-socials a:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bg_color_icon_social',
            [
                'label' => __('Background Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',

                'selectors' => [
                    '{{WRAPPER}} .team-icon-socials a:not(:hover)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_social_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'color_icon_social_hover',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-team-socials a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bg_hover_icon_social',
            [
                'label' => __('Background Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',

                'selectors' => [
                    '{{WRAPPER}} .team-icon-socials a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrapper', 'class', 'elementor-teams-wrapper');


        // Item
        $this->add_render_attribute('item', 'class', 'elementor-team-item');

        $this->add_render_attribute('meta', 'class', 'elementor-team-meta');

        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <div <?php echo $this->get_render_attribute_string('item'); ?>>
                <?php $this->render_style($settings) ?>
            </div>
        </div>
        <?php
    }

    protected function render_style($settings)
    {
        $team_name_html = $settings['name'];
        if (!empty($settings['link']['url'])) :
            $team_name_html = '<a href="' . esc_url($settings['link']['url']) . '">' . $team_name_html . '</a>';
        endif;
        ?>

        <div class="elementor-team-meta-inner">
            <div class="elementor-team-image">
                <?php
                if (!empty($settings['image']['url'])) :
                    $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
                    echo $image_html;
                endif;
                ?>
            </div>
            <div class="elementor-team-details">
                <div class="elementor-team-name"><?php echo $team_name_html; ?></div>
                <div class="elementor-team-job"><?php echo $settings['job']; ?></div>
                <div class="elementor-team-description"><?php echo $settings['description']; ?></div>
                <div class="elementor-team-socials">
                    <ul class="team-icon-socials">
                        <?php foreach ($this->get_socials() as $key => $social): ?>
                            <?php if (!empty($settings[$key])) : ?>
                                <li class="social">
                                    <a href="<?php echo esc_url($settings[$key]) ?>">
                                        <i class="fa <?php echo esc_attr($social); ?>"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }

    private function get_socials()
    {
        return array(
            'facebook'  => 'fa-facebook',
            'twitter'   => 'fa-twitter',
            'youtube'   => 'fa-youtube',
            'google'    => 'fa-google-plus',
            'linkedin'  => 'fa-linkedin',
        );
    }

}

$widgets_manager->register_widget_type(new OSF_Elementor_Team_Box());
