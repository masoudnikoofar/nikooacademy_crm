<script>
function confirm_delete(id,href)
{
    var is_confirm=confirm ("delete?");
    if (is_confirm)
    {
        this.location.href=href;     
    }
}
</script>
<?php
function price_english($number)
{
	$number=(float)($number);
	return number_format($number, 0, '.', ',');
}
function price_persian($number)
{
	$text=number_format($number, 0, '.', ',');
	$persian_digits = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
	$english_digits = array('0','1','2','3','4','5','6','7','8','9');
	$text = str_replace($english_digits, $persian_digits, $text);

	return $text;
}
function number_persian($text)
{
	$persian_digits = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
	$english_digits = array('0','1','2','3','4','5','6','7','8','9');
	$text = str_replace($english_digits, $persian_digits, $text);

	return $text;
}
function date_persian($text)
{
	$persian_digits = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','/');
	$english_digits = array('0','1','2','3','4','5','6','7','8','9','-');
	$text = str_replace($english_digits, $persian_digits, $text);

	return $text;
}
function access_check()
{  
	global $company_name_en;
  
    if ($_SESSION['admin.'.$company_name_en.'_user_level']!="4" && $_SESSION['admin.'.$company_name_en.'_user_level']!="1")
    {
        alert("دسترسی به این قسمت امکان پذیر نمی باشد");
        die;
    }
}
function popup_close()
{
	?>
	<script>
	window.self.close();
	</script>
	<?php
}

function timetable_popup($arguments)//$pid,$width=320,$height=220,$parent_redirect="")
{
	$pid=$arguments['pid'];
    ?> 
    <script>
        var window_child = window.open('timetable.php?pid=<?php echo $pid; ?>','All','channelmode=yes,fullscreen=yes,status=0,toolbar=0,menubar=0,resizable=0');
        window_child.moveTo(300,300);
    </script>
    <?php
}


function popup($arguments)//$pid,$width=320,$height=220,$parent_redirect="")
{
	//$var_is_greater_than_two = ($var > 2 ? true : false); // returns true
	$pid=$arguments['pid'];
	$width=(isset($arguments['width'])?$arguments['width']:320);
	$height=(isset($arguments['height'])?$arguments['height']:220);

	$parent_redirect=$arguments['parent_redirect'];
	$parent_redirect_url=$arguments['parent_redirect_url'];
	//array("pid"=>"","width"=>"","height"=>"",parent_redirect=>"")
    ?> 
    <script>
        var window_child = window.open('popup.php?pid=<?php echo $pid; ?>','All','status=0,toolbar=0,menubar=0,resizable=0,width=<?php echo $width; ?>,height=<?php echo $height; ?>');
        window_child.moveTo(300,300);
		var window_parent=window.self;
		<?php
		if ($parent_redirect==true)
		{
		?>
			/*
			window_parent.location.href= '<?php echo $parent_redirect; ?>';
			window_child.onunload = function(){ window_parent.location.reload(); }
			*/
			window_child.onbeforeunload = function()
			{ 
				window_parent.location.href= '<?php echo $parent_redirect_url; ?>';
			}
		<?php
		}
		?>
    </script>
    <?php
}

function alert($string)
{
    echo "<script>alert('".$string."');</script>";
}
function goback($path)
{
    echo "<script>this.location.href='$path';</script>";    
}
function goback_parent($path)
{
    echo "<script>parent.location.href='$path';</script>";    
}
function calendar($name)
{
    echo "<img src='../scripts/calendar/Images/calendar.jpg' onclick=\"displayDatePicker('$name', this);\">";
}

function backward_button($variables,$start,$limit,$count)
{
    echo "<form method='post'>";
    echo "<input type='hidden' name='start' value='".($start-$limit)."'>";
    foreach ($variables as $row)
    {
        echo "<input type='hidden' name='$row' value='".$_POST[$row]."'>";
    }   
    if ($start>0) 
    {
        echo "<button type='submit'> قبلی </button>";
    }
    echo "</form>";
}
function forward_button($variables,$start,$limit,$count)
{
    echo "<form method='post'>";
    echo "<input type='hidden' name='start' value='".($start+$limit)."'>";
    foreach ($variables as $row)
    {
        echo "<input type='hidden' name='$row' value='".$_POST[$row]."'>";
    }   
    if ($start<($count-$limit)) 
    {
        echo "<button type='submit'> بعدی </button>";
    }
    echo "</form>";
}
?>