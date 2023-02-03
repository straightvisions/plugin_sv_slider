const {
	InnerBlocks,
	useInnerBlocksProps,
} = wp.blockEditor;

const CONFIG = js_sv_slider_slider_scripts_sv_slider_editor_script.config;
const ALLOWED_BLOCKS = ['woocommerce/handpicked-products'];
const TEMPLATE = [['woocommerce/handpicked-products',{}]];

export default function SliderHandPickedProducts(props){
	
	return (
		<InnerBlocks template={TEMPLATE} allowedBlocks={ALLOWED_BLOCKS}/>
	);
}
