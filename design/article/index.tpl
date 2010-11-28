{extends file="theme.tpl"}

{block name="content"}
    {obj name="cnt" class="Article"}
    {$cnt->getData($id) assign="data"}
    <div class="title">{$data.Title}</div>
    <div class="text">{$data.Content}</div>

{/block}