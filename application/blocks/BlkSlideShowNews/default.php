<script type="text/javascript">
$(document).ready(function(){
	var a={next:$("#lofslidecontent45 .lof-previous"),
			previous:$("#lofslidecontent45 .lof-next")};
			$obj=$("#lofslidecontent45").lofJSidernews({
					interval:4000,
					direction:"opacity",
					easing:"easeInOutExpo",
					duration:2000,
					auto:true,
					maxItemDisplay:5,
					navPosition:"horizontal",
					navigatorHeight:52,
					navigatorWidth:74,
					mainWidth:426,
					buttons:a});
			});
</script>

<div id="lofslidecontent45" class="lof-slidecontent"
	style="width: 426px; height: 368px; float: left; margin-left: 13px; margin-top: 10px;">
<div style="display: none;" class="preload">
<div></div>
</div>
<div class="lof-main-outer" style="width: 426px; height: 368px;">
<ul class="lof-main-wapper lof-opacity">
		<?php
		foreach ( $rows as $val ) {
			$linkDetail = $view->baseUrl('/donga/index/view-detail/catid/'.$val['parents'].'/id/'. $val['news_id']);
		?>
            <li style="display: none;"><a target="_parent"
		title="<?php
			echo $val ['title_news']?>" href="<?php echo $linkDetail;?>"> <img
		src="<?php
			echo FILES_URL . '/news/img_big/' . $val ['img_news_big']?>"
		alt="<?php
			echo $val ['title_news']?>"
		title="<?php
			echo $val ['title_news']?>" width="426" height="306">\ </a>
	<div class="lof-main-item-desc">
	<h2><a target="_parent" title="<?php
			echo $val ['title_news']?>"
		href="<?php echo $linkDetail;?>"><?php
			echo $val ['title_news']?></a></h2>
	<p><?php
			//echo $val ['SUMARY_NEWS']?></p>
	</div>
	</li>
            <?php
		}
		?>
    	</ul>
</div>
<div class="lof-navigator-wapper">
<div onclick="return false" href="" class="lof-next">Next</div>
<div style="width: 370px; height: 52px;" class="lof-navigator-outer">
<ul style="width: 518px; left: 0px;" class="lof-navigator">
			<?php
			foreach ( $rows as $val ) {
				?>
            	<li style="height: 52px; width: 74px;" rel="1" class=""><a
		onclick="return false" href="" class="item"> <img
		src="<?php
				echo FILES_URL . '/news/img_small/' . $val ['img_news_sml']?>"
		alt="<?php
				echo $val ['title_news']?>" width="70" height="48"> </a></li>      
           <?php
			}
			?>          
        	</ul>
</div>
<div onclick="return false" href="" class="lof-previous">Previous</div>
</div>
</div>