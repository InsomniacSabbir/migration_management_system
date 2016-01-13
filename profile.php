<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>

<?php
	$error="";
	if(!logged_in())
	{
		redirect_to("index.php");
	}
	else
	{
		
		$u_id=$_SESSION['user_id'];
		$sql="SELECT * FROM student WHERE u_id='{$u_id}'";
		$result=mysql_query($sql,$connection);
		$row=mysql_fetch_array($result);

		$name=$row['name'];
		$fname=$row['father'];
		$mname=$row['mother'];
		$hroll=$row['roll_hsc'];
		$sroll=$row['roll_ssc'];
		$aroll=$row['roll_admission'];
		$phone=$row['phone'];
		$unit=$row['unit_id'];
		$sc=$row['subject_choice'];
		$ms=$row['migration_status'];
		$as=$row['admission_status'];
		$mp=$row['merit_position'];
		$marks=$row['marks'];
		$cs=$row['current_subject'];
		$sql="SELECT * FROM unit WHERE unit_id='{$unit}'";
		$result=mysql_query($sql,$connection);
		$row=mysql_fetch_array($result);
		$unit_name = $row['unit_name'];
		if(isset($_POST['ac']))
		{
			$sql="UPDATE student SET admission_status='0' WHERE u_id='{$u_id}'";
			mysql_query($sql,$connection);
		}
		else if(isset($_POST['mc']))
		{
			$sql="UPDATE student SET migration_status='0' WHERE u_id='{$u_id}'";
			mysql_query($sql,$connection);
		}
		if(isset($cs))
		{
			$sql="SELECT * FROM subject WHERE serial='{$cs}'";
			$result=mysql_query($sql,$connection);
			$row=mysql_fetch_array($result);
			$sc_name=$row['subject_name'];
		}
		else if(isset($_POST['password_change']))
		{
			$u_id=$_SESSION['user_id'];
			$sql="SELECT * FROM user WHERE id='{$u_id}'";
			$result=mysql_query($sql,$connection);
			$row=mysql_fetch_array($result);
			$curr_pass=$_POST['curr_pass'];
			$new_pass=$_POST['new_pass'];
			$re_pass=$_POST['re_pass'];
			$pass=$row['user_pass'];
			
			if($pass === $curr_pass)
			{
				if($re_pass === $new_pass)
				{
					$sql="UPDATE user SET user_pass='{$new_pass}' WHERE id='{$u_id}'";
					mysql_query($sql,$connection);
					$_POST=array();
				}
				else
				{
					$error="password not matched";
				}
				
			}
			else
			{
				$error="password not matched";
			}
		}
		?>
		
		<form id="bio-data">
			<table>
				<tr>
					<td><p>Name : </p></td>
					<td><p><?php echo $name ;?></p></td>
				</tr>
				<tr>
					<td><p>Father's Name : </p></td>
					<td><p><?php echo $fname ;?></p></td>
				</tr>
				<tr>
					<td><p>Mother's Name : </p></td>
					<td><p><?php echo $mname ;?></p></td>
				</tr>
				<tr>
					<td><p>Admission Roll : </p></td>
					<td><p><?php echo $aroll ;?></p></td>
				</tr>
				<tr>
					<td><p>HSC Roll : </p></td>
					<td><p><?php echo $hroll ;?></p></td>
				</tr>
				<tr>
					<td><p>SSC Roll : </p></td>
					<td><p><?php echo $sroll ;?></p></td>
				</tr>
				<tr>
					<td><p>Unit : </p></td>
					<td><p><?php echo $unit_name ;?></p></td>
				</tr>
				<tr>
					<td><p>Merit Position : </p></td>
					<td><p><?php echo $mp ;?></p></td>
				</tr>
				<tr>
					<td><p>Marks : </p></td>
					<td><p><?php echo $marks ;?></p></td>
				</tr>
				<tr>
					<td><p>Admission Status : </p></td>
					<td><p><?php if($as)echo "YES";else echo "NO";?>  (admitted ?)</p></td>
				</tr>
				<tr>
					<td ><p>Migration Status : </p></td>
					<td><p><?php if($ms)echo "Enabled" ; else echo "Disabled"; ;?>  (migration enabled ?)</p></td>
				</tr>
				<tr>
					<td><p>Current Subject : </p></td>
					<td><p><?php if(isset($cs))echo $sc_name ; else echo "Not Allocated Yet";?></p></td>
				</tr>
			</table>

		</form>
		<hr>
		
		<form id="pass_change" action="profile.php" method="post">
			<div id="alert"> 
			<?php
				if(!empty($error)) 
					echo $error;
			?>
			</div>
			<table>
				<tr>
					<td><p>Current Password: </p></td>
					<td><input type="password" name="curr_pass" required></td>
				</tr>
				<tr>
					<td><p>New Password: </p></td>
					<td><input type="password" name="new_pass" required></td>
				</tr>
				<tr>
					<td><p>Re-type Password: </p></td>
					<td><input type="password" name="re_pass" required></td>
				</tr>
				<tr>
					<td></td>
					<td><button name="password_change" type="submit" value="1">Change Password</button></td>
				</tr>
			</table>
		</form>
		<hr>
		<?php
		if(!$sc)
		{
			?>
			<form id="sub_choice" >
				<ul id="sortable">
				<?php 
					$sql="SELECT * FROM subject WHERE unit_id='{$unit}'";
					$result=mysql_query($sql,$connection);
					while($row=mysql_fetch_array($result))
					{
						?>
						<li class="ui-state-default" id="<?php echo $row['serial']; ?>"><?php echo $row['subject_name'];?></li>
						<?php
					}
				?>
				</ul>
				<button onclick="sendd()" name="subject_choice" value="1">Submit</button>
			</form>
			
			<?php
		}
		else
		{
			?>
			
			<form id="sub_choice">
			<div id="head">
				Your Preferred Subjects
			</div>
				<?php
				$list="[]";
				$sc = trim($sc,$list);
				$sc = explode(',',$sc);
				for($i=0;$i<sizeof($sc);$i++)
				{
					$sc[$i]=trim($sc[$i],'"');
					//echo $sc[$i]."<br \>";
					$sql="SELECT * FROM subject WHERE serial='{$sc[$i]}'";
					$result=mysql_query($sql,$connection);
					$row=mysql_fetch_array($result);
					$subject_name=$row['subject_name'];
					?>
					<p><?php echo $subject_name;?></p>
					<?php
				}
				?>
			</form>
			
			<?php
		}

		?>
		<hr>
		<form id="btn_form" action="profile.php" method="post">
			<table>
				<tr>
					<td><button type="submit" name="ac" value="1">Cancel Admission</button></td>
					<td><button type="submit" name="mc" value="2">Cancel Migration</button></td>
				</tr>
			</table>
		</form>
		<?php
	}
?>
<script type="text/javascript">
	
	function sendd(){
		var arr=new Array();
		var ul=document.getElementById('sortable').children;
		for(i=0; i < ul.length; i++)
		 {
		    var ids=ul[i].getAttribute('id');
		  	//alert(""+ids);
		  	arr[i]=ids;   
		 }
		 var jsons=JSON.stringify(arr);
		$.post('profile1.php', {"key" : jsons});
	}
</script>
<?php include("includes/footer.php");?>
