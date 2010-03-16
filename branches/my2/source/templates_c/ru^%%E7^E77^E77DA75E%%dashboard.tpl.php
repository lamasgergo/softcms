<?php /* Smarty version 2.6.19, created on 2010-03-14 16:19:46
         compiled from admin/dashboard.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'lang', 'admin/dashboard.tpl', 7, false),)), $this); ?>

  <div id="mod_menu">
      <ul>
      <?php $this->assign('mod_group', ""); ?>
      <?php $_from = $this->_tpl_vars['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
        <?php if ($this->_tpl_vars['mod_group'] <> $this->_tpl_vars['module']['ModGroup']): ?>
            <li><a href="#<?php echo $this->_tpl_vars['module']['ModGroup']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['module']['ModGroup'])) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</a></li>
            <?php $this->assign('mod_group', $this->_tpl_vars['module']['ModGroup']); ?>
        <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?>
      </ul>

      <?php $this->assign('mod_group', ""); ?>
      <?php $_from = $this->_tpl_vars['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module']):
?>
        <?php if ($this->_tpl_vars['mod_group'] <> $this->_tpl_vars['module']['ModGroup']): ?>
            <?php if ($this->_tpl_vars['mod_group'] != ""): ?>
                <div style="clear: left;"></div>
                </div>
            <?php endif; ?>
            <div id="<?php echo $this->_tpl_vars['module']['ModGroup']; ?>
" style="border: 1px solid;">
            <?php $this->assign('mod_group', $this->_tpl_vars['module']['ModGroup']); ?>
        <?php endif; ?>

        <div class="icon">
            <a href="/admin/index.php?mod=<?php echo $this->_tpl_vars['module']['Name']; ?>
">
                <img border="0" src="/source/images/icons/<?php echo $this->_tpl_vars['module']['Icon']; ?>
" /><br>
               <?php echo ((is_array($_tmp=$this->_tpl_vars['module']['Name'])) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>

            </a>
        </div>
      <?php endforeach; endif; unset($_from); ?>
      <div style="clear: left;"></div>
  </div>

  
<?php echo '
  <script>
  $(document).ready(function(){
    $(\'#mod_menu\').tabs();
  });
  </script>
'; ?>