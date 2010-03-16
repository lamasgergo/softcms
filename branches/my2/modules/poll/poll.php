<?php
$mod_name = "poll";

require_once(MODULES_DIR."/".$mod_name."/poll.class.php");

$poll = new Poll($mod_name, $block_vars, $dynamic);
$output = $poll->show();
?>