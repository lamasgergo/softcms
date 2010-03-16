{if $has_reg_auth eq 0}
	<form method="POST" name="reg_auth"> 
	<div class="login_form">
	<input type="hidden" name="reg_auth" value="true">
		<div class="form_row">
			<div class="login"><input type="text" id="req_login" name="reg_login" class="text" value="{lang username}"></div>
		</div>
		<div class="form_row">
			<div class="pass"><input type="password" id="reg_password" name="reg_password" class="text"></div>
			<div class="submit">
				<input type="submit" value="OK" />
			</div>
		</div>
		<div class="buton">
			<div class="register">
				<a href="/{$cur_lang}/register/">
					<img src="{$design_images}/{$cur_lang}/register_btn.png" border="0" />
				</a>
			</div>
		</div>
	</div>
	</form>
{else}	
	<div class="login_form">
		<div class="username">{"You are registred as"|lang} <b>{$user_name}</b></div>
		<div class="links">
				<ul>
					<li><a href="/{$cur_lang}/register/edit/">{"Modify your details"|lang}</a>
					</li><li><a href="/{$cur_lang}/register/maillists/">{"Mailing list editing"|lang}</a>
					</li><li><a href="/index.php?logout"><font color="red">{"Exit"|lang}</font></a>
					</li>
				</ul>
		</div>
	</div>
{/if}	

