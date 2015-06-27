<?php
echo $this->doctype ()?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  	<?php
			echo $this->headTitle ()?>
    <?php
			echo $this->headMeta ()?>
	<link rel="shortcut icon" href="<?php echo $this->imgUrl;?>/favicon.ico" type="image/x-icon" />
	<?php
	echo $this->headLink ()?>

	<?php
	echo $this->headScript ()?>
	<!--[if IE]>
<link rel="stylesheet" type="text/css" href="/public/templates/public/donga/css/style_ie.css"/>
<![endif]-->
</head>
<body>
<center>
<div class="header" align="center">
<div class="top">
<p style="float:left; margin-left:0px;">Hotline: 090 313 0817</p>
<p><script type="text/javascript">
        			showdate();
				</script></p>
<ul></ul>
</div>
</div>
<div class="clr"></div>
<div class="frame_bane" align="left">
<div class="bane" style="position: relative;">
<img style="position: absolute; top: 0px; left: 0px; width: 160px;" src="<?php echo $this->imgUrl;?>/logo_kimdong.png" />
<!--[if !IE]> --> 
	<object
		type="application/x-shockwave-flash"
		data="<?php	echo $this->imgUrl;	?>/banner.swf"
		width="1000" height="147"> 
	<!-- <![endif]--> <!--[if IE]>
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
		codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
		width="1000" height="147">
		<param name="movie" value="<?php	echo $this->imgUrl;	?>/banner.swf" />
		<param name=quality value=high>
		<param name=wmode value=transparent>
	<!--><!--dgx-->
		<param name="loop" value="true" />
		<param name="menu" value="false" />
		<param name=quality value=high>
		<param name=wmode value=transparent>
		<p>This is <b>alternative</b> content.</p>
	</object> <!-- <![endif]-->
</div>
</div>
<div class="clr"></div>
<div class="wrapage">
<div class="frame_menu">
<div class="menu">
<ul>
	<li <?php if($this->arrParam['catid'] == ''){?>class="active"<?php }?>>
		<a href="<?php	echo $this->baseUrl ( '/default/index/index' );?>">Trang chủ</a>
	</li>
	<li <?php if($this->arrParam['catid'] == 2){?>class="active"<?php }?>>
		<a href="<?php	echo $this->baseUrl ( '/donga/index/category/catid/2' );?>">Giới thiệu</a>
		<ul style="left:20px;">			
			<li><a href="<?php echo $this->baseUrl ( '/donga/index/view-detail/catid/2/id/66' );?>" name="category" id="29">Mục tiêu đào tạo</a></li>
			<li><a href="<?php echo $this->baseUrl ( '/donga/index/view-detail/catid/2/id/67' );?>" name="category" id="29">Cơ sở vật chất</a></li>			
			<li><a href="<?php echo $this->baseUrl ( '/donga/index/view-detail/catid/2/id/68' );?>" name="category" id="29">Nhân sự</a></li>
		</ul>
	</li>
	<li <?php if($this->arrParam['catid'] == 10){?>class="active"<?php }?>>
		<a href="<?php	echo $this->baseUrl ( '/donga/index/view-detail/catid/10/id/70' );?>">Chương trình học</a>		
	</li>
	<li <?php if($this->arrParam['catid'] == 16){?>class="active"<?php }?>>
		<a href="<?php	echo $this->baseUrl ( '/donga/index/category/catid/16' );?>">Tin tức - Sự kiện</a>
		<ul style="width: 500px;left:220px;">
			<li><a href="<?php echo $this->baseUrl ( '/donga/index/category-child/catid/16/id/17' );?>" name="category" id="29">Thông báo</a></li>					
			<li><a href="<?php echo $this->baseUrl ( '/donga/index/category-child/catid/16/id/21' );?>" name="category" id="29">Sự kiện</a></li>
			<li><a href="<?php echo $this->baseUrl ( '/donga/index/category-child/catid/16/id/20' );?>" name="category" id="29">Thực đơn của bé</a></li>
			<li><a href="<?php echo $this->baseUrl ( '/donga/index/category-child/catid/16/id/18' );?>" name="category" id="29">Thông tin cho mẹ & bé</a></li>
		</ul>
	</li>
	<li <?php if($this->arrParam['catid'] == 22){?>class="active"<?php }?>>
		<a href="<?php	echo $this->baseUrl ( '/donga/index/category/catid/22' );?>">Tuyển sinh</a>
		<ul style="width: 600px;left:340px;">
			<li><a href="<?php echo $this->baseUrl ( '/donga/index/category-child/catid/22/id/26' );?>" name="category" id="29">Thông tin tuyển sinh</a></li>
			<li><a href="<?php echo $this->baseUrl ( '/donga/index/category-child/catid/22/id/25' );?>" name="category" id="29">Biểu phí & các khoản phải nộp</a></li>
			<li><a href="<?php echo $this->baseUrl ( '/donga/index/category-child/catid/22/id/24' );?>" name="category" id="29">Lưu ý dành cho phụ huynh</a></li>
		</ul>
	</li>
	<li <?php if($this->arrParam['catid'] == 28){?>class="active"<?php }?>>
		<a href="<?php	echo $this->baseUrl ( '/donga/album/index/catid/28' );?>">Thư viện ảnh</a>	
	</li>
	<li <?php if($this->arrParam['catid'] == 43){?>class="active"<?php }?>>
		<a href="<?php	echo $this->baseUrl ( '/donga/index/category/catid/43' );?>">Camera</a>
	</li>
	<li <?php if($this->arrParam['catid'] == 37){?>class="active"<?php }?>>
		<a href="<?php	echo $this->baseUrl ( '/donga/contact/index/catid/37/id/40' );?>">Liên hệ</a>
		<ul style="width: 130px;left:755px;">
			<li><a href="<?php echo $this->baseUrl ( '/donga/index/category-child/catid/37/id/38' );?>" name="category" id="29">Bản đồ</a></li>			
			<li><a href="<?php echo $this->baseUrl ( '/donga/contact/answer/catid/37' );?>" name="category" id="29">Hỏi - Đáp</a></li>
		</ul>
	</li>
	<li <?php if($this->arrParam['catid'] == 41){?>class="active"<?php }?>>
		<a href="<?php	echo $this->baseUrl ( '/donga/index/category/catid/41' );?>">Tuyển dụng</a>
	</li>
</ul>
</div>
</div>
<div class="clr"></div>
<div class="frame_menu_2">
<div class="menu_2"></div>
</div>
<div class="clr"></div>