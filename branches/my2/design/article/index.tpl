{extends file="theme.tpl"}
{block name="content"}
    {new class="Article" name="cnt"}
    {$cnt->getData($id) assign="data"}
    <div class="title">{$data.Title}</div>
    <div class="text">{$data.Content}</div>
{/block}