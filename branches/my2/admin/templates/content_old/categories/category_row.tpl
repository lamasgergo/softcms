  <tr>
        <td style="height:20px;"><input type="checkbox" name="actionid_{$ID}" value="{$ID}"></td>
        <td><span style="color:blue;">{$depth}</span><span onClick="items_refresh({$ID});showTab('dhtmlgoodies_tabView1',1);" style="cursor:hand; text-decoration:underline;">{$Name}</span></td>
        <td>
            {if $Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
           <input type="checkbox" name="published_{$ID}" {$pub_ch} value="1" onclick="categories_publish({$ID},this.checked);">
        </td>
        <td>{$LangID|ShowLang|default:"&nbsp;"}</td>
        <td>{$UserID|ShowUser|default:"&nbsp;"}</td>
        <td>{$Description|default:"&nbsp;"}</td>
        <td>{$Created|date_format:"%d.%m.%Y %H:%M:%S"|default:"&nbsp;"}</td>
      </tr>