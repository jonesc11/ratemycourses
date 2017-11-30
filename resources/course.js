$(document).ready(function() {
    $("#courseinfo").hide();
    $(".major-link").click(function(e) {
        $("#coursenav-container").removeClass("initial-view").addClass("side-view");
        $("#coursenav").removeClass("courses");
        $(".display-school").removeClass("display-school").addClass("side-school");
        
        var code = e.currentTarget.title;
        var schoolid = $("input[name=schoolid]").val();
        var request = $.ajax({
          url: "/lib/browse-helpers.php",
          type: "post",
          data: {
            major: code,
            schoolid: schoolid
          }
        }).done(function(data) {
          $("#major_container").html(data);
          $("#courseinfo").show();
        }).fail(function() {
          alert("Error");
        });
      
        window.location.hash = '#courseinfo';
    }); 
});
