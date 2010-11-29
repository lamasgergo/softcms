{assign var=total value=ceil($class->totalRecords/$class->perPage)}
{if $total}
    <div class="pager">
        {for $page=1 to $total}
            {assign var="pageLink" value=PageHelper::changeLinkParam('', 'page', $page)}
            <a href="{$pageLink}"{if $smarty.get.page==$page} class="selected"{/if}>{$page}</a>&nbsp;
        {/for}
    </div>
{/if}