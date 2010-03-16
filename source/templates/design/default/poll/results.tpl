<div id="poll" class="box">
	<div class="title">{"poll"|lang}</div>
	<div class="body">
		<div id="question">
			{$category[0].Description}
		</div>
		<div id="questions" style="width: 150px;">
			{foreach from=$items item=item}
			{$item.Name} {$item.Persent}%<br />
			<img src='/source/images/poll/bar.gif' width='{$item.Persent}*150/100px;' height='5'><br />
			{/foreach}
		</div>
	</div>
</div>