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
  } else {
    // Your code here to handle a successful verification

    $address=$_POST['address'];
    $emailid=$_POST['email'];
    $description=$_POST['description'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $category = $_POST['category'];
    $n=count($category);

    $categoryList="";
    for ($i=0; $i < $n; $i++) { 
      $categoryList .= $category[$i]."\n";
    }

    $username = "a2414660_jagriti";
    $password = "projasha1234";

    #Mailer without attachment
    $to="jagritiproject@gmail.com";
    $subject = "Complaint Submission";
    $body="Complaint received from $emailid .\nThe address of the location is:\n$address.\nThe categories under which complaints has been received is:\n$categoryList.\nDescription is:\n$description\n";

    mail($to, $subject, $body);


    #storing in database
    try {
          $conn = new PDO('mysql:host=mysql3.000webhost.com;dbname=a2414660_maindb', $username, $password);
         # $conn = new PDO('mysql:host=localhost:3036;dbname=jtest', $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          # Prepare Query
          $stmt = $conn->prepare('INSERT INTO USERS VALUES(:address, :email, :description, :name, :num, :categories)');
          $stmt->execute(array(
              ':name' => $name,
              ':num' => $number,
              ':description' => $description,
              ':email' => $emailid,
              ':address' => $address,
              ':categories' => $categoryList,
              #':file'
            ));
          echo $stmt->rowCount();
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
  }
  ?>
