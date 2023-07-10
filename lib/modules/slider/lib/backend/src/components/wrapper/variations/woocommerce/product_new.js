const {
	InnerBlocks,
	useInnerBlocksProps,
} = wp.blockEditor;

const CONFIG = js_sv_slider_slider_scripts_editor_script.config;
const ALLOWED_BLOCKS = ['woocommerce/product-new'];
const TEMPLATE = [['woocommerce/product-new',{}]];

export default function SliderProductNew(props){
	
	return (
		<InnerBlocks template={TEMPLATE} allowedBlocks={ALLOWED_BLOCKS}/>
	);
}
