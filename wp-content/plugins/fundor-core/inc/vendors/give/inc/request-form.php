<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class OSF_Give_Request_Form {
    private $link_redirect;

    public function __construct() {
        add_action('admin_post_opal_give_create_campaign', [$this, 'create_campaign']);
        add_action('admin_post_opal_give_edit_campaign', [$this, 'edit_campaign']);
        add_action('wp_ajax_opal_give_creator_avatar', [$this, 'update_avatar']);

        add_action('wp_ajax_opal_give_delete_campaign', [$this, 'delete_campaign']);

        add_action('admin_post_opal_edit_user_creator', [$this, 'edit_custom_user_profile_fields']);
    }

    public function update_avatar() {
        $avatar_id = $_REQUEST['avatar_id'];
        $user_id   = get_current_user_id();

        wp_send_json(['result' => update_user_meta($user_id, '_creator_avatar_id', $avatar_id)]);
    }

    public function edit_campaign() {

        //setup Redirect Link
        if (isset($_REQUEST['redirect']) && $_REQUEST['redirect']) {
            $this->link_redirect = $_REQUEST['redirect'];
        } else {
            $this->link_redirect = home_url();
        }

        if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'edit-campaign')) {
            // Security Check
            $this->link_redirect = home_url('404');
            $this->redirect(3);
        }

        if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id']) || get_post_field('post_author', $_REQUEST['id']) != get_current_user_id()) {
            $this->link_redirect = home_url('404');
            $this->redirect(3);

            return;
        }

        $args = array(
            'ID'         => $_REQUEST['id'],
            'post_title' => $_REQUEST["name"],
        );

        wp_update_post($args);

        $this->update_data($_REQUEST['id']);
        $this->redirect(1);
    }

    public function create_campaign() {
        //setup Redirect Link
        if (isset($_REQUEST['redirect']) && $_REQUEST['redirect']) {
            $this->link_redirect = $_REQUEST['redirect'];
        } else {
            $this->link_redirect = home_url();
        }

        if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'create-campaign')) {
            // Security Check
            $this->link_redirect = home_url('404');
            $this->redirect(3);
        }

        $user = wp_get_current_user();

        // Create Form
        $post_id = wp_insert_post([
            'post_title'  => $_REQUEST["name"],
            'post_type'   => 'give_forms',
            'post_author' => $user->ID
        ]);

        $this->update_data($post_id);

        do_action('opal_frontend_give_submit_form', $post_id);

        $this->redirect(1);
    }

    private function update_data($post_id) {
        $user = wp_get_current_user();
        update_post_meta($post_id, '_give_form_status', 'open');
        update_post_meta($post_id, '_give_goal_format', 'amount');

        if (isset($_REQUEST['goal_number']) && $_REQUEST['goal_number']) {
            update_post_meta($post_id, '_give_goal_option', 'enabled');
            update_post_meta($post_id, '_give_set_goal', $_REQUEST['goal_number']);
        }

        // Gallery
        if (isset($_REQUEST['gallery']) && $goal_number = $_REQUEST['gallery']) {
            update_post_meta($post_id, 'osf_give_gallery', $_REQUEST['gallery']);
        }
        // Video
        if (isset($_REQUEST['featured_video']) && $goal_number = $_REQUEST['featured_video']) {
            update_post_meta($post_id, 'osf_give_video', $_REQUEST['featured_video']);
        }

        // Content
        if (isset($_REQUEST['content']) && $content = $_REQUEST['content']) {
            update_post_meta($post_id, '_give_display_content', 'enabled');
            update_post_meta($post_id, '_give_form_content', $content);
        }

        // Email
        update_post_meta($post_id, '_give_new-donation_notification', 'enabled');
        update_post_meta($post_id, '_give_new-donation_recipient', [["email" => $user->user_email]]);


        // Featured Images
        if (isset($_REQUEST['featured_image']) && $_REQUEST['featured_image']) {
            set_post_thumbnail($post_id, $_REQUEST['featured_image']);
        }

        // Category
        if (isset($_REQUEST['category']) && $_REQUEST['category']) {
            wp_set_post_terms($post_id, $_REQUEST['category'], 'give_forms_category');
        }


    }

    private function redirect($status) {
        wp_redirect(add_query_arg(array(
            'status' => $status,
        ), $this->link_redirect));
        exit();
    }

    public function delete_campaign() {
        $form_id = $_REQUEST['form_id'];
        if (get_post_status($form_id)
            && (get_post_field('post_author', $form_id) == get_current_user_id())
            && ('give_forms' == get_post_type($form_id))) {
            wp_trash_post($form_id);
            wp_send_json(1);
        }
    }

    public function edit_custom_user_profile_fields() {
        global $current_user;

        if(isset($_POST['user_location'])) {
            update_user_meta($current_user->ID, 'user_location', $_POST['user_location']);
        }
        if(isset($_POST['user_company'])) {
            update_user_meta($current_user->ID, 'user_company', $_POST['user_company']);
        }
        if(isset($_POST['user_phone'])) {
            update_user_meta($current_user->ID, 'user_phone', $_POST['user_phone']);
        }
        if(isset($_POST['user_fax'])) {
            update_user_meta($current_user->ID, 'user_fax', $_POST['user_fax']);
        }
        $user_data = array(
            'ID' => $current_user->ID,
            'display_name'  => $_POST['username'],
            'user_email'    => $_POST['email'],
            'user_url' =>$_POST['website'],
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'description'=> $_POST['info']
        );

        wp_update_user($user_data);

        if (isset($_REQUEST['redirect']) && $_REQUEST['redirect']) {
            $this->link_redirect = $_REQUEST['redirect'];
        } else {
            $this->link_redirect = home_url();
        }

        $this->redirect(1);

    }
}

return new OSF_Give_Request_Form;