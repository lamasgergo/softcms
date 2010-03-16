{if !$has_reg_auth}
{literal}
<script language="JavaScript">
 function check_login_form (form)
 {
	
  if (form.reg_login.value == '') 
  {
    alert ("{/literal}{"Please input login"|lang}{literal}");
    return false;
  }

   if (form.reg_password.value == '')
  {
   alert ('{/literal}{"Please input password"|lang}{literal}');
     return false;
  }
 }
</script>
{/literal}
 <table width="500">

<form onsubmit="return check_login_form(this)" method="post" />

 <input type="hidden" value="login" name="action"/>
 <input type="hidden" value="" name="back_url"/>

 <tbody><tr>
  <td colspan="2"><b>{"Please input login and password"|lang}</b></td>
 </tr>
 <tr>
   <td>{"login_name"|lang}</td>
   <td>
    <input name="reg_login"/>
   </td>
 </tr>
  <tr>
   <td>{"password"|lang}</td>
   <td>
    <input type="password" name="reg_password"/>
   </td>
 </tr>
 <tr>
  <td colspan="2">
	<input type="hidden" name="reg_auth" value="true"/>
    <input type="submit" value="{"login"|lang}"/>
  </td>
 </tr>



</tbody></table>
</form>
{/if}

<br/>
{literal}
<script language="JavaScript">
 function check_form (form)
 {
  if (form.reg_login.value == '') 
  {
    alert ("{/literal}{"Please input login"|lang}{literal}");
    return false;
  }

 if (form.reg_email.value == '') 
  {
    alert ("{/literal}{"Please input email"|lang}{literal}");
    return false;
  }





  if (form.reg_password.value == '')
  {
   alert ('{/literal}{"Please input password"|lang}{literal}');
     return false;
  }

   if (form.reg_password.value != form.reg_password2.value)
   {
     alert ('{/literal}{"Password and Password repeat are not equal"|lang}{literal}');
     return false;
   }
  



  if (form.reg_name.value == '') 
  {
    alert ("{/literal}{"Please input name"|lang}{literal}");
    return false;
  }

  return true;
 }
</script>
{/literal}

<table width="500">

{$error}

<form onsubmit="return check_form(this)" method="post" />

<input type="hidden" value="" name="back_url"/>
 <input type="hidden" value="register" name="action"/>
 <tbody><tr>
  <td colspan="2"><b>
  {if $has_reg_auth}
	{"Edit user data"|lang}
  {else}
	{"Or fill register form"|lang}
  {/if}
  </b></td>
 </tr>


 <tr>
   <td>{"login_name"|lang}</td>
   <td>
    <input value="{$user_data.login}" name="reg_login"/>
   </td>
 </tr>
  <tr>
   <td>E-mail</td>
   <td>
    <input value="{$user_data.email}" name="reg_email"/>
   </td>
 </tr>
   <tr>
   <td>{"password"|lang}</td>
   <td>
    <input type="password" value="" name="reg_password"/>
   </td>
 </tr>
  <tr>
   <td>{"password_repeat"|lang}</td>
   <td>
    <input type="password" value="" name="reg_password2"/>
   </td>
 </tr>
  <tr>
   <td>{"username"|lang}</td>
   <td>
    <input value="{$user_data.name}" name="reg_name"/>
   </td>
 </tr>

 
 <tr>
  <td colspan="2">
    <input type="hidden" name="reg_save_data" value="true"/>
    <input type="submit" value="{"save"|lang}"/>

  </td>
 </tr>



</tbody></table>
</form>