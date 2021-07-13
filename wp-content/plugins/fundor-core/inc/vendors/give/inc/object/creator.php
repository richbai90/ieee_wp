<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Opal_Give_Creator extends WP_User {

    /**
     * @return bool
     */
    public function is_creator() {
        return $this->roles[0] === 'opal-creator';
//		return true;
    }


    /**
     * @return float|int
     */
    public function get_earnings() {
        $earning = $this->get('opal_give_earnings');
        if ($earning) {
            return floatval($earning);
        } else {
            return 0;
        }
    }

    /**
     * @param $format bool
     *
     * @return array
     */
    public function get_campaign_ids($format = false) {
        $ids = $this->get('opal_give_campaign_ids');
        if ($ids) {
            if ($format) {
                $newids = [];
                foreach ($ids as $key => $v) {
                    $newids[] = $key;
                }

                return $newids;
            }

            return $ids;
        } else {
            return [];
        }
    }

    /**
     * @return int
     */
    public function get_campaign_count() {
        return count($this->get_campaign_ids());
    }


    /**
     * @param $id int
     *
     * @return void
     */
    public function add_campaign_id($id) {
        $ids      = $this->get_campaign_ids();
        $ids[$id] = true;
        update_user_meta($this->ID, 'opal_give_campaign_ids', $ids);
    }

    /**
     * @param $id
     *
     * @return void
     */
    public function remove_campaign_id($id) {
        $ids = $this->get_campaign_ids();
        if (isset($ids[$id])) {
            unset($ids[$id]);
        }
        update_user_meta($this->ID, 'opal_give_campaign_ids', $ids);
    }

    /**
     * @return string
     */
    public function get_avatar($size = 160) {
        if ($attachID = $this->get('_creator_avatar_id')) {
            return wp_get_attachment_image($attachID, 'fundor-avatar');
        } else {
            return get_avatar($this->ID, $size);
        }
    }

    /**
     * @param $attach_id int
     */
    public function set_avatar($attach_id) {
        update_user_meta($this->ID, '_creator_avatar_id', $attach_id);
    }

    /**
     * @param array $args
     *
     * @return array
     */
    public function get_campaigns_query($args = []) {
        return wp_parse_args($args, [
            'post_type'   => 'give_forms',
            'post_status' => [
                'publish',
                'draft',
            ],
            'paged'       => isset($_GET['paging']) ? absint($_GET['paging']) : 1,
            'author'      => $this->ID,
        ]);
    }

    /**
     * @param $number float
     *
     * @return void
     */
    public function set_earnings($number) {
        if (is_numeric($number)) {

            $new = $this->get_earnings() + $number;

            update_user_meta($this->ID, 'opal_give_earnings', $new);
        }
    }

    /**
     * @param $args array
     *
     * @return array
     */
    public function get_donations_query($args = []) {
        $ids = $this->get_campaign_ids(true);
        return wp_parse_args($args, [
            'post_type'  => 'give_payment',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key'     => '_give_payment_form_id',
                    'value'   => count($ids) > 0 ? $ids : [0],
                    'compare' => 'IN',
                ]
            ],
            'paged'      => isset($_GET['paging']) ? absint($_GET['paging']) : 1,
        ]);
    }

    /**
     * @param bool $format
     *
     * @return array
     */
    public function get_donner_ids($format = false) {
        $key_transient = 'opal-give-creator-' . $this->ID . '-donner-ids';
        $donners       = get_transient($key_transient);

        if (!is_array($donners)) {
            $donners = [];
            $query   = $this->get_donations_query([
                'paged'          => 1,
                'posts_per_page' => -1
            ]);

            $loop = new WP_Query($query);
            while ($loop->have_posts()): $loop->the_post();
                $payment                     = new Give_Payment(get_the_ID());
                $donners[$payment->donor_id] = true;
            endwhile;
            set_transient($key_transient, $donners, 12 * HOUR_IN_SECONDS);
        }


        if ($format) {
            $newids = [];
            foreach ($donners as $key => $v) {
                $newids[] = $key;
            }
            return $newids;
        }

        return $donners;
    }

    /**
     * @return int
     */
    public function get_donner_count() {
        return count($this->get_donner_ids());
    }
}