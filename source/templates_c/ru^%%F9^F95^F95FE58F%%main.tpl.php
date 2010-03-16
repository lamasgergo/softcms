<?php /* Smarty version 2.6.19, created on 2010-03-13 12:25:37
         compiled from admin/modules/main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'admin/modules/main.tpl', 7, false),array('modifier', 'lang', 'admin/modules/main.tpl', 7, false),)), $this); ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['js']; ?>
/sort_table.js"></script>
<link type="text/css" rel="StyleSheet" href="<?php echo $this->_tpl_vars['css']; ?>
/sort_table.css" />
        
<div id="backend">
	<ul>
	  <?php $_from = $this->_tpl_vars['tabs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tab']):
?>
		<li><a href="#<?php echo ((is_array($_tmp='tab_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['tab']['name']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['tab']['name'])); ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_') : smarty_modifier_cat($_tmp, '_')))) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['tab']['name']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['tab']['name'])))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</a></li>
	  <?php endforeach; endif; unset($_from); ?>
	</ul>
    <?php $_from = $this->_tpl_vars['tabs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tab']):
?>
    <div id="<?php echo ((is_array($_tmp='tab_')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['tab']['name']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['tab']['name'])); ?>
">
		<div id="menu">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "admin/modules/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</div>
		<div id="grid">
			<?php echo $this->_tpl_vars['tab']['value']; ?>

		</div>
    </div>
  <?php endforeach; endif; unset($_from); ?>

</div>

<?php echo '
<script type="text/javascript">

  $(\'#backend\').tabs();

</script>
'; ?>
