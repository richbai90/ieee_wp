<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * @var $campaign Give_Donate_Form
 *
 */
global $wp;

$post_id = $campaign->ID;
//$campaign = new Give_Donate_Form($post_id);


$thumbnail_id = 0;
if (has_post_thumbnail($post_id)) {
    $thumbnail_id = get_post_thumbnail_id($post_id);
}

$gallery = get_post_meta($post_id, 'osf_give_gallery', true);
$gallery = $gallery ? $gallery : [];
$featured_video = get_post_meta($post_id, 'osf_give_video', true);
$goal_number = $campaign->get_goal();

if (give_is_setting_enabled(give_get_option('categories'))) {
    $args = array(
        'taxonomy'   => 'give_forms_category',
        'hide_empty' => 0
    );

    $cats = get_categories($args);
}

$cat_post = get_the_terms($post_id,'give_forms_category');

?>
<form id="opal-frontend-campaign-form" action="<?php echo admin_url('admin-post.php') ?>" class="create-campaign-form" method="post">
    <div class="media-group">
        <label><?php echo esc_html__('Featured Image', 'fundor-core') ?></label>
        <div class="feature-thumb">

            <div class="instruction-inside<?php echo $thumbnail_id ? ' hide' : '' ?>">
                <input type="hidden" value="<?php echo esc_attr($thumbnail_id); ?>" name="featured_image" class="featured-image">
                <span><?php echo esc_html__('Upload Featured Image', 'fundor-core'); ?></span>
                <a href="#" class="osf-button-media"></a>
            </div>
            <div class="image-wrap<?php echo $thumbnail_id ? '' : ' hide' ?>">
                <a href="#" class="close remove-feat-image">&times;</a>
                <img src="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'full')) ?>" alt="<?php echo esc_attr($campaign->post_title); ?>">
            </div>
        </div>

        <ul class="campaign-gallery">
            <?php foreach ($gallery as $key => $image): ?>
                <li class="image">
                    <img src="<?php echo esc_url($image); ?>">
                    <a href="#" class="action-delete">×</a>
                    <input type="hidden" name="gallery[<?php echo esc_attr($key) ?>]" value="<?php echo esc_attr($image) ?>">
                </li>
            <?php endforeach; ?>
            <li class="add-image" data-title="<?php esc_html_e('Add gallery image', 'fundor-core'); ?>">
                <a href="#" class="add-gallery-images"><i class="fa fa-plus" aria-hidden="true"></i></a>
            </li>
        </ul>
    </div>
    <div class="field-group">
        <div>
            <label><?php echo esc_html__('Campaign Name', 'fundor-core') ?><span class="required">*</span></label>
            <input type="text" name="name" value="<?php echo esc_attr($campaign->post_title) ?>"/>
        </div>

        <?php

        if (give_is_setting_enabled(give_get_option('categories')) && !is_wp_error($cats)) {
            ?>
            <div><label><?php echo esc_html__('Category', 'fundor-core') ?><span class="required">*</span></label>
                <select name="categories" >
                    <?php
                    foreach ((array)$cats as $cat) {
                        if($cat_post[0]->term_id == $cat->term_id){
                            ?>
                            <option value="<?php echo $cat->term_id; ?>" selected><?php echo $cat->name; ?></option>
                            <?php
                        }
                        else{
                            ?>
                            <option value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
                            <?php
                        }
                        ?>
                    <?php } ?>
                </select>
            </div>
            <?php
        }

        ?>

        <div>
            <label><?php echo esc_html__('Featured Video URL', 'fundor-core') ?></label>
            <input type="text" name="featured_video" value="<?php echo esc_attr($featured_video); ?>"/>
        </div>

        <div>
            <label><?php echo esc_html__('Funding Goal', 'fundor-core') ?></label>
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" name="goal_number" value="<?php echo esc_attr(round($campaign->get_goal(), 2)); ?>"/>
            </div>
        </div>

        <div>

            <label><?php echo esc_html__('Description', 'fundor-core') ?></label>
            <?php wp_editor(get_post_meta($post_id, '_give_form_content', true), 'opal-editor-content', ['textarea_name' => 'content']); ?>

        </div>
    </div>

    <input type="submit" name="create-campaign-submit" value="<?php esc_attr_e('submit campaign', 'fundor-core'); ?>"/>

    <input type="hidden" name="id" value="<?php echo esc_attr($post_id); ?>">
    <input type="hidden" name="action" value="opal_give_edit_campaign">
    <input type="hidden" name="redirect" value="<?php echo esc_url(home_url($wp->request)) ?>">
    <?php wp_nonce_field('edit-campaign'); ?>
</form>
