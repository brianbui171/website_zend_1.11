$(document).ready(function() {
	menu = $(".menu");
	if (menu) {
		var a = "";
		menu.mouseover(function() {
			a = $(".menu > ul > li.active");
			$(".menu > ul > li").removeClass()
		});
		menu.mouseout(function() {
			a.toggleClass("active")
		})
	}
	var b = $("#notice_item");
	if (b) {
		var c = 0;
		var d = new Array;
		$("#notice_item > span").each(function() {
			d[c] = $(this).html();
			c++
		});
		c--;
		b.html(" ");
		if (c > 0) {
			b.html("<span>" + d[0] + "</span>");
			b.fadeIn("slow");
			var e = 1;
			setInterval(function() {
				b.fadeOut("fast");
				b.html("<span>" + d[e] + "</span>");
				b.fadeIn("slow");
				if (e >= c) {
					e = 0
				} else {
					e++
				}
			}, 1e4)
		}
	}
})

	function showdate(){
    	var dayName = new Array ("Chủ nhật","Thứ hai","Thứ ba","Thứ tư","Thứ năm","Thứ sáu","Thứ bảy");
    	 var monName = new Array ("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
    	 var now = new Date;
    	 var year = now.getYear()+1900;
    	 var day = now.getDate();
    	 if(day == 1){day = "01";}
     	if(day == 2){day = "02";}
     	if(day == 3){day = "03";}
     	if(day == 4){day = "04";}
     	if(day == 5){day = "05";}
     	if(day == 6){day = "06";}
     	if(day == 7){day = "07";}
     	if(day == 8){day = "08";}
     	if(day == 9){day = "09";}
    	 var hour = now.getHours();
    	if(hour == 1){hour = "01";}
    	if(hour == 2){hour = "02";}
    	if(hour == 3){hour = "03";}
    	if(hour == 4){hour = "04";}
    	if(hour == 5){hour = "05";}
    	if(hour == 6){hour = "06";}
    	if(hour == 7){hour = "07";}
    	if(hour == 8){hour = "08";}
    	if(hour == 9){hour = "09";}
    	var min = now.getMinutes();
    	if(min == 1){min = "01";}
    	if(min == 2){min = "02";}
    	if(min == 3){min = "03";}
    	if(min == 4){min = "04";}
    	if(min == 5){min = "05";}
    	if(min == 6){min = "06";}
    	if(min == 7){min = "07";}
    	if(min == 8){min = "08";}
    	if(min == 9){min = "09";}
    	var second= now.getSeconds();
    	if(second== 1){second= "01";}
    	if(second== 2){second= "02";}
    	if(second== 3){second= "03";}
    	if(second== 4){second= "04";}
    	if(second== 5){second= "05";}
    	if(second== 6){second= "06";}
    	if(second== 7){second= "07";}
    	if(second== 8){second= "08";}
    	if(second== 9){second= "09";} 
    	document.write(dayName[now.getDay()] + ", "+day+"/"+monName[now.getMonth()]+"/"+year+" , "+hour+":"+min);	
	}