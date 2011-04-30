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
		parent::Markdown_Parser();
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