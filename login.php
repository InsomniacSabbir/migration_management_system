<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php
include_once("includes/form_functions.php");

// START FORM PROCESSING
if(logged_in())
    {
        redirect_to('index.php');
    }
if (isset($_POST['submit'])) { // Form has been submitted.
    $errors = array();

    // perform validations on the form data
    $required_fields = array('username', 'password');
    $errors = array_merge($errors, check_required_fields($required_fields, $_POST));

    $fields_with_lengths = array('username' => 30, 'password' => 30);
    $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

    $username = trim(mysql_prep($_POST['username']));
    $password = trim(mysql_prep($_POST['password']));

    if ( empty($errors) ) {
        // Check database to see if username and the hashed password exist there.
        $query = "SELECT * ";
        $query .= "FROM user ";
        $query .= "WHERE user_name = '{$username}' ";
        $query .= "AND user_pass = '{$password}'";
        $result_set = mysql_query($query,$connection);
        confirm_query($result_set);
        $unit=$_POST['unit_select'];
        while($found_user=mysql_fetch_array($result_set))
        {
            $u_id=$found_user['id'];
            $sql="SELECT * FROM student WHERE u_id='{$u_id}'";
            $result=mysql_query($sql,$connection);
            $row=mysql_fetch_array($result);
            $temp_unit=$row['unit_id'];
            if($unit===$temp_unit)
            {
                //echo "yes ".$temp_unit." ".$unit;
                $_SESSION['user_id'] = $found_user['id'];
                $_SESSION['username'] = $found_user['user_name'];
                $_SESSION['unit_id']=$_POST['unit_select'];
                redirect_to("index.php");
            }
            else
            {
                //echo $temp_unit;
            }
        }
        $message = "admission roll , password , unit combination incorrect.";
    } 
    else {
        if (count($errors) == 1) {
            $message = "There was 1 error in the form.";
        } else {
            $message = "There were " . count($errors) . " errors in the form.";
        }
    }

}

?>
<?php include("includes/header.php"); ?>

  <div class="form">
  <div id="alert">
        <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
        <?php if (!empty($errors)) { display_errors($errors); } ?>
    </div>
    <form id="login_form" action="login.php" method="post">
        <table>
            <tr>
                <td><input required placeholder="Roll Number" type="text" name="username" maxlength="30" /></td>
            </tr>
            <tr>
                <td><input required placeholder="Password" type="password" name="password" maxlength="30" /></td>
            </tr>
            <tr>
                <td>
                    <select required name="unit_select">
                        <option value="1">KA</option>
                        <option value="2">KHA</option>
                        <option value="3">GA</option>
                        <option value="4">GHA</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><button type="submit" name="submit">Log In</button></td>
            </tr>
        </table>
    </form>
  </div>
<?php include("includes/footer.php");?>
