<?php 
    $linkCategoryManager = $this->baseUrl('/donga/admin-category/index/');
    $linkNewsManager = $this->baseUrl('/donga/admin-news/index/');
    $linkImageManager = $this->baseUrl('/donga/admin-album/index/');
    $linkVideoManager = $this->baseUrl('/donga/admin-video/index/');
    $linkQA = $this->baseUrl('/donga/admin-contact/index/');
    $linkResourceManage = $this->baseUrl('/donga/admin-doc/index/');
?>
<div id="submenu-box">
                            <div style="border:1px solid #CCCCCC; padding:5px">
                                <ul id="submenu">
                                    <li>
                                        <a href="<?php echo $linkCategoryManager;?>" >Quản lý chuyên mục</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $linkNewsManager;?>" >Quản lý bài viết</a>
                                    </li>
                                    <li>
                                        <a href="#" class="active">Quản lý hình ảnh</a>
                                    </li>                                   
                                    <li>
                                        <a href="<?php echo $linkQA;?>">Hỏi - Đáp</a>
                                    </li>
                                </ul>
                                <div class="clr"></div>
                            </div>
                        </div>	