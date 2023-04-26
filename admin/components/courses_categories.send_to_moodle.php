<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<pre>
<?php
$db->query("select * from courses_categories where id='".$course_category_id."'");
$res=$db->result();
$row=$res[0];

$id=$row['id'];
$title=$row['title'];
$parent_id=$row['parent_id'];


$new_category = array('categories' => array(array(
	 'name' => $title          
	,'parent' => $parent_id               
	,'idnumber' => $id           
)));

print_r($new_category);
$return = $MoodleRest->request('core_course_create_categories', $new_category, MoodleRest::METHOD_POST);
print_r($return);
$moodle_category_id=$return[0]['id'];
$db->query("update courses_categories set moodle_category_id='".$moodle_category_id."' where id='".$course_category_id."'");
?>