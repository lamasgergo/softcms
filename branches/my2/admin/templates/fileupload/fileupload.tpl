{literal}
<script language="javascript">
function submit_upload(form){
    var op = opener.document.getElementById('{/literal}{$target}{literal}');
    var i=1;
    var txt = "";
    while (document.getElementById("file"+i)!=null){
        if (document.getElementById("file"+i).value!=""){
            var filename = document.getElementById("file"+i).value;
            filename = filename.replace(/^.+[\/|\\](.+)$/ig,"$1");
            txt += "<input type='text' disable class='form_item' name='"+document.getElementById("file"+i).name+"' value='"+filename+"'><br>";
        }
        i++;
    }
    op.innerHTML = txt;
    form.submit();
}
</script>
{/literal}
<fieldset style="width:450px; background-color:#FFFFFF;">
<legend>{lang upl_upload_title}</legend>
<div style="padding:10px;" class="content">
<form method="POST" enctype="multipart/form-data">
	<div id="files" style="width: 400px; padding:5px;">
		<div id="file_1" style='padding:5px;'>
			<input type="file" name="file1" id="file1" class="form_item"><br><br>
 			<span onclick="add_upload_field(document.getElementById('count').value);" style="text-decoration:underline; cursor: hand;">{lang upl_add_more}</span>&nbsp;
		</div>
		<div id="file_2"></div>
	</div>
	<div id="submit" style="width: 400px; text-align:right; valign:bottom;">
			<input type="hidden" name="count" id="count" value="1">
    		<input type="submit" name="uploadimg" value="{lang upl_upload}" class="form_but" onclick="submit_upload(this.form);">
    </div>
</form>
</div>
</fieldset>
