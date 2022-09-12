/**
 * WordPress dependencies
 */
import {edit, keyboardReturn} from '@wordpress/icons';
import ControlComponents from '../controls';
import {handleBlockId, getAttributes} from './helper.js';

const {useSelect} = wp.data;
const {
	InnerBlocks,
	useBlockProps,
	InspectorControls,
	BlockControls,
	useInnerBlocksProps,
	store,
} = wp.blockEditor;
const blockEditorStore = store;
const {
	Dashicon,
	SelectControl,
	Panel,
	PanelBody,
	ToolbarGroup,
	Toolbar,
	ToolbarButton,
	ServerSideRender,
	Placeholder,
	TabPanel
} = wp.components;
const {Fragment} = wp.element;
const {getBlockContent} = wp.blocks;
const {__} = wp.i18n;

const CONFIG = js_sv_slider_slider_scripts_sv_slider_editor_script.config;
const ALLOWED_BLOCKS = CONFIG.allowedBlocks;
const TEMPLATE = CONFIG.template;

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

function SliderEdit(props) {
	
	const {
		attributes,
		setAttributes,
		clientId
	} = props;
	
	const {tagName: TagName = 'div', editMode} = attributes;
	// get nested slider object attributes (not supported by gutenberg yet)
	const svSliderAttributes = getAttributes(props);
	console.log("editsvslillderatr");
	console.log(svSliderAttributes);
	const blockProps = useBlockProps({
		className: 'wp-block-straightvisions-sv-slider',
	});
	
	const innerBlocksProps = useInnerBlocksProps({renderAppender: InnerBlocks.ButtonBlockAppender});
	
	const {innerContent, innerBlocks} = useSelect(
		(select) => {
			const {getBlock} = select(blockEditorStore);
			const {getBlocks} = select('core/block-editor');
			const block = getBlock(clientId);
			
			return {
				innerContent: getBlockContent(block),
				innerBlocks: getBlocks(clientId)
			}
		},
		[clientId]
	);
	// check for duplicates + set blockId
	handleBlockId(props);
	
	if (editMode === true) {
		
		return (
			<>
				<BlockControls>
					<ToolbarGroup>
						<ToolbarButton
							icon={keyboardReturn}
							label="Preview Mode"
							onClick={() => setAttributes({editMode: false})}
						/>
					</ToolbarGroup>
				</BlockControls>
				<InspectorControls>
					<PanelBody>
						<SelectControl
							label={__('HTML element')}
							options={[
								{label: __('Default (<div>)'), value: 'div'},
								{label: '<header>', value: 'header'},
								{label: '<main>', value: 'main'},
								{label: '<section>', value: 'section'},
								{label: '<article>', value: 'article'},
								{label: '<aside>', value: 'aside'},
								{label: '<footer>', value: 'footer'},
							]}
							value={TagName}
							onChange={(value) =>
								setAttributes({tagName: value})
							}
							help={htmlElementMessages[TagName]}
						/>
					</PanelBody>
					<PanelBody>
						<TabPanel
							className='sv100-premium-panelbody'
							tabs={[
								
								{
									name: "Mobile",
									title: <Dashicon icon="smartphone"/>,
									className: 'tab-icon',
								},
								
								{
									name: "MobileLandscape",
									title: <Dashicon icon="smartphone" style={{transform: 'rotate(90deg)'}}/>,
									className: 'tab-icon',
								},
								
								{
									name: "Tablet",
									title: <Dashicon icon="tablet"/>,
									className: 'tab-icon',
								},
								
								{
									name: "TabletLandscape",
									title: <Dashicon icon="tablet" style={{transform: 'rotate(90deg)'}}/>,
									className: 'tab-icon',
								},
								
								{
									name: "TabletPro",
									title: <Dashicon icon="tablet" style={{color: 'red'}}/>,
									className: 'tab-icon',
								},
								
								{
									name: "TabletProLandscape",
									title: <Dashicon icon="tablet" style={{transform: 'rotate(90deg)', color: 'red'}}/>,
									className: 'tab-icon',
								},
								
								{
									name: "Desktop",
									title: <Dashicon icon="desktop"/>,
									className: 'tab-icon',
								}
							
							
							]}
						>
							{(tab) => {
								let output = (
									setAttributes({currentResponsiveTab: tab.name})
								);
								
								return <div>{output}</div>;
							}}
						</TabPanel>
						<Fragment>
							<ControlComponents {...props}/>
						</Fragment>
					</PanelBody>
				
				</InspectorControls>
				<TagName {...props}>
					<ul className={'slider-container'}>
						<InnerBlocks {...innerBlocksProps} template={TEMPLATE} allowedBlocks={ALLOWED_BLOCKS}/>
					</ul>
				</TagName>
			</>
		);
	} else {
		
		const LoadingResponsePlaceholder = () => <Placeholder label={'Loading...'}/>;
		const EmptyResponsePlaceholder = () => <Placeholder label={'Empty'}/>;
		const ErrorResponsePlaceholder = () => <Placeholder label={'Error'}/>;
		
		return (
			<>
				<BlockControls>
					<ToolbarGroup>
						<ToolbarButton
							icon={edit}
							label="Edit Mode"
							onClick={() => setAttributes({editMode: true})}
						/>
					</ToolbarGroup>
				</BlockControls>
				<InspectorControls>
					
					<PanelBody>
						<SelectControl
							label={__('HTML element')}
							options={[
								{label: __('Default (<div>)'), value: 'div'},
								{label: '<header>', value: 'header'},
								{label: '<main>', value: 'main'},
								{label: '<section>', value: 'section'},
								{label: '<article>', value: 'article'},
								{label: '<aside>', value: 'aside'},
								{label: '<footer>', value: 'footer'},
							]}
							value={TagName}
							onChange={(value) =>
								setAttributes({tagName: value})
							}
							help={htmlElementMessages[TagName]}
						/>
					</PanelBody>
				
				</InspectorControls>
				<div {...blockProps}>
					<ServerSideRender
						block="straightvisions/sv-slider"
						attributes={{
							className: attributes.className,
							align: attributes.align,
							tagName: attributes.tagName,
							innerContent: innerContent,
							innerBlocks: innerBlocks
						}}
						httpMethod="POST"
						LoadingResponsePlaceholder={LoadingResponsePlaceholder}
						EmptyResponsePlaceholder={EmptyResponsePlaceholder}
						ErrorResponsePlaceholder={ErrorResponsePlaceholder}
					
					/>
				</div>
			
			</>
		);
	}
	
}


export default SliderEdit;
