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

const ALLOWED_BLOCKS = [ 'straightvisions/sv-slider-slide' ];
const TEMPLATE = [ [ 'straightvisions/sv-slider-slide', {} ] ];

const htmlElementMessages = {
	header: __(
		'The <header> element should represent introductory content, typically a group of introductory or navigational aids.'
	),
	main: __(
		'The <main> element should be used for the primary content of your document only. '
	),
	section: __(
		"The <section> element should represent a standalone portion of the document that can't be better represented by another element."
	),
	article: __(
		'The <article> element should represent a self contained, syndicatable portion of the document.'
	),
	aside: __(
		"The <aside> element should represent a portion of a document whose content is only indirectly related to the document's main content."
	),
	footer: __(
		'The <footer> element should represent a footer for its nearest sectioning element (e.g.: <section>, <article>, <main> etc.).'
	),
};

function SliderEdit( { attributes, setAttributes, clientId } ) {
	const { tagName: TagName = 'div', templateLock, layout = {} } = attributes;
	
	const blockProps = useBlockProps( {
		className: 'sv-block-slider',
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
	
	const innerBlocksProps = useInnerBlocksProps({
		className: 'sv-slider-container slider-container'
	});
	
	return (
		<>
			<InspectorControls>
				<PanelBody>
					<SelectControl
						label={ __( 'HTML element' ) }
						options={ [
							{ label: __( 'Default (<div>)' ), value: 'div' },
							{ label: '<header>', value: 'header' },
							{ label: '<main>', value: 'main' },
							{ label: '<section>', value: 'section' },
							{ label: '<article>', value: 'article' },
							{ label: '<aside>', value: 'aside' },
							{ label: '<footer>', value: 'footer' },
						] }
						value={ TagName }
						onChange={ ( value ) =>
							setAttributes( { tagName: value } )
						}
						help={ htmlElementMessages[ TagName ] }
					/>
				</PanelBody>
			
			</InspectorControls>
			<TagName {...blockProps} >
				<ul>
					<InnerBlocks { ...innerBlocksProps } template={TEMPLATE} allowedBlocks={ALLOWED_BLOCKS} />
				</ul>
			</TagName>
		</>
	);
}

export default SliderEdit;
