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
	
	const currentResponsiveTab = attributes.svSlider._currentResponsiveTab;
	const svSlider = attributes.svSlider;
	
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
				value={svSlider.layout[currentResponsiveTab]}
				onChange={(value) => {
					svSlider.layout[currentResponsiveTab] = value;
					setAttributes({svSlider});
				}}
			/>
			
			<ToggleControl
				label={__('Reveal before and after', 'sv_slider')}
				checked={svSlider.layoutReveal[currentResponsiveTab]}
				onChange={(value) => {
					svSlider.layoutReveal[currentResponsiveTab] = value;
					setAttributes({svSlider});
				}}
			/>
		</Fragment>
	);
	
}

export default ControlComponents;