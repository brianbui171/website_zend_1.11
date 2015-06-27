<style>
<!--
#advert-ph{
	position: relative;
	font-family: times New Roman;
}
#advert-ph-ts{
	font-size: 19px;
    padding-left: 55px;
    padding-top: 76px;
    position: absolute;
    z-index: 999;
}
#advert-ph-hp{
	font-size: 19px;
    padding-left: 55px;
    padding-top: 112px;
    position: absolute;
    z-index: 888;
}
#advert-ph-ct{
	font-size: 19px;
    padding-left: 55px;
    padding-top: 148px;
    position: absolute;
    z-index: 777;
}
#advert-ph-dv{
	font-size: 19px;
    padding-left: 55px;
    padding-top: 186px;
    position: absolute;
    z-index: 666;
}
#advert-ph-nt{
	font-size: 19px;
    padding-left: 55px;
    padding-top: 222px;
    position: absolute;
    z-index: 555;
}

-->
</style>
<?php 
	$linkDetail1 = $view->baseUrl('/donga/index/category-child/catid/22/id/26');
	$linkDetail2 = $view->baseUrl('/donga/index/category-child/catid/22/id/25');
	$linkDetail3 = $view->baseUrl('/donga/index/category-child/catid/10/id/12');
	$linkDetail4 = $view->baseUrl('/donga/index/category-child/catid/16/id/20');
	$linkDetail5 = $view->baseUrl('/donga/index/category/catid/43');
?>
<div <?php
		if($flagShow == false) {
			echo 'class="box_advert"';
		} else {
			echo 'class="advert"';
		}
	?>>
<ul>
	<li>	
		<div id="advert-ph">
			<div id="advert-ph-ts">
				<a href="<?php echo $linkDetail1;?>">Thông tin tuyển sinh</a>
			</div>
			<div id="advert-ph-hp">
				<a href="<?php echo $linkDetail2;?>">Học phí</a>
			</div>
			<div id="advert-ph-ct">
				<a href="<?php echo $linkDetail3;?>">Chương trình chính khóa</a>
			</div>
			<div id="advert-ph-dv">
				<a href="<?php echo $linkDetail4;?>">Thực đơn của bé</a>
			</div>
			<div id="advert-ph-nt">
				<a href="<?php echo $linkDetail5;?>">Camera quan sát</a>
			</div>
			<div id="advert-ph-bg">
				<img src="<?php echo $view->imgUrl;?>/phuhuynhquantam.jpg">
			</div>
		</div>
	</li>
</ul>
</div>
