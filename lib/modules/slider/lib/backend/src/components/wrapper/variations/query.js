const {
	InnerBlocks,
	useInnerBlocksProps,
} = wp.blockEditor;

const CONFIG = js_sv_slider_slider_scripts_editor_script.config;
const ALLOWED_BLOCKS = CONFIG.allowedQueryBlocks;
const TEMPLATE = CONFIG.templateQuery;

export default function SliderQuery(props){
	const innerBlocksProps = useInnerBlocksProps({renderAppender: InnerBlocks.ButtonBlockAppender});
	
	return (
		<ul>
			<InnerBlocks {...innerBlocksProps} template={TEMPLATE} allowedBlocks={ALLOWED_BLOCKS}/>
		</ul>
		
	);
}
