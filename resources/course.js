$(document).ready(function() {
    $("#courseinfo").hide();
    $(".major-link").click(function(e) { 
        // window.event.target gets the element that was clicked on, "li"
        // $(this).on("click",populate(window.event.target));
//	    var coursenav = document.getElementById('coursenav');
//	    var headings = coursenav.getElementsByTagName("h2");
//	    for (var i = 0; i <headings.length; i++) {
//	    	headings[i].style.fontSize = "14px";
//	    }
//		coursenav.style.paddingLeft = "0px";
//		coursenav.style.fontSize = "12px";
//		coursenav.style.width = "20%";
//		coursenav.style.height = "100%";
//		coursenav.style.backgroundColor = "rgb(235,241,246)";
        $("#coursenav").removeClass("initial-view").addClass("side-view");
        $(".display-school").removeClass("display-school").addClass("side-school");
      
        var code = e.currentTarget.title;
        var request = $.ajax({
          url: "../ratemycourses/lib/browse-helpers.php",
          type: "post",
          data: {major: code}
        }).done(function(data) {
          $("#major_container").html(data);
          $("#courseinfo").show();
        }).fail(function() {
          alert("Error");
        });
    }); 

});

function populate(e){




}

