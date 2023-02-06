<?php
$slider_type_woocommerce = isset($attributes['svSlider']['sliderType']) ? $attributes['svSlider']['sliderType'] : 'default';

switch($slider_type_woocommerce){
    case 'handpicked-products':
        require($this->get_path('lib/frontend/tpl/woocommerce/handpicked_products.php'));
        $this->get_script('sv_slider_woocommerce_handpicked_products')
             ->set_path('lib/frontend/css/woocommerce/handpicked_products.css')
             ->set_is_enqueued();
        break;
    default: require($this->get_path('lib/frontend/tpl/woocommerce/handpicked_products.php'));
}