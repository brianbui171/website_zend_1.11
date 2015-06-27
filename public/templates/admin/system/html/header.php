<?php
echo $this->doctype ()?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <?php
			echo $this->headTitle ()?>
        <?php
			echo $this->headMeta ()?>
	    <?php
			echo $this->headLink ()?>

	    <?php
			echo $this->headScript ()?>
    </head>
<body id="minwidth-body">
<div id="border-top" class="h_green">
<div>
<div><span class="version">Version 1.0</span> <span class="title"
	style="padding-left: 20px">Mầm Non Kim Đồng CMS</span></div>
</div>
</div>
<div id="header-box">
<div id="module-status"><span class="preview"> <a target="_blank"
	href="#">Preview</a> </span> <a href="#"> <span
	class="no-unread-messages">0</span> </a> <span class="loggedin-users">1</span>
<span class="logout"> <a
	href="<?php
	echo $this->baseUrl ();
	?>/default/public/logout/">Đăng xuất</a>
</span></div>
<div id="module-menu"><!-- BEGIN: Menu -->
<ul class="menuTiny" id="menuTiny">
	<li><a href="#" class="menuTinyLink">Chuyển đến</a>
	<ul>
		<li><a href="<?php
		echo $this->baseUrl ();
		?>/default/index/index/">Trang chủ</a></li>
		<li><a href="<?php
		echo $this->baseUrl ();
		?>/default/admin/index">Quản trị</a></li>

	</ul>
	</li>
	<li><a href="#" class="menuTinyLink">Thành viên</a>
	<ul>
		<li><a
			href="<?php
			echo $this->baseUrl ();
			?>/default/admin-group/index/">Quản lý nhóm</a></li>
		<li><a href="<?php
		echo $this->baseUrl ();
		?>/default/admin-user/index/">Quản lý thành viên</a></li>
	</ul>
	</li>
	<li><a href="#" class="menuTinyLink">Chuyên mục</a>
	<ul>
		<li><a
			href="<?php
			echo $this->baseUrl ();
			?>/donga/admin-category/index/">Quản lý chuyên mục</a></li>
		<li><a
			href="<?php
			echo $this->baseUrl ();
			?>/donga/admin-news/index/">Quản lý bài viết</a></li>
		<li><a
			href="<?php
			echo $this->baseUrl ();
			?>/donga/admin-album/index/">Quản lý hình ảnh</a></li>		
		<li><a
			href="<?php
			echo $this->baseUrl ();
			?>/donga/admin-contact/index/">Hỏi - Đáp</a></li>
	</ul>
	</li>	
</ul>

<script type="text/javascript">
                    var menu=new menu.dd("menu");
                    menu.init("menuTiny","menuTinyHover");
                </script><!-- END: Menu --></div>
<div class="clr"></div>
</div>