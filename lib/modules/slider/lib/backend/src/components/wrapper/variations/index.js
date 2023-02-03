const {useState} = wp.element;

import SliderDefault from './default';
import SliderSelect from './select';
import SliderPostTemplate from './post_template';
import SliderWooCommerce from './woocommerce';

export default function Slider(props) {
	const {
		sliderType = 'default',
		innerBlocks,
		handleSelect = () => {},
	} = props;
	
	const [selected, setSelected] = useState(false);
	
	const _handleSelect = (value) => {
		setSelected(true);
		handleSelect({sliderType: value});
	}
	
	const _handleSelectWooCommerce = (value) => {
		setSelected(true);
		handleSelect({sliderType: 'woocommerce', sliderTypeWooCommerce: value});
	}
	
	// fresh block
	if(selected === false && innerBlocks.length <= 0) return (<SliderSelect onChange={_handleSelect} onChangeWooCommerce={_handleSelectWooCommerce}/>);
	// default selected
	if (sliderType === 'default') return (<SliderDefault {...props} />);
	// query selected
	if (sliderType === 'post-template') return (<SliderPostTemplate {...props} />);
	// woocommerce selected - tunnel output
	if (sliderType === 'woocommerce') return (<SliderWooCommerce {...props} />);
}