/**
 * WordPress dependencies
 */
import {edit, keyboardReturn} from '@wordpress/icons';
import ControlComponents from '../controls';
import ServerSideRender from '../server_side_renderer';
import {handleBlockId, setAttributes as setSliderAttributes} from './helper.js';

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
	ToolbarButton,
	Placeholder,
	Disabled
} = wp.components;
//const { serverSideRender: ServerSideRender } = wp;

const {useEffect} = wp.element;
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
	
	// hint attributes means the native gutenberg attributes here
	// they are used to support some gutenberg features like TagName and our global editMode
	const {
		attributes,
		setAttributes,
		clientId
	} = props;
	
	const {tagName: TagName = 'div', editMode} = attributes;
	const blockProps = useBlockProps();
	
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

	//@todo optimise the fake attributes pipeline to be more streamlined and stable
	useEffect(() => {
		setSliderAttributes(props, {'childrenCount': innerBlocks.length});
	}, [innerBlocks]);

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
					<Panel className={'sv-slider-controls-panel'}>
						<ControlComponents {...props}/>
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
					</Panel>
				</InspectorControls>
				<TagName {...blockProps}>
					<ul>
						<InnerBlocks {...innerBlocksProps} template={TEMPLATE} allowedBlocks={ALLOWED_BLOCKS}/>
					</ul>
				</TagName>
			</>
		);
	} else {
		const EmptyResponsePlaceholder = () => <Placeholder label={'Empty'}/>;
		const ErrorResponsePlaceholder = () => <Placeholder label={'Error'}/>;
		
		// server side render trigger
		const TriggerWhenLoadingFinished = attributes => {
			return () => {
				useEffect( () => {
					// Call action when the loading component unmounts because loading is finished.
					return () => {
						window.swiffyslider.init();
					};
				} );
				
				return (<Placeholder label={'Loading...'}/>);
			};
		};
		
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
					<Panel className={'sv-slider-controls-panel'}>
						<ControlComponents {...props}/>
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
					</Panel>
				</InspectorControls>
				<div { ...blockProps }>
					<ServerSideRender
						block="straightvisions/sv-slider"
						attributes={ {...attributes, ...{
							innerContent: innerContent
						}}}
						httpMethod="POST"
						LoadingResponsePlaceholder={TriggerWhenLoadingFinished( attributes )}
						EmptyResponsePlaceholder={EmptyResponsePlaceholder}
						ErrorResponsePlaceholder={ErrorResponsePlaceholder}
					/>
				</div>
			</>
		);
	}
	
}


export default SliderEdit;
