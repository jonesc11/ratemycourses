$(document).ready(function() {
    $("#courseinfo").hide();
    $(".major-link").click(function(e) { 
        $("#coursenav").removeClass("initial-view").addClass("side-view");
        $(".display-school").removeClass("display-school").addClass("side-school");
      
        var code = e.currentTarget.title;
        var request = $.ajax({
          url: "/lib/browse-helpers.php",
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

