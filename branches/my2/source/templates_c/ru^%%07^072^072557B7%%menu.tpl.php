<?php /* Smarty version 2.6.19, created on 2010-03-13 12:25:37
         compiled from admin/modules/menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'admin/modules/menu.tpl', 58, false),array('modifier', 'lang', 'admin/modules/menu.tpl', 58, false),)), $this); ?>
<?php echo '
<script>

    function closeActiveTab(){
        var selected = $("#backend").data(\'selected.tabs\');

    }

	function refreshTabTable( module, component, method, tabLocked){
		if (!tabLocked){
			var selected = $("#backend").data(\'selected.tabs\');
			$("#backend").tabs(\'remove\', selected);
			$("#backend").find(\'[href=#tab_\'+component+\']\').click();
		}

		var selected = $("#backend").data(\'selected.tabs\');
        
		var link = \'/admin/ajax/index.php?mod=\'+module+\'&class=\'+component+\'&method=getTabContent\';
		
		$.get(link, function(data){
			$(\'#tab_\'+component).find(\'#grid\').replaceWith(data);
		});
		
		
	};

	var lastIndex = 0;

	function addTab(title, action, module, component, id){
		if (lastIndex!=0){
			removeDynamicTabs();
		}
		lastIndex = $(\'#backend\').tabs(\'length\');
		var link = \'/admin/ajax/index.php?mod=\'+module+\'&class=\'+component+\'&method=\'+component+\'_form&action=\'+action;
		if (id) link += "&id="+id;

        $(\'#backend\').tabs("add", link, title);
        $("#backend").tabs("select", lastIndex);

	};
	
	function removeTabByTitle(title){
		var index = 0;
		$("#backend >ul").find(\'li\').each(function(){
			if ($(this).find(\'span\').text()==title){
				$("#backend").tabs("remove", index);
			}
			index++;
		});
	};
	function removeDynamicTabs(){
		for (i=lastIndex; i<$(\'#backend\').tabs(\'length\'); i++){
			$("#backend").tabs("remove", i);
		}
	};
	
	function showAddForm(module, component){
		var title = \''; ?>
<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_add') : smarty_modifier_cat($_tmp, '_add')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
<?php echo '\';
		addTab(title, \'add\', module, component);
	};

	function showChangeForm(module, component){
//		var val = $("#"+component+"Grid").getGridParam("selrow");
        var val = $(\'div[id^=tab_]:visible\').find(\'input[name^=actionid_]:checked\').val();
		val = $.trim(val);
		if (val!=\'\' && val!=\'undefined\'){
			var title = \''; ?>
<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['module'])) ? $this->_run_mod_handler('cat', true, $_tmp, '_change') : smarty_modifier_cat($_tmp, '_change')))) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
<?php echo '\';
			addTab(title, \'change\', module, component, val);
		} else {
			alert(\''; ?>
<?php echo ((is_array($_tmp='check_item_first')) ? $this->_run_mod_handler('lang', true, $_tmp) : smarty_modifier_lang($_tmp)); ?>
<?php echo '\');
		}
	};
	

	var ids = new Array();
	function showDeleteForm(module, component){
		
//		$("#"+component+"Table").find("input:checked").each(function(){
        $(\'div[id^=tab_]:visible\').find(\'input[name^=actionid_]:checked\').each(function(){        
			ids.push($(this).val());
		});

        if (ids.length > 0){
            var link = \'/admin/ajax/index.php?mod=\'+module+\'&class=\'+component+\'&method=\'+component+\'_delete\';

            $.ajax({
                type: "POST",
                url: link,
                data: {ids: ids.join(\',\')},
                success: function(response){
                    eval(\'var response = \'+response+\';\');
                    if(typeof response ==\'object\' || typeof response ==\'array\'){
                        alert(response[1]);
                        result = response[0];
                    }
                    if (result){
                        refreshTabTable(module, component, method);
                    }
                }
            });

		} 
		return false;
	};
	
	function addFormCallback(module, component){
		refreshTabTable(module, component);
	};
	
	function changeFormCallback(module, component, tabLocked){
		refreshTabTable(module, component, tabLocked);
	};
	function deleteFormCallback(module, component){
		refreshTabTable(module, component, true);
	};
</script>
'; ?>


<a id="addButton" onClick="showAddForm('<?php echo $this->_tpl_vars['module']; ?>
','<?php echo $this->_tpl_vars['tab']['name']; ?>
');" href='#'><img src="<?php echo $this->_tpl_vars['images']; ?>
/menu/add.gif" border="0" /></a>
<a id="changeButton" onClick="showChangeForm('<?php echo $this->_tpl_vars['module']; ?>
','<?php echo $this->_tpl_vars['tab']['name']; ?>
');" href='#'><img src="<?php echo $this->_tpl_vars['images']; ?>
/menu/change.gif" border="0" /></a>
<a id="deleteButton}" onClick="showDeleteForm('<?php echo $this->_tpl_vars['module']; ?>
','<?php echo $this->_tpl_vars['tab']['name']; ?>
');" href='#'><img src="<?php echo $this->_tpl_vars['images']; ?>
/menu/del.gif" border="0" /></a>