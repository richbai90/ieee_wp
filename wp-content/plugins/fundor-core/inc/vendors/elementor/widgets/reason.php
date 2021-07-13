<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Control_Media;

class OSF_Elementor_Reason_Carousel extends OSF_Elementor_Carousel_Base {

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
    public function get_name() {
        return 'opal-reason_carousel';
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
    public function get_title() {
        return __('Reason Carousel', 'fundor-core');
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
    public function get_icon() {
        return 'eicon-slider-push';
    }

    public function get_categories() {
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
    protected function _register_controls() {
        $this->start_controls_section(
            'section_text_carousel',
            [
                'label' => __('Content', 'fundor-core'),
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'image',
            [
                'label'   => __('Choose Image', 'fundor-core'),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label'       => __('Title', 'fundor-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Title', 'fundor-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'contents',
            [
                'label'       => __('Content Item', 'fundor-core'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'title'   => __('Title 1', 'fundor-core'),
                    ],
                    [
                        'title'   => __('Title 2', 'fundor-core'),
                    ],
                    [
                        'title'   => __('Title 3', 'fundor-core'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'text_alignment',
            [
                'label'     => __('Alignment', 'fundor-core'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'left',
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'fundor-core'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'fundor-core'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'fundor-core'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'header_size',
            [
                'label'   => __('HTML Tag', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'h4',
            ]
        );


        $this->add_responsive_control(
            'column',
            [
                'label'           => __('Columns', 'fundor-core'),
                'type'            => \Elementor\Controls_Manager::SELECT,
                'options'         => [1 => 1, 2 => 2, 3 => 3],
                'desktop_default' => 3,
                'tablet_default'  => 2,
                'mobile_default'  => 1,
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => __('View', 'fundor-core'),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );
        $this->end_controls_section();

        // Title Style.
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __('Title', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Title Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->end_controls_section();


        // Carousel Option
//        $this->add_control_carousel();

    }

    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['contents']) && is_array($settings['contents'])) {

            $this->add_render_attribute('wrapper', 'class', 'elementor-reacon_carousel-wrapper');

            // Row
            $this->add_render_attribute('row', 'class', 'row');

            $this->add_render_attribute('row', 'class', 'owl-carousel owl-theme');

            $carousel_settings = array(
                'navigation'         => $settings['navigation'],
                'autoplayHoverPause' => $settings['pause_on_hover'] === 'yes' ? 'true' : 'false',
                'autoplay'           => $settings['autoplay'] === 'yes' ? 'true' : 'false',
                'autoplayTimeout'    => $settings['autoplay_speed'],
                'items'              => $settings['column'],
                'items_tablet'       => $settings['column_tablet'],
                'items_mobile'       => $settings['column_mobile'],
                'loop'               => $settings['infinite'] === 'yes' ? 'true' : 'false',

            );
            $this->add_render_attribute('row', 'data-settings', wp_json_encode($carousel_settings));

            // Item
            $this->add_render_attribute('item', 'class', 'elementor-content-item');
            $this->add_render_attribute('item', 'class', 'column-item');

            $this->add_render_attribute('meta', 'class', 'elementor-content-meta');

            $this->add_render_attribute('title', 'class', 'elementor-heading-title');

            $order_number = 1;

            ?>
            <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                <div <?php echo $this->get_render_attribute_string('row') ?>>
                    <?php foreach ($settings['contents'] as $content): ?>
                        <div <?php echo $this->get_render_attribute_string('item'); ?>>
                            <div class="elementor-content-item-inner">
                                <?php
                                $html = '';
                                if (!empty($content['image']['url'])) {
                                    $this->add_render_attribute('image', 'src', $content['image']['url']);
                                    $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($content['image']));
                                    $this->add_render_attribute('image', 'title', Control_Media::get_image_title($content['image']));
                                    $content['image_size']             = $settings['image_size'];
                                    $content['image_custom_dimension'] = $settings['image_custom_dimension'];

                                    if ($settings['hover_animation']) {
                                        $this->add_render_attribute('image-wrapper', 'class', 'elementor-animation-' . $settings['hover_animation']);
                                    }
                                    $this->add_render_attribute('image-wrapper', 'class', 'elementor-image-box-img');

                                    $image_html = Group_Control_Image_Size::get_attachment_image_html($content, 'image', 'image');
                                    if (!empty($content['image']['url'])) {
                                        $image_url = $content['image']['url'];
                                        $path_parts = pathinfo($image_url);
                                        if ($path_parts['extension'] === 'svg') {
                                            $image = $this->get_settings_for_display('image');
                                            if ($image['id']) {
                                                $pathSvg = get_attached_file($image['id']);
                                                $image_html = osf_get_icon_svg($pathSvg);
                                            }

                                        }
                                    }
                                    //SVG
                                    $html .= '<div class="elementor-image-framed">';
                                    $html .= '<figure ' . $this->get_render_attribute_string("image-wrapper") . '>' . $image_html . '</figure>';
                                    $html .= '</div>';
                                    echo $html;
                                }
                                ?>
                                <div class="elementor-content-wrap">
                                    <div class="elementor-reason-number">
                                        <span>
                                              <?php
                                                    if($order_number<10) {
                                                        echo '0' . $order_number++;
                                                    }
                                                    else{
                                                        echo $order_number++;
                                                    }
                                              ?>
                                        </span>
                                    </div>
                                    <div class="elementor-reason-title">
                                        <?php printf('<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string('title'), $content['title']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        }
    }

}

$widgets_manager->register_widget_type(new OSF_Elementor_Reason_Carousel());
