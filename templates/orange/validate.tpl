{include file="$theme/header.tpl"}
{include file="$theme/navigation.tpl"}
{section name=validation_sent show=$show_validation_sent}
  <div class="centered"><br/>
    <h4>{$L_VALIDATION_EMAIL_SENT}</h4><br/>
  </div>
{/section}
{section name=validation_complete show=$show_validation_complete}
  <div class="centered"><br/>
    <h4>{$L_VALIDATION_COMPLETED}</h4><br/>
  </div>
{/section}
{include file="$theme/footer.tpl"}