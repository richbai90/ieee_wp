<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Give')) {
    return;
}

use Elementor\Controls_Manager;

class OSF_Elementor_Give_Search_Campain extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-give-search-campain';
    }

    public function get_title() {
        return __('Opal Give Search Campaign', 'fundor-core');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_give_form',
            [
                'label' => __('Give Search', 'fundor-core'),
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $unique_id = esc_attr(uniqid('search-form-'));
        ?>
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <div class="input-group">
                <div class="input-group-form">
                    <input type="search" id="<?php echo esc_attr($unique_id); ?>" class="search-field form-control" placeholder="<?php echo esc_attr_x('Search Campaign', 'placeholder', 'fundor-core'); ?>" value="<?php echo get_search_query(); ?>" name="s"/>
                    <input type="hidden" name="post_type" value="give_forms">
                    <?php
                    $enable_category = give_is_setting_enabled(give_get_option('categories', 'disabled'));
                    if ($enable_category) {
                        ?>
                        <select class="give-search-cat" name="give_forms_category">
                            <option value=""><?php echo esc_html__('Category', 'fundor-core'); ?></option>
                            <?php
                            $args               = array(
                                'hide_empty' => false,
                                'orderby'    => 'name',
                                'order'      => 'ASC',
                                'number'     => 0,
                            );
                            $terms              = get_terms('give_forms_category', $args);
                            $give_form_taxonomy = array();
                            foreach ($terms as $term) {
                                $give_form_taxonomy[$term->term_id] = $term->name;
                                ?>
                                <option value="<?php echo esc_attr($term->slug); ?>"><?php echo esc_attr($term->name); ?></option>
                                <?php

                            }
                            ?>
                        </select>
                        <?php
                    }
                    ?>
                </div>
                <button type="submit" class="search-submit"><?php echo esc_html__('help us now', 'fundor-core'); ?></button>
            </div>
        </form>
        <?php
    }
}

$widgets_manager->register_widget_type(new OSF_Elementor_Give_Search_Campain());