import {getAttributes, setAttributes} from '../wrapper/helper.js';
import ResponsiveTabs from "../tabs";

const {
	SelectControl,
	ToggleControl,
	TextControl,
	Panel,
	PanelBody,
	PanelRow,
	ToolbarGroup,
	Toolbar,
	ToolbarButton,
	ServerSideRender,
	Placeholder,
	TabPanel,
	__experimentalUnitControl,
	__experimentalDivider
} = wp.components;
const Divider = __experimentalDivider;
const UnitControl = __experimentalUnitControl ;
const {Fragment} = wp.element;

const {__} = wp.i18n;

function ControlComponents(props) {
	
	const {
		attributes
	} = props;

	const currentResponsiveTab = attributes.currentResponsiveTab;
	const svSliderAttributes = getAttributes(props);
	
	const onChange = (value, name) => {
		let attribute = svSliderAttributes[name];
		attribute[currentResponsiveTab] = value;
		setAttributes(props, {[name]: attribute});
	};
	
	const onUnitChange = (value, name, currentValue) => {
		value = parseInt(currentValue) + value;
		let attribute = svSliderAttributes[name];
		attribute[currentResponsiveTab] = value;
		setAttributes(props, {[name]: attribute});
	};
	
	return (
		<Fragment>
			<PanelBody title='Layout'>
				<ResponsiveTabs {...props} />
				<Divider />
			
					<SelectControl
						label={__('Slides per page', 'sv_slider')}
						options={[
							{label: __('Select', 'sv_slider'), value: ''},
							{label: __('1 Slide per page', 'sv_slider'), value: '1'},
							{label: __('2 Slide per page', 'sv_slider'), value: '2'},
							{label: __('3 Slide per page', 'sv_slider'), value: '3'},
							{label: __('4 Slide per page', 'sv_slider'), value: '4'},
							{label: __('5 Slide per page', 'sv_slider'), value: '5'},
							{label: __('6 Slide per page', 'sv_slider'), value: '6'},
						]}
						value={svSliderAttributes['--swiffy-slider-item-count'][currentResponsiveTab]}
						onChange={(value) => onChange(value, '--swiffy-slider-item-count')}
					/>
					<Divider/>
					<UnitControl
						label={__('Reveal before and after', 'sv_slider')}
						value={svSliderAttributes['--swiffy-slider-item-reveal'][currentResponsiveTab]}
						onChange={(value) => onChange(value, '--swiffy-slider-item-reveal')}
						onUnitChange={(value) => onUnitChange(value, '--swiffy-slider-item-reveal',
							svSliderAttributes['--swiffy-slider-item-reveal'][currentResponsiveTab])}
					/>
			</PanelBody>
			
			<PanelBody title='Slides'>
				<ResponsiveTabs {...props} />
				<Divider />
				<PanelRow>
					<UnitControl
						label={__('Gap between slides', 'sv_slider')}
						value={svSliderAttributes['--swiffy-slider-item-gap'][currentResponsiveTab]}
						onChange={(value) => onChange(value, '--swiffy-slider-item-gap')}
						onUnitChange={(value) => onUnitChange(value, '--swiffy-slider-item-gap',
							svSliderAttributes['--swiffy-slider-item-gap'][currentResponsiveTab])}
					/>
				</PanelRow>
				<Divider/>
				<PanelRow>
					<SelectControl
						label={__('Ratio', 'sv_slider')}
						options={[
							{label: __('Select', 'sv_slider'), value: ''},
							{label: __('16:9', 'sv_slider'), value: '16/9'},
							{label: __('21:9', 'sv_slider'), value: '21/9'},
							{label: __('32:9', 'sv_slider'), value: '32/9'},
							{label: __('4:3', 'sv_slider'), value: '4/3'},
							{label: __('3:4', 'sv_slider'), value: '3/4'},
							{label: __('2:1', 'sv_slider'), value: '2/1'},
							{label: __('1:1', 'sv_slider'), value: '1/1'},
						]}
						value={svSliderAttributes['--swiffy-slider-item-ratio'][currentResponsiveTab]}
						onChange={(value) => onChange(value, '--swiffy-slider-item-ratio')}
					/>
				</PanelRow>
				<Divider/>
				<PanelRow>
					<SelectControl
						label={__('Snap', 'sv_slider')}
						options={[
							{label: __('Select', 'sv_slider'), value: ''},
							{label: __('Snap center', 'sv_slider'), value: 'start'},
							{label: __('Snap to start', 'sv_slider'), value: 'center'},
							{label: __('No snap', 'sv_slider'), value: 'unset'}
						]}
						value={svSliderAttributes['--swiffy-slider-snap-align'][currentResponsiveTab]}
						onChange={(value) => onChange(value, '--swiffy-slider-snap-align')}
					/>
				</PanelRow>
			
			</PanelBody>
			
			<PanelBody title='Navigation'>
				<ResponsiveTabs {...props} />
				<Divider />
				<PanelRow>
					<SelectControl
						label={__('Arrows', 'sv_slider')}
						options={[
							{label: __('Select', 'sv_slider'), value: ''},
							{label: __('Arrow', 'sv_slider'), value: 'arrow'},
							{label: __('Arrow round', 'sv_slider'), value: 'arrow-round'},
							{label: __('Caret', 'sv_slider'), value: 'caret'},
							{label: __('Caret filled', 'sv_slider'), value: 'caret-filled'},
							{label: __('Chevron', 'sv_slider'), value: 'chevron'},
							{label: __('Chevron square', 'sv_slider'), value: 'chevron-square'},
							{label: __('Chevron compact', 'sv_slider'), value: 'chevron-compact'}
						]}
						value={svSliderAttributes['--swiffy-slider-arrows'][currentResponsiveTab]}
						onChange={(value) => onChange(value, '--swiffy-slider-arrows')}
					/>
				</PanelRow>
			</PanelBody>
			{/*
			<PanelBody title='hello world'>
				<ResponsiveTabs {...props} />
				<Divider />
				<PanelRow>
				
				</PanelRow>
				<Divider/>
				<PanelRow>
				
				</PanelRow>
			
			</PanelBody>
		*/}
		</Fragment>
	);
	
}

export default ControlComponents;