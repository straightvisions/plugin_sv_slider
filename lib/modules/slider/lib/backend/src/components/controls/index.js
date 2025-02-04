import {getAttributes, setAttributes} from '../wrapper/helper.js';
import ResponsiveTabs from "../tabs";

const {
	SelectControl,
	ToggleControl,
	PanelBody,
	ColorIndicator,
	ColorPalette,
	Popover,
	Button,
	__experimentalDivider: Divider,
	__experimentalUnitControl: UnitControl,
	__experimentalNumberControl: NumberControl
} = wp.components;

const {Fragment} = wp.element;
const {__} = wp.i18n;

export default function ControlComponents(props){
	const {
		attributes
	} = props;

	const currentResponsiveTab = attributes.currentResponsiveTab;
	const svSliderAttributes = getAttributes(props);
	
	const settings = wp.data.select( 'core/block-editor' ).getSettings();
	let themeColors = [];
	
	if ( settings && settings.colors ) {
		themeColors = settings.colors;
	}
	
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
	
	const onStaticChange = (value, name) => {
		svSliderAttributes[name] = value;
		setAttributes(props, {[name]: svSliderAttributes[name]});
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
				<UnitControl
					label={__('Reveal before and after', 'sv_slider')}
					value={svSliderAttributes['--swiffy-slider-item-reveal'][currentResponsiveTab]}
					onChange={(value) => onChange(value, '--swiffy-slider-item-reveal')}
					onUnitChange={(value) => onUnitChange(value, '--swiffy-slider-item-reveal',
						svSliderAttributes['--swiffy-slider-item-reveal'][currentResponsiveTab])}
				/>
			</PanelBody>
			
			<PanelBody title='Slides' initialOpen={false}>
				<ResponsiveTabs {...props} />
				<Divider />
				
				<UnitControl
					label={__('Gap between slides', 'sv_slider')}
					value={svSliderAttributes['--swiffy-slider-item-gap'][currentResponsiveTab]}
					onChange={(value) => onChange(value, '--swiffy-slider-item-gap')}
					onUnitChange={(value) => onUnitChange(value, '--swiffy-slider-item-gap',
						svSliderAttributes['--swiffy-slider-item-gap'][currentResponsiveTab])}
				/>
				
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
				
				<SelectControl
					label={__('Snap', 'sv_slider')}
					options={[
						{label: __('Select', 'sv_slider'), value: ''},
						{label: __('Snap center', 'sv_slider'), value: 'center'},
						{label: __('Snap to start', 'sv_slider'), value: 'start'},
						{label: __('No snap', 'sv_slider'), value: 'unset'}
					]}
					value={svSliderAttributes['--swiffy-slider-snap-align'][currentResponsiveTab]}
					onChange={(value) => onChange(value, '--swiffy-slider-snap-align')}
				/>
			</PanelBody>
			
			<PanelBody title='Navigation' initialOpen={false}>
				<ResponsiveTabs {...props} />
				<Divider />
				
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
				
				<Button className="colorpicker-button" onClick={()=>props.setAttributes({_svSliderArrowsColorPopover: true})}>
					<ColorIndicator
						className={'clickable'}
						colorValue={svSliderAttributes['--swiffy-slider-arrows-color'][currentResponsiveTab]}
						
					/>
					{ attributes._svSliderArrowsColorPopover === true &&
						<Popover position='left' onClose={()=>props.setAttributes({_svSliderArrowsColorPopover: false})}>
							<ColorPalette
								colors={ themeColors }
								value={ svSliderAttributes['--swiffy-slider-arrows-color'][currentResponsiveTab] }
								onChange={ (value) => onChange(value, '--swiffy-slider-arrows-color') }
							/>
						</Popover>
					}
					<span>{__('Arrow Color', 'sv_slider')}</span>
				</Button>
				
				<Button className="colorpicker-button" onClick={()=>props.setAttributes({_svSliderArrowsColorBackgroundPopover: true})}>
					<ColorIndicator
						className={'clickable'}
						colorValue={svSliderAttributes['--swiffy-slider-arrows-color-background'][currentResponsiveTab]}
						
					/>
					{ attributes._svSliderArrowsColorBackgroundPopover === true &&
						<Popover position='left' onClose={()=>props.setAttributes({_svSliderArrowsColorBackgroundPopover: false})}>
							<ColorPalette
								colors={ themeColors }
								value={ svSliderAttributes['--swiffy-slider-arrows-color-background'][currentResponsiveTab] }
								onChange={ (value) => onChange(value, '--swiffy-slider-arrows-color-background') }
							/>
						</Popover>
					}
					<span>{__('Background (square, round)', 'sv_slider')}</span>
				</Button>
				
				<Divider />
				
				<SelectControl
					label={__('Hide arrows', 'sv_slider')}
					options={[
						{label: __('Select', 'sv_slider'), value: ''},
						{label: __('Show', 'sv_slider'), value: 'flex'},
						{label: __('Hide', 'sv_slider'), value: 'none'},
						
					]}
					value={svSliderAttributes['--swiffy-slider-arrows-display'][currentResponsiveTab]}
					onChange={(value) => onChange(value, '--swiffy-slider-arrows-display')}
				/>
			</PanelBody>
			
			<PanelBody title='Indicators' initialOpen={false}>
				<Divider />
				
				<SelectControl
					label={__('Style', 'sv_slider')}
					options={[
						{label: __('Hide', 'sv_slider'), value: 'none'},
						{label: __('Round', 'sv_slider'), value: 'round'},
						{label: __('Dash', 'sv_slider'), value: 'dash'},
						{label: __('Square', 'sv_slider'), value: 'square'},
					]}
					value={svSliderAttributes['indicators-style']}
					onChange={(value) => onStaticChange(value, 'indicators-style')}
				/>
				
				<ToggleControl
					label={__('Dark', 'sv_slider')}
					options={[
						{label: __('On', 'sv_slider'), value: true},
						{label: __('Off', 'sv_slider'), value: false},
					]}
					checked={svSliderAttributes['indicators-dark']}
					onChange={(value) => onStaticChange(value, 'indicators-dark')}
				/>
				
				<ToggleControl
					label={__('Outside', 'sv_slider')}
					options={[
						{label: __('On', 'sv_slider'), value: true},
						{label: __('Off', 'sv_slider'), value: false},
					]}
					checked={svSliderAttributes['indicators-outside']}
					onChange={(value) => onStaticChange(value, 'indicators-outside')}
				/>
				
				<ToggleControl
					label={__('Highlight', 'sv_slider')}
					options={[
						{label: __('On', 'sv_slider'), value: true},
						{label: __('Off', 'sv_slider'), value: false},
					]}
					checked={svSliderAttributes['indicators-highlight']}
					onChange={(value) => onStaticChange(value, 'indicators-highlight')}
				/>
				
				<ToggleControl
					label={__('Visible on small devices', 'sv_slider')}
					options={[
						{label: __('On', 'sv_slider'), value: true},
						{label: __('Off', 'sv_slider'), value: false},
					]}
					checked={svSliderAttributes['indicators-visible-sm']}
					onChange={(value) => onStaticChange(value, 'indicators-visible-sm')}
				/>
				
				<Button className="colorpicker-button" onClick={()=>props.setAttributes({_svSliderIndicatorsColorPopover: true})}>
					<ColorIndicator
						className={'clickable'}
						colorValue={svSliderAttributes['--swiffy-slider-indicators-color']['Mobile']}
					
					/>
					{ attributes._svSliderIndicatorsColorPopover === true &&
						<Popover position='left' onClose={()=>props.setAttributes({_svSliderIndicatorsColorPopover: false})}>
							<ColorPalette
								colors={ themeColors }
								value={ svSliderAttributes['--swiffy-slider-indicators-color']['Mobile'] }
								onChange={ (value) => onChange(value, '--swiffy-slider-indicators-color') }
							/>
						</Popover>
					}
					<span>{__('Color', 'sv_slider')}</span>
				</Button>
				
				<Button className="colorpicker-button" onClick={()=>props.setAttributes({_svSliderIndicatorsColorActivePopover: true})}>
					<ColorIndicator
						className={'clickable'}
						colorValue={svSliderAttributes['--swiffy-slider-indicators-color-active']['Mobile']}
					
					/>
					{ attributes._svSliderIndicatorsColorActivePopover === true &&
						<Popover position='left' onClose={()=>props.setAttributes({_svSliderIndicatorsColorActivePopover: false})}>
							<ColorPalette
								colors={ themeColors }
								value={ svSliderAttributes['--swiffy-slider-indicators-color-active']['Mobile'] }
								onChange={ (value) => onChange(value, '--swiffy-slider-indicators-color-active') }
							/>
						</Popover>
					}
					<span>{__('Active Color', 'sv_slider')}</span>
				</Button>
			</PanelBody>
			
			<PanelBody title='Autoplay' initialOpen={false}>
				<p>Autoplay settings are not responsive.</p>
				<ToggleControl
					label={__('Auto play slides', 'sv_slider')}
					options={[
						{label: __('On', 'sv_slider'), value: true},
						{label: __('Off', 'sv_slider'), value: false},
					]}
					checked={svSliderAttributes['--swiffy-slider-class-autoplay']}
					onChange={(value) => onStaticChange(value, '--swiffy-slider-class-autoplay')}
				/>
				<ToggleControl
					label={__('Pause on hover and touch', 'sv_slider')}
					options={[
						{label: __('On', 'sv_slider'), value: true},
						{label: __('Off', 'sv_slider'), value: false},
					]}
					checked={svSliderAttributes['--swiffy-slider-class-autopause']}
					onChange={(value) => onStaticChange(value, '--swiffy-slider-class-autopause')}
				/>
				<NumberControl
					label={__('Autoplay delay (ms)', 'sv_slider')}
					isShiftStepEnabled={ true }
					onChange={(value) => onStaticChange(value, '--swiffy-slider-data-autoplay-timeout')}
					shiftStep={ 100 }
					value={svSliderAttributes['--swiffy-slider-data-autoplay-timeout']}
				/>
				
			</PanelBody>
		</Fragment>
	);
}