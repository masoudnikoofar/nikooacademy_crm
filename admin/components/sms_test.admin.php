<?php if ($_SESSION['admin.'.$company_name_en.'_login']!="1") die; ?>
<?php
/*
$firstname="مریم";
$lastname="نیکوفر";
$sms_text= $firstname." ".$lastname." عزیز به آکادمی هوش مصنوعی نیکو خوش آمدید\n";
sms_send("09122736253",$sms_text);
echo "ok";
*/
?>	



<?php
sms_updatestatus("10090944545");
echo "ok";
?>	