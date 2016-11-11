 $(document).ready(function () {

   $("body").contents().each(function () {
    if (this.nodeType === 3) this.nodeValue = $.trim($(this).text()).replace(/SmashTracker/g, "WebsiteName")
    if (this.nodeType === 1) $(this).html( $(this).html().replace(/SmashTracker/g, "WebsiteName") )
})
	// Add ".nav-active" to current page's tab

	var uri = window.location.pathname;
	var uriParts = uri.split('/');
  var uri1 = uriParts[1];
	var uri2 = uriParts[2];

	// If viewing the page from the root, default to HOME tab
	if (uri2 === undefined ){
		uri2 = 'home';
	}

	$('.'+uri2+'-link').addClass('nav-active');
  $('.'+uri1+'-link').addClass('nav-active');

});
