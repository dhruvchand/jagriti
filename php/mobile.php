<?php

	function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
    }

    $picName=generateRandomString();

	#$_FILES["file"]["tmp_name"];
	$emailid=$_POST['email']; 
	$description=$_POST['description']; 
	$address=$_POST['address']; 
	$name="";
	$number="";
	$categoryList="";


	$temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);
	$picName.=".".$extension;
    $_FILES["file"]["name"]=$picName;
	if (file_exists("php/upload/" . $_FILES["file"]["name"]))
        {
        echo $_FILES["file"]["name"] . " already exists. ";
        }
    else
        {
        echo "Entered else\n";
        move_uploaded_file($_FILES["file"]["tmp_name"],
        "php/upload/" . $_FILES["file"]["name"]);
        echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
        }

    echo "checking require swift library";
  	require_once '../lib/swift_required.php';
  	echo "got swift library";
  
 
    #$name = $_POST['name'];
    #$number = $_POST['number'];
    #$category = $_POST['category'];
    #$n=count($category);

    #$categoryList="";
    #for ($i=0; $i < $n; $i++)
    #{ 
     # $categoryList .= $category[$i]."\n";
    #}

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
  	$picName='php/upload/'.$picName;
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

          header("Location: http://projectjagriti.org/index.html"); /* Redirect browser */
					exit();
					#echo "1";
    	}
    catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        header("Location: http://projectjagriti.org/failure.html");
        exit();
    		#echo "Form submission failed. Please try again.";
        
    }
?>