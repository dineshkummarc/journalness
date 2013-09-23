{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{section name=logged_in show=$show_logged_in}
	<div class="centered">
    	  <h2>{$L_LOGGED_IN}</h2><br/>
    	  <p><h4>{$L_USER_LOGGED_IN}</h4></p><br/>
    	  <p><h4>{$L_RETURN_TO_INDEX}</h4></p>
	</div>
{/section}
{section name=log_in show=$show_log_in}
	<div class="centered">
		<div class="login">
			<h1>{$L_ADMIN_LOGIN}</h1>
			<form action="login.php" method="post" class="loginform">
				<div class="inputlabel">{$L_USERNAME}: {$username_error}</div>
				<div class="left"><input name="username" type="text" class="inputbox" maxlength="30" value="{$username_value}" /></div>
				<div class="inputlabel">{$L_PASSWORD} {$password_error}</div>
				<div class="left"><input name="password" type="password" class="inputbox" maxlength="30" value="{$password_value}" /></div>
				<div class="right"><input type="submit" name="login" class="button" value="{$L_LOGIN}" /></div>
			</form>
		</div>
	</div>
{/section}
	<div class="centered">
	  <noscript>
		<p>WARNING! Javscript MUST be enabled for access to the Admin Panel.</p>
	  </noscript>
	</div>
{include file="$theme/footer.tpl"}