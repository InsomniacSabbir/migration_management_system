<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>

<?php
	if(!isset($_SESSION['admin_id']))
	{
		redirect_to('admin.php');
	}
	if(isset($_POST['add_subject']))
	{

		$len = $_POST['add_subject'];
		//echo $len;
		$subject_name = $_POST['subject_name'];
		$unit_id = $_POST['unit_select'];
		//echo $unit_id;
		$capacity =  $_POST['subject_capacity'];
		//echo $capacity;
		$sql="INSERT INTO subject (subject_name,unit_id,capacity,allocated) VALUES('{$subject_name}','{$unit_id}','{$capacity}',0)";
		mysql_query($sql,$connection);
		for($i=1;$i<=$len;$i++)
		{
			if(isset($_POST['subject_name'.$i]))
			{
				//echo "OKAY";
				$subject_name = $_POST['subject_name'.$i];
				$unit_id = $_POST['unit_select'.$i];
				$capacity = $_POST['subject_capacity'.$i];
				//echo $subject_name." ".$unit_id." ".$capacity;
				$sql="INSERT INTO subject (subject_name,unit_id,capacity,allocated) VALUES('{$subject_name}','{$unit_id}','{$capacity}',0)";
				mysql_query($sql,$connection);
			}
			//echo "Not Okay";
		}
		//$_POST = array();
	}
?>


<div class="metabox">
	<form id="sub_form" action="add_subject.php" method="post">
		<table id="sub_table">
			<tr>
				<td><input placeholder="Subject Name" type="text" name="subject_name" maxlength="30"/></td>
				<td><input placeholder="Capacity" type="number_format(number)" name="subject_capacity" /></td>
				<td><select name="unit_select">
			    <option value="1">KA</option>
			    <option value="2">KHA</option>
			    <option value="3">GA</option>
			    <option value="4">GHA</option>
		</select></td>
			<td><button value="1" id="submit_btn" type="submit" name="add_subject">Add Subject</button></td>
			</tr>	
		</table>
	</form>
	<button id="add" onclick="add()">+</button>
</div>		  
<script type="text/javascript">
function add(){
	var table = document.getElementById("sub_table");
	var sub_name = document.createElement("input");
	var sub_capacity = document.createElement("input");
	var sub_unit = document.createElement("select");
	var ka = document.createElement("option");
	var kha = document.createElement("option");
	var ga = document.createElement("option");
	var gha = document.createElement("option");
	var submit_btn = document.getElementById("submit_btn");
	var tr=document.createElement("tr");
	var td1=document.createElement("td");
	var td2=document.createElement("td");
	var td3=document.createElement("td");
	var td4=document.createElement("td");
	submit_btn.parentNode.removeChild(submit_btn);
	//created new childs
	
	sub_name.placeholder = "Subject Name";
	sub_name.type="text";
	sub_name.name="subject_name"+counter;
	sub_name.maxlength=30;

	sub_capacity.placeholder = "Capacity";
	sub_capacity.type="number_format(number)";
	sub_capacity.name="subject_capacity"+counter;
	sub_capacity.maxlength=30;

	sub_unit.name="unit_select"+counter;
	
	ka.value="1";
	kha.value="2";
	ga.value="3";
	gha.value="4";

	ka.text="KA";
	kha.text="KHA";
	ga.text="GA";
	gha.text="GHA";
	
	td1.appendChild(sub_name);
	td2.appendChild(sub_capacity);
	sub_unit.appendChild(ka);
	sub_unit.appendChild(kha);
	sub_unit.appendChild(ga);
	sub_unit.appendChild(gha);
	td3.appendChild(sub_unit);
	submit_btn.value=counter;
	td4.appendChild(submit_btn);

	tr.appendChild(td1);
	tr.appendChild(td2);
	tr.appendChild(td3);
	tr.appendChild(td4);
	
	table.appendChild(tr);

	
	counter++;
}; 

function process(){
	console.log("Hi");
};
var counter=1;
</script>
<?php include("includes/footer.php");?>
