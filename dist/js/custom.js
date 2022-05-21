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
      let formData = new FormData($("#signupFrom")[0]);
      $.ajax({
        method: "POST",
        url: baseUrl + "include/process.php?action=add_edit_users",
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
            tableLoad(response.fetchTableurl, response.user_type);
            $("#alert").show();
            $("#alert").html(response.message);
            $("#district_manager_form")[0].reset();
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

/*signup form end*/
