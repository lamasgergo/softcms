<?php

if ($stream = fopen('http://news.liga.net/news/rss.xml', 'r')) {
    $text = stream_get_contents($stream, -1);
    fclose($stream);
}

echo $text;
?>