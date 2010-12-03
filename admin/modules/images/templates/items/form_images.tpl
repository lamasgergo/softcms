<fieldset>
    <legend>{"Upload files"|lang:$component}</legend>
    <label for="src">{"Select file"|lang:$component}</label>
    <input type="file" id="src" name="src"/>
</fieldset>
<fieldset>
    <legend>{"Files"|lang:$component}</legend>
    <div class="filesContainer">
        {foreach $images_src as $src}
            <div>
                <a href="{$src}" target="_blank">
                    <img src="{$src}" alt="" class="image_preview"/><br/>
                    {image_info file=$src show="name"}<br/>
                    {image_info file=$src show="resolution"}<br/>
                </a>
            </div>
        {/foreach}
    </div>
</fieldset>