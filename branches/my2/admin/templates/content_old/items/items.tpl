    <form method="post" action="javascript: return false;" name="items">
    <div class="widget_tableDiv">
    <table border="0" cellpadding="0" cellspacing="0" class="content" id="myTable">
      <thead>
        <tr>
          <td>{lang cnt_items_action}</td>
          <td>{lang cnt_items_title}</td>
          <td>{lang cnt_items_category}</td>
          <td>{lang cnt_items_published}</td>
          <td>{lang cnt_items_lang}</td>
          <td>{lang cnt_items_user}</td>
          <td>{lang cnt_items_created}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {foreach from=$items item=item}
      <tr>
        <td style="height:20px;"><input type="checkbox" name="actionid_{$item.ID}" value="{$item.ID}"></td>
        <td>{$item.Title}</td>
        <td>{$item.CategoryID|ShowCntCategory|default:"&nbsp;"}</td>
        <td>
            {if $item.Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
           <input type="checkbox" name="published_{$item.ID}" {$pub_ch} value="1" onclick="items_publish({$item.ID},this.checked);">
        </td>
        <td>{$item.LangID|ShowLang|default:"&nbsp;"}</td>
        <td>{$item.UserID|ShowUser|default:"&nbsp;"}</td>
        <td>{$item.Created|date_format:"%d.%m.%Y %H:%M:%S"|default:"&nbsp;"}</td>
      </tr>
      {/foreach}
      </tbody>
    </table>
    </div>
    </form>
    <script type="text/javascript">
      initTableWidget('myTable',"100%","480",Array(false,'S','S',false,'S','S','D'));
    </script>
