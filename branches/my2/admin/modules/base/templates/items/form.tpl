<form id="EXForm" onsubmit="return false;">
<input type="hidden"	id="RequiredFields" name="RequiredFields" value="Title, CategoryID">

<div class="formBlock">
    <div class="panel" id="general">
        <div class="title">{$component|cat:"_General"|lang}</div>
            <div>
                  <div>{$component|cat:"_Title"|lang}</div>
                  <div>
                        <input type="text" id="Title" name="Title" value="{$items_arr[0].Title}" class="form_item">
                  </div>
            </div>

            <div>
                  <div>{$component|cat:"_CategoryID"|lang}</div>
                  <div>
                        <select name="CategoryID" id="CategoryID" >
                          <option value="0">{lang select_default_name}</option>
                          {html_options values=$category_ids selected=$items_arr[0].CategoryID output=$category_names}
                        </select>
                  </div>
            </div>
            <div>
                  <div>{$component|cat:"_Published"|lang}</div>
                  <div>
                        {if $items_arr[0].Published eq "1"}{assign var="pub_ch" value="checked"}{else}{assign var="pub_ch" value=""}{/if}
                        <input type="checkbox" id="Published" name="Published" value="1" {$pub_ch}>
                  </div>
            </div>
            <div>
                  <div>{$component|cat:"_LoginRequired"|lang}</div>
                  <div>
                        {if $items_arr[0].LoginRequired eq "1"}{assign var="LoginRequired_ch" value="checked"}{else}{assign var="LoginRequired_ch" value=""}{/if}
					<input type="checkbox" id="LoginRequired" name="LoginRequired" value="1" {$LoginRequired_ch}>
                  </div>
            </div>
    </div>
    <div class="panel" id="cnt">
        <div class="title">{$component|cat:"_Content"|lang}</div>
            <div>
                  <div>{$component|cat:"_Content"|lang}</div>
                  <div>
                        <textarea id="Content" name="Content" class="form_area">{$items_arr[0].Content}</textarea>
                  </div>
            </div>

            <div>
                  <div>{$component|cat:"_Teaser"|lang}</div>
                  <div>
                        <textarea id="Teaser" name="Teaser" class="form_area">{$items_arr[0].Teaser}</textarea>
                  </div>
            </div>
    </div>
    <div class="panel" id="cnt">
        <div class="title">{$component|cat:"_Content"|lang}</div>
            <div>
                  <div>{$component|cat:"_MetaTitle"|lang}</div>
                  <div>
                        <input type="text" id="MetaTitle" name="MetaTitle" value="{$items_arr[0].MetaTitle}" class="form_item">
                  </div>
            </div>
            <div>
                  <div>{$component|cat:"_MetaKeywords"|lang}</div>
                  <div>
                        <input type="text" id="MetaKeywords" name="MetaKeywords" value="{$items_arr[0].MetaKeywords}" class="form_item">
                  </div>
            </div>
            <div>
                  <div>{$component|cat:"_MetaDescription"|lang}</div>
                  <div>
                        <input type="text" id="MetaDescription" name="MetaDescription" value="{$items_arr[0].MetaDescription}" class="form_item">
                  </div>
            </div>
            <div>
                  <div>{$component|cat:"_MetaAlt"|lang}</div>
                  <div>
                        <input type="text" id="MetaAlt" name="MetaAlt" value="{$items_arr[0].MetaAlt}" class="form_item">
                  </div>
            </div>
    </div>


    <div class="formToolbar">
                <input type="hidden" id="ID" name="ID" value="{$items_arr[0].ID}">
                <input type="hidden" id="tab_name" name="tab_name" value="{$tab_name}">
                <input type="hidden" id="tab_id" name="tab_id" value="{$tab_id}">
                            {if $form=='change'}
                    <input type="submit" name="{$component}_apply" value="{'button_apply'|lang}" class="form_but" onclick="send_form('EXForm', '{$module}', '{$component}', '{$component}_{$form}', true); return false;">
                {/if}
                <input type="submit" name="{$component}_vendors" value="{'button_'|cat:$form|lang}" class="form_but" onclick="send_form('EXForm', '{$module}', '{$component}', '{$component}_{$form}'); return false;">
    </div>
</div>
</form>

        {literal}
        <script type="text/javascript">
            $(document).ready(function(){
                $('#Created').datepicker({ dateFormat: 'yy-mm-dd' });
                initEditorFull('Full_Text');
                initEditorLite('Short_Text');
            });
        </script>
        {/literal}