<?php /* Smarty version 2.6.19, created on 2010-03-13 12:17:59
         compiled from C:%5Chtdocs%5Cphp4%5Chypermarket%5Cadmin%5Cmodules%5Cbase/templates/categories//form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'C:\\htdocs\\php4\\hypermarket\\admin\\modules\\base/templates/categories//form.tpl', 9, false),array('modifier', 'lang', 'C:\\htdocs\\php4\\hypermarket\\admin\\modules\\base/templates/categories//form.tpl', 9, false),array('function', 'html_options', 'C:\\htdocs\\php4\\hypermarket\\admin\\modules\\base/templates/categories//form.tpl', 13, false),)), $this); ?>
<form id="EXForm" onsubmit="return false;"><input type="hidden"	id="RequiredFields" name="RequiredFields" value="Name">
<table border="0" cellpadding="5" cellspacing="0" class="content"
	width="100%" height="100%" bgcolor="white">
	<tr valign="top">
		<td>
		<table border="0" cellpadding="5" cellspacing="0" class="content">
			<!--
			<tr>
				<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_LangID') : smarty_modifier_cat($_tmp, '_LangID')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
<span class="required">*</span></td>
				<td>
					<select name="LangID" id="LangID" onChange="categories_showCategories(this.value, document.getElementById('ID').value);">
						<option value="0">--- выбрать ---</option>
						<?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['lang_ids'],'selected' => $this->_tpl_vars['items_arr'][0]['LangID'],'output' => $this->_tpl_vars['lang_names']), $this);?>

					</select>
				</td>
			</tr>
			-->
			<tr>
				<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_parent') : smarty_modifier_cat($_tmp, '_parent')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
				<td>
					<select name="ParentID" id="ParentID">
						<option value="0">--- выбрать ---</option>
						<?php echo smarty_function_html_options(array('values' => $this->_tpl_vars['parent_ids'],'selected' => $this->_tpl_vars['items_arr'][0]['ParentID'],'output' => $this->_tpl_vars['parent_names']), $this);?>

					</select>
				</td>
			</tr>
			<tr>
				<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_name') : smarty_modifier_cat($_tmp, '_name')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
<span class="required">*</span></td>
				<td><input type="text" id="Name" name="Name" value="<?php echo $this->_tpl_vars['items_arr'][0]['Name']; ?>
" class="form_item"></td>
			</tr>
			<tr>
				<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_description') : smarty_modifier_cat($_tmp, '_description')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
				<td><textarea id="Description" name="Description" class="form_area"><?php echo $this->_tpl_vars['items_arr'][0]['Description']; ?>
</textarea></td>
			</tr>
			<tr>
				<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_published') : smarty_modifier_cat($_tmp, '_published')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
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
		</table>
		</td>
	</tr>
	<tr valign="bottom">
		<td align="right">
			<input type="hidden" id="ID" name="ID" value="<?php echo $this->_tpl_vars['items_arr'][0]['ID']; ?>
">
			<input type="hidden" id="tab_name" name="tab_name" value="<?php echo $this->_tpl_vars['tab_name']; ?>
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