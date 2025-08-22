//Contact form validation and response

$(document).ready(function(){
    $("#contact_submit_button").click(function(){
        let contact_name = $("#contact_name").val().trim();
        let contact_email = $("#contact_email").val().trim();
        let contact_subject = $("#contact_subject").val().trim();
        let contact_message = $("#contact_message").val().trim();
        // alert(contact_name);

        let name_error = $("#name_error");
        let email_error = $("#email_error");
        let subject_error = $("#subject_error");
        let message_error = $("#message_error");

        let isValid = true;

        // Clear previous errors
        name_error.text("").hide();
        email_error.text("").hide();
        subject_error.text("").hide();
        message_error.text("").hide();
       

        // Validate Name
        if (!/^[A-Za-z\s]+$/.test(contact_name) || contact_name.length < 3) {
            name_error.text("Please enter a valid name").show().delay(3000).fadeOut();
            isValid = false;
        }

        // Validate Email
        if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(contact_email)) {
            email_error.text("Please enter a valid email id").show().delay(3000).fadeOut();
            isValid = false;
        }

         if(contact_subject===""){
            subject_error.text("Please enter subject").show().delay(3000).fadeOut();
            isValid = false;
        }

         if(contact_message===""){
            message_error.text("Please type something").show().delay(3000).fadeOut();
            isValid = false;
        }

        if (isValid) {
            // Clear errors
            name_error.text("").hide();
            email_error.text("").hide();
            subject_error.text("").hide();
            message_error.text("").hide();

            // Clear fields
            $("#contact_name,#contact_email,#contact_subject,#contact_message").val("");
            $("#contact_submit_button").prop("disabled", true);

            // AJAX submit
            $.post("php/send_email.php", {
                register_customer_name: contact_name,
                register_customer_email: contact_email,
                register_contact_subject: contact_subject,
                register_contact_message: contact_message
            }, function(data) {
                console.log(data);
                $("#contact_submit_button").prop("disabled", false);

                $("#response_message")
                    .stop(true, true)
                    .css("color", "green") // set color first
                    .text("Your message has been sent successfully.")
                    .fadeIn(500)
                    .delay(7000)
                    .fadeOut(1000, function() {
                        $(this).text(""); 
                    });

            }).fail(function() {
                $("#contact_submit_button").prop("disabled", false);
                $("#response_message")
                    .stop(true, true)
                    .css("color", "red") // set color first
                    .text("Something went wrong, please try again later.")
                    .fadeIn(500)
                    .delay(7000)
                    .fadeOut(1000, function() {
                        $(this).text(""); 
                    });
            });

        }
    });
});