import { swiffyslider } from 'swiffy-slider';
import 'swiffy-slider/css';

const { useSelect, select } = wp.data;
const {
	store,
} = wp.blockEditor;
const blockEditorStore = store;
const { getSaveElement, getSaveContent } = wp.blocks;

function PreviewBlock( { clientId } ) {
	
	return useSelect(
		( select ) => {
			const { getBlock } = select( blockEditorStore );
			const block = getBlock( clientId );
			
			return getSaveElement( 'straightvisions/sv-slider', block.attributes, block.innerBlocks );
		},
		[ clientId ]
	);

}

export default PreviewBlock;