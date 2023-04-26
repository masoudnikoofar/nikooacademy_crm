<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
if ($_POST['step']=="2")
{
    $students_count=$db->mysql_real_escape_string($_POST['students_count']);
    
    for ($i=0;$i<$students_count;$i++)
    {
        $student_id=$db->mysql_real_escape_string($_POST['student_id_'.$i]);
        $discount_rate=$db->mysql_real_escape_string($_POST['discount_rate_'.$i]);
        
        $db->query("insert into courses_students set
			course_id='".$course_id."',
			student_id='".$student_id."',
			discount_rate='".$discount_rate."'
        ");            
    }
                  
    alert("با موفقیت ثبت شد");
}
?>

<hr/>
<table class="tables" width="100%">
	<tr>
		<td width="10%">
			<input type="text" id="student_fullname_temp">
			<input type="hidden" id="student_id_temp">
			<img src="../images/buttons/add.png" id="add_student">
		</td>
		<td>
			<form method="post">
				<input type="hidden" name="step" value="2">
				<input type="hidden" name="students_count" id="students_count" value="">
				<table class="tableslistr" border="1" width="100%" id="students_table">
					<tr class="tablesheader">
						<td>ردیف</td>
						<td>نام و نام خانوادگی</td>
						<td>درصد تخفیف</td>
					</tr>
				</table>
				<button type="submit"> اضافه</button> توجه: حتما پس از اضافه کردن لیست دانشجویان، کلید اضافه را فشار دهید.
			</form>
		</td>
	</tr>
</table>

<script>
var students = 
[
<?php
$db->query("select * from students");
$res=$db->result();
foreach ($res as $row)
{
    echo "[\"".$row['firstname']." ".$row['lastname']."\",".$row['id']."],";
}
?>
["",0]
];

autocomplete(document.getElementById("student_fullname_temp"),document.getElementById("student_id_temp"), students);
var i = 0;
$("#add_student").click(function(){
	/*
	$("#students_list").append("<tr>");
	$("#students_list").append("<input type='hidden' name='student_id_" + i + "' value='" + $("#student_id_temp").val() + "'>");
	$("#students_list").append("<td>" + (i+1) + "</td>");
	$("#students_list").append("<td>" + $("#student_fullname_temp").val() + "</td>");
	$("#students_list").append("<td>" + "<input type='text' name='discount_rate_" + i + "' value='0'>%" + "</td>");
	$("#students_list").append("</tr>");
	*/
	var str = "";
	str += "<tr>"
	str += "<input type='hidden' name='student_id_" + i + "' value='" + $("#student_id_temp").val() + "'>";
	str += "<td>" + (i+1) + "</td>";
	str += "<td>" + $("#student_fullname_temp").val() + "</td>";
	str += "<td>" + "<input type='text' name='discount_rate_" + i + "' value='0'>%" + "</td>";
	str += "</tr>";
	$('#students_table tr:last').after(str);

	i++;
	$("#students_count").val(i);
});
</script>