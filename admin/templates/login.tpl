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
