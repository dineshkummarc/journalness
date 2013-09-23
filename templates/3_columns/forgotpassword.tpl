{include file="$theme/header.tpl"}
{include file="$theme/leftnav.tpl"}
{section name=passwordreset show=$show_password_reset}
  <div class="centered">
   <table>
    <tr>
	<td>
        <div class="centered"><h4>{$L_PASSWORD_RESET}</h4><br/>
	  {if $num_errors > 0}<p style="color:red;">{$num_errors} error(s) found</p>{/if}
	  </div>
	  <form action="forgotpassword.php" method="post">
	  <table border="0" cellspacing="0" cellpadding="10" width="50%">
	    <tr>
		<td>
		  <span style="font-size: 11px;">{$L_PASSWORD_RESET_EXPLAIN}</span>
		</td>
	    </tr>
	    <tr>
		<td align="left">
		  <h5 style="margin-bottom: 2px;">{$L_EMAIL_ADDRESS} {$email_error}</h5>
		  <input type="text" name="email" maxlength="50" size="60" value="{$email_value}"/>
		</td>
	    </tr>
	    <tr>
		<td align="center">
		  <input class="button" type="submit" name="password_reset_submit" value="{$L_SEND_PASSWORD_RESET_EMAIL}"/>
		</td>
	    </tr>
	  </table>
	  </form>
	</td>
    </tr>
   </table>
  </div>
{/section}
{section name=emailsuccess show=$show_email_success}
  <div class="centered">
    <h4>{$email_sent_title}</h4><br/>
    <p><br/>{$email_sent}<br/><br/></p>
  </div>
{/section}
{section name=emailfailed show=$show_email_failed}
  <div class="centered">
    <h4>{$email_failed_title}</h4>
    <p><br/>{$email_failed}</p>
  </div>
{/section}
{section name=resetcompleted show=$show_reset_completed}
  <div class="centered">
    <h4>{$password_reset_completed_title}</h4><br/>
    <p><br/>{$password_reset_completed}<br/><br/></p>
  </div>
{/section}
{section name=resetfailed show=$show_reset_failed}
  <div class="centered">
    <h4>{$password_reset_failed_title}</h4>
    <p><br/>{$password_reset_failed}</p>
  </div>
{/section}
  </td>
{include file="$theme/rightnav.tpl"}
{include file="$theme/footer.tpl"}