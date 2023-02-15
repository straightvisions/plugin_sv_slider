const {
	InnerBlocks,
	useInnerBlocksProps,
} = wp.blockEditor;

const CONFIG = js_sv_slider_slider_scripts_editor_script.config;
const ALLOWED_BLOCKS = CONFIG.allowedPostTemplateBlocks;
const TEMPLATE = CONFIG.templatePostTemplate;

export default function SliderPostTemplate(props){

	return (
		<ul>
			<InnerBlocks template={TEMPLATE} allowedBlocks={ALLOWED_BLOCKS}/>
		</ul>
		
	);
}
