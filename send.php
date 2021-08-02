<?php
  //form validation
if (empty($_POST["name"])){
  $errMsg = "Error! You didn't enter the Name.";
             echo $errMsg;
} else {
      $vName = $_POST['name'];
}
if (!preg_match ("/^[a-zA-z]*$/", $vName) ) {
    $ErrMsg = "Only alphabets and whitespace are allowed.";
             echo $ErrMsg;
} else {
}

$vTel = $_POST ["tel"];
if (!preg_match ("/^[0-9]*$/", $vTel) ){
    $ErrMsg = "Only numeric value is allowed.";
    echo $ErrMsg;
} else {
    echo $vTel;
}

$vEmail = $_POST ["email"];
$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
if (!preg_match ($pattern, $vEmail) ){
    $ErrMsg = "Email is not valid.";
            echo $ErrMsg;
} else {
    echo "Your valid email address is: " .$vEmail;
}


  $vAddOne = $_POST['addOne'];
  $vTown = $_POST['town'];
  $vPCode = $_POST['pCode'];
  $vLast = $_POST['last'];
  $vTel = $_POST['tel'];
  $vAddTwo = $_POST['addTwo'];
  $vCounty = $_POST['county'];
  $vCountry = $_POST['country'];
  $vDes = $_POST['des'];
  $vFile = $_POST['myfile'];
  $file = $_FILES['myfile'];

  //input the email which you'd like to submit the forms to
  $email_from = 'jamesganley96@gmail.com';

	$email_subject = "New Form submission";


	$email_body = "$vLast,$vName has submitted a form.\n".
                "Name = $vName. \n".
                "Email Address = $vEmail. \n".
                "Address 1 = $vAddOne. \n".
                "Town = $vTown. \n".
                "Postcode = $vPCode. \n".
                "Last name = $vLast. \n".
                "Telephone number = $vTel. \n".
                "Address 2 = $vAddTwo. \n".
                "County = $vCounty. \n".
                "Country = $vCountry. \n".
                "Description = $vDes. \n".
                "myfile = $vFile. \n".

  $to = "jamesganley96@gmail.com";



//my attempt to get the file to send over
  $tmp_name    = $_FILES['my_file']['tmp_name']; // get the temporary file name of the file on the server
  $name        = $_FILES['my_file']['name'];  // get the name of the file
  $size        = $_FILES['my_file']['size'];  // get size of the file for size validation
  $type        = $_FILES['my_file']['type'];  // get type of the file
  $error       = $_FILES['my_file']['error']; // get the error (if any)

  //validate form field for attaching the file
  if($file_error > 0)
  {
      die('Upload error or No files uploaded');
  }

  //read from the uploaded file & base64_encode content
  $handle = fopen($tmp_name, "r");  // set the file handle only for reading the file
  $content = fread($handle, $size); // reading the file
  fclose($handle);                  // close upon completion

  $encoded_content = chunk_split(base64_encode($content));

  $boundary = md5("random"); // define boundary with a md5 hashed value

  //header
  $headers = "MIME-Version: 1.0\r\n"; // Defining the MIME version
  $headers .= "From:".$email_from."\r\n"; // Sender Email
  $headers .= "Reply-To: ".$vEmail."\r\n"; // Email addrress to reach back
  $headers .= "Content-Type: multipart/mixed;"; // Defining Content-Type
  $headers .= "boundary = $boundary\r\n"; //Defining the Boundary

  //plain text
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode($message));

    //attachment
    $body .= "--$boundary\r\n";
    $body .="Content-Type: $type; name=".$name."\r\n";
    $body .="Content-Disposition: attachment; filename=".$name."\r\n";
    $body .="Content-Transfer-Encoding: base64\r\n";
    $body .="X-Attachment-Id: ".rand(1000, 99999)."\r\n\r\n";
    $body .= $encoded_content; // Attaching the encoded file with email
  // $headers = "From: $email_from \r\n";
  //
  // $headers .= "Reply-To: $vEmail \r\n";
// vFilevFileemail_bodyvFilevFileemail_bodyvFilevFilevFilevFilevFileemail_body
   $sentMailResult = mail($to,$email_subject,$email_body,$headers);


  if($sentMailResult )
    {
       echo "File Sent Successfully.";
       header('Location: index.php');
       unlink($name); // delete the file after attachment sent.
    }
    else
    {
       die("Sorry but the email could not be sent. Please go back and try again!");
    }
//Securing Form against email injection
  function IsInjected($str)
  {
      $injections = array('(\n+)',
             '(\r+)',
             '(\t+)',
             '(%0A+)',
             '(%0D+)',
             '(%08+)',
             '(%09+)'
             );

      $inject = join('|', $injections);
      $inject = "/$inject/i";

      if(preg_match($inject,$str))
      {
        return true;
      }
      else
      {
        return false;
      }
  }

  if(IsInjected($vEmail))
  {
      echo "Bad email value!";
      exit;
  }

?>
