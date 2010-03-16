<?php

	require_once(dirname(__FILE__).'/magpierss/rss_fetch.inc'); 
	
	$url = 'http://news.liga.net/news/rss.xml';

	$limit = 3;
	
	$rss = fetch_rss($url);
 
	$items = $rss->items;
	
	$items = array_reverse($items);
	
	foreach ($items as $item ) {
			$items[] = array(
				"NEWS_ID"     => $item['news_id'],
				"title"     => $item['title'],
				"link"      => $item['link'],
				"pubDate"   => $item['pubdate'],
				"description" => $item['description'],
				"category"   => $item['category']
				);
	}
	
	$items = array_reverse($items);
	$news = array();
	
	$i=1;
	foreach ($items as $item){
		if ($i<=$limit){
			$news[] = $item;
		}
		$i++;
	}
	
	$this->smarty->assign("news_arr",$news);
	$output = $this->smarty->fetch('news/news.tpl',null,$language);
?>