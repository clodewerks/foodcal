var foodCal = {
	today: new Date(),
	day:0,
	month:0,
	year:0,
	meals:{},
	dayNames:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
	monthNames:["","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
	mealList:"",
	monthNav:function(dir){
		var newMonth = this.month + dir;
		if(newMonth == -1){
		 newMonth = 11;
		 this.year--;
		}
		if(newMonth == 12) {
			newMonth = 0;
			this.year++;
		}
		var url = window.location.pathname + "?view=m&" +"month=" + newMonth + "&year=" + this.year;
		window.location = url;
	},
	monthInit:function(){
		$('#monthName').html(this.monthNames[this.month] +", "+this.year);
		$('#prevMonth').click(function(){foodCal.monthNav(-1);});
		$('#nextMonth').click(function(){foodCal.monthNav(1)});
		$.get( "./jsonservices/getDates.php?month="+foodCal.month+"&year="+foodCal.year, function( data ) {
		 eval(data);
		 	foodCal.meals = meals;
		 	if(meals.length < 14)  $.post("./jsonservices/addDates.php?month="+foodCal.month+"&year="+foodCal.year,function(){window.location = window.location})
		 	$(".dateRow").remove();
		 	for (var i=0; i<meals.length; i++){
		 		if(i%7 == 0)$("#calendar").append("<tr class='dateRow'></tr>");
		 		$("#calendar tr:last").append("<td><span class='mealName'>"+meals[i].name+"<span></td>");
		 		$("#calendar td:last").append("<span class='calNum'>"+meals[i].day.substring(8)+"</span>");
		 		if(foodCal.parseURL("edit") == "true"){
			 		$("#calendar td:last").append("<select id='Meal"+meals[i].day+"'>"+foodCal.mealList+"</select>");
			 		$("#Meal"+meals[i].day).val(meals[i].id);
			 		$("#Meal"+meals[i].day).change(function(){foodCal.editDate(this)});
		 		}
		 	}
		});
	},
	weekNav:function(dir){
		var d = new Date(this.year,this.month,this.day);
 		d.setDate(d.getDate()+dir);
 		var url = window.location.pathname + "?view=w&"+"day=" + d.getDate().toString()  +"&month=" + d.getMonth().toString() + "&year=" + d.getFullYear().toString();
		window.location = url;
	},
	weekInit:function(){
		$('#prevWeek').click(function(){foodCal.weekNav(-7);});
		$('#nextWeek').click(function(){foodCal.weekNav(7)});
		$('#weekName').html("Week of "+this.monthNames[this.month] +" "+ this.day +", "+this.year);

		$.get( "./jsonservices/getDates.php?timeframe=week&day="+foodCal.day+"&month="+foodCal.month+"&year="+foodCal.year, function( data ) {
		 eval(data);
		 	foodCal.meals = meals;
		 	if(meals.length ==0)  $.post("./jsonservices/addDates.php?month="+foodCal.month+"&year="+foodCal.year,function(){window.location = window.location})
		 	$(".dateRow").remove();
		 	for (var i=0; i<meals.length; i++){
		 		$("#weekView").append("<div class='dateRow'></div>");
		 		$("#weekView div:last").append("<p class='weekDate'>"+foodCal.dayNames[i]+ ", "+ meals[i].day.substring(8)+"</p>");
		 		$("#weekView div:last").append("<p class='mealName'>"+meals[i].name+"</p>");
		 		if(foodCal.parseURL("edit") == "true"){
			 		$("#weekView div:last").append("<select id='Meal"+meals[i].day+"'>"+foodCal.mealList+"</select>");
			 		$("#Meal"+meals[i].day).val(meals[i].id);
			 		$("#Meal"+meals[i].day).change(function(){foodCal.editDate(this)});
		 		}
		 		
		 	}
		});
	},
	createMealList:function(){
		foodCal.mealList = "";
		$.get( "./jsonservices/getMeals.php", function( data ) {
			 eval(data);
			meals.sort(function(a,b) {return (a.name > b.name) ? 1 : ((b.name > a.name) ? -1 : 0);} );
			 for(var i = 0; i<meals.length; i++){
			 	foodCal.mealList += "<option value='"+meals[i].id+"''>"+meals[i].name+"</option>";
			 }
			 $("#meals").html("<option value=''>-Select a Meal-</option>"+foodCal.mealList);
		});	
	},
	editMeal:function(){
		$('#myModal').modal('show');
		$("#addOrEdit").show();
		$("#mealEditor").hide();
		$("#meals").change(function(){
			$("#addOrEdit").hide();
			$("#newMeal").val("false");
			$("#mealName").val($("#meals").children("option:selected").html());
			$("#mealEditor").show();
			$("#mealUpdate").html("Edit");

			$("#mealUpdate").click(function(){
				var url = "./jsonservices/editMeal.php?mealID="+$("#meals").val()+"&mealName="+$("#mealName").val();
			if($("#Delete").prop('checked')){ url+="&mealActive=0";$("#Delete").prop('checked',false)}
				$.get(url,function(data){
					$("#addOrEdit").show();
					$("#deleteContainer").show();
					$("#mealEditor").hide();
					foodCal.createMealList();
					if(foodCal.parseURL("view")==="m")foodCal.monthInit();
				    if(foodCal.parseURL("view")==="w"){
				    foodCal.weekInit();
				   
				    }
				});
			});


		});
		$("#newButton").click(function(){
			$("#addOrEdit").hide();
			$("#newMeal").val("false");
			$("#mealName").val("");
			$("#mealEditor").show();
			$("#deleteContainer").hide();
			$("#mealUpdate").html("Edit");
			$("#mealUpdate").click(function(){
				$.get("./jsonservices/addMeal.php?mealID="+$("#meals").val()+"&mealName="+$("#mealName").val(),function(data){
					$("#addOrEdit").show();
					$("#mealEditor").hide();
					foodCal.createMealList();
					if(foodCal.parseURL("view")==="m")foodCal.monthInit();
					if(foodCal.parseURL("view")==="w")foodCal.weekInit();

				});
			});
		});
		
	},
	parseURL:function(param){
		search = window.location.search.substring(1).split(/[&=]/gi);
		if(search.indexOf(param)>=0) return(search[(search.indexOf(param) +1)]); 
		else return "";
	},
	editDate:function(elm){
		$.get("./jsonservices/editDate.php?mealID="+$(elm).val() + "&fullDate=" + elm.id.substring(4),function(){
			$(elm).siblings(".mealName").html($(elm).children("option:selected").text());
		})

	},
	init:function(){
		if(this.parseURL("month").length == 0){
			this.month = this.today.getMonth()+1;
		}
		else{
			this.month = parseInt(this.parseURL("month"));
		}
		if(this.parseURL("year").length == 0){
			this.year = this.today.getFullYear();
		}
		else{
			this.year = parseInt(this.parseURL("year"));
		}
		if(this.parseURL("day").length == 0){
			this.day = this.today.getDate();
		}
		else{
			this.day = parseInt(this.parseURL("day"));
		}
		this.createMealList();
		if(this.parseURL("view")==="w"){
			this.weekInit();
			$("#calendar").css("display","none");
		}
		else{
			this.monthInit();
			$("#weekView").css("display","none");
		}
		
		$("#editPop").click(function(){foodCal.editMeal()});

		if(foodCal.parseURL("edit") =="true") $("#editMode").html("Done Editing");
		$("#editMode").click(function(){
			if(foodCal.parseURL("edit") !=="true")window.location = window.location.href + "&edit=true";
			else window.location = window.location.href.replace("&edit=true","");
		});
		if(foodCal.parseURL("view") == "w") $("#viewMode").html("Month View");
		$("#viewMode").click(function(){
		
			if(foodCal.parseURL("view") == "w")window.location=window.location.href.replace("view=w","view=m");
			else if(foodCal.parseURL("view") == "m") window.location = window.location.href.replace("view=m","view=w");
			else window.location = window.location.href + "&view=w";
		});
		if(window.location.href.search(/\?/gi)<0 )window.location.href += "?";
	},

};

$( document ).ready(function() {
  foodCal.init();
});

