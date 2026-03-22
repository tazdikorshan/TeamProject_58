@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script>
  (function () {
    emailjs.init({ publicKey: "EU4C10z7pKbVAnulR" });
  })();
</script>
<style>

        .contact-us {
            display: flex;
            justify-content: space-between;
            padding: 40px;
            gap: 20px;
            font-family: Arial, sans-serif;
        }

        .contact-us,
        .contact-us * {
            box-sizing: border-box;
        }

        .description {
            width: 50%;
        }

        .contactUs-img {
            margin-bottom: 20px;
        }

        h2 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 15px;
            color: rgb(0, 0, 0);
        }

        .description p {
            font-size: 18px;
            margin-bottom: 30px;
            color: rgb(0, 0, 0);
        }

        .contactUs-box {
            width: 50%;
            background: rgb(255, 140, 0);
            padding: 10px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .contact-form label {
            font-size: 14px;
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        .contact-form input {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            font-size: 15px;
            border-radius: 8px;
            border: 1px solid brown;
            outline: none;
        }

        .contact-form textarea {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            font-size: 15px;
            border-radius: 8px;
            border: 3px solid brown;
            outline: none;
        }

        .contact-form button {
            margin-top: 25px;
            padding: 12px 20px;
            width: 100%;
            font-size: 16px;
            background-color: brown;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
</style>

        <div class="contact-us">
            <div class="description">
                <h2>Contact Us</h2>
                <p>
                    <strong>We understand you may have questions you want to ask us,
                        just fill out the form and we'll get back to you!</strong>
                </p>
                <img src="{{ asset('images/furniture & appliances with no room.png') }}" width="500" height="300"
                    class="contactUs-img ">
            </div>
            <section class="contactUs-box">
                <form id="Contact-submission" class="contact-form">

                    <label>Your First Name</label>
                    <input type="text" id="first-name" placeholder="First Name" required>

                    <label>Your Last Name</label>
                    <input type="text" id="last-name" placeholder="Last Name" required>

                    <label>Email</label>
                    <input type="email" id="email" placeholder="Email" required>

                    <label>Confirm Email</label>
                    <input type="email" id="confirm-email" placeholder="Confirm Email" required>

                    <label> Subject</label>
                    <input type="text" id="Subject" placeholder="Subject" required>

                    <label>Your Message</label>
                    <textarea id="Message" rows="5"></textarea>

                    <button type="submit"><strong>Send Message</strong></button>
                </form>
            </section>
        </div>

<script>
    function validateForm() {
        let firstName = document.getElementById("first-name").value;
        let lastName = document.getElementById("last-name").value;
        let email = document.getElementById("email").value;
        let confirmEmail = document.getElementById("confirm-email").value;
        let Subject = document.getElementById("Subject").value;

        if (firstName === "" || lastName === "" || email === "" || confirmEmail === "" || Subject == "") {
            alert("The fields must be filled");
            return false;
        }
        return true;
    }

    document.getElementById("email").onchange = checkEmails;
    document.getElementById("confirm-email").onchange = checkEmails;

    function checkEmails() {
        let email = document.getElementById("email");
        let confirmEmail = document.getElementById("confirm-email");

        if (email.value === confirmEmail.value) {
            confirmEmail.setCustomValidity("");
        } else {
            confirmEmail.setCustomValidity("Emails must match.");
        }
    }
    document.getElementById("Contact-submission").addEventListener("submit", function (event) {
        event.preventDefault();
        if (validateForm()) {
            sendMail();
        }
    });

    function sendMail() {
        let params = {
            first_name: document.getElementById("first-name").value,
            last_name: document.getElementById("last-name").value,
            email: document.getElementById("email").value,
            subject: document.getElementById("Subject").value,
            message: document.getElementById("Message").value
        };

        emailjs.send("service_t15q8pr", "template_0xm9e9r", params)
            .then(function (response) {
                alert("Your message has been successfully sent!");
                document.getElementById("Contact-submission").reset();
            })
            .catch(function (error) {
                alert("Error sending message.");
                console.log(error);
            });
    }
</script>

@endsection
