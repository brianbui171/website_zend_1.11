<?php 
    //1. Active Items - submit
    $linkActiveItems     = $this->baseUrl($this->currentController . '/status/type/1');
    $btnActiveItems      = $this->cmsButton('Active Items',$linkActiveItems,
                                        $this->imgUrl . '/toolbar/icon-32-active.png','submit');
    //2. Inactive Items - submit
    $linkInactiveItems   = $this->baseUrl($this->currentController . '/status/type/0');
    $btnInactiveItems    = $this->cmsButton('Inactive Items',$linkInactiveItems,
                                        $this->imgUrl . '/toolbar/icon-32-inactive.png','submit'); 
    //3. Add new Item - link
    $linkAddItems        = $this->baseUrl($this->currentController . '/add');
    $btnAddItems         = $this->cmsButton('Add Item',$linkAddItems,
                                        $this->imgUrl . '/toolbar/icon-32-new.png','link');  
    
    //5. Delete Items - submit
    $linkDeleteItems     = $this->baseUrl($this->currentController . '/multi-delete');
    $btnDeleteItems      = $this->cmsButton('Delete Items',$linkDeleteItems,
                                        $this->imgUrl . '/toolbar/icon-32-delete.png','submit');
    //6. Save Item - submit
    if($this->arrParams['action'] == 'add'){
        $linkSaveItem    = $this->baseUrl($this->currentController . '/add');
    }else{
        $linkSaveItem    = $this->baseUrl($this->currentController . '/edit/id/' . $this->item['id']);
    }
    
    $btnSaveItem         = $this->cmsButton('Save Item',$linkSaveItem,
                                        $this->imgUrl . '/toolbar/icon-32-save.png','submit');
    //8. Cancel - link
    $linkCancel          = $this->baseUrl($this->currentController . '/index');
    $btnCancel           = $this->cmsButton('Cancel',$linkCancel,
                                        $this->imgUrl . '/toolbar/icon-32-cancel.png','link');
    //9. Edit Item - link
    $linkEditItem        = $this->baseUrl($this->currentController . '/edit/id/' . $this->item['id']);
    $btnEditItem         = $this->cmsButton('Edit Item',$linkEditItem,
                                        $this->imgUrl . '/toolbar/icon-32-edit.png','link');                                    
    //10. Back - link
    $linkBack            = $this->baseUrl($this->currentController . '/index');
    $btnBack             = $this->cmsButton('Back',$linkBack,
                                        $this->imgUrl . '/toolbar/icon-32-back.png','link');
    //11. Accept - link
    $linkAccept          = $this->baseUrl($this->currentController . '/delete/id/' . $this->arrParams['id']);
    $btnAccept           = $this->cmsButton('Accept',$linkAccept,
                                        $this->imgUrl . '/toolbar/icon-32-accept.png','submit');                                    
    switch ($this->arrParams['action']) {
        case 'index':
        $strBtn = $btnActiveItems . ' ' . $btnInactiveItems . ' ' . $btnAddItems . ' ' . $btnDeleteItems;
        break;
        case 'add':
        $strBtn = $btnSaveItem . ' ' . $btnCancel;
        break;
        case 'edit':
        $strBtn = $btnSaveItem . ' ' . $btnCancel;
        break;
        case 'info':
        $strBtn = $btnEditItem . ' ' . $btnBack;
        break;
        case 'delete':
        $strBtn = $btnAccept . ' ' . $btnCancel;
        break;
        default:
        $strBtn = '';
        break;
    }
?>
<div id="toolbar-box">
                            <div class="t"><div class="t"><div class="t"></div></div></div>
                            <div class="m">
                                <div id="toolbar" class="toolbar" >	
                                  <?php echo $strBtn;?>
                                  <div class="clr"></div>
                                </div>
                                <div class="header icon-48-install"><?php echo $this->Title;?></div>
                                
                                <div class="clr"></div>
                            </div>
                            <div class="b"><div class="b"><div class="b"></div></div></div>
                        </div>