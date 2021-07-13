<div class="site-header">
    <?php
    if (fundor_is_header_builder()) {
        fundor_the_header_builder();
    } else {
        $container = get_theme_mod('osf_header_width', false) ? 'container-fluid' : 'container';
        ?>
        <div id="opal-header-content" class="header-content osf-sticky-active">
            <div class="custom-header <?php echo esc_attr($container) ?>">
                <div class="header-main-content row d-flex align-items-center justify-content-between <?php echo esc_attr(get_theme_mod('osf_header_layout_is_sticky', false) ? ' opal-element-sticky' : ''); ?>">
                    <?php get_template_part('template-parts/header/site', 'branding'); ?>
                    <?php if (has_nav_menu('top')) : ?>
                        <div class="navigation-top">
                            <?php get_template_part('template-parts/header/navigation'); ?>
                        </div><!-- .navigation-top -->
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
