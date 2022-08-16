/**
 * WordPress dependencies
 */
import { edit, keyboardReturn } from '@wordpress/icons';
import PreviewBlock from './../preview_block/index.js';

const { useSelect } = wp.data;
const {
	InnerBlocks,
	useBlockProps,
	InspectorControls,
	BlockControls,
	useInnerBlocksProps,
	useSetting,
	store,
} = wp.blockEditor;
const blockEditorStore = store;
const { SelectControl, Panel, PanelBody, ToolbarGroup, Toolbar, ToolbarButton, ServerSideRender } = wp.components;
const { getSaveElement } = wp.blocks;
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
	const {tagName: TagName = 'div', editMode} = attributes;
	
	const blockProps = useBlockProps({
		className: 'wp-block-straightvisions-sv-slider',
	});
	
	const innerBlocksProps = useInnerBlocksProps({renderAppender: InnerBlocks.ButtonBlockAppender});
	
	if(editMode === true){
		
		return (
			<>
				<BlockControls>
					<ToolbarGroup>
						<ToolbarButton
							icon={ keyboardReturn }
							label="Preview Mode"
							onClick={ () => setAttributes({editMode:false}) }
						/>
					</ToolbarGroup>
				</BlockControls>
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
					<ul className={'slider-container'}>
						<InnerBlocks { ...innerBlocksProps } template={TEMPLATE} allowedBlocks={ALLOWED_BLOCKS} />
					</ul>
				</TagName>
			</>
		);
	}else{
		
		return (
			<>
				<BlockControls>
					<ToolbarGroup>
						<ToolbarButton
							icon={ edit }
							label="Edit Mode"
							onClick={ () => setAttributes({editMode:true}) }
						/>
					</ToolbarGroup>
				</BlockControls>
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
				<TagName {...blockProps} className={'wp-block-straightvisions-sv-slider swiffy-slider'}>
					<ul {...innerBlocksProps} className={'slider-container'} />
					
					<button type="button" className="slider-nav"></button>
					<button type="button" className="slider-nav slider-nav-next"></button>
					
					<div className="slider-indicators">
						<button className="active"></button>
						<button></button>
						<button></button>
					</div>
				</TagName>
				
			</>
		);
	}
	
}

export default SliderEdit;
