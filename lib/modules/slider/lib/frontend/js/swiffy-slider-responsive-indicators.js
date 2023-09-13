const _swiffysliderResponsiveIndicators = function () {
	return {
		version: "1.6.0",
		init(rootElement = document.body) {
			for (const sliderElement of rootElement.querySelectorAll(".swiffy-slider")) {
				this.initSlider(rootElement);
			}
		},
		
		initSlider(rootElement) {
			this.handleResize(rootElement);
		},
		
		handleResize(rootElement = document.body) {
			const indicatorChild = '<li></li>';
			for (const sliderElement of rootElement.querySelectorAll('.swiffy-slider')) {
				const itemCount = parseInt(getComputedStyle(sliderElement).getPropertyValue('--swiffy-slider-item-count').trim(), 10);
				const sliderChildrenCount = sliderElement.querySelectorAll('.slider-container > *').length;
				const indicatorsWrapper = sliderElement.querySelector(".slider-indicators"); // Using querySelector instead of querySelectorAll
				
				if(indicatorsWrapper){
					const numberOfIndicators = Math.ceil(sliderChildrenCount / itemCount);
					indicatorsWrapper.innerHTML = ''; // Clear existing indicators

					for (let i = 0; i < numberOfIndicators; i++) {
						indicatorsWrapper.innerHTML += indicatorChild; // Append new indicators
					}
				}
				
			}
		},
		
		
	};
}

window.swiffyslider.responseIndicators = _swiffysliderResponsiveIndicators();
if (!document.currentScript.hasAttribute("data-noinit")) {
	window.addEventListener("load", () => {
		swiffyslider.responseIndicators.init();
	});
	
	window.addEventListener('resize', function() {
		swiffyslider.responseIndicators.handleResize();
	});
}


