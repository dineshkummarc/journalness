{include file="$theme/header.tpl"}
{include file="$theme/leftnav.tpl"}
{section name=logged_in show=$show_logged_in}
	<div class="centered">
    	  <h5>{$L_LOGGED_IN}</h5><br/>
    	  <p>{$L_USER_LOGGED_IN}</p><br/>
    	  <p>{$L_RETURN_TO_INDEX}</p>
	</div>
{/section}
{section name=log_in show=$show_log_in}
  <div class="centered">
   <table>
    <tr>
	<td>
        <div class="centered"><h4>{$L_LOGIN}</h4><br/>
	  {if $num_errors > 0}<p style="color:red;">{$num_errors} error(s) found</p>{/if}
	  </div>
	  <form action="login.php" method="post">
	  <table border="0" cellspacing="0" cellpadding="5">
	    <tr>
		<td>
		  <h5>{$L_USERNAME}: </h5>
		</td>
		<td>
		  <input type="text" name="username" maxlength="30" value="{$username_value}"/><br/>
		  <p>{$username_error}</p>
		</td>
	    </tr>
	    <tr>
		<td>
		  <h5>{$L_PASSWORD}</h5>
		</td>
		<td>
		  <input type="password" name="password" maxlength="30" value="{$password_value}"/><br/>
		  <p>{$password_error}</p>
		</td>
	    </tr>
	    <tr>
		<td align="right">
		  <input type="checkbox" name="remember" {if $remember_value}checked="checked"{/if}/>
		</td>
            <td colspan="2" align="left">
		  <h5>{$L_REMEMBER_ME}</h5>
		</td>
	    </tr>
	    <tr>
		<td>
		</td>
		<td align="left">
		  <span style="font-size:10px;">[<a href="forgotpassword.php">Forgot password?</a>]</span>
		</td>
	    </tr>
	    <tr>
		<td colspan="2" align="right">
		  <input class="button" type="submit" name="login" value="{$L_LOGIN}"/>
		</td>
	    </tr>
	  </table>
	  </form>
	</td>
    </tr>
   </table>
  </div>
{/section}
{section name=not_authorized show=$show_not_authorized}
	<div class="centered">
    	  <p>{$not_authorized}</p>
	</div>
{/section}
</td>
{include file="$theme/rightnav.tpl"}
{include file="$theme/footer.tpl"}