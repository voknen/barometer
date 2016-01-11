$(document).ready(function() {
   $(".mymenu").load("menu.html");

   $("input[type=radio][name=balance]").change(function(){
   		if (this.value == 'day') {
   			$('#form-month-balance').hide();
   			$('#form-week-balance').hide();
   			$('#form-year-balance').hide();
   			$('#form-day-balance').show();
   		}
   		if (this.value == 'week') {
   			$('#form-day-balance').hide();
   			$('#form-month-balance').hide();
   			$('#form-year-balance').hide();
   			$('#form-week-balance').show();
   		}
   		if (this.value == 'month') {
   			$('#form-day-balance').hide();
   			$('#form-week-balance').hide();
   			$('#form-year-balance').hide();
   			$('#form-month-balance').show();
   		}
   		if (this.value == 'year') {
   			$('#form-day-balance').hide();
   			$('#form-month-balance').hide();
   			$('#form-week-balance').hide();
   			$('#form-year-balance').show();
   		}
   });
});