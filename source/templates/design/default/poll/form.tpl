<div id="poll" class="box">
	<div class="title">{"poll"|lang}</div>
	<div class="body">
		<div id="question">
			{$category[0].Description}
		</div>
		<div id="questions">
			<form method='POST'>
				{foreach from=$items item=item}
					<input type='radio' name='vote' value='{$item.ID}'>&nbsp;{$item.Name}<br />
				{/foreach}
				<br />
				<center>
				<input type="hidden" name="poll_id" value="{$poll_id}">
				<input type='submit' name='vote_submit' value='{lang Ok}'>&nbsp;&nbsp;&nbsp;
				<input type='button' value='{lang poll_results}'onClick="location.replace('/index.php?mod=poll&id={$category[0].ID}&voted=1'); return false;">
				</center>


			</form>
		</div>
	</div>
</div>