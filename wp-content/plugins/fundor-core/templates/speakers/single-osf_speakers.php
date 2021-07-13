<?php

/**
 * The template for displaying product content in the single-osf_speakers.php template
 *
 * This template can be overridden by copying it to yourtheme/single-osf_speakers.php.
 *
 */

defined('ABSPATH') || exit;

get_header(); ?>
    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">

                <?php
                /* Start the Loop */
                while (have_posts()) : the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('osf-speakers'); ?>>
                        <div class="post-inner">
                            <div class="row justify-content-between">
                                <div class="col-lg-6">
                                    <?php
                                    if (has_post_thumbnail()) : ?>
                                        <div class="single-speaker-thumbnail">
                                            <?php the_post_thumbnail('full'); ?>
                                        </div><!-- .post-thumbnail -->
                                    <?php endif;
                                    ?>
                                </div>
                                <div class="col-lg-6">
                                    <div class="speaker-entry-content">
                                        <?php the_title('<h1 class="title">', '</h1>'); ?>
                                        <div class="speaker-meta"><span class="meta-title"><?php echo esc_html__('Speciality','fundor-core');?></span><?php echo osf_get_metabox(get_the_ID(), 'osf_speakers_job', ''); ?></div>
                                        <?php
                                        $entries = get_post_meta(get_the_ID(), 'osf_speakers_repeat_group', true);
                                        foreach ((array)$entries as $key => $entry) {
                                            $desc = $title = '';
                                            ?>
                                            <div class="speaker-meta"><?php if (isset($entry['title'])): echo '<span class="meta-title">' . esc_html($entry['title']) . '</span>'; endif;
                                                if (isset($entry['description'])): echo esc_html($entry['description']); endif; ?></div>
                                            <?php
                                        }

                                        ?>
                                        <div class="speaker-desc"><?php the_content();?></div>
                                    </div><!-- .entry-content -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <?php $speaker_events = osf_get_metabox(get_the_ID(), 'osf_speaker_event_item');
                                    if (!empty($speaker_events)) {
                                        ?>
                                        <h3 class="speaker-events-title"><?php echo sprintf(__('All session <br> by %s', 'fundor-core'), get_the_title()) ?></h3>
                                        <div class="owl-theme owl-carousel speaker-schedules" data-opal-carousel="true" data-dots="true" data-nav="false" data-items="2" data-tablet="1" data-loop="false" data-margin="30">
                                            <?php

                                            foreach ((array)$speaker_events as $k => $i) {
                                                if (('osf_event' === get_post_type($k)) && (get_post_status($k) == 'publish')) {
                                                    ?>
                                                    <div class="event-item">
                                                        <div class="event-item-header">
                                                            <h4><?php echo get_the_title($k) ?></h4>
                                                            <time><?php if (!empty(osf_get_metabox($k, 'osf_event_date'))) : echo date(get_option('date_format'), strtotime(osf_get_metabox($k, 'osf_event_date'))); endif; ?></time>
                                                        </div>
                                                        <div class="event-item-content">
                                                            <?php

                                                            foreach ((array)$i as $e) {
                                                                ?>
                                                                <div class="event-item-content-inner">
                                                                    <div class="time-schedules">
                                                                        <?php if (isset($e['osf_event_time_start'])):echo date('h:ia', strtotime($e['osf_event_time_start']));endif;
                                                                        if (isset($e['osf_event_time_start'])):echo ' - ' . date('h:ia', strtotime($e['osf_event_time_end']));endif;
                                                                        echo ' | <span>' . esc_html__('By ', 'fundor-core') . '</span>';

                                                                        foreach ((array)$e['speaker'] as $k => $v) {
                                                                            echo '<a href="' . get_permalink($v) . '">' . get_the_title($v) . '</a>, ';
                                                                        }

                                                                        ?>
                                                                    </div>
                                                                    <h5 class="event-title"><?php echo !empty($e['title']) ? $e['title'] : ''; ?></h5>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                    </article><!-- #post-## -->
                <?php
                endwhile; // End of the loop.
                ?>
            </main> <!-- #main -->
        </div> <!-- #primary -->
    </div><!-- .wrap -->

<?php get_footer();
