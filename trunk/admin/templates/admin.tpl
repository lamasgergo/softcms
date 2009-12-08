<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="{$css}/admin_style.css" type="text/css">
<!--[if lt IE 7.]>
<script defer type="text/javascript" src="{$js}/pngfix.js"></script>
<![endif]-->
{$xajax_js}
<script type="text/javascript" src="/admin/source/editors/FCKEditor/fckeditor.js"></script>

<link rel="stylesheet" type="text/css" href="{$js}/jquery/themes/default/ui.all.css" media="screen" /> 
<script type="text/javascript" src="{$js}/jquery/jquery.js"></script>
<script type="text/javascript" src="{$js}/jquery/ui/jquery.ui.all.js"></script>


<link rel="stylesheet" href="{$js}/jquery/plugins/layout/layout.css" type="text/css">
<script type="text/javascript" src="{$js}/jquery/plugins/layout/jquery.layout.js"></script>

<link rel="stylesheet" href="{$js}/jquery/plugins/tablesorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />
<script type="text/javascript" src="{$js}/jquery/plugins/tablesorter/jquery.tablesorter.js"></script> 
<script type="text/javascript" src="{$js}/jquery/plugins/tablesorter/addons/pager/jquery.tablesorter.pager.js"></script> 

<script src="{$js}/jquery/plugins/fckeditor/jquery.FCKEditor.js" type="text/javascript" language="javascript"></script>

{literal}
<script>
    $(document).ready(function () {
		Layout = $('body').layout({
			initClosed: true,
			north__initClosed : false,
			east__initClosed : false
		});
		Layout.sizePane('north', 80);
		Layout.sizePane('east', 50);
    });
</script>

{/literal}

</head>
<body>
<div class="ui-layout-center">{$BODY}</div>
<div class="ui-layout-north">{$MENU}</div>
<div class="ui-layout-east">{$LANG}</div>
<div class="ui-layout-west">{$TREE}</div>

</body>
</html>