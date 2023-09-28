// don't overwrite this file with swiffy-slider.js
const swiffyslider = function () {
	return {
		version: "1.6.0",
		init(rootElement = document.body) {
			for (let sliderElement of rootElement.querySelectorAll(".swiffy-slider")) {
				this.initSlider(sliderElement);
			}
		},
		
		initSlider(sliderElement) {
			for (let navElement of sliderElement.querySelectorAll(".slider-nav")) {
				let next = navElement.classList.contains("slider-nav-next");
				navElement.addEventListener("click", () => this.slide(sliderElement, next), {passive: true});
			}
			for (let indicatorElement of sliderElement.querySelectorAll(".slider-indicators")) {
				indicatorElement.addEventListener("click", () => this.slideToByIndicator());
				this.onSlideEnd(sliderElement, () => this.handleIndicators(sliderElement), 60);
			}
			if (sliderElement.classList.contains("slider-nav-autoplay")) {
				const timeout = sliderElement.getAttribute("data-slider-nav-autoplay-interval") ? sliderElement.getAttribute("data-slider-nav-autoplay-interval") : 2500;
				this.autoPlay(sliderElement, timeout, sliderElement.classList.contains("slider-nav-autopause"));
			}
			if (["slider-nav-autohide", "slider-nav-animation"].some(className => sliderElement.classList.contains(className))) {
				const threshold = sliderElement.getAttribute("data-slider-nav-animation-threshold") ? sliderElement.getAttribute("data-slider-nav-animation-threshold") : 0.3;
				this.setVisibleSlides(sliderElement, threshold);
			}
			
			this.slideTo(sliderElement, 0);
		},
		
		setVisibleSlides(sliderElement, threshold = 0.3) {
			let observer = new IntersectionObserver(slides => {
				slides.forEach(slide => {
					slide.isIntersecting ? slide.target.classList.add("slide-visible") : slide.target.classList.remove("slide-visible");
				});
				sliderElement.querySelector(".slider-container>*:first-child").classList.contains("slide-visible") ? sliderElement.classList.add("slider-item-first-visible") : sliderElement.classList.remove("slider-item-first-visible");
				sliderElement.querySelector(".slider-container>*:last-child").classList.contains("slide-visible") ? sliderElement.classList.add("slider-item-last-visible") : sliderElement.classList.remove("slider-item-last-visible");
			}, {
				root: sliderElement.querySelector(".slider-container"),
				threshold: threshold
			});
			for (let slide of sliderElement.querySelectorAll(".slider-container>*"))
				observer.observe(slide);
		},
		
		slide(sliderElement, next = true) {
			const container = sliderElement.querySelector(".slider-container");
			const slides = container.children;
			const currentSlideIndex = Array.from(slides).findIndex(slide => slide.classList.contains('active'));
			
			if (next) {
				this.slideTo(sliderElement, currentSlideIndex + 1);
			} else {
				this.slideTo(sliderElement, currentSlideIndex - 1);
			}
		},
		
		slideToByIndicator() {
			const indicator = window.event.target;
			const indicatorIndex = Array.from(indicator.parentElement.children).indexOf(indicator);
			const indicatorCount = indicator.parentElement.children.length;
			const sliderElement = indicator.closest(".swiffy-slider");
			const slideCount = sliderElement.querySelector(".slider-container").children.length;
			const relativeSlideIndex = (slideCount / indicatorCount) * indicatorIndex;
			this.slideTo(sliderElement, relativeSlideIndex);
		},
		
		slideTo(sliderElement, slideIndex) {
			const container = sliderElement.querySelector(".slider-container");
			const gapWidth = parseInt(window.getComputedStyle(container).columnGap);
			const scrollStep = container.children[0].offsetWidth + gapWidth;
			const nodelay = sliderElement.classList.contains("slider-nav-nodelay");
			const noloop = sliderElement.classList.contains("slider-nav-noloop");
			
			// loop support
			if(noloop){
				// no loop - stop
				if(slideIndex < 0 || slideIndex >= container.children.length) return;
			}else{
				// loop - wrap around
				if(slideIndex < 0) slideIndex = container.children.length - 1; // go to last slide
				if(slideIndex > container.children.length - 1) slideIndex = 0; // go to first slide
			}
			
			this.setActiveSlide(sliderElement, slideIndex);
			container.scroll({
				left: (scrollStep * slideIndex),
				behavior: nodelay ? "auto" : "smooth"
			});
		},
		
		onSlideEnd(sliderElement, delegate, timeout = 125) {
			let isScrolling;
			
			sliderElement.querySelector(".slider-container").addEventListener("scroll", function () {
				window.clearTimeout(isScrolling);
				isScrolling = setTimeout(delegate, timeout);
			}, {capture: false, passive: true});
		},
		
		autoPlay(sliderElement, timeout, autopause) {
			timeout = timeout < 750 ? 750 : timeout;
			let autoplayTimer = setInterval(() => this.slide(sliderElement), timeout);
			const autoplayer = () => this.autoPlay(sliderElement, timeout, autopause);
			if (autopause) {
				["mouseover", "touchstart"].forEach(function (event) {
					sliderElement.addEventListener(event, function () {
						window.clearTimeout(autoplayTimer);
					}, {once: true, passive: true});
				});
				["mouseout", "touchend"].forEach(function (event) {
					sliderElement.addEventListener(event, function () {
						autoplayer();
					}, {once: true, passive: true});
				});
			}
			return autoplayTimer;
		},
		
		handleIndicators(sliderElement) {
			if (!sliderElement) return;
			const container = sliderElement.querySelector(".slider-container");
			const slidingAreaWidth = container.scrollWidth - container.offsetWidth;
			const percentSlide = (container.scrollLeft / slidingAreaWidth);
			for (let scrollIndicatorContainers of sliderElement.querySelectorAll(".slider-indicators")) {
				let scrollIndicators = scrollIndicatorContainers.children;
				let activeIndicator = Math.abs(Math.round((scrollIndicators.length - 1) * percentSlide));
				
				for (let element of scrollIndicators) element.classList.remove("active");
				
				if(typeof scrollIndicators[activeIndicator] !== 'undefined'){
					scrollIndicators[activeIndicator].classList.add("active");
					this.setActiveSlide(sliderElement, activeIndicator);
				}
				
			}
		},
		
		setActiveSlide(sliderElement, slideIndex) {
			const slides = sliderElement.querySelectorAll(".slider-container > *");
			if (slides) {
				slides.forEach((slide, index) => {
					slide.classList.remove('active');
					if (index === slideIndex) {
						slide.classList.add('active');
					}
				});
			}
		}
	};
}();

window.swiffyslider = swiffyslider;
if (!document.currentScript.hasAttribute("data-noinit")) {
	if (document.currentScript.hasAttribute("defer")) {
		swiffyslider.init();
	} else {
		document.onreadystatechange = () => {
			if (document.readyState === 'interactive') {
				swiffyslider.init();
			}
		}
	}
}