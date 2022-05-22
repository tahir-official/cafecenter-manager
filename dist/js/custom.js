$(".toggle-password").click(function () {
  $(this).children().toggleClass("fa-lock fa-lock-open");
  let input = $(this).prev();
  console.log(input);
  input.attr("type", input.attr("type") === "password" ? "text" : "password");
});

$("#agreeTerms").click(function () {
  if ($(this).is(":checked")) {
    $("#sdbtn").prop("disabled", false);
  } else {
    $("#sdbtn").prop("disabled", true);
  }
});

function sent_otp(cnumber, page) {
  $.ajax({
    method: "POST",
    url: baseUrl + "include/process.php?action=send_otp",
    data: { cnumber: cnumber, page: page },
    dataType: "JSON",
    beforeSend: function () {
      $("#alert").html(
        '<i class="fa fa-spinner fa-spin" style="font-size:27px;margin-bottom: 15px;color: brown;"></i>'
      );
      $("#vload").html(
        '<i class="fa fa-spinner fa-spin" style="font-size:27px;margin-bottom: 15px;color: brown;margin-top: 5px;"></i>'
      );

      if (page == "forget") {
        $(".btnForgetpass").html('Processing <i class="fa fa-spinner"></i>');
        $(".btnForgetpass").prop("disabled", true);
        $("#alert").hide();
      }
    },
  })

    .fail(function (response) {
      alert("Try again later.");
    })

    .done(function (response) {
      if (response.status == 0) {
        $("#alert").html(response.message);
        $("#alert").show();
        $("#vload").html('<a href="' + baseUrl + 'index.php">Login</a>');
        if (page == "forget") {
          $(".btnForgetpass").html("Request OTP");
          $(".btnForgetpass").prop("disabled", false);
        }
      } else {
        location.href = response.url;
      }
    });

  return false;
}

/*login script start*/
$("#alert").hide();
$("#loginFrom").submit(function (e) {
  e.preventDefault();
  let formData = $("#loginFrom").serialize();
  $.ajax({
    method: "POST",
    url: baseUrl + "include/process.php?action=login",
    data: formData,
    dataType: "JSON",
    beforeSend: function () {
      $(".btnLogin").html('Login <i class="fa fa-spinner"></i>');
      $(".btnLogin").prop("disabled", true);
      $("#alert").hide();
    },
  })

    .fail(function (response) {
      alert("Try again later.");
    })

    .done(function (response) {
      if (response.status == 0) {
        $("#alert").html(response.message);
        $("#alert").show();
      } else {
        location.href = response.url;
      }
    })
    .always(function () {
      $(".btnLogin").html("Login");
      $(".btnLogin").prop("disabled", false);
    });
  return false;
});
/*login script end*/

/*load Distric list start*/
function loadDistric(state_id) {
  $.ajax({
    method: "POST",
    url: baseUrl + "include/process.php?action=get_distric",
    data: { state_id: state_id },
    dataType: "JSON",
    beforeSend: function () {
      $("#district").html("<option>Please wait</option>");
    },
  })

    .fail(function (response) {
      alert("Try again later.");
    })

    .done(function (response) {
      $("#district").html(response.html);
    });
  return false;
}
/*load Distric list end*/

/*signup form start*/
$(document).ready(function () {
  $("#signupFrom").validate({
    rules: {
      user_type: {
        required: true,
      },
      fname: {
        required: true,
      },
      lname: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      contact_number: {
        required: true,
        number: true,
        maxlength: 10,
      },
      address: {
        required: true,
      },
      state: {
        required: true,
      },
      district: {
        required: true,
      },
      city: {
        required: true,
      },
      zipcode: {
        required: true,
        number: true,
      },
      gender: {
        required: true,
      },
      dob: {
        required: true,
      },
      password: {
        required: true,
      },
      c_password: {
        required: true,
        equalTo: "#password",
      },
    },
    submitHandler: function (form) {
      let formData = new FormData($("#signupFrom")[0]);
      $.ajax({
        method: "POST",
        url: baseUrl + "include/process.php?action=add_user",
        data: formData,
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
          $(".btnsbt").html('<i class="fa fa-spinner"></i> Processing...');
          $(".btnsbt").prop("disabled", true);
          $("#alert").hide();
        },
      })

        .fail(function (response) {
          alert("Try again later.");
        })

        .done(function (response) {
          $(".btnsbt").html("Register");
          $(".btnsbt").prop("disabled", false);
          if (response.status == 0) {
            $("#alert").show();
            $("#alert").html(response.message);
          } else {
            location.href = response.url;
          }
        })
        .always(function () {
          $(".btnsbt").html("Register");
          $(".btnsbt").prop("disabled", false);
        });
      return false;
    },
  });
});

/*signup form end*/

/*otpverify form start*/
$(document).ready(function () {
  $("#otpverifyFrom").validate({
    rules: {
      number: {
        required: true,
        number: true,
        maxlength: 10,
      },
      otp: {
        required: true,
        number: true,
      },
    },
    submitHandler: function (form) {
      let formData = new FormData($("#otpverifyFrom")[0]);
      $.ajax({
        method: "POST",
        url: baseUrl + "include/process.php?action=otp_verify",
        data: formData,
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
          $(".btnOtpverify").html(
            '<i class="fa fa-spinner"></i> Processing...'
          );
          $(".btnOtpverify").prop("disabled", true);
          $("#alert").hide();
        },
      })

        .fail(function (response) {
          alert("Try again later.");
        })

        .done(function (response) {
          $(".btnOtpverify").html("Submit");
          $(".btnOtpverify").prop("disabled", false);
          if (response.status == 0) {
            $("#alert").show();
            $("#alert").html(response.message);
          } else {
            location.href = response.url;
          }
        })
        .always(function () {
          $(".btnOtpverify").html("Submit");
          $(".btnOtpverify").prop("disabled", false);
        });
      return false;
    },
  });
});

/*otpverify form end*/

/*forget form start*/
$(document).ready(function () {
  $("#forgetpassFrom").validate({
    rules: {
      number: {
        required: true,
        number: true,
        maxlength: 10,
      },
    },
    submitHandler: function (form) {
      var number = $("#number").val();
      var page = $("#page").val();
      sent_otp(number, page);
    },
  });
});

/*forget form end*/

/*reset password form start*/
$(document).ready(function () {
  $("#resetFrom").validate({
    rules: {
      password: {
        required: true,
      },
      cpassword: {
        required: true,
        equalTo: "#password",
      },
    },
    submitHandler: function (form) {
      let formData = new FormData($("#resetFrom")[0]);
      $.ajax({
        method: "POST",
        url: baseUrl + "include/process.php?action=reset_password",
        data: formData,
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
          $(".btnResetpass").html(
            '<i class="fa fa-spinner"></i> Processing...'
          );
          $(".btnResetpass").prop("disabled", true);
          $("#alert").hide();
        },
      })

        .fail(function (response) {
          alert("Try again later.");
        })

        .done(function (response) {
          $(".btnResetpass").html("Submit");
          $(".btnResetpass").prop("disabled", false);
          if (response.status == 0) {
            $("#alert").show();
            $("#alert").html(response.message);
          } else {
            location.href = response.url;
          }
        })
        .always(function () {
          $(".btnResetpass").html("Submit");
          $(".btnResetpass").prop("disabled", false);
        });
      return false;
    },
  });
});

/*reset password form end*/
