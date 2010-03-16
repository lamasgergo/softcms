<form method="post" action="javascript: return false;" name="users">

<div class="widget_tableDiv" id="visual_users">
<table border="0" cellpadding="0" cellspacing="0" class="content" id="myTable">
  <thead>
    <tr>
      <td>{lang users_action}</td>
      <td>{lang users_login}</td>
      <td>{lang users_published}</td>
      <td>{lang users_group}</td>
      <td>{lang users_name}</td>
      <td>{lang users_familyname}</td>
      <td>{lang users_country}</td>
      <td>{lang users_zip}</td>
      <td>{lang users_city}</td>
      <td>{lang users_address}</td>
    </tr>
  </thead>
  <tbody class="scrollingContent" style="align:center;">
  {foreach from=$users item=users_item}
  <tr>
    <td style="height:20px;"><input type="checkbox" name="actionid_{$users_item.ID}" value="{$users_item.ID}"></td>
    <td>{$users_item.Login}</td>
    <td>
       {if $users_item.Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
       <input type="checkbox" name="published_{$users_item.ID}" {$pub_ch} value="1" onclick="publish_users({$users_item.ID},this.checked);">
    </td>
    <td>{$users_item.GroupName}</td>
    <td>{$users_item.UName}&nbsp;</td>
    <td>{$users_item.Familyname}&nbsp;</td>
    <td>{$users_item.Country}&nbsp;</td>
    <td>{$users_item.ZIP}&nbsp;</td>
    <td>{$users_item.City}&nbsp;</td>
    <td>{$users_item.Address}&nbsp;</td>
  </tr>
  {/foreach}
  </tbody>
</table>
</div>
</form>

<script type="text/javascript">
initTableWidget('myTable',"100%","480",Array(false,'S',false,'N','S','S','S','N','S','S'));
</script>