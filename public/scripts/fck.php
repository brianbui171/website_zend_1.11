<?php

//1. Nhung tap tin fckeditor vao file chay
include ("fckeditor/fckeditor.php");

//2. Khai bao duong dan URL den thu muc fckeditor
$sBasePath = '/test-scripts/fckeditor/';

//3. Khoi tao doi tuong FCKeditor
$oFCKeditor = new FCKeditor ( 'FCKeditor1' );

//4. Thiet lap duong den cho thuong BasePath
$oFCKeditor->BasePath = $sBasePath;

//Dua gia tri vao Editor
$oFCKeditor->Value = 'Huong dan cau hinh FCKeditor ';

//Thay doi kich thuoc cua Editor
$oFCKeditor->Width = '100%';
$oFCKeditor->Height = 400;
$oFCKeditor->ToolbarSet = 'Default';
$oFCKeditor->Config ['AutoDetectLanguage'] = false;
$oFCKeditor->Config ['DefaultLanguage'] = 'en';

//5. Tao FCKeditor
$oFCKeditor->Create ();