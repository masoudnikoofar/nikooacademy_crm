<?php

if (isset($_GET['pid']))
{
    $pid=$db->mysql_real_escape_string($_GET['pid']);
    include("components/".$pid.".admin.php");
}
else
{
    include("home.php");
}
?>
