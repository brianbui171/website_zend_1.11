(function(a){function bc(b,c){var d=a(b.doc.body).html(),f=b.options,g=f.updateTextArea,h=b.$area;if(g){var i=I(d);if(c&&b.frameChecksum==i)return;b.frameChecksum=i}var j=g?g(d):d;if(f.updateFrame)b.areaChecksum=I(j);if(j!=h.val()){h.val(j);a(b).triggerHandler(e)}}function bb(b,c){var d=b.$area.val(),f=b.options,g=f.updateFrame,h=a(b.doc.body);if(g){var i=I(d);if(c&&b.areaChecksum==i)return;b.areaChecksum=i}var j=g?g(d):d;j=j.replace(/<(?=\/?script)/ig,"<");if(f.updateTextArea)b.frameChecksum=I(j);if(j!=h.html()){h.html(j);a(b).triggerHandler(e)}}function ba(a){return a.$area.is(":visible")}function _(b,d,e){var f,h,i,j=a(d);if(e){var k=a(e);f=k.offset();h=--f.left;i=f.top+k.height()}else{var l=b.$toolbar;f=l.offset();h=Math.floor((l.width()-j.width())/2)+f.left;i=f.top+l.height()-2}R();j.css({left:h,top:i}).show();if(e){a.data(d,c,e);j.bind(g,{popup:d},a.proxy(H,b))}setTimeout(function(){j.find(":text,textarea").eq(0).focus().select()},100)}function $(a,b,c){var d=K("msg",a.options,v);d.innerHTML=b;_(a,d,c)}function Z(a){W(a);if(w)return O(a).text;return P(a).toString()}function Y(b){W(b);var c=O(b);if(w)return c.htmlText;var d=a("<layer>")[0];d.appendChild(c.cloneContents());var e=d.innerHTML;d=null;return e}function X(a){setTimeout(function(){if(ba(a))a.$area.select();else M(a,"selectall")},0)}function W(a){if(w&&a.range)a.range[0].select()}function V(b){if(!y&&a.browser.webkit&&!b.focused){b.$frame[0].contentWindow.focus();window.focus();b.focused=true}var c=b.doc;if(w)c=O(b);var e=ba(b);a.each(b.$toolbar.find("."+o),function(f,g){var i=a(g),j=a.cleditor.buttons[a.data(g,d)],k=j.command,l=true;if(b.disabled)l=false;else if(j.getEnabled){var m={editor:b,button:g,buttonName:j.name,popup:z[j.popupName],popupName:j.popupName,command:j.command,useCSS:b.options.useCSS};l=j.getEnabled(m);if(l===undefined)l=true}else if((e||y)&&j.name!="source"||w&&(k=="undo"||k=="redo"))l=false;else if(k&&k!="print"){if(w&&k=="hilitecolor")k="backcolor";if(!w||k!="inserthtml"){try{l=c.queryCommandEnabled(k)}catch(n){l=false}}}if(l){i.removeClass(p);i.removeAttr(h)}else{i.addClass(p);i.attr(h,h)}})}function U(b){var c=b.$main,d=b.options;if(b.$frame)b.$frame.remove();var e=b.$frame=a('<iframe frameborder="0" src="javascript:true;">').hide().appendTo(c);var f=e[0].contentWindow,g=b.doc=f.document,h=a(g);g.open();g.write(d.docType+"<html>"+(d.docCSSFile===""?"":'<head><link rel="stylesheet" type="text/css" href="'+d.docCSSFile+'" /></head>')+'<body style="'+d.bodyStyle+'"></body></html>');g.close();if(w)h.click(function(){N(b)});bb(b);if(w){h.bind("beforedeactivate beforeactivate selectionchange keypress",function(a){if(a.type=="beforedeactivate")b.inactive=true;else if(a.type=="beforeactivate"){if(!b.inactive&&b.range&&b.range.length>1)b.range.shift();delete b.inactive}else if(!b.inactive){if(!b.range)b.range=[];b.range.unshift(O(b));while(b.range.length>2)b.range.pop()}});e.focus(function(){W(b)})}(a.browser.mozilla?h:a(f)).blur(function(){bc(b,true)});h.click(R).bind("keyup mouseup",function(){V(b)});if(y)b.$area.show();else e.show();a(function(){var a=b.$toolbar,f=a.children("div:last"),g=c.width()-7;var h=f.offset().top+f.outerHeight()-a.offset().top+1;a.height(h);h=(/%/.test(""+d.height)?c.height():parseInt(d.height))-h-50;e.width(g).height(h);b.$area.width(g).height(x?h-2:h);L(b,b.disabled);V(b)})}function T(a){return"url("+S()+a+")"}function S(){var b="jquery.cleditor.css",c=a("link[href$='"+b+"']").attr("href");return c.substr(0,c.length-b.length)+"images/"}function R(){a.each(z,function(b,d){a(d).hide().unbind(g).removeData(c)})}function Q(a){var b=/rgba?\((\d+), (\d+), (\d+)/.exec(a),c=a.split("");if(b){a=(b[1]<<16|b[2]<<8|b[3]).toString(16);while(a.length<6)a="0"+a}return"#"+(a.length==6?a:c[1]+c[1]+c[2]+c[2]+c[3]+c[3])}function P(a){if(w)return a.doc.selection;return a.$frame[0].contentWindow.getSelection()}function O(a){if(w)return P(a).createRange();return P(a).getRangeAt(0)}function N(a){setTimeout(function(){if(ba(a))a.$area.focus();else a.$frame[0].contentWindow.focus();V(a)},0)}function M(a,b,c,d,e){W(a);if(!w){if(d===undefined||d===null)d=a.options.useCSS;a.doc.execCommand("styleWithCSS",0,d.toString())}var f=true,g;if(w&&b.toLowerCase()=="inserthtml")O(a).pasteHTML(c);else{try{f=a.doc.execCommand(b,0,c||null)}catch(h){g=h.description;f=false}if(!f){if("cutcopypaste".indexOf(b)>-1)$(a,"For security reasons, your browser does not support the "+b+" command. Try using the keyboard shortcut or context menu instead.",e);else $(a,g?g:"Error executing the "+b+" command.",e)}}V(a);return f}function L(a,b){if(b){a.$area.attr(h,h);a.disabled=true}else{a.$area.removeAttr(h);delete a.disabled}try{if(w)a.doc.body.contentEditable=!b;else a.doc.designMode=!b?"on":"off"}catch(c){}V(a)}function K(c,d,e,f,g){if(z[c])return z[c];var h=a(i).hide().addClass(r).appendTo("body");if(f)h.html(f);else if(c=="color"){var j=d.colors.split(" ");if(j.length<10)h.width("auto");a.each(j,function(c,d){a(i).appendTo(h).css(b,"#"+d)});e=t}else if(c=="font")a.each(d.fonts.split(","),function(b,c){a(i).appendTo(h).css("fontFamily",c).html(c)});else if(c=="size")a.each(d.sizes.split(","),function(b,c){a(i).appendTo(h).html("<font size="+c+">"+c+"</font>")});else if(c=="style")a.each(d.styles,function(b,c){a(i).appendTo(h).html(c[1]+c[0]+c[1].replace("<","</"))});else if(c=="url"){h.html('Enter URL:<br><input type=text value="http://" size=35><br><input type=button value="Submit">');e=u}else if(c=="pastetext"){h.html("Paste your content here and click submit.<br /><textarea cols=40 rows=3></textarea><br /><input type=button value=Submit>");e=u}if(!e&&!f)e=s;h.addClass(e);if(w){h.attr(k,"on").find("div,font,p,h1,h2,h3,h4,h5,h6").attr(k,"on")}if(h.hasClass(s)||g===true)h.children().hover(F,G);z[c]=h[0];return h[0]}function J(a){a.$area.val("");bb(a)}function I(a){var b=1,c=0;for(var d=0;d<a.length;++d){b=(b+a.charCodeAt(d))%65521;c=(c+b)%65521}return c<<16|b}function H(b){var e=this,f=b.data.popup,g=b.target;if(f===z.msg||a(f).hasClass(u))return;var h=a.data(f,c),i=a.data(h,d),j=B[i],k=j.command,l,m=e.options.useCSS;if(i=="font")l=g.style.fontFamily.replace(/"/g,"");else if(i=="size"){if(g.tagName=="DIV")g=g.children[0];l=g.innerHTML}else if(i=="style")l="<"+g.tagName+">";else if(i=="color")l=Q(g.style.backgroundColor);else if(i=="highlight"){l=Q(g.style.backgroundColor);if(w)k="backcolor";else m=true}var n={editor:e,button:h,buttonName:i,popup:f,popupName:j.popupName,command:k,value:l,useCSS:m};if(j.popupClick&&j.popupClick(b,n)===false)return;if(n.command&&!M(e,n.command,n.value,n.useCSS,h))return false;R();N(e)}function G(c){a(c.target).closest("div").css(b,"transparent")}function F(c){var e=a(c.target).closest("div");e.css(b,e.data(d)?"#FFF":"#FFC")}function E(b){var e=this,f=b.target,i=a.data(f,d),j=B[i],k=j.popupName,l=z[k];if(e.disabled||a(f).attr(h)==h)return;var m={editor:e,button:f,buttonName:i,popup:l,popupName:k,command:j.command,useCSS:e.options.useCSS};if(j.buttonClick&&j.buttonClick(b,m)===false)return false;if(i=="source"){if(ba(e)){delete e.range;e.$area.hide();e.$frame.show();f.title=j.title}else{e.$frame.hide();e.$area.show();f.title="Show Rich Text"}setTimeout(function(){V(e)},100)}else if(!ba(e)){if(k){var n=a(l);if(k=="url"){if(i=="link"&&Z(e)===""){$(e,"A selection is required when inserting a link.",f);return false}n.children(":button").unbind(g).bind(g,function(){var b=n.find(":text"),c=a.trim(b.val());if(c!=="")M(e,m.command,c,null,m.button);b.val("http://");R();N(e)})}else if(k=="pastetext"){n.children(":button").unbind(g).bind(g,function(){var a=n.find("textarea"),b=a.val().replace(/\n/g,"<br />");if(b!=="")M(e,m.command,b,null,m.button);a.val("");R();N(e)})}if(f!==a.data(l,c)){_(e,l,f);return false}return}else if(i=="print")e.$frame[0].contentWindow.print();else if(!M(e,m.command,m.value,m.useCSS,f))return false}N(e)}a.cleditor={defaultOptions:{width:500,height:250,controls:"bold italic underline strikethrough subscript superscript | font size "+"style | color highlight removeformat | bullets numbering | outdent "+"indent | alignleft center alignright justify | undo redo | "+"rule image link unlink | cut copy paste pastetext | print source",colors:"FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF "+"CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F "+"BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C "+"999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C "+"666 900 C60 C93 990 090 399 33F 60C 939 "+"333 600 930 963 660 060 366 009 339 636 "+"000 300 630 633 330 030 033 006 309 303",fonts:"Arial,Arial Black,Comic Sans MS,Courier New,Narrow,Garamond,"+"Georgia,Impact,Sans Serif,Serif,Tahoma,Trebuchet MS,Verdana",sizes:"1,2,3,4,5,6,7",styles:[["Paragraph","<p>"],["Header 1","<h1>"],["Header 2","<h2>"],["Header 3","<h3>"],["Header 4","<h4>"],["Header 5","<h5>"],["Header 6","<h6>"]],useCSS:false,docType:'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',docCSSFile:"",bodyStyle:"margin:4px; font:10pt Arial,Verdana; cursor:text"},buttons:{init:"bold,,|"+"italic,,|"+"underline,,|"+"strikethrough,,|"+"subscript,,|"+"superscript,,|"+"font,,fontname,|"+"size,Font Size,fontsize,|"+"style,,formatblock,|"+"color,Font Color,forecolor,|"+"highlight,Text Highlight Color,hilitecolor,color|"+"removeformat,Remove Formatting,|"+"bullets,,insertunorderedlist|"+"numbering,,insertorderedlist|"+"outdent,,|"+"indent,,|"+"alignleft,Align Text Left,justifyleft|"+"center,,justifycenter|"+"alignright,Align Text Right,justifyright|"+"justify,,justifyfull|"+"undo,,|"+"redo,,|"+"rule,Insert Horizontal Rule,inserthorizontalrule|"+"image,Insert Image,insertimage,url|"+"link,Insert Hyperlink,createlink,url|"+"unlink,Remove Hyperlink,|"+"cut,,|"+"copy,,|"+"paste,,|"+"pastetext,Paste as Text,inserthtml,|"+"print,,|"+"source,Show Source"},imagesPath:function(){return S()}};a.fn.cleditor=function(b){var c=a([]);this.each(function(d,e){if(e.tagName=="TEXTAREA"){var g=a.data(e,f);if(!g)g=new cleditor(e,b);c=c.add(g)}});return c};var b="backgroundColor",c="button",d="buttonName",e="change",f="cleditor",g="click",h="disabled",i="<div>",j="transparent",k="unselectable",l="cleditorMain",m="cleditorToolbar",n="cleditorGroup",o="cleditorButton",p="cleditorDisabled",q="cleditorDivider",r="cleditorPopup",s="cleditorList",t="cleditorColor",u="cleditorPrompt",v="cleditorMsg",w=a.browser.msie,x=/msie\s6/i.test(navigator.userAgent),y=/iphone|ipad|ipod/i.test(navigator.userAgent),z={},A,B=a.cleditor.buttons;a.each(B.init.split("|"),function(a,b){var c=b.split(","),d=c[0];B[d]={stripIndex:a,name:d,title:c[1]===""?d.charAt(0).toUpperCase()+d.substr(1):c[1],command:c[2]===""?d:c[2],popupName:c[3]===""?d:c[3]}});delete B.init;cleditor=function(b,c){var e=this;e.options=c=a.extend({},a.cleditor.defaultOptions,c);var h=e.$area=a(b).hide().data(f,e).blur(function(){bb(e,true)});var j=e.$main=a(i).addClass(l).width(c.width).height(c.height);var p=e.$toolbar=a(i).addClass(m).appendTo(j);var r=a(i).addClass(n).appendTo(p);a.each(c.controls.split(" "),function(b,f){if(f==="")return true;if(f=="|"){var h=a(i).addClass(q).appendTo(r);r=a(i).addClass(n).appendTo(p)}else{var j=B[f];var l=a(i).data(d,j.name).addClass(o).attr("title",j.title).bind(g,a.proxy(E,e)).appendTo(r).hover(F,G);var m={};if(j.css)m=j.css;else if(j.image)m.backgroundImage=T(j.image);if(j.stripIndex)m.backgroundPosition=j.stripIndex*-24;l.css(m);if(w)l.attr(k,"on");if(j.popupName)K(j.popupName,c,j.popupClass,j.popupContent,j.popupHover)}});j.insertBefore(h).append(h);if(!A){a(document).click(function(b){var c=a(b.target);if(!c.add(c.parents()).is("."+u))R()});A=true}if(/auto|%/.test(""+c.width+c.height))a(window).resize(function(){U(e)});U(e)};var C=cleditor.prototype,D=[["clear",J],["disable",L],["execCommand",M],["focus",N],["hidePopups",R],["sourceMode",ba,true],["refresh",U],["select",X],["selectedHTML",Y,true],["selectedText",Z,true],["showMessage",$],["updateFrame",bb],["updateTextArea",bc]];a.each(D,function(a,b){C[b[0]]=function(){var a=this,c=[a];for(var d=0;d<arguments.length;d++){c.push(arguments[d])}var e=b[1].apply(a,c);if(b[2])return e;return a}});C.change=function(b){var c=a(this);return b?c.bind(e,b):c.trigger(e)}})(jQuery)