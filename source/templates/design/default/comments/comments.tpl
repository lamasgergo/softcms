{literal}
<script language="Javascript">
function validate_form(){

	var form = document.comment;
	
	if (form.captcha.value.length < 1) {
        alert('{/literal}{"Captcha incorrect"|lang}{literal}');
        form.captcha.focus();
        return false;
    }
    if (form.captcha.value.length != 4) {
        alert('{/literal}{"Captcha incorrect"|lang}{literal}');
        form.captcha.focus();
        return false;
    }
    
    if (document.getElementById('sid').value != document.getElementById('captcha').value) {
        alert('{/literal}{"Captcha incorrect"|lang}{literal}');
        form.captcha.focus();
        return false;
    }

    if (form.comment_text.value.length == 0) {
    	alert('{/literal}{"Please input text of the comment"|lang}{literal}');
        form.captcha.focus();
        return false;
    }
    
    document.comment.submit();	
  	return true;
}
</script>
{/literal}


<form method="post" name="comment">
<table border="0" cellpadding="5" cellspacing="0" class="commentsForm">
<tr>
	<th colspan="2">{"Add comment"|lang}</th>
</tr>
<tr>
	<td>{"Comment Text"|lang}</td>
	<td>
		<textarea name="comment_text" rows="6" cols="45"></textarea>
	</td>
</tr>
<tr>
	<td>
		<script language="JavaScript" type="text/javascript">
			{literal}
            var rndseed = new String(Math.random()); rndseed = rndseed.substring(2,11);
            var hex = "0123456789abcdef";
            var captchaSID = '';
            for (var i = 0 ; i < 32; i++) {
                var pos = Math.floor(Math.random() * 16);
                captchaSID += hex.substr(pos, 1);
            }
			captchaSID = captchaSID.substr(5,4);
            document.write ('<img src="/modules/captcha/captcha.php?sid=' + captchaSID + '" />');
			document.write ('<input type="hidden" id="sid" name="sid" value="' + captchaSID + '" />');
			{/literal}
        </script>
	</td>
	<td><input type="text" class="txt" id="captcha" name="captcha" size="4" value="" maxlength="4"></td>
</tr>
<tr>
	<td colspan="2" align="right">
		<input type="hidden" name="item_id" value="{$smarty.get.iid}" />
		<input type="hidden" name="add_comment" value="true" />
		<input type="button" name="add_button" onClick="validate_form(this); return false;" value="{"Add comment"|lang}" class="submit" />
	</td>
</tr>
</table>
</form>

<table class="commentsList">
<tr>
	<th>{"Comments"|lang}:</th>
</tr>
{foreach from=$comments_arr item=comment name=comments}
<tr>
	<td>
		<table class="commentItem">
		<tr class="header">
			<td class="left">
				{$comment.UserID|getUserLogin}
			</td>
			<td class="right">
				{$comment.Created|date_format:"%d-%m-%Y %H:%M:%S"}
			</td>
		</tr>
		<tr>
			<td colspan="2">
				{$comment.Comment}
			</td>
		</tr>
		</table>
	</td>
</tr>
{/foreach}
</table>

<center>
	{$comments_navigation}
</center>