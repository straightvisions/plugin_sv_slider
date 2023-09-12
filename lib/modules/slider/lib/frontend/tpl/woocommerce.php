<?php

$slider_type_woocommerce = $this->get_attr('sliderTypeWooCommerce', 'default');
$slider_type_woocommerce = str_replace('-', '_', $slider_type_woocommerce);

require($this->get_path('lib/frontend/tpl/woocommerce/' . $slider_type_woocommerce . '.php'));
// @todo move this to frontend.php and use a late filter to add this once
if ($this->parent) {
	$this->parent->get_script('sv_slider_woocommerce_' . $slider_type_woocommerce)
	             ->set_path('lib/frontend/css/woocommerce/' . $slider_type_woocommerce . '.css')
	             ->set_is_enqueued();
}


