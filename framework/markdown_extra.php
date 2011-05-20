<?php
require("markdown.php");
require_once("file-storage.php");

/**
 * Sorbet + Markdown = <3
 * This is an expansion of Markdown Extra!
 * Basically adding Sorbet specific stuff :)
 * @author kennydude
 *
 */
class SorbetMarkdown extends MarkdownExtra_Parser{
	function SorbetMarkdown() {
		$this->span_gamut += array(
			"doSorbetAutoLinks" => 32
		);
		$this->block_gamut += array(
			"doSorbetEmbeds" => 80
		);
		parent::Markdown_Parser();
	}
	
	function doSorbetEmbeds($text){
		$text = preg_replace_callback('/^\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]$/im', 
			array(&$this, '_doSorbetEmbeds_callback'), $text);
		return $text;
	}
	
	function _doSorbetEmbeds_callback($matches){
		$types = get_embed_types();
		$url = parse_url($matches[0]);
		if(isset($types[$url['host']])){
			$parser = $types[$url['host']];
			$link = $parser::embed($matches[0]);
			return $this->hashPart($link);
		}
		return $matches[0];
	}
	
	function doSorbetAutoLinks($text){
		$text = preg_replace_callback('{<((sorbet):[^\'">\s]+)>}i', 
			array(&$this, '_doSorbetAutoLinks_url_callback'), $text); // Sorbet://protocol
		return $text;
	}
	
	function _doSorbetAutoLinks_url_callback($matches) {
		$url = $this->encodeAttribute($matches[1]);
		$file = File::getFromSorbetUrl($url);
		$link = "<a href=\"".$file->get_url()."\">".$file->get_thumbnail()->render_html()."</a>";
		return $this->hashPart($link);
	}
}