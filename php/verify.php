<?php
  require_once('recaptchalib.php');
  $privatekey = "6Le3F-8SAAAAAMVsukqZkG2d4_JSDy47lEJ1EmXP";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
  }
  else
  {
    // Your code here to handle a successful verification
    $address=$_POST['address'];
    $emailid=$_POST['email'];
    $description=$_POST['description'];

    $to="jagritiproject@gmail.com";
    $subject = "Complaint Submission";
    $body="Complaint received from $emailid .\nThe address of the location is:\n$address.\nDescription is:\n$description\n";

    mail($to, $subject, $body);
  }
  ?>