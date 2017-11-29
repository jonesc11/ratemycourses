$(document).ready(function () {
  $("#sign-up").on("click", function() {
    var username_v = $("form[name=create-account] input[name=username]").val();
    var firstname_v = $("form[name=create-account] input[name=firstname]").val();
    var lastname_v = $("form[name=create-account] input[name=lastname]").val();
    var email_v = $("form[name=create-account] input[name=email]").val();
    var confemail_v = $("form[name=create-account] input[name=conf_email]").val();
    var pw_v = $("form[name=create-account] input[name=password]").val();
    var confpw_v = $("form[name=create-account] input[name=conf_password]").val();
    
    var request = $.ajax({
      url: "/lib/form-submit-create-acct.php",
      type: "post",
      data: {
        firstname: firstname_v,
        lastname: lastname_v,
        username: username_v,
        email: email_v,
        conf_email: confemail_v,
        password: pw_v,
        conf_password: confpw_v
      }
    }).done(function(data) {
      $("#sign_up_form").html(data);
    }).fail(function() {
      alert("Error");
    });
  });
  
  $("#login-submit").on("click", function() {
    var username_v = $("form[name=login] input[name=username]").val();
    var password_v = $("form[name=login] input[name=password]").val();
    
    var request = $.ajax({
      url: "/lib/form_submit_login.php",
      type: "post",
      data: {
        username: username_v,
        password: password_v,
      }
    }).done(function(data) {
      $("#login_form").html(data);
    }).fail(function() {
      alert("Error");
    });
  });
});