var calendar = {
	dropdowns:function(){
		$("select[id^='mealdd']").change(function(){
			var dayId= this.id.substring(6);
			$("#meal" + dayId).val(this.value);
			var mealDate = $("#day" + dayId).val();
			$.ajax({url:"daySubmit.php",
				type:"POST",
				data:{
				day:mealDate,
				meal:this.value
				}
			});
			$("#text"+dayId).html($(this).children("option:selected").text());
		});
	$("input[name^=meal]").each(function() {
			this.nextSibling.value = this.value
		});
	}
};

$(document).ready(function() {
	calendar.dropdowns();
	
	$('.positioner').mouseenter(function(){
		if($(this).children('.recipe').html() !== "") $(this).children('.recipe').show();
	});
	$('.positioner').mouseleave(function(){
		if($(this).children('.recipe').html() !== "") $(this).children('.recipe').hide();
	});
});
