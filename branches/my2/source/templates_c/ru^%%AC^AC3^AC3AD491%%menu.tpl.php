<?php /* Smarty version 2.6.19, created on 2010-03-02 20:48:25
         compiled from gallery/categories/menu/menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'gallery/categories/menu/menu.tpl', 59, false),array('modifier', 'lang', 'gallery/categories/menu/menu.tpl', 59, false),)), $this); ?>
<script language="JavaScript">
  function set_action_<?php echo $this->_tpl_vars['tab_prefix']; ?>
(act){
    if (act=="add"){
      <?php echo $this->_tpl_vars['tab_prefix']; ?>
_form('add','<?php echo $this->_tpl_vars['tab_id']; ?>
');
    }
    if (act=="change"){
      var boxcount = 0;
      for (i=0; i< document.forms["<?php echo $this->_tpl_vars['tab_prefix']; ?>
"].length; i++){
        var act_reg = new RegExp("^actionid\_.*","i");
        if (act_reg.test(document.forms["<?php echo $this->_tpl_vars['tab_prefix']; ?>
"].elements[i].name) && document.forms["<?php echo $this->_tpl_vars['tab_prefix']; ?>
"].elements[i].checked){
          var id = document.forms["<?php echo $this->_tpl_vars['tab_prefix']; ?>
"].elements[i].value;
          boxcount++;
        }
      }
      if (boxcount==1){
        <?php echo $this->_tpl_vars['tab_prefix']; ?>
_form('change','<?php echo $this->_tpl_vars['tab_id']; ?>
',id);
      }
      if(boxcount>1){
        alert("Выделено более 1 элемента списка"); 
      }
      if(boxcount==0){
        alert("Выделите элемент из списка для редактирования"); 
      }
    }
    if (act=="publish"){
      document.getElementById("form_action").value="publish";
      document.forms["<?php echo $this->_tpl_vars['tab_prefix']; ?>
"].submit();
    }
    if (act=="delete"){
      var boxcount = 0;
      var del = false;
      for (i=0; i< document.forms["<?php echo $this->_tpl_vars['tab_prefix']; ?>
"].length; i++){
        var act_reg = new RegExp("^actionid\_.*","i");
        if (act_reg.test(document.forms["<?php echo $this->_tpl_vars['tab_prefix']; ?>
"].elements[i].name) && document.forms["<?php echo $this->_tpl_vars['tab_prefix']; ?>
"].elements[i].checked){
          var id = document.forms["<?php echo $this->_tpl_vars['tab_prefix']; ?>
"].elements[i].value;
          boxcount++;
        }
      }
      if (boxcount==1){
        del = true;
      }
      if(boxcount>1){
        alert("Выделено более 1 элемента списка"); 
      }
      if(boxcount==0){
        alert("Выделите элемент из списка для удаления"); 
      }
      if (del==true){
      if(confirm("Вы действительно хотите удалить выделенные элементы?")){
       <?php echo $this->_tpl_vars['tab_prefix']; ?>
_delete(id,'<?php echo $this->_tpl_vars['tab_id']; ?>
');
      }
      }
    }
  }
</script>
<table border="0" cellpadding="4" cellspacing="0" width="100%">
<tr>
    <td>
      <img src="<?php echo $this->_tpl_vars['images']; ?>
/menu/add.gif" border="0" title="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_add') : smarty_modifier_cat($_tmp, '_add')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
" style="cursor:hand;" onclick="set_action_<?php echo $this->_tpl_vars['tab_prefix']; ?>
('add');">
    </td>
    <td>
      <img src="<?php echo $this->_tpl_vars['images']; ?>
/menu/change.gif" border="0" title="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_change') : smarty_modifier_cat($_tmp, '_change')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
"onclick="set_action_<?php echo $this->_tpl_vars['tab_prefix']; ?>
('change');" style="cursor:hand;">
    </td>
    <td>
      <img src="<?php echo $this->_tpl_vars['images']; ?>
/menu/del.gif" border="0" title="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['prefix'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_delete') : smarty_modifier_cat($_tmp, '_delete')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
"onclick="set_action_<?php echo $this->_tpl_vars['tab_prefix']; ?>
('delete');" style="cursor:hand;">
    </td>
</tr>
</table>