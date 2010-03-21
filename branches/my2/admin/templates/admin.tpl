<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/admin/css/admin_style.css" type="text/css">
<!--[if lt IE 7.]>
<script defer type="text/javascript" src="{$js}/pngfix.js"></script>
<![endif]-->

<script type="text/javascript" src="/admin/source/editors/FCKEditor/fckeditor.js"></script>
<script type="text/javascript" src="/admin/js/functions.js"></script>

{*<link rel="stylesheet" type="text/css" href="{$js}/jquery/themes/base/jquery-ui.css" media="screen" /> *}
<link rel="stylesheet" type="text/css" href="{$js}/jquery/themes/redmond/jquery.ui.all.css" media="screen" /> 
<script type="text/javascript" src="{$js}/jquery/jquery.js"></script>
<script type="text/javascript" src="{$js}/jquery/ui/jquery-ui.js"></script>

<!-- <script src="{$js}/jquery/plugins/fckeditor/jquery.FCKEditor.js" type="text/javascript"></script> -->
<script type="text/javascript" src="/admin/source/editors/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/admin/source/editors/ckeditor/adapters/jquery.js"></script>

</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" background="{$images}/admin_bg.gif" style="background-repeat:no-repeat; background-position: bottom right; height: 100%;">
<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
  <tr valign="top">
    <td width="100%">
      <table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
      <tr>
        <td style='width:100%;'>
        {include file="index_menu/menu.tpl"}
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
      {$BODY}
    </td>
  </tr>
</table>


{literal}
<script>
	$(document).find('.widget_tableDiv').each(function(){
		var $table = $(this);
		var defHeight = parseInt($table.get(0).style.height);
		$head = $table.find('thead');
		$body = $table.find('.scrollingContent');
		if (defHeight < $head.height() + $body.height()){
			$body.height(defHeight-$head.height()-30);
			$body.css('overflow-y','auto');
		}
	});
</script>
{/literal}

</body>
</html>