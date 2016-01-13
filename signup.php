<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>

<?php
	if(logged_in())
	{
		redirect_to('index.php');
	}
	if(isset($_POST['signup']))
	{
		
	    $aroll = $_POST['aroll'];
	    $password = $_POST['password'];
	    $name=$_POST['username'];
	    $fname=$_POST['fname'];
	    $mname=$_POST['mname'];
	    $sroll=$_POST['sroll'];
	    $mobile=$_POST['mobile'];
	    $unit=$_POST['unit'];
	    $hroll=$_POST['hroll'];

	    $sql = "INSERT INTO user (user_name,user_pass) VALUES('{$aroll}','{$password}')";
	    mysql_query($sql,$connection);
	    $sql ="SELECT * FROM user WHERE user_name='{$aroll}'";
	    $result=mysql_query($sql,$connection);
	    $row=mysql_fetch_array($result);
	    $u_id=$row['id'];
	    $sql="INSERT INTO student (u_id,name,father,mother,roll_admission,roll_hsc,roll_ssc,phone,unit_id,admission_status,migration_status) VALUES('{$u_id}','{$name}','{$fname}','{$mname}','{$aroll}','{$hroll}','{$sroll}','{$mobile}','{$unit}',1,1)";
	    mysql_query($sql,$connection);
	    redirect_to("index.php");
	}
	if(logged_in())
	{
		redirect_to("index.php");	
	}
	?>	
	<form id="signup_form" action="signup.php" method="post">
		<table>
			<tr>
				
				<td><input name="username" type="text" placeholder="your name" maxlength="30" required></td>
			</tr>
			<tr>
				
				<td><input name="password" type="password" placeholder="your password" maxlength="16" required></td>
			</tr>
			<tr>
				
				<td><input name="fname" type="text" placeholder="father's name" maxlength="30" required></td>
			</tr>
			<tr>
				
				<td><input name="mname" type="text" placeholder="mother's name" maxlength="30" required></td>
			</tr>
			<tr>
				
				<td><input name="aroll" type="number_format(number)" placeholder="admission roll" required></td>
			</tr>
			<tr>
				
				<td><input name="hroll" type="number_format(number)" placeholder="hsc roll" required></td>
			</tr>
			<tr>
				
				<td><input name="sroll" type="number_format(number)" placeholder="ssc roll" required></td>
			</tr>
			<tr>
				<td><input placeholder="phone number" name="mobile" type="tel" pattern="01[156789]{1}[0-9]{8}" required></td>
			</tr>
			<tr>
				<td>
					<select name="unit" required>
						<option value="1">KA</option>
						<option value="2">KHA</option>
						<option value="3">GA</option>
						<option value="4">GHA</option>
					</select>
				</td>
			</tr>
			<tr>
				
				<td><button name="signup" type="submit" value="1">Sign Up</button></td>
			</tr>
		</table>
		
	</form>
<?php include("includes/footer.php");?>
