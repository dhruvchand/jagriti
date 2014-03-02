
<!--Mail Attachment code-->

<!-- reCAPTCHA and mailer stuff -->
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
    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
		if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& ($_FILES["file"]["size"] < 20000)
		&& in_array($extension, $allowedExts))
  	{
  		if ($_FILES["file"]["error"] > 0)
    	{
    		echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    	}
  		else
    	{
    		echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    		echo "Type: " . $_FILES["file"]["type"] . "<br>";
    		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    		echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

		    if (file_exists("upload/" . $_FILES["file"]["name"]))
   		  {
      			echo $_FILES["file"]["name"] . " already exists. ";
     		}
    		else
      	{
      			move_uploaded_file($_FILES["file"]["tmp_name"],
      			"upload/" . $_FILES["file"]["name"]);
      			echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      	}
    	}
  	}
		else
  	{
  		echo "Invalid file";
  	}
  	require_once 'lib/swift_required.php';
  	

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
    $body="Complaint received from $emailid .\nThe address of the location is:\n$address.\nThe categories under which complaints has been received is:\n$categoryList\nDescription is:\n$description\n";


    {
    	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
  		->setUsername('jagritiproject@gmail.com')
  		->setPassword('projectasha');
    	$message=Swift_Message::newInstance();
    	$mailer = Swift_Mailer::newInstance($transport);

    	$message->setSubject('Complaint Submission');
    	$message->setBody($body);
    	$attachment = Swift_Attachment::fromPath('/public-html/img/logo.png', 'image/png');
    	$message->attach($attachment);
    	$message->setFrom($emailid);
    	$message->setTo('jagritiproject@gmail.com');
    	$result=$mailer->send($message);
    }
    #Mailer without attachment
    #Testing Attachment. Might result in delayed mail!
    $to="jagritiproject@gmail.com";
    $subject = "Complaint Submission";
    $body="Complaint received from $emailid .\nThe address of the location is:\n$address.\nThe categories under which complaints has been received is:\n$categoryList\nDescription is:\n$description\n";

    mail($to, $subject, $body);
?>
<!--Database Stuff-->
<?php    
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
          #link to successful submission page
          #header("Location: http://jagriti.site90.net/success.html"); /* Redirect browser */
					#exit();
					echo "1";
    } catch(PDOException $e) {
    		echo "Form submission failed. Please try again.";
        echo 'Error: ' . $e->getMessage();
    }
  }
  ?>
