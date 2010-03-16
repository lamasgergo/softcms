<?php /* Smarty version 2.6.19, created on 2010-02-21 08:06:04
         compiled from content/items/form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'content/items/form.tpl', 12, false),array('modifier', 'cat', 'content/items/form.tpl', 56, false),array('modifier', 'lang', 'content/items/form.tpl', 56, false),array('modifier', 'date_format', 'content/items/form.tpl', 65, false),)), $this); ?>
<form id="EXForm" onsubmit="return false;"><input type="hidden"	id="RequiredFields" name="RequiredFields" value="Title,Created">
<table border="0" cellpadding="5" cellspacing="0" class="content"
	width="100%" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<table border="0" cellpadding="5" cellspacing="0" class="content">
		<tr>
	      <td>Связать с пунктом меню</td>
	      <td>
				<select name="MenuID" id="MenuID" >
		          <option value="0">--- выбрать ---</option>
		          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['menu_ids'],'selected' => $this->_tpl_vars['items_arr'][0]['MenuID'],'output' => $this->_tpl_vars['menu_names']), $this);?>

		        </select>
	      </td>
	    </tr>
		<tr>
	      <td>Только для зарегистрированных пользователей</td>
	      <td>
			<?php if ($this->_tpl_vars['items_arr'][0]['LoginRequired'] == '1'): ?><?php $this->assign('pub_LoginRequired', 'checked'); ?><?php else: ?><?php $this->assign('pub_LoginRequired', ""); ?><?php endif; ?>
	        <input type="checkbox" id="LoginRequired" name="LoginRequired" value="1" <?php echo $this->_tpl_vars['pub_LoginRequired']; ?>
>
	      </td>
	    </tr>
	    <tr>
	      <td>Категория<span class="required">*</span></td>
	      <td>
	      	<div id="CategoryIDDiv">
		        <select name="CategoryID" id="CategoryID" >
		          <option value="0">--- выбрать ---</option>
		          <?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['category_ids'],'selected' => $this->_tpl_vars['items_arr'][0]['CategoryID'],'output' => $this->_tpl_vars['category_names']), $this);?>

		        </select>
		    </div>
	      </td>
	    </tr>
	    <tr>
	      <td>Название<span class="required">*</span></td>
	      <td><input type="text" id="Title" name="Title" value="<?php echo $this->_tpl_vars['items_arr'][0]['Title']; ?>
" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>
	      	Краткое содержание
	      </td>
	      <td><textarea id="Short_Text" name="Short_Text" class="form_area"><?php echo $this->_tpl_vars['items_arr'][0]['Short_Text']; ?>
</textarea></td>
	    </tr>
	    <tr>
	      <td>Содержание</td>
	      <td><textarea id="Full_Text" name="Full_Text" class="form_area"><?php echo $this->_tpl_vars['items_arr'][0]['Full_Text']; ?>
</textarea></td>
	    </tr>
	    <tr>
	      <td>Опубликована</td>
	      <td>
	        <?php if ($this->_tpl_vars['items_arr'][0]['Published'] == '1'): ?><?php $this->assign('pub_ch', 'checked'); ?><?php else: ?><?php $this->assign('pub_ch', ""); ?><?php endif; ?>
	        <input type="checkbox" id="Published" name="Published" value="1" <?php echo $this->_tpl_vars['pub_ch']; ?>
>
	    </td>
	    </tr>
		<tr>
				<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_AllowComments') : smarty_modifier_cat($_tmp, '_AllowComments')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
				<td>
					<?php if ($this->_tpl_vars['items_arr'][0]['AllowComments'] == '1'): ?><?php $this->assign('AllowComments_ch', 'checked'); ?><?php else: ?><?php $this->assign('AllowComments_ch', ""); ?><?php endif; ?>
					<input type="checkbox" id="AllowComments" name="AllowComments" value="1" <?php echo $this->_tpl_vars['AllowComments_ch']; ?>
>
				</td>
			</tr>
	    <tr>
	      <td>Дата создания<span class="required">*</span></td>
	      <td>
			<input type="text" id="Created" name="Created" readonly value="<?php echo ((is_array($_tmp=$this->_tpl_vars['items_arr'][0]['Created'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
" class="form_item">
		  </td>
	    </tr>
	    <tr>
	      <td>Мета заголовок</td>
	      <td><input type="text" id="MetaTitle" name="MetaTitle" value="<?php echo $this->_tpl_vars['items_arr'][0]['MetaTitle']; ?>
" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>Мета ключ. слова</td>
	      <td><input type="text" id="MetaKeywords" name="MetaKeywords" value="<?php echo $this->_tpl_vars['items_arr'][0]['MetaKeywords']; ?>
" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>Мета описание</td>
	      <td><input type="text" id="MetaDescription" name="MetaDescription" value="<?php echo $this->_tpl_vars['items_arr'][0]['MetaDescription']; ?>
" class="form_item"></td>
	    </tr>
	    <tr>
	      <td>Мета опис. картинок</td>
	      <td><input type="text" id="MetaAlt" name="MetaAlt" value="<?php echo $this->_tpl_vars['items_arr'][0]['MetaAlt']; ?>
" class="form_item"></td>
	    </tr>
	    </table>
		</td>
	</tr>
	<tr valign="bottom">
		<td align="right">
			<input type="hidden" id="ID" name="ID" value="<?php echo $this->_tpl_vars['items_arr'][0]['ID']; ?>
">
			<input type="hidden" id="tab_name" name="tab_name" value="<?php echo $this->_tpl_vars['tab_name']; ?>
">
			<input type="hidden" id="tab_id" name="tab_id" value="<?php echo $this->_tpl_vars['tab_id']; ?>
">
			<?php if ($this->_tpl_vars['form'] == 'change'): ?>
				<input type="submit" name="<?php echo $this->_tpl_vars['prefix']; ?>
_apply" value="<?php echo ((is_array($_tmp='button_apply')) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
" class="form_but" onclick="send_form('EXForm', '<?php echo $this->_tpl_vars['prefix']; ?>
', '<?php echo $this->_tpl_vars['tab_prefix']; ?>
', '<?php echo $this->_tpl_vars['tab_prefix']; ?>
_<?php echo $this->_tpl_vars['form']; ?>
', true); return false;">
			<?php endif; ?>
			<input type="submit" name="<?php echo $this->_tpl_vars['prefix']; ?>
_vendors" value="<?php echo ((is_array($_tmp=((is_array($_tmp='button_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['form']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['form'])))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
" class="form_but" onclick="send_form('EXForm', '<?php echo $this->_tpl_vars['prefix']; ?>
', '<?php echo $this->_tpl_vars['tab_prefix']; ?>
', '<?php echo $this->_tpl_vars['tab_prefix']; ?>
_<?php echo $this->_tpl_vars['form']; ?>
'); return false;">
		</td>
	</tr>
</table>
</form>

        <?php echo '
        <script type="text/javascript">
            $(document).ready(function(){
                $(\'#Created\').datepicker({ dateFormat: \'yy-mm-dd\' });
                initEditorFull(\'Full_Text\');
                initEditorLite(\'Short_Text\');
            });
        </script>
        '; ?>