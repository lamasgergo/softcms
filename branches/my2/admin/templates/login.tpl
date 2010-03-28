<html>
<head>
<META http-equiv="Content-Type" content="text/html; charset=utf-8" >
<title>{lang admin_title}</title>
<link rel="stylesheet" href="/admin/css/admin_style.css" type="text/css">
<link rel="stylesheet" type="text/css" href="{$js}/jquery/themes/redmond/jquery.ui.all.css" media="screen" />
<script type="text/javascript" src="{$js}/jquery/jquery.js"></script>
<script type="text/javascript" src="{$js}/jquery/ui/jquery-ui.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="/source/js/jquery/plugins/niceforms/niceforms-default.css" />
<script language="javascript" type="text/javascript" src="/source/js/jquery/plugins/niceforms/niceforms.js"></script>
</head>
<body>

<div class="loginForm">
    <div class="login">
        ##ERROR_MESSAGE##

        <form method="POST" class="niceform">
        <fieldset>                            
        <legend>{lang autorization}:</legend>
        <dl>
        	<dt><label for="login">{lang login_name}:</label></dt>
            <dd><input type="text" name="login" value="{$login}"></dd>
        </dl>
        <dl>
        	<dt><label for="password">{lang login_name}:</label></dt>
            <dd><input type="password" name="password" value="{$password}"></dd>
        </dl>
        </fieldset>
        <fieldset class="action">
    	    <input type="submit" name="submit" id="submit" value="Submit" />
        </fieldset>
        </form>
    </div>        
</div>
</body>
</html>