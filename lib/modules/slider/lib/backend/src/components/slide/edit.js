/**
 * WordPress dependencies
 */
const { useSelect } = wp.data;
const {
	InnerBlocks,
	useBlockProps,
	InspectorControls,
	useInnerBlocksProps,
	useSetting,
	store,
} = wp.blockEditor;
const blockEditorStore = store;
const { SelectControl, Panel, PanelBody } = wp.components;
const { __ } = wp.i18n;

const TEMPLATE = [['core/cover',{}]]

function SlideEdit( { attributes, setAttributes, clientId } ) {
	const { tagName: TagName = 'li'} = attributes;
	const blockProps = useBlockProps();
	const innerBlocksProps = useInnerBlocksProps();
	
	return (
		<TagName {...blockProps} >
			<InnerBlocks { ...innerBlocksProps } template={TEMPLATE} />
		</TagName>
	);
}

export default SlideEdit;
