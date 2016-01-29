$(document).ready(function(){ 
	var jsFileLocation = $('script[src*=cmcboolean]').attr('src');  // the js file path
	alert(jsFileLocation);
	jsFileLocation = jsFileLocation.replace(/cmcboolean\.js.*$/, '');   // the js folder path
  $(".col-IsCompleted-NiceCMS").html($(".col-IsCompleted-NiceCMS").html().replace(/ /g,'<img src="'+jsFileLocation+'images/checkmark.png" />'));
});