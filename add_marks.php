<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>

<?php
	if(isset($_POST['submit_unit']))
	{
		$counter=0;
		$unit=$_POST['unit'];
		$sql="SELECT * FROM student WHERE unit_id='{$unit}'";
		$result=mysql_query($sql,$connection);
			?>
			<form id="add_marks_form" action="add_marks.php" method="post">
				<table>
			<?php
			while($row=mysql_fetch_array($result))
			{
				$counter++;
				?>
				<tr>
					<td><p><?php echo $row['roll_admission']." : ";?></p></td>
					<td><input placeholder="marks" type="number_format(number)" name=<?php echo $row['roll_admission'];?> maxlength="30"/></td>
				</tr>
				
				<?php
			}
			?>
				<tr>
					<td></td>
					<td><button name="submit_marks" type="submit">Submit</button></td>
				</tr>
				</table>
			</form>
			<?php
			$_POST=array();
			if($counter==0)
			{
				redirect_to("add_marks.php");
			}
	}		
	else if(isset($_POST['submit_marks']))
	{

		$sql="SELECT * FROM student";
		$result=mysql_query($sql,$connection);
		
		while($row=mysql_fetch_array($result))
		{
			if(isset($_POST[$row['roll_admission']]))
			{
				$sql = "UPDATE student SET marks = '{$_POST[$row['roll_admission']]}' WHERE roll_admission='{$row['roll_admission']}'";
				mysql_query($sql,$connection);
			}
		}
		$_POST=array();
		redirect_to("add_marks.php");
	} 
	else
	{
		?>
		<form id="select_unit_form" action="add_marks.php" method="post">
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
					<td><input name="submit_unit" type="submit" value="Select Unit"></td>
				</tr>
			</table>
		</form>
		<?php
	}
?>

<?php include("includes/footer.php");?>
