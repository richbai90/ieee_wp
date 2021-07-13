<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * @var $creator Opal_Give_Creator
 */

global $wp;
$max_campign_create = !empty(get_user_meta(get_current_user_id(), 'campaign_max')) ? get_user_meta(get_current_user_id(), 'campaign_max') : 5;

if (!current_user_can('administrator')){
    $max_campign_create = (int)$max_campign_create[0];
}

if ($creator->get_campaign_count() >= $max_campign_create && !current_user_can('administrator')) {
    ?>
    <div class="profile-notification">
        <h3 class="account-title"><?php esc_html_e('User Notification', 'fundor-core');?></h3>
        <p><?php esc_html_e('Exceeds the number of posts', 'fundor-core');?></p>
    </div>
    <?php
    return;
}

$args = array(
    'taxonomy'   => 'give_forms_category',
    'orderby'    => 'name',
    'order'      => 'ASC',
    'hide_empty' => 0
);


$cats = get_categories($args);

?>
<form id="opal-frontend-campaign-form" action="<?php echo admin_url('admin-post.php') ?>" class="create-campaign-form" method="post">
    <div class="media-group">
        <label><?php echo esc_html__('Featured Image', 'fundor-core') ?></label>
        <div class="feature-thumb">

            <div class="instruction-inside">
                <input type="hidden" value="" name="featured_image" class="featured-image">
                <span><?php echo esc_html__('Upload Featured Image', 'fundor-core'); ?></span>
                <a href="#" class="osf-button-media"></a>
            </div>
            <div class="image-wrap hide">
                <a href="#" class="close remove-feat-image">&times;</a>
                <img height="" width="" src="" alt="">
            </div>
        </div>

        <ul class="campaign-gallery">
            <li class="add-image" data-title="<?php esc_html_e('Add gallery image', 'fundor-core'); ?>">
                <a href="#" class="add-gallery-images"><i class="fa fa-plus" aria-hidden="true"></i></a>
            </li>
        </ul>
    </div>
    <div class="field-group">
        <div>
            <label><?php echo esc_html__('Campaign Name', 'fundor-core') ?><span class="required">*</span></label>
            <input type="text" name="name"/>
        </div>


        <?php
        if (give_is_setting_enabled(give_get_option('categories')) && !is_wp_error($cats)) {
            ?>
            <div><label><?php echo esc_html__('Category', 'fundor-core') ?><span class="required">*</span></label>
                <select name="category">
                    <?php
                    foreach ((array)$cats as $cat) {
                        ?>
                        <option value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <?php
        }
        ?>
        
        <div>
            <label><?php echo esc_html__('Featured Video URL', 'fundor-core') ?></label>
            <input type="text" name="featured_video"/>
        </div>
        <div>
            <label><?php echo esc_html__('Funding Goal', 'fundor-core') ?></label>
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" name="goal_number"/>
            </div>
        </div>
        <div>

            <label><?php echo esc_html__('Description', 'fundor-core') ?></label>
            <?php wp_editor('', 'opal-editor-content', ['textarea_name' => 'content']); ?>
        </div>

    </div>

    <input type="submit" name="create-campaign-submit" value="<?php esc_attr_e('submit campaign', 'fundor-core'); ?>"/>

    <input type="hidden" name="action" value="opal_give_create_campaign">
    <input type="hidden" name="redirect" value="<?php echo esc_url(home_url($wp->request)) ?>">
    <?php wp_nonce_field('create-campaign'); ?>
</form>
