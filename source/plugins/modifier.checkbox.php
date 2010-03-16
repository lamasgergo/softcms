<?php
function smarty_modifier_checkbox($name,$checked)
{
if ($checked == 1) {
	$checked = "checked";
	$_true = "1";
} else {
	$checked = "";
	$_true = "0";
}
return <<<ZZZ
	 <input type="checkbox" id="checked_$name" $checked onclick="var form1=document.getElementById('checked_$name'); var form2=document.getElementById('$name'); if (form1.checked == 1) {form2.value = '1'; } else { form2.value = '0';}">
	 <input type="hidden" id="$name" name="$name" value="$_true"> 
ZZZ;
}
?>
