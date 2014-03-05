<!-- reCAPTCHA and mailer stuff -->
<?php
  require_once('recaptchalib.php');
  $privatekey = "6Leuiu8SAAAAANMOTv3wEggrv7WMgP38or2tnKLl";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
  }
  else //Code for the file upload
  {
    // Your code here to handle a successful verification
    #Must prevent injection or malware here.

    function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
    }

    $picName=generateRandomString();

    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
    if ((($_FILES["file"]["type"] == "image/gif")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/jpg")
    || ($_FILES["file"]["type"] == "image/pjpeg")
    || ($_FILES["file"]["type"] == "image/x-png")
    || ($_FILES["file"]["type"] == "image/png"))
    && ($_FILES["file"]["size"] < 7000000)
    && in_array($extension, $allowedExts))
    {
      if ($_FILES["file"]["error"] > 0)
        {
        echo "Error: " . $_FILES["file"]["error"] . "<br>";
        }
      else
        {
        $picName.=".".$extension;
        $_FILES["file"]["name"]=$picName;

        echo "Upload: " . $_FILES["file"]["name"] . "<br>";
        echo "Type: " . $_FILES["file"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
        echo "Stored in: " . $_FILES["file"]["tmp_name"];
         if (file_exists("upload/" . $_FILES["file"]["name"]))
        {
        echo $_FILES["file"]["name"] . " already exists. ";
        }
      else
        {
        echo "Entered else\n";
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


    #mailer code!
    echo "checking require swift library";
  	require_once '../lib/swift_required.php';
  	echo "got swift library";
  
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

    $username = "jagriti";
    $password = "projectasha";
    $body="Complaint received from $emailid .\nThe address of the location is:\n$address.\nThe categories under which complaints has been received is:\n$categoryList\nDescription is:\n$description\n";

    #Temporary mailing code, until we get a new server :P
    $to="jagritiproject@gmail.com";
    $subject = "Complaint Submission";
    #$body="Complaint received from $emailid .\nThe address of the location is:\n$address.\nThe categories under which complaints has been received is:\n$categoryList\nDescription is:\n$description\n";

    #mail($to, $subject, $body);


  	
  	$message=Swift_Message::newInstance();
  	$message->setSubject('Complaint Submission');
  	$message->setBody($body);

    #Change this to location of latest uploaded pic
  	$picName='upload/'.$picName;
    try
    {
    $attachment = Swift_Attachment::fromPath($picName, $_FILES["file"]["type"]);
  	$message->attach($attachment);
      
  	$message->setFrom($emailid);

    #change to her email id
  	$message->setTo('jagritiproject@gmail.com');
    echo "Something before smtp\n";
    #this will work on proper server :P

    #change this to swift mail transport
    echo "random echo\n";
    $transport = Swift_MailTransport::newInstance();
    echo "not 1\n";
    $mailer = Swift_Mailer::newInstance($transport);
    echo "not 2\n";
    $result=$mailer->send($message);
    echo "not 3\n";
    }
    catch(Swift_IoException $e)
    {
        echo "no file attached\n";
        mail($to, $subject, $body);
    }
  	

    echo "mail sent\n";
    #Mailer without attachment
    #Testing Attachment. Might result in delayed mail!
    
?>
<!--Database Stuff-->
<?php    
    #storing in database
    try {
          echo "before mysql\n";
          $conn = new PDO('mysql:host=localhost;dbname=jagriti', $username, $password);
          echo "after mysql\n";
         # $conn = new PDO('mysql:host=localhost:3036;dbname=jtest', $username, $password);
          echo "something\n";
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "something after set attribute\n";
          # Prepare Query

          #Add picture stuff also here!
          echo "inserting into table\n";
          $stmt = $conn->prepare('INSERT INTO CONTENTS VALUES(:address, :email, :description, :name, :num, :categories, :picture)');
          $stmt->execute(array(
              ':name' => $name,
              ':num' => $number,
              ':description' => $description,
              ':email' => $emailid,
              ':address' => $address,
              ':categories' => $categoryList,
              ':picture' => $picName,
              #':file'
            ));
          echo "before exit\n";
          #link to successful submission page
          header("Location: http://projectjagriti.org/success.html"); /* Redirect browser */
					exit();
					#echo "1";
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        header("Location: http://projectjagriti.org/failure.html");
        exit();
    		#echo "Form submission failed. Please try again.";
        
    }
  }
  ?>
