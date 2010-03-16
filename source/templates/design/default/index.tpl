<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>{$meta_title}</title>
	<meta name="verify-v1" content="74/9Ltkm7i1TpbOeoOw9q0yPx+40zJTDNmF6mTcDnZc=" >
	<meta name="description" content="{$meta_description}">
	<meta name="keywords" content="{$meta_keywords}">
	<meta http-equiv="keywords" content="{$meta_keywords}">
	<meta http-equiv="description" content="{$meta_description}">

	
	<link rel="stylesheet" href="{$design_css}/main.css" />
	<link rel="stylesheet" href="{$js}/jquery/themes/base/ui.all.css" type="text/css">
	<script type="text/javascript" src="{$js}/jquery/jquery.js"></script>
	<script type="text/javascript" src="{$js}/jquery/ui/ui.core.js"></script>
	<script type="text/javascript" src="{$js}/jquery/ui/ui.accordion.js"></script>
	
	{$js}
	
	{literal}
	<script>
		function addToCart(id){
			cart_add(id);
			cart_refresh();
		}
	</script>
	{/literal}	
</head>
<body  bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="centerDiv">
	<div id="mainContainer">
		<div class="head">
			<div class="left"><a href="/"><img src="{$design_images}/head1.png" border="0"/></a></div>
			<div class="center"><div class="search_panel">{$SEARCH}</div></div>
			<div class="right"></div>
		</div>
		<div class="clr"></div>
		<div class="body">
			<div class="left">
				{$MENU}
				{$CONTENT_MENU}
			</div>
			<div class="center">{$BODY}</div>
			<div class="right">
				{$RIGHT}
			</div>
		</div>
		<div class="clr"></div>
		<div class="footer">
			<div class="left"></div>
			<div class="center"></div>
			<div class="right">
				<div style="position: absolute; bottom: 33px; right: 160px;">
				{literal}
					<!--LiveInternet counter--><script type="text/javascript"><!--
					document.write("<a href='http://www.liveinternet.ru/click' "+
					"target=_blank><img src='http://counter.yadro.ru/hit?t42.11;r"+
					escape(document.referrer)+((typeof(screen)=="undefined")?"":
					";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
					screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
					";"+Math.random()+
					"' alt='' title='LiveInternet' "+
					"border='0' width='31' height='31'><\/a>")
					//--></script><!--/LiveInternet-->
				{/literal}
				</div>
			</div>
		</div>
	</div>
</div>	

{literal}
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7738187-3");
pageTracker._trackPageview();
} catch(err) {}</script>



{/literal}

</body>
</html>