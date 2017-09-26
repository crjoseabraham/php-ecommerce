// ADD ITEM TO CART
$('.add-btn').click(function() {
	var productid = $(this).data('id');
	var quantity = $(this).prev('input').val();
	if(quantity > 0){
		var parameters = {"item_id": productid, "qty": quantity};
		$.ajax({
			data: parameters,
			method: "POST",
			url: "add-to-cart.php"
		})
		.done(function(data) {
			$(".details-table").fadeOut('fast', function(){
			$(".details-table").fadeIn('fast').html(data);
			$('.add-to-cart').val("");	
			});
		});
	}else{
		alert("Invalid value");
	}
});

// REMOVE ITEM FROM CART
// .click only works for elements already on the page.
// you have to use a parent id or class in the first $('') and then the actual class of the button after "click"
$(".details-table").on("click",".remove-btn", function(){
  	var productid = $(this).data('id');	
	var parameters = {"item_id": productid};
	$.ajax({
		data: parameters,
		method: "POST",
		url: "delete.php"
	})
	.done(function(data) {
		$(".details-table").fadeOut('fast', function(){
		$(".details-table").fadeIn('fast').html(data);
		});		
	});
});

// PAYMENT
$(".details-table").on("click",".pay-btn", function(){
  	var sum = $(this).data('id');
  	var ship_cost = parseFloat($('select[name=method]').val());
  	var current_cash = parseFloat($('input[name=cash-input]').val());
  	
  	if(isNaN(ship_cost)) {
  		alert("You have to select the transport type");
  	} else{  		
  		var total = sum + ship_cost;
  		if(total > current_cash) {
  			alert("You don't have enough money to process this purchase");
  		}else{  			
  			var parameters = {"total_amount": total};
			$.ajax({
				data: parameters,
				method: "POST",
				url: "pay.php"
			})
			.done(function(data) {
				location.reload();
			});
  		}
  	}
});

// RATING SYSTEM
$('.stars input').click(function() {
	var value = $(this).val();
	var id = $(this).closest('.stars').data('id');
	var ResultDiv = $(this).closest('.stars').next();
	var parameters = {"item_id": id, "rate": value};
	$.ajax({
	  data: parameters,
	  method: "POST",
	  url: "rating.php"
	})
	
	.done(function(data) {
	    ResultDiv.fadeOut('fast', function(){
	        ResultDiv.fadeIn('fast').html(data);
	    });
	});
});