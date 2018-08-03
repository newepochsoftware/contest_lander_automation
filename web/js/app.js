$(document).foundation()

$(document).ready(function () {

    // set up the jquery numeric only function
    jQuery.fn.ForceNumericOnly = function (size) {
        return this.each(function ()
        {
            $(this).keypress(function (e)
            {
                var key = e.charCode || e.keyCode || 0;
                var ctrlKey = (e.ctrlKey ? true : false);
                if (ctrlKey && (key === 118 || key === 99 || key === 114)) {
                    // ctrl-c, ctrl-v, ctrl-r 
                    return true;
                }
                // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
                // home, end, period, and numpad decimal
                if (key === 8 ||
                        key === 9 ||
                        key === 35 ||
                        key === 36 ||
                        key === 37 ||
                        key === 39 ||
                        key === 46
                        )
                    return true;
                if (size && $(this).val().length >= size) {
                    $(this).val($(this).val().substr(0, 5));
                    return false;
                }
                return ((e.shiftKey === false && key >= 48 && key <= 57));
            });
        });
    };

    var formatPhone = function () {
        var val = phone.val().replace(/\D/g, "");
        /*if (val.length > 0 && (val.substr(0,1) === "1" || val.substr(0,1) === "0")) {
        val = val.substr(1);
        }*/
        val = val.replace(/^[01]+/, "");
        if (val.length === 0) {
            phone.val("");
            return;
        }
        else if (val.length <= 3) {
            phone.val("(" + val);
        } else if (val.length <= 6) {
            phone.val("(" + val.substr(0, 3) + ") " + val.substr(3));
        } else {
            phone.val("(" + val.substr(0, 3) + ") " + val.substr(3, 3) + "-" + val.substr(6));
        }
    };

    var currentTarget = null;
    var errorBox = $("#error_box");
    var frontPageForm = $("#contest_form");
    if (frontPageForm.length) {
    // only run this code if the front page form actually exists
    var form = frontPageForm;
    form.validate({
        submitHandler: function (form) {
            $.ajax({
                type: $(form).attr('method'),
                url: $(form).attr('action'),
                data: $(form).serialize(),
                dataType: 'json'
            })
            .done(function (response) {
                if (response.status === "success") {
                    /* var profileURL = (typeof profileURL !== 'undefined') ? profileURL : 'default'; */
                    window.location.href = "thank-you.php?profile="+profileURL;
                } else {
                    window.alert("AN ERROR OCCURRED");
                }
            });
              return false; // required to block normal submit since you used ajax
          },
          rules: {
            fname: {
                required: true
            },
            lname: {
                required: true
            },
            email: {
                required: true,
                email: true,
                pattern: /@.+\..+/
            },
            phone: {
                pattern: /^\(\d{3}\) \d{3}-\d{4}$/
            }
          },
          messages: {
            fname: {
                required: "Please enter your first name",
                minlength: "Abbreviated names aren't accepted"
            },
            lname: {
                required: "Please enter your surname",
                minlength: "Abbreviated names aren't accepted"
            },
            email: {
                required: "Please enter a valid email address",
                email: "The address you have entered is invalid",
                pattern: "The address you have entered is invalid"
            },
            phone: {
                required: "Please include your contact number",
                pattern: "Must be a 10-digit number"
            }
          },
          showErrors: function (errorMap, errorList) {
            $("input, select").parent().removeClass("error");
            if (0 !== this.numberOfInvalids()) {
                var firstError = errorList[0];
                // not sure why but gets number of invalids != 0
                // while having no errors in list
                if (typeof firstError !== 'undefined') {
                    var elem = firstError.element;
                    currentTarget = elem;
                    var offset = $(elem).offset();
                    errorBox.css("left", offset.left - 15);
                    errorBox.css("top", offset.top + $(elem).height() + 35);
                    errorBox.html(firstError.message);
                    errorBox.show();
                    // $(elem).focus();
                    // add error to all element classes
                    for (var x in errorList) {
                        var obj = errorList[x];
                        $(obj.element).parent().addClass("error");
                    }
                }
            } else {
                errorBox.hide();
            }
        }
    });
  }

  var phone = $("#phone");
      phone.ForceNumericOnly();
      phone.keyup(formatPhone);
      phone.change(formatPhone);
      phone.bind("paste", formatPhone);

  $("input").focus(function () {
      if (this !== currentTarget &&
            (this.type === "text" ||
            this.type === "email" ||
            this.type === "tel")) {
        errorBox.hide();
      }
  });

  $("input,select").change(function () {
      errorBox.hide();
  });

});