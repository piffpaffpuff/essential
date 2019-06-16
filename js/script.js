jQuery(document).ready(function($) {

	/* --------------------------------
	 * properties
	 * -------------------------------- */

 // 	// var splitTextTimeline = new TimelineLite();

 	/* --------------------------------
 	 * init
 	 * -------------------------------- */

	 // scroll tracking
	ScrollOut({
		once: true,
		threshold: 0,
		onShown: onShown_scrollOut,
		onHidden: onHidden_scrollOut
	});

 	/* --------------------------------
 	 * functions
 	 * -------------------------------- */

	// split title
	function splitTitle(element) {
		var split = new SplitText(element, {type:"chars, words", wordsClass:"word word++"});
		var splitTimeline = new TimelineLite();
		splitTimeline.staggerFrom(split.chars, 1.1, {delay: 0.5, y:"100%", transformOrigin:"0% 0%", ease:Power4.easeOut}, 0.06);
	}

	/* --------------------------------
	 * events
	 * -------------------------------- */

	// scroll out
	function onShown_scrollOut(element, ctx, scrollelement) {
		var $element = $(element);
		if($element.hasClass('split-text') == true) {
			//splitTitle($element);
		}
	}

	// scroll in
	function onHidden_scrollOut(element) {
	}
});
