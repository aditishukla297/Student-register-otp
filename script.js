document.addEventListener("DOMContentLoaded", function () {

    const sendOtpButton = document.getElementById("sendOtp");
    const status = document.getElementById("otpStatus");

    console.log("JavaScript loaded");
    console.log("Button:", sendOtpButton);
    console.log("Status:", status);

    sendOtpButton.addEventListener("click", function () {

        status.textContent = "✅ BUTTON IS WORKING!";

        console.log("Send OTP button clicked!");

    });

});