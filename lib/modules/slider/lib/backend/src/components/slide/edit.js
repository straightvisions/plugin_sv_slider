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
	const { tagName: TagName = 'li', templateLock, layout = {} } = attributes;
	
	const blockProps = useBlockProps( {
		className: 'sv-block-slider-slide',
	} );
	
	const { hasInnerBlocks }  = useSelect(
		( select ) => {
			const { getBlock } = select( blockEditorStore );
			const block = getBlock( clientId );
			
			return {
				hasInnerBlocks: !!(block && block.innerBlocks.length)
			}
		},
		[ clientId ]
	);
	
	const innerBlocksProps = useInnerBlocksProps();
	
	return (
		<>
			<InspectorControls>
				<PanelBody>
				
				</PanelBody>
			
			</InspectorControls>
			<TagName {...blockProps} >
				<InnerBlocks { ...innerBlocksProps } template={TEMPLATE} />
			</TagName>
		
		</>
	);
}

export default SlideEdit;
