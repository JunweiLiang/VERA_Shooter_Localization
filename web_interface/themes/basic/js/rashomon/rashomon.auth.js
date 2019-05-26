
var auth = {};
$(document).ready(function () {

    $("#auth").toggle();

    $('.signin').click(function () {
        navigator.id.request();
    });

$("#logout").click(function() {

  navigator.id.logout(); 
});



});    


function loggedIn(email) {
    setSessions([{
        email: email
    }]);
    var sign = $("#signin");
    sign.text("Signed in as " + email);
    sign.unbind("click");
    $("#auth").toggle();
    $("#upload").toggle();
}


function setSessions(val) {
    if (navigator.id) {
        navigator.id.sessions = val ? val : [];
    }
}

function loggedOut() {
    console.log("logged out");
}



navigator.id.watch({
  loggedInUser: null,
  onlogin: function(assertion) {
    // A user has logged in! Here you need to:
    // 1. Send the assertion to your backend for verification and to create a session.
    // 2. Update your UI.
    $.ajax({ /* <-- This example uses jQuery, but you can use whatever you'd like */
      type: 'POST',
      url: 'signin.php', // This is a URL on your website.
      dataType: 'JSON',
      data: {assertion: assertion},
      success: function(res, status, xhr) { 
        console.log(res.status);
        if (res.status === "okay"){
          auth.assertion = assertion;
          Rashomon.loggedIn();
        } else {
          $("#auth").toggle();
 
        }
      },
      error: function(xhr, status, err) { alert("Login failure: " + err); }
    });
  },
  onlogout: function() {
    // A user has logged out! Here you need to:
    // Tear down the user's session by redirecting the user or making a call to your backend.
    // Also, make sure loggedInUser will get set to null on the next page load.
    // (That's a literal JavaScript null. Not false, 0, or undefined. null.)
    $.ajax({
      type: 'POST',
      url: 'signin.php', // This is a URL on your website.
      success: function(res, status, xhr) { window.location.reload(); },
      error: function(xhr, status, err) { alert("Logout failure: " + err); }
    });
  }
});



//browserID assertion
function gotAssertion(assertion) {
    // got an assertion, now send it up to the server for verification  
    if (assertion !== null) {
        $.ajax({
            type: 'POST',
            url: 'signin.php',
            data: {
                assertion: assertion
            },
            success: function (res, status, xhr) {
                if (res === null) {
                    loggedOut();
                } else {
                    loggedIn(res);
                }
            },
            error: function(xhr, status, err) {
                alert("login failure" + err);
            }
        });
    } else {
        loggedOut();
    }
}
