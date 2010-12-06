{if $form=='change'}
<input class="button_apply ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="submit" name="{$component}_apply" value="{'Apply'|lang}" onclick="send_form('EXForm', '{$module}', '{$component}', '{$form}', true); return false;">
{/if}
<input class="button_save ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="submit" name="{$component}_vendors" value="{'Save'|lang}" onclick="send_form('EXForm', '{$module}', '{$component}', '{$form}'); return false;">