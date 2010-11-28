{extends file="theme.tpl"}

{block name="content"}
    {obj name="cnt" class="Article"}
    {$cnt->getData() assign="list"}
{foreach $list as $data}
<div class="list">
    <div class="title">{$data.Title}</div>
    <div class="text">{$data.Content}</div>
</div>
{/foreach}
{/block}