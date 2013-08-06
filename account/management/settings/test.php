<html>
<body>

<?php
if (isset($_POST['email']))
//if "email" is filled out, send email
  {
  //send email
  $email = $_POST['email'];
  $tstamp = date("YmdHms");
					$sendemail = 'official.ren@gmail.com'.$tstamp;
					$sendemail = "/mmo.tm/home/reset.php?rid=".sha1($sendemail);//localhost!!!!!
					$subject = "Password Reset" ;
					$message = "Click this link to reset password: ".$sendemail;
					mail($email, $subject,
						$message, "From:" . "no-reply@mmo.tm");
  echo "Thank you for using our mail form";
  }
else
//if "email" is not filled out, display the form
  {
  echo "<form method='post' action='test.php'>
  Send to: <input name='email' type='text'><br>
  Subject: <input name='subject' type='text'><br>
  Message:<br>
  <textarea name='message' rows='15' cols='40'>
  </textarea><br>
  <input type='submit'>
  </form>";
  }
?>

</body>
</html>