<table border="0" cellpadding="0" cellspacing="0" class="contentTable">
<tr>
	<td class="title">
		<h2>{$item_arr[0].Title}</h2>
		<br/>
	</td>
</tr>
<tr>
    <td>
		{if $item_arr[0].LoginRequired==1 && !$isAuth}
			<b>{"You have no right to see this content"|lang}</b>
		{else}
			{$item_arr[0].Full_Text}
		{/if}
	</td>
</tr>
</table>

{literal}
<script language="javascript">
function ch_m(a_1,a_2,a_3,a_4)
{
if(document.getElementById(a_1).value==""||document.getElementById(a_2).value==""||document.getElementById(a_3).value==""||document.getElementById(a_4).value=="")
 {
 alert('{"All fields must be filled"|lang}');
 return true;
 }
else
 {
 return false;
 }
}
</script>
{/literal}

<form method="post" action="">
<br/>
<br/>

<table>
<tr>
	<td>{"Your name"|lang}: </td>
	<td><input type="text" name="req_name" id="req_name" class="text" style="background: rgb(244, 244, 244) none repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"/><input type="text" value="" name="sname" size="20" maxlength="40" style="display: none;" id="_1"/><br/><br/></td>
</tr>

<tr>
	<td>{"Your eMail"|lang}: </td>
	<td><input type="text" name="req_email" id="req_email" class="text" style="background: rgb(244, 244, 244) none repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"/><br/><br/></td>
</tr>

<tr>
	<td>{"Your phone"|lang}: </td>
	<td><input type="text" name="req_phone" id="req_phone" class="text" style="background: rgb(244, 244, 244) none repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;"/><br/><br/></td>
</tr>

<tr>
	<td>{"Message"|lang}: </td>
	<td><textarea name="req_message" id="req_message" class="text" style="width: 80%; height: 100px;"></textarea></td>
</tr>

<tr>
	<td> </td>
	<td><br/>
	<input type="hidden" name="send_request" value="1">
	<input type="submit" onclick="if(ch_m('req_name','req_email','req_phone','req_message'))return false;" value="{"Send"|lang}" name="send" class="button"/></td>
</tr>
</table>
</form>

{mod_stat title="stat_content" link=$smarty.server.REQUEST_URI description=$item_arr[0].Title}