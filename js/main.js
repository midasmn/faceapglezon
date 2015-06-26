$(document).ready(init);

var galleryWheel;
var galleryCenter;
var galleryItems;
var animating; 

function init() { 
	galleryWheel = $("#gallery-wheel");
	galleryCenter = $("#gallery-center");
	galleryItems = $("#gallery img");
	
	galleryItems.click(clickImage);
}

function clickImage(e) {
	var target = $(e.target);
	if (!target.hasClass("active") && !animating) {
		animating = true;
		var activeElement = galleryWheel.find(".active");
		
		// Calculate the amount of elements between the active (top) image and the clicked
        // one, and multiply that by the inner angle that each slice has.
		var rotateBy = -360/galleryItems.length * (target.index() - activeElement.index());
		
		// Make sure the shortest path is taken, the maximum length the wheel should spin
        // is 180 degrees.
		if (rotateBy >= 180) {
			rotateBy -= 360;
		} else if(rotateBy < -180) {
			rotateBy += 360;
		}


		// Create a temporary overlay element that fades in over the center image.
		// When the opacity is full, change the image of the center element behind,
		// and remove the overlay.
		$('<div class="fade-overlay">')
			.css("backgroundImage", "url(" + target.attr("src") + ")")
				.appendTo(galleryCenter).animate({opacity: 1.0}, 500, function() { 
					galleryCenter.css("backgroundImage", "url(" + target.attr("src") + ")");
					$(this).remove();
				});

		activeElement.removeClass("active");
		target.addClass("active");

		galleryWheel.animate({rotate: "+=" + rotateBy + 'deg'}, 500, function() { animating = false; } );
	}
}