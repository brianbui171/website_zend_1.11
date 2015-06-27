<div class="list_post" align="left">
<div class="title_post">Tin tức nổi bật</div>
<ul>
		<?php
		foreach ( $rows as $val ) {
			$linkDetail = $view->baseUrl('/donga/index/view-detail/catid/'.$val['parents'].'/id/'. $val['news_id']);
			?>
        	<li><a href="<?php echo $linkDetail?>"><?php
			echo $val ['title_news'];
			?></a></li>  
        <?php
		}
		?>          
		</ul>
</div>