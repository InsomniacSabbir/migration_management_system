<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>

<?php
	if(!logged_in())
	{
		redirect_to("index.php");
	}
	$flag=0;
	$mr=1;
	$unit=$_POST['unit'];
	$sql="SELECT * FROM student WHERE unit_id='{$unit}' ORDER BY merit_position ASC";
	$result=mysql_query($sql,$connection);
	$row=mysql_fetch_array($result);
	if($row['merit_position']==1)
	{
		$mr=0;
	}
	if(isset($_POST['merit']) && $mr==1)
	{
		$unit=$_POST['unit'];
		$sql="SELECT * FROM student WHERE unit_id='{$unit}' ORDER BY marks DESC";
		$result=mysql_query($sql,$connection);
		$pos=1;
		while($row=mysql_fetch_array($result))
		{
			$u_id=$row['u_id'];
			$query="UPDATE student SET merit_position='{$pos}' WHERE u_id='{$u_id}'";
			mysql_query($query,$connection);
			$sc=$row['subject_choice'];
			$list="[]";
			$sc = trim($sc,$list);
			$sc = explode(',',$sc);
			for($i=0;$i<sizeof($sc);$i++)
			{
				$sc[$i]=trim($sc[$i],'"');
				//echo $sc[$i]."<br \>";
				$sql="SELECT * FROM subject WHERE serial='{$sc[$i]}'";
				$subject_result=mysql_query($sql,$connection);
				$subject_row=mysql_fetch_array($subject_result);
				$subject_name=$subject_row['subject_name'];
				$capacity=$subject_row['capacity'];
				$allocated=$subject_row['allocated'];
				if($allocated <$capacity)
				{
					$allocated++;
					$sql="UPDATE subject SET allocated='{$allocated}' WHERE serial='{$sc[$i]}'";
					mysql_query($sql,$connection);
					$sql="UPDATE student SET current_subject='{$sc[$i]}' WHERE u_id='{$u_id}'";
					mysql_query($sql,$connection);
					$i+=sizeof($sc);
					$flag=1;
				}
			}
			$pos++;
			if($flag==0){
				$query="UPDATE student SET current_subject='0' WHERE u_id='{$u_id}'";
				mysql_query($query,$connection);
			}
		}
		?>
		<form id="merit_show">
		<table>
		<tr>
			<td><p style="border:1px solid white;">Admission Roll</p></td>
			<td><p  style="border:1px solid white;">Name</p></td>
			<td><p style="border:1px solid white;">Marks</p></td>
			<td><p style="border:1px solid white;">Merit Position</p></td>
		</tr>
		<?php
			$sql="SELECT * FROM student WHERE unit_id='{$unit}' ORDER BY merit_position ASC";
			$result=mysql_query($sql,$connection);
			while($row=mysql_fetch_array($result))
			{
				$admission_status=$row['admission_status'];
				$migration_status=$row['migration_status'];
				if($admission_status==1 && $migration_status==1)
				{
					?>
					<tr>
						<td><p><?php echo $row['roll_admission'];?></p></td>
						<td><p><?php echo $row['name'];?></p></td>
						<td><p><?php echo $row['marks'];?></p></td>
						<td><p><?php echo $row['merit_position'];?></p></td>
					</tr>
					<?php
				}
			}
		?>
		</table>
		</form>
		<hr>
		<?php
		$mr=0;
	}
	elseif(isset($_POST['update']))
	{
		$unit=$_POST['unit'];
		$sql="SELECT * FROM student WHERE unit_id='{$unit}'";
		$result=mysql_query($sql,$connection);
		while($row=mysql_fetch_array($result))
		{
			$u_id=$row['u_id'];
			$id=$row['serial'];
			$as=$row['admission_status'];
			$cs=$row['current_subject'];
			if($as<=0)
			{
				if($cs>0)
				{
					$sql="SELECT * FROM subject WHERE serial='{$cs}'";
					$rr=mysql_query($sql,$connection);
					$rw=mysql_fetch_array($rr);
					$rw['allocated']--;
					$sql="UPDATE subject SET allocated='{$rw['allocated']}' WHERE serial='{$cs}'";
					mysql_query($sql,$connection);
				}

				$sql="DELETE FROM student WHERE serial='{$id}'";
				mysql_query($sql,$connection);

				$sql="DELETE FROM user WHERE id='{$u_id}'";
				mysql_query($sql,$connection);
			}
		}
		//echo "2";
		//redirect_to("admin_panel.php");
	}
	elseif(isset($_POST['migration']))
	{
		$unit=$_POST['unit'];
		$sql="SELECT * FROM student WHERE unit_id='{$unit}' ORDER BY merit_position ASC";
		$result=mysql_query($sql,$connection);
		//$pos=1;
		while($row=mysql_fetch_array($result))
		{
			$u_id=$row['u_id'];
			$cs=$row['current_subject'];
			//$query="UPDATE student SET merit_position='{$pos}' WHERE u_id='{$u_id}'";
			//mysql_query($query,$connection);
			if($row['migration_status']==1)
			{
				$sc=$row['subject_choice'];
				$list="[]";
				$sc = trim($sc,$list);
				$sc = explode(',',$sc);
				if($cs>0)
				{
					$sql="SELECT * FROM subject WHERE serial='{$cs}'";
					$rr=mysql_query($sql,$connection);
					$rw=mysql_fetch_array($rr);
					$rw['allocated']--;
					$sql="UPDATE subject SET allocated='{$rw['allocated']}' WHERE serial='{$cs}'";
					mysql_query($sql,$connection);
				}
				for($i=0;$i<sizeof($sc);$i++)
				{
					$sc[$i]=trim($sc[$i],'"');
					//echo $sc[$i]."<br \>";
					$sql="SELECT * FROM subject WHERE serial='{$sc[$i]}'";
					$subject_result=mysql_query($sql,$connection);
					$subject_row=mysql_fetch_array($subject_result);
					$subject_name=$subject_row['subject_name'];
					$capacity=$subject_row['capacity'];
					$allocated=$subject_row['allocated'];
					if($allocated <$capacity)
					{
						$allocated++;
						$sql="UPDATE subject SET allocated='{$allocated}' WHERE serial='{$sc[$i]}'";
						mysql_query($sql,$connection);
						$sql="UPDATE student SET current_subject='{$sc[$i]}' WHERE u_id='{$u_id}'";
						mysql_query($sql,$connection);
						$i+=sizeof($sc);
						$flag=1;
					}
				}
				$pos++;
				if($flag==0){
					$query="UPDATE student SET current_subject='0' WHERE u_id='{$u_id}'";
					mysql_query($query,$connection);
				}
			}
		}
		//echo "3";
		//redirect_to("admin_panel.php");
	}
?>

<form id="trigger_form" action="trigger.php" method="post">
	<table>
		<tr>
			<td>
				<select name="unit">
					<option value="1">KA</option>
					<option value="2">KHA</option>
					<option value="3">GA</option>
					<option value="4">GHA</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><button type="submit" name="merit" value="">Merit List Process</button></td>
		</tr>
		<tr>
			<td><button type="submit" name="update" value="">Update</button></td>
		</tr>
		<tr>
			<td><button type="submit" name="migration" value="">Migration</button></td>
		</tr>	
	</table>

</form>

<?php include("includes/footer.php");?>
