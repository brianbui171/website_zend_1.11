<!--div class="box_right">
<embed type="application/x-shockwave-flash" src="/public/jwplayer/player.swf" width="298" height="268" style="undefined" id="ply" name="ply" bgcolor="#000000" quality="high" allowfullscreen="true" allowscriptaccess="always" wmode="opaque" flashvars="file=/public/files/videos/donga.flv&amp;autostart=false&amp;image=/public/images/dongafilm.jpg">
</embed>
</div-->
<div class="clr"></div>
<div class="ui-tabs ui-widget ui-widget-content ui-corner-all" id="tabs">
<ul
	class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
	<li
		class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active">
	<a href="#popular">Xem nhiều nhất</a></li>
</ul>
<div class="ui-tabs-panel ui-widget-content ui-corner-bottom"
	id="popular">
<ul class="popular">
	<?php
		$index = 1;
		foreach ( $rows as $val ) {
			$linkDetail = $view->baseUrl('/donga/index/view-detail/catid/'.$val['parents'].'/id/'. $val['news_id']);
	?>
	<li><a href="<?php echo $linkDetail;?>"><span><?php echo $index;?>.</span>
	<?php
		echo $val ['title_news']?></a></li>
	 <?php
	 	$index ++;
		}
	?>					
</ul>
</div>
</div>
