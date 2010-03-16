<?php /* Smarty version 2.6.19, created on 2010-03-09 21:42:55
         compiled from content/items/table.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'content/items/table.tpl', 7, false),array('modifier', 'lang', 'content/items/table.tpl', 7, false),array('modifier', 'ShowCntCategory', 'content/items/table.tpl', 21, false),array('modifier', 'default', 'content/items/table.tpl', 21, false),array('modifier', 'date_format', 'content/items/table.tpl', 26, false),)), $this); ?>
    <form method="post" action="javascript:return false;" name="<?php echo $this->_tpl_vars['tab_prefix']; ?>
">
    
    <div class="widget_tableDiv">
    <table id="myTable">
      <thead>
        <tr>
          <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_action') : smarty_modifier_cat($_tmp, '_action')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
		  <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_ID') : smarty_modifier_cat($_tmp, '_ID')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
          <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_Title') : smarty_modifier_cat($_tmp, '_Title')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
          <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_CategoryID') : smarty_modifier_cat($_tmp, '_CategoryID')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
          <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_Published') : smarty_modifier_cat($_tmp, '_Published')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
</td>
          <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_created') : smarty_modifier_cat($_tmp, '_created')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
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
          <td><?php echo $this->_tpl_vars['item']['Title']; ?>
</td>
          <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['CategoryID'])) ? $this->_run_mod_handler('ShowCntCategory', true, $_tmp) : smarty_modifier_ShowCntCategory($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
          <td>
			<?php if ($this->_tpl_vars['item']['Published'] == '1'): ?><?php $this->assign('pub_ch', 'checked'); ?><?php else: ?><?php $this->assign('pub_ch', ""); ?><?php endif; ?>
			<input type="checkbox" name="published_<?php echo $this->_tpl_vars['item']['ID']; ?>
" <?php echo $this->_tpl_vars['pub_ch']; ?>
 value="1" onclick="items_publish(<?php echo $this->_tpl_vars['item']['ID']; ?>
,this.checked);">
		  </td>
          <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['Created'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d.%m.%Y %H:%M:%S") : smarty_modifier_date_format($_tmp, "%d.%m.%Y %H:%M:%S")))) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
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