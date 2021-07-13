<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Opal_WP_Template extends WP_Widget {

    private $sidebar_id;

    public function __construct() {
        parent::__construct(
            'opal-wp_template',
            esc_html__( 'Opal Elementor Template', 'fundor-core' ),
            [
                'description' => esc_html__( 'Embed your saved elements.', 'fundor-core' ),
            ]
        );
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        if ( ! empty( $instance['template_id'] ) ) {
            $id = apply_filters( 'wpml_object_id', $instance['template_id'], 'elementor_library' );
            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $id );
        }

        echo $args['after_widget'];
    }



    /**
     * @param array $instance
     *
     * @return void
     */
    public function form( $instance ) {
        $default = [
            'title' => '',
            'template_id' => '',
        ];

        $instance = array_merge( $default, $instance );

        $templates = Elementor\Plugin::instance()->templates_manager->get_source( 'local' )->get_items();

        $options = [
            '0' => '— ' . __( 'Select', 'fundor-core' ) . ' —',
        ];

        $types = [];

        foreach ( $templates as $template ) {
            $options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
            $types[ $template['template_id'] ] = $template['type'];
        }
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title', 'fundor-core' ); ?>:</label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'template_id' ) ); ?>"><?php esc_attr_e( 'Choose Template', 'fundor-core' ); ?>:</label>
            <select class="widefat elementor-widget-template-select" id="<?php echo esc_attr( $this->get_field_id( 'template_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'template_id' ) ); ?>">
                <option value="">— <?php _e( 'Select', 'fundor-core' ); ?> —</option>
                <?php
                foreach ( $templates as $template ) :
                    $selected = selected( $template['template_id'], $instance['template_id'] );
                    ?>
                    <option value="<?php echo $template['template_id'] ?>" <?php echo $selected; ?> data-type="<?php echo esc_attr( $template['type'] ); ?>">
                        <?php echo $template['title']; ?> (<?php echo $template['type']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <?php
            $style = ' style="display:none"';


            ?>
            <a target="_blank" class="elementor-edit-template"<?php echo $style; ?> href="<?php echo add_query_arg( 'elementor', '', get_permalink( $instance['template_id'] ) ); ?>">
                <i class="fa fa-pencil"></i> <?php echo __( 'Edit Template', 'fundor-core' ); ?>
            </a>
        </p>
        <?php
    }

    /**
     *
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = [];
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['template_id'] = $new_instance['template_id'];

        return $instance;
    }
}
