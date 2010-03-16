<?php /* Smarty version 2.6.19, created on 2010-02-20 12:36:57
         compiled from index_menu/menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'lang', 'index_menu/menu.tpl', 7, false),array('modifier', 'replace', 'index_menu/menu.tpl', 7, false),array('function', 'mod_admin_common_link', 'index_menu/menu.tpl', 13, false),)), $this); ?>
<div id="menu_top">
	<div class="item"><a href="/admin/"><img src="/source/images/icons/home.png" border="0"></a></div>
	<div class="top_menu">
          <?php $_from = $this->_tpl_vars['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
            <a href="index.php?mod=<?php echo $this->_tpl_vars['menu']['Link']; ?>
">
				<div class="item">
					<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['module']['Name'])) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)))) ? $this->_run_mod_handler('replace', true, $_tmp, "<br>", ' ') : smarty_modifier_replace($_tmp, "<br>", ' ')); ?>

				</div>
			</a>
          <?php endforeach; endif; unset($_from); ?>
	</div>

	<div class="user">(<?php echo $this->_tpl_vars['user']['Name']; ?>
)&nbsp;<a href="<?php echo smarty_function_mod_admin_common_link(array('value' => 'logout'), $this);?>
" style="color:black;">Exit</a></div>
    <div class="lang">
	    <select onChange='change_edit_lang(this.value);'>
		<?php $_from = $this->_tpl_vars['langList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lang'] => $this->_tpl_vars['lang_desc']):
?>
            <option value="<?php echo $this->_tpl_vars['lang']; ?>
"><?php echo $this->_tpl_vars['lang_desc']; ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
	</div>
</div>