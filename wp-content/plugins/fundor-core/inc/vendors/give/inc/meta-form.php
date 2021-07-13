<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class OSF_Give_Meta_Form{
	public function __construct() {
		add_action('cmb2_admin_init', array($this, 'page_meta_box'));
	}

	public function page_meta_box() {

		$cmb2 = new_cmb2_box(array(
			'id'            => 'osf_give',
			'title'         => __('Donation Media', 'fundor-core'),
			'object_types'  => array('give_forms'),
			'context'       => 'normal',
			'priority'      => 'high',
//			'show_names'    => false,
//			'vertical_tabs' => true,
//			'tabs'          => array(
//				array(
//					'id'     => 'osf_give_tab1',
//					'title'  => __('Video', 'fundor-core'),
//					'fields' => array(
//						'osf_give_video'
//					),
//				),
//				array(
//					'id'     => 'osf_give_tab2',
//					'title'  => __('Gallery', 'fundor-core'),
//					'fields' => array(
//						'osf_give_gallery'
//					),
//				),
//			)
		));

		$cmb2->add_field(array(
			'name' => __('Donation video', 'fundor-core'),
			'desc' => __('Supports video from youtube and vimeo.', 'fundor-core'),
			'id'   => 'osf_give_video',
			'type' => 'oembed',
		));

		$cmb2->add_field(array(
			'name' => 'Donation gallery',
			'desc' => '',
			'id'   => 'osf_give_gallery',
			'type' => 'file_list',
		));
	}


	public function setup_media_setting($settings){

	}
}

return new OSF_Give_Meta_Form();