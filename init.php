<?php

	/**
	 * @author			straightvisions GmbH
	 * @package			sv100
	 * @copyright       2022 straightvisions GmbH
	 * @link			https://straightvisions.com
	 * @since			1.4
	 * @license			See license.txt or https://straightvisions.com
	 */

	namespace sv_slider;
	
	if(!class_exists('\sv_core\core_plugin')) {
		require_once(dirname(__FILE__) . '/lib/core_plugin/core_plugin.php');
	}
	
	class init extends \sv_core\core_plugin {
		const version = 1902;
		const version_core_match = 9000;
		
		public function load(){
			if(!$this->setup( __NAMESPACE__, __FILE__ )){
				return false;
			}

			$info = get_file_data($this->get_path($this->get_name().'.php'), array(
				'name'	=> 'Plugin Name',
				'desc'	=> 'Description'
			));

			$this->set_section_title( $info['name'] )
				->set_section_desc( $info['desc'] )
				->set_section_type('')
				->set_section_privacy( '<p>' . $this->get_section_title() . __(' does not collect or share any data',  'sv100_companion').'</p>' );
		}
	}
	
	$GLOBALS[ __NAMESPACE__ ] = new init();
	$GLOBALS[ __NAMESPACE__ ]->load();