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
<script type="text/javascript" src="{$js}/jquery/ui/jquery-ui.js"></script>
<script type="text/javascript" src="{$js}/jquery/external/bgiframe/jquery.bgiframe.min.js"></script>


<link rel="stylesheet" href="{$js}/jquery/plugins/layout/layout.css" type="text/css">
<script type="text/javascript" src="{$js}/jquery/plugins/layout/jquery.layout.js"></script>

<script src="{$js}/jquery/plugins/fckeditor/jquery.FCKEditor.js" type="text/javascript" language="javascript"></script>

<link rel="stylesheet" type="text/css" media="screen" href="{$js}/jquery/plugins/jqGrid/css/ui.jqgrid.css" />
<script src="{$js}/jquery/plugins/jqGrid/js/i18n/grid.locale-{$GUILang}.js" type="text/javascript"></script>
<script src="{$js}/jquery/plugins/jqGrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" media="screen" href="{$js}/jquery/plugins/jdMenu/jquery.jdMenu.css" />
<script src="{$js}/jquery/plugins/jdMenu/jquery.jdMenu.js" type="text/javascript"></script>
<script src="{$js}/jquery/plugins/jdMenu/jquery.positionBy.js" type="text/javascript"></script>

{literal}
<script>
    $(document).ready(function () {
		Layout = $('body').layout({
			initClosed: true,
			north__initClosed : false,
			north__minSize : 80,
			north__maxSize : 80,
			east__minSize : 350
		});
    });
</script>

{/literal}

</head>
<body>
<div class="ui-layout-center">{$BODY}</div>
<div class="ui-layout-north">{admin_menu type='top'}</div>
<div class="ui-layout-east">{$LANG}</div>
<div class="ui-layout-west">{$TREE}</div>

</body>
</html>