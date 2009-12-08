<?php /* Smarty version 2.6.26, created on 2009-12-08 09:21:39
         compiled from templates/login/login.tpl */ ?>
<html>
<head>
<META http-equiv="Content-Type" content="text/html; charset=utf-8" >
<title>admin_title</title>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['css']; ?>
/admin_style.css" type="text/css">
</head>
<body leftmargin="0" topmargin="0" bgcolor="#FFFFFF" background="/source/images/admin_bg.gif" style="background-repeat:no-repeat;background-position: top right">
<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
<tr>
  <td align="center">
    <!-- login -->
    <table border="0" cellpadding="5" cellspacing="0" class="content">
    <tr valign="bottom">
      <td align="center"><span class='error'></span></td>
    </tr>
    <tr>
    <td align="center">
        <form method="POST">
        <fieldset style='border: 1px solid #000000;'>                            
        <legend style='color:#000000; '>autorization:</legend>
        <table border="0" cellpadding="5" cellspacing="0" class="content" style="color:#000000;">
        <tr>
          <td>
            login_name:
          </td>
          <td>
                <input type="text" name="login" value="<?php echo $this->_tpl_vars['login']; ?>
" class="form_item" style="color:#000000;">
          </td>
        </tr>
        <tr>
          <td>
            password:
          </td>
          <td>
                <input type="password" name="password" value="<?php echo $this->_tpl_vars['password']; ?>
" class="form_item" style="color:#000000;">
          </td>
        </tr>
        <tr>
               <td colspan="2" align="right"><input type="submit" name="LogIn" value="login" class="form_submit" style="color:#000000;"></td>
        </tr>
        </table>
        </fieldset>
        </form>
    </td>
  </tr>
  </table>
    <!-- /login -->
  </td>
</tr>
</table>                                   
</body>
</html>