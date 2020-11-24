$(document).ready(function() {

	// Select tag with rel classdesc when mouse is over the bdo character class image
	$('a[rel=classdesc]').mouseover(function(e) {
		
		// Grab the title attribute value
		var tv = $(this).attr('title');	
		
		// Remove the title attribute's to avoid the first classdesc from the browser
		$(this).attr('title','');
		
		// Append the classdesc template and it's value
		$(this).append('<div id="classdesc"><div class="body">' + tv + '</div></div>');		
				
		// Show the classdesc with few effects
		$('#classdesc').fadeIn('500');
		$('#classdesc').fadeTo('10',0.9);
		
	}).mousemove(function(e) {
	
		// Keep changing the X and Y axis for the classdesc, then the classdesc move along with the mouse
		$('#classdesc').css('top', e.pageY + 10 );
		$('#classdesc').css('left', e.pageX - 125 );
		
	}).mouseout(function() {
	
		// Put back the title attribute value
		$(this).attr('title',$('.body').html());
	
		// Remove the appended classdesc template
		$(this).children('div#classdesc').remove();		
	});
});
