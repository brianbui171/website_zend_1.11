<?php 
    $linkGroupManager = $this->baseUrl('/default/admin-group/index/');
    $linkPermission = $this->baseUrl('/default/admin-permission/index/');
?>
<div id="submenu-box">
                            <div style="border:1px solid #CCCCCC; padding:5px">
                                <ul id="submenu">
                                    <li>
                                        <a href="<?php echo $linkGroupManager;?>">Quản lý nhóm</a>
                                    </li>
                                    <li>
                                        <a href="#" class="active">Quản lý thành viên</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $linkPermission;?>">Quản lý phân quyền</a>
                                    </li>
                                </ul>
                                <div class="clr"></div>
                            </div>
                        </div>	