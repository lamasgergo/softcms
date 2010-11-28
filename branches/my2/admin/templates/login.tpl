<div class="loginForm">
    <div class="login">

        {$error}
        <form method="POST" class="niceform">
        <fieldset>                            
        <legend>{"Autorization"|lang:"LOGIN"}:</legend>
        <dl>
        	<dt><label for="login">{"Login"|lang:"LOGIN"}:</label></dt>
            <dd><input type="text" name="login" value="{$login|default:''}"></dd>
        </dl>
        <dl>
        	<dt><label for="password">{"Password"|lang:"LOGIN"}:</label></dt>
            <dd><input type="password" name="password" value="{$password|default:''}"></dd>
        </dl>
        </fieldset>
        <fieldset class="action">
    	    <input type="submit" name="submit" id="submit" value="{"Log in"|lang:"LOGIN"}" />
        </fieldset>
        </form>
    </div>        
</div>
