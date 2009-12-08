<?php
function smarty_function_get_link($params, &$smarty)
{
	return LinkHelper::getStaticLink($params['link']);
}

?>