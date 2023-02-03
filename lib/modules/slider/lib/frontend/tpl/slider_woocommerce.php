<?php
$slider_type_woocommerce = isset($attributes['svSlider']['sliderType']) ? $attributes['svSlider']['sliderType'] : 'default';

switch($slider_type_woocommerce){
    case 'handpicked-products': require($this->get_path('lib/frontend/tpl/woocommerce/handpicked_products.php'));break;
    default: require($this->get_path('lib/frontend/tpl/woocommerce/handpicked_products.php'));
}