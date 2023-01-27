const {
	InnerBlocks,
	useInnerBlocksProps,
} = wp.blockEditor;

const CONFIG = js_sv_slider_slider_scripts_sv_slider_editor_script.config;
const ALLOWED_BLOCKS = CONFIG.allowedBlocks;
const TEMPLATE = CONFIG.template;

export default function SliderDefault(props){
	const innerBlocksProps = useInnerBlocksProps({renderAppender: InnerBlocks.ButtonBlockAppender});
	
	return (
		<ul>
			<InnerBlocks {...innerBlocksProps} template={TEMPLATE} allowedBlocks={ALLOWED_BLOCKS}/>
		</ul>
	);
}
