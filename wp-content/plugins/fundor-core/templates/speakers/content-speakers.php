<?php
/**
 * The template for displaying product content in the content-speakers.php template
 *
 * This template can be overridden by copying it to yourtheme/template-parts/speakers/content-speakers.php.
 *
 */

defined('ABSPATH') || exit;

?>

<article class="column-item">
    <div class="speaker-item">
        <div class="speaker-image">
            <?php
            if (has_post_thumbnail()):
                the_post_thumbnail();
            endif;
            ?>
            <a class="link-detail" href="<?php the_permalink() ?>"></a>
        </div>
        <div class="speaker-details">
            <h3 class="speaker-name"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
            <div class="speaker-job"><?php echo osf_get_metabox(get_the_ID(), 'osf_speakers_job', ''); ?></div>
        </div>
    </div>
</article>

