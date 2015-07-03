<?php
require_once 'core/init.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'includes/html/header.html';
$loginmsg = '';
// if we have the input
if (Input::exists()) {
    // see token to prevent cross site
    if (Token::check(Input::get('token'))) {

        // validate to the same standart as we registered the user
        $validate = new Validation();
        // check the post data with a rule of arrays
        $validation = $validate -> check($_POST, array('name' => array('required' => true, 'min' => 2, 'max' => 50)));

        // check if validation passed
        if ($validation -> passed()) {
            try {
                $user = new User();
                if(!$user->find(Input::get('name'))){
                    $loginmsg = '<p> There was a problem retrieving your username. Please contact the <a href="">administrator</a></p>' . '<p>Or you may <a href="http://homepages.uc.edu/group2/getPassword.php">Try Again</a></p>';
                    exit($loginmsg);
                }
                // update the user
                $user -> find(Input::get('name'));

                // send a message
                if($user -> data() -> username == null){
                echo 'no user by that name';

            }
                $name = $user -> data() -> username;

                $pass = $user->data()->password;


                // redirect to index
                $to = "{$name}@mail.uc.edu";

                $subject = "UC Portal";

                $message = <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Notification</title>
</head>

<body bgcolor="#8d8e90">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#8d8e90">
  <tr>
    <td><table width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" align="center">
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="61"><a style="text-decoration: none; color: red;" href= "http://www.ucclermont.edu/" target="_blank"><center>UC Clermont</center></a></td>

                <td width="393"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="46" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
						  <td><h4>Welcome to the UC Clermont IT Student Portal</h4><td>

                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td height="30"><div style="background: black; width:393px; height:5px;"></div></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>


        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10%">&nbsp;</td>
                <td width="80%" align="left" valign="top"><font style="font-family: Georgia, 'Times New Roman', Times, serif; color:#010101; font-size:24px"><strong><em>Hi $name,</em></strong></font><br /><br />
                  <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px"> Welcome, your password is:
<br /><br />
                      $pass
<br /><br />
Thank you for registering with the IT Student Portal. In order to finish your registration process, please copy and paste the password into the password box on the login page.</font><br></td>
                <td width="10%">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="right" valign="top"><table width="108" border="0" cellspacing="0" cellpadding="0">

                  <tr>
                    <td align="center" valign="middle" bgcolor="red"><font style="font-family: Georgia, 'Times New Roman', Times, serif; color:#ffffff; font-size:15px"><strong><a href="http://homepages.uc.edu/group2/index.php" target="_blank" style="color:#ffffff; text-decoration:none"><em>IT login</em></a></strong></font></td>
                  </tr>

                </table></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div style="background: black; height:3px;"></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><font style="font-family:'Myriad Pro', Helvetica, Arial, sans-serif; color:#231f20; font-size:8px"><strong>Uc clermont</strong></font></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
EOF;

// Always set content-type when sending HTML email
                $headers = 'From: <admin@admin.com>' . "\r\n";
                $headers .= "Content-type: text/html\r\n";

                mail($to,$subject,$message,$headers);
                // catch any errors with the database update
            } catch (Exception $e) {
                die($e -> getMessage());

            }

            //Session::flash('home', 'Please Check Your Email For Password');
            $loginmsg = '<h3>Message Sent Please go to email for password. It might take a minute or two</h3>';
//            Redirect::to('index.php');


        } else {
            // print out the validation rules that were broken
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }

    }
}
?>

<h2>Welcome First Year Students</h2>
<p>To get started with the UC Clermont IT Portal, please fill in your 6+2</p>

<form action="" method="post">

    <div class="field">
        <label for="name"> <h3>UserName:</h3> </label>
        <input type="text" name="name" placeholder="6+2">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="submit" value="Get Password">

    </div>
</form>
    <div><?php echo $loginmsg; ?></div>
<a href="index.php" class="btn btn-primary">Back</a>
<?php
include 'includes/html/footer.html';
?>