<?php /* Smarty version 2.6.19, created on 2010-03-13 12:25:37
         compiled from C:%5Chtdocs%5Cphp4%5Chypermarket%5Cadmin%5Cmodules%5Cbase/templates/categories//table.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'C:\\htdocs\\php4\\hypermarket\\admin\\modules\\base/templates/categories//table.tpl', 7, false),array('modifier', 'lang', 'C:\\htdocs\\php4\\hypermarket\\admin\\modules\\base/templates/categories//table.tpl', 7, false),array('modifier', 'default', 'C:\\htdocs\\php4\\hypermarket\\admin\\modules\\base/templates/categories//table.tpl', 21, false),)), $this); ?>
    <form method="post" action="javascript:return false;" name="<?php echo $this->_tpl_vars['component']; ?>
">
    
    <div class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_action') : smarty_modifier_cat($_tmp, '_action')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
		  <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_ID') : smarty_modifier_cat($_tmp, '_ID')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
          <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_name') : smarty_modifier_cat($_tmp, '_name')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
          <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_description') : smarty_modifier_cat($_tmp, '_description')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
          <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_published') : smarty_modifier_cat($_tmp, '_published')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
          <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_modified') : smarty_modifier_cat($_tmp, '_modified')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      <?php $_from = $this->_tpl_vars['items_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
        <tr>
          <td style="height:20px;"><input type="checkbox" name="actionid_<?php echo $this->_tpl_vars['item']['ID']; ?>
" value="<?php echo $this->_tpl_vars['item']['ID']; ?>
"></td>
		  <td><?php echo $this->_tpl_vars['item']['ID']; ?>
</td>
          <td><?php echo $this->_tpl_vars['item']['Name']; ?>
</td>
          <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['Description'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
          <td>
			<?php if ($this->_tpl_vars['item']['Published'] == '1'): ?><?php $this->assign('pub_ch', 'checked'); ?><?php else: ?><?php $this->assign('pub_ch', ""); ?><?php endif; ?>
			<input type="checkbox" name="published_<?php echo $this->_tpl_vars['item']['ID']; ?>
" <?php echo $this->_tpl_vars['pub_ch']; ?>
 value="1" onclick="xajax_categories_publish(<?php echo $this->_tpl_vars['item']['ID']; ?>
,this.checked);">
		  </td>
          <td><?php echo $this->_tpl_vars['item']['Modified']; ?>
</td>
        </tr>
      <?php endforeach; endif; unset($_from); ?>
      </tbody>
    </table>
    </div>
    </form>
    <script type="text/javascript">
      initTableWidget('myTable',"100%","480",Array(<?php echo $this->_tpl_vars['sort_table_fields']; ?>
));
    </script>