<div class="box">
	<div class="title">{"Login Form"|lang}</div>
	<div class="body">
		<form id="login_form" method="POST"> 
		<table border="0" cellpadding="10" cellspacing="0"  >
		<tr>
			<td align="right">
			{if $has_reg_auth eq 0}
				<div class="login">
				  <form method="POST" name="reg_auth"><input type="hidden" name="reg_auth" value="true">
					<div class="row">
						<div class="desc">{lang username}</div>
						<input type="text" id="req_login" name="reg_login" class="text">
					</div>
					<div class="row">
					  <div class="desc">{lang password}</div>
					  <input type="password" id="reg_password" name="reg_password" class="text">
					</div>
					<div class="buton">
						<div style="float: left">
							<a href="/{$cur_lang}/register/">{lang register}</a>
						</div>
						<div style="float: right; text-align: right;">
							<input type="image" value="{'login'|lang}" style="border: none;" src="{$design_images}/{$cur_lang}/login_btn.png" />
						</div>
					</div>
				  </form>
				</div>
			{else}	
			<div class="login">
				<p>{"You are registred as"|lang} <b>{$user_name}</b></p>
				<p></p>
				<ul>
					<li><a href="/{$cur_lang}/register/edit/">{"Modify your details"|lang}</a>
					</li><li><a href="/{$cur_lang}/register/maillists/">{"Mailing list editing"|lang}</a>
					</li><li><a href="/index.php?logout"><font color="red">{"Exit"|lang}</font></a>
					</li>
				</ul>
			</div>
			{/if}	
			</td>
		</tr>
		</table>
		</form>
	</div>
</div>
