import {getAttributes, setAttributes} from '../wrapper/helper.js';

const {
	SelectControl,
	ToggleControl,
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

const {__} = wp.i18n;

function ControlComponents(props) {
	
	const {
		attributes
	} = props;
	
	const currentResponsiveTab = attributes.currentResponsiveTab;
	const svSliderAttributes = getAttributes(props);
	
	return (
		<Fragment>
			<SelectControl
				label={__('Layout')}
				options={[
					{label: __('1 Slide per Page', 'sv_slider'), value: '1'},
					{label: __('2 Slide per Page', 'sv_slider'), value: '2'},
					{label: __('3 Slide per Page', 'sv_slider'), value: '3'},
					{label: __('4 Slide per Page', 'sv_slider'), value: '4'},
					{label: __('5 Slide per Page', 'sv_slider'), value: '5'},
					{label: __('6 Slide per Page', 'sv_slider'), value: '6'},
				]}
				value={svSliderAttributes['--swiffy-slider-item-count'][currentResponsiveTab]}
				onChange={(value) => {
					let itemCount = svSliderAttributes['--swiffy-slider-item-count'];
					itemCount[currentResponsiveTab] = value;
					setAttributes(props, {'--swiffy-slider-item-count': itemCount});
				}}
			/>
			
			<ToggleControl
				label={__('Reveal before and after', 'sv_slider')}
				checked={svSliderAttributes['--swiffy-slider-item-reveal'][currentResponsiveTab]}
				onChange={(value) => {
					return;
					svSlider.layoutReveal[currentResponsiveTab] = value;
					setAttributes({svSlider});
				}}
			/>
		</Fragment>
	);
	
}

export default ControlComponents;