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
        url: baseUrl + "include/process.php",
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

/*load table data start*/
function tableLoad(loadurl, user_type, portal, show_by) {
  var dataTable = $("#mytable").DataTable({
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
      url: loadurl,
      type: "POST",
      data: {
        user_type: user_type,
        portal: portal,
        show_by: show_by,
      },
    },
    columnDefs: [
      {
        targets: "_all" /* column index */,

        orderable: false /* true or false */,
      },
    ],
  });
}
/*load table data end*/

/*reset password form start*/
function resetPasswordFrom() {
  $("#updatePassword")[0].reset();
  return false;
}
/*reset password form end*/

/*update password script start*/
$(document).ready(function () {
  $("#updatePassword").validate({
    rules: {
      current_password: {
        required: true,
      },
      new_password: {
        required: true,
      },
      confirm_password: {
        required: true,
        equalTo: "#new_password",
      },
    },
    submitHandler: function (form) {
      let formData = new FormData($("#updatePassword")[0]);
      $.ajax({
        method: "POST",
        url: baseUrl + "include/process.php?action=changePassword",
        data: formData,
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
          $("#updatePassBtn").html(
            '<i class="fa fa-spinner"></i> Processing...'
          );
          $("#updatePassBtn").prop("disabled", true);
          $("#alert_change_pass").hide();
        },
      })

        .fail(function (response) {
          alert("Try again later.");
        })

        .done(function (response) {
          $("#updatePassBtn").prop("disabled", false);
          $("#updatePassBtn").html("Change");
          $("#alert_change_pass").show();
          $("#alert_change_pass").html(response.message);
          if (response.status == 1) {
            $("#updatePassword")[0].reset();
          }
        })
        .always(function () {
          $("#updatePassBtn").html("Change");
          $("#updatePassBtn").prop("disabled", false);
        });
      return false;
    },
  });
});

/*update password script end*/

/*edit user form start*/
$(document).ready(function () {
  $("#edit_form").validate({
    rules: {
      fname: {
        required: true,
      },
      lname: {
        required: true,
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
    },
    submitHandler: function (form) {
      let formData = new FormData($("#edit_form")[0]);
      $.ajax({
        method: "POST",
        url: baseUrl + "include/process.php?action=edit_users",
        data: formData,
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
          $(".btnsbt").html('<i class="fa fa-spinner"></i> Processing...');
          $(".btnsbt").prop("disabled", true);
          $("#alert_edit_user").hide();
        },
      })

        .fail(function (response) {
          alert("Try again later.");
        })

        .done(function (response) {
          $(".btnsbt").html("Submit");
          $(".btnsbt").prop("disabled", false);
          $("#alert_edit_user").show();
          $("#alert_edit_user").html(response.message);
          if (response.status == 1) {
            $("#manager_name").html(response.manager_name);
            $("#profile_name").html(response.manager_name);
          }
        })
        .always(function () {
          $(".btnsbt").html("Submit");
          $(".btnsbt").prop("disabled", false);
        });
      return false;
    },
  });
});

/*edit user form end*/

$(document).ready(function () {
  $("#profile_image").on("change", function () {
    let formData = new FormData($("#profile_form")[0]);
    $.ajax({
      method: "POST",
      url: baseUrl + "include/process.php?action=edit_profile_image",
      data: formData,
      dataType: "JSON",
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $(".loader").css("display", "block");
        $(".profile_form").prop("disabled", true);
        $("#alert").hide();
      },
    })

      .fail(function (response) {
        alert("Try again later.");
      })

      .done(function (response) {
        $(".loader").css("display", "none");
        $(".profile_form").prop("disabled", false);
        $("#alert").show();
        $("#alert").html(response.message);
        if (response.status == 1) {
          $("#header_profile_image").attr("src", response.profile_url);
          $(".outer").css(
            "background-image",
            "url(" + response.profile_url + ")"
          );
        }
      })
      .always(function () {
        $(".loader").css("display", "none");
        $(".profile_form").prop("disabled", false);
      });
    return false;
  });
});

/*Load Users Popup start*/
function load_users_popup(row_id, user_type) {
  $.ajax({
    method: "POST",
    url: baseUrl + "include/process.php?action=load_users_popup",
    data: { row_id: row_id, user_type: user_type },
    dataType: "JSON",
    beforeSend: function () {
      $("#form-dialog-other").modal("show");
      $("#popupcontent").html('<div id="loader"></div>');
    },
  })

    .fail(function (response) {
      alert("Try again later.");
    })

    .done(function (response) {
      $.getScript(baseUrl + "dist/js/custom.js");

      $("#popupcontent").html(response.html);
    })
    .always(function () {
      $("#form-dialog-other").modal("show");
    });

  return false;
}
/*Load Users Popup end*/
/*add edit district_manager_form form start*/
$(document).ready(function () {
  $("#users_form").validate({
    rules: {
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
    },
    submitHandler: function (form) {
      let formData = new FormData($("#users_form")[0]);
      $.ajax({
        method: "POST",
        url: baseUrl + "include/process.php",
        data: formData,
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
          $(".btnsbt").html('<i class="fa fa-spinner"></i> Processing...');
          $(".btnsbt").prop("disabled", true);
          $("#alert").hide();
          $("#popupalert").hide();
        },
      })

        .fail(function (response) {
          alert("Try again later.");
        })

        .done(function (response) {
          $(".btnsbt").html("Submit");
          $(".btnsbt").prop("disabled", false);
          if (response.status == 0) {
            $("#popupalert").show();
            $("#popupalert").html(response.message);
          } else {
            $("#form-dialog-other").trigger("click");
            $("#mytable").DataTable().destroy();
            tableLoad(
              response.fetchTableurl,
              response.user_type,
              response.portal,
              response.show_by
            );
            $("#alert").show();
            $("#alert").html(response.message);
            $("#users_form")[0].reset();
          }
        })
        .always(function () {
          $(".btnsbt").html("Submit");
          $(".btnsbt").prop("disabled", false);
        });
      return false;
    },
  });
});

/*add edit district_manager_form form end*/

/*change user status start*/
function changeUserStatus(user_id, status, user_type) {
  if (status == 1) {
    var alert = "active";
  } else {
    var alert = "deactive";
  }
  if (user_type == 1) {
    alertmessage =
      "Are you sure you want to " + alert + " this District Manager?";
  } else if (user_type == 2) {
    alertmessage = "Are you sure you want to " + alert + " this Distributor?";
  } else if (user_type == 3) {
    alertmessage = "Are you sure you want to " + alert + " this Retailer?";
  } else if (user_type == 4) {
    alertmessage = "Are you sure you want to " + alert + " this Consumer?";
  }
  if (confirm(alertmessage)) {
    $.ajax({
      method: "POST",
      url: baseUrl + "include/process.php?action=change_user_status",
      data: { user_id: user_id, status: status, user_type: user_type },
      dataType: "JSON",
      beforeSend: function () {
        $(".stbtn").attr("disabled", true);
        $("#alert").hide();
      },
    })

      .fail(function (response) {
        alert("Try again later.");
      })

      .done(function (response) {
        if (response.status == 0) {
          $(".stbtn").attr("disabled", false);
        } else {
          $("#mytable").DataTable().destroy();
          tableLoad(
            response.fetchTableurl,
            response.user_type,
            response.portal,
            response.show_by
          );
        }
        $("#alert").html(response.message);
        $("#alert").show();
      })

      .always(function () {
        $(".stbtn").attr("disabled", false);
      });
  } else {
    return false;
  }
}
/*change user status end*/

/*load user detail model script start*/
function detailPopupUser(user_id) {
  $.ajax({
    method: "POST",
    url: baseUrl + "include/process.php?action=detail_popup_user",
    data: { user_id: user_id },
    dataType: "JSON",
    beforeSend: function () {
      $("#form-dialog-other").modal("show");
      $("#popupcontent").html('<div id="loader"></div>');
    },
  })

    .fail(function (response) {
      alert("Try again later.");
    })

    .done(function (response) {
      $.getScript(baseUrl + "dist/js/custom.js");

      $("#popupcontent").html(response.html);
    })
    .always(function () {
      $("#form-dialog-other").modal("show");
    });

  return false;
}
/*load user model script end*/

/*load paywall script start*/
function load_paywall(user_id) {

  $.ajax({
    method: "POST",
    url: baseUrl + "include/process.php?action=load_paywall",
    data: { user_id: user_id },
    dataType: "JSON",
    beforeSend: function () {
      $(".wrapper").html('<div id="loader"></div>');
      $(".wrapper").css("text-align", "center");
    },
  })

    .fail(function (response) {
      alert("Try again later.");
    })

    .done(function (response) {
      $.getScript(baseUrl + "dist/js/custom.js");
      if (response.status == 0) {
        $(".wrapper").html(response.html);
        $(".wrapper").css("text-align", "center");
      } else {
        $(".wrapper").html(response.html);
        $(".wrapper").css("text-align", "center");
        $(".wrapper").css("background-image", "url(" + response.img + ")");
        $(".wrapper").css("height", "100vh");
        $(".wrapper").css("background-size", "cover");
        $(".wrapper").css("justify-content", "center");
        $(".wrapper").css("display", "flex");
        $(".wrapper").css("align-items", "center");
        
      }
    });

  return false;
}
$(".first").click(function(){
  $(".second").click(); 
  return false;
});
/*load paywall script end*/
