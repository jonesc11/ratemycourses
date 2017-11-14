$(document).ready(function() {
    $("a").click(function() { 
        // window.event.target gets the element that was clicked on, "li"
        // $(this).on("click",populate(window.event.target));
	    var coursenav = document.getElementById('coursenav');
	    var headings = coursenav.getElementsByTagName("h2");
	    for (var i = 0; i <headings.length; i++) {
	    	headings[i].style.fontSize = "14px";
	    }
		coursenav.style.paddingLeft = "0px";
		coursenav.style.fontSize = "12px";
		coursenav.style.width = "20%";
		coursenav.style.height = "100%";
		coursenav.style.backgroundColor = "rgb(235,241,246)";
    }); 

});

function populate(e){




}

