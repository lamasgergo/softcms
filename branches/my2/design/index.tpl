{extends file="theme.tpl"}

{block name="content"}
Index
    {new class="Article" name="cnt"}
    {$cnt->setPage({$smarty.get.page})}
    {$cnt->getData() assign="list"}
{foreach $list as $data}
<div class="list">
    <div class="title">{$data.Title}</div>
    <div class="text">{$data.Content}</div>
</div>
{/foreach}
{include file="pager/simple.tpl" class=$cnt}
{/block}