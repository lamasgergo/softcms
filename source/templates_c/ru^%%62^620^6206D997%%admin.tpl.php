<?php /* Smarty version 2.6.19, created on 2010-03-14 16:19:46
         compiled from admin.tpl */ ?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['css']; ?>
/admin_style.css" type="text/css">
<!--[if lt IE 7.]>
<script defer type="text/javascript" src="<?php echo $this->_tpl_vars['js']; ?>
/pngfix.js"></script>
<![endif]-->

<script type="text/javascript" src="/admin/source/editors/FCKEditor/fckeditor.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['js']; ?>
/functions.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['js']; ?>
/jquery/themes/base/ui.all.css" media="screen" /> 
<script type="text/javascript" src="<?php echo $this->_tpl_vars['js']; ?>
/jquery/jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['js']; ?>
/jquery/ui/jquery-ui.js"></script>

<!-- <script src="<?php echo $this->_tpl_vars['js']; ?>
/jquery/plugins/fckeditor/jquery.FCKEditor.js" type="text/javascript"></script> -->
<script type="text/javascript" src="/admin/source/editors/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/admin/source/editors/ckeditor/adapters/jquery.js"></script>

</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" background="<?php echo $this->_tpl_vars['images']; ?>
/admin_bg.gif" style="background-repeat:no-repeat; background-position: bottom right; height: 100%;">
<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
  <tr valign="top">
    <td width="100%">
      <table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
      <tr>
        <td style='width:100%;'>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "index_menu/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </td>
      </tr>
      </table>
    </td>
  </tr>
  <tr valign="middle">
    <td id="ProgressCell" style='visibility: hidden; height: 0px; vertical-align: middle;' align="center">
      <span class="progressBar" id="element1">0%</span>
    </td>
  </tr>
  <tr valign="top">
    <td id="BodyCell">
      <?php echo $this->_tpl_vars['BODY']; ?>

    </td>
  </tr>
</table>


<?php echo '
<script>
	$(document).find(\'.widget_tableDiv\').each(function(){
		var $table = $(this);
		var defHeight = parseInt($table.get(0).style.height);
		$head = $table.find(\'thead\');
		$body = $table.find(\'.scrollingContent\');
		if (defHeight < $head.height() + $body.height()){
			$body.height(defHeight-$head.height()-30);
			$body.css(\'overflow-y\',\'auto\');
		}
	});
</script>
'; ?>


</body>
</html>