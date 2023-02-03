import SliderHandPickedProducts from "./handpicked_products";

export default function SliderWooCommerce(props) {
	const {
		sliderTypeWooCommerce = 'handpicked-products',
	} = props;
	
	// woocommerce selected
	if (sliderTypeWooCommerce === 'handpicked-products') return (<SliderHandPickedProducts {...props} />);
}