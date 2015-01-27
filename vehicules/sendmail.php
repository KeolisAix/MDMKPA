<?
//This php file receives the post vars of the contact page and sends it to a email address

//Settings
$email = 'yourmail@mail.be';
$subject = '[NAME] has send you a mail';

//Get post variables
$name = $_POST['name'];
$from = $_POST['email'];
$message = $_POST['message'];

//Set the headers and send the mail
$subject = str_replace('[NAME]', $name, $subject);
$headers = 'From: '.$name.' <'.$from.'>';
mail($email, $subject, $message, $headers);
?>