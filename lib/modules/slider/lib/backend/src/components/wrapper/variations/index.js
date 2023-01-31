const {useState} = wp.element;

import SliderDefault from './default';
import SliderSelect from './select';
import SliderPostTemplate from './post_template';

export default function Slider(props) {
	const {
		sliderType = 'default',
		innerBlocks,
		handleSelect = () => {},
	} = props;
	
	const [selected, setSelected] = useState(false);
	
	const _handleSelect = (value) => {
		setSelected(true);
		handleSelect(value);
	}
	
	// fresh block
	if(selected === false && innerBlocks.length <= 0) return (<SliderSelect onChange={_handleSelect} />);
	// default selected
	if (sliderType === 'default') return (<SliderDefault {...props} />);
	// query selected
	if (sliderType === 'post-template') return (<SliderPostTemplate {...props} />);
}