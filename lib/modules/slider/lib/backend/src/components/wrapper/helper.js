import {sliderAttributes} from './attributes.js';
const classname = 'wp-block-straightvisions-sv-slider';

// important custom attributes handling -----------------------------------------------------
// important custom attributes handling -----------------------------------------------------
// important custom attributes handling -----------------------------------------------------
// set attributes by merging to a JSON string
export function setAttributes(props, attributes){
	let _svSlider = {...JSON.parse(props.attributes.svSlider), ...attributes};
	props.setAttributes({svSlider: JSON.stringify(_svSlider)});
}

// get attributes by parsing JSON and merging with defaults
export function getAttributes(props){
	return {...sliderAttributes, ...JSON.parse(props.attributes.svSlider)};
}
// important custom attributes handling -----------------------------------------------------
// important custom attributes handling -----------------------------------------------------
// important custom attributes handling -----------------------------------------------------
export function handleBlockId(props){
	const svSlider = getAttributes(props);
	const {blockId} = svSlider;

	if(blockId === '' || typeof blockId === 'undefined' || isDuplicate(props) === true){
		// replace old block ID with new one if block is a duplicate
		const newBlockId = getUniqueBlockId(props);
		setAttributes(props, {blockId: newBlockId}); // set functions triggers render
	}
}

export function getUniqueBlockId(props){
	let id = btoa( props.clientId ).replace(/[^a-z0-9]/gi,'');
	
	return id.substring(id.length - 12, 12);
}


export function setBlockId(props, blockId){
	const {svSlider} = props.attributes;
	let _svSlider = {...svSlider};
	_svSlider.blockId = blockId;
	props.setAttributes({svSlider: _svSlider});
}

export function isDuplicate(props){
	let output = false;
	const _document = getBlockDocumentRoot(props);
	const elements = _document.querySelectorAll('.' + classname + props.attributes.blockId);
	
	if(elements.length > 1){
		output = true;
	}
	
	return output;
}

export function getBlockDocumentRoot(props){
	const iframes = document.querySelectorAll('.edit-site-visual-editor__editor-canvas');
	let _document = document;
	
	// check for block editor iframes
	for(let i = 0; i < iframes.length; i++){
		
		let block = iframes[i].contentDocument.getElementById('block-' + props.id);
		if(block !== null){
			_document = iframes[i].contentDocument;
			break;
		}
	}
	
	return _document;
}