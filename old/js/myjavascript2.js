// ADD ITEM TO CART
$('.add-btn').click(function () {
	var productid = $(this).data('id');
	var quantity = $(this).prev('input').val();
	if (quantity > 0)
	{
		var parameters = {"item_id": productid, "qty": quantity};
		$.ajax({
			data: parameters,
			method: "POST",
			url: "add-to-cart.php"
		})
		.done(function(data){			
            $(".summary").fadeOut('fast', function(){
            $(".summary").html("");
            $(".summary").fadeIn('fast').html(data);
            $('.add-to-cart').val("");
            });	
		});
	}
	else
	{
		alert("Invalid value");
	}	
});

// REMOVE ITEM FROM CART
// .click only works for elements already on the page.
// you have to use a parent id or class in the first $('') and then the actual class of the button after "click"
$(".summary").on("click",".remove-btn", function(){
  	var productid = $(this).data('id');	  	
	var parameters = {"item_id": productid};
	$.ajax({
		data: parameters,
		method: "POST",
		url: "delete.php"
	})
	.done(function(data) {        
		$(".summary").fadeOut('fast', function(){
        $(".summary").html("");
		$(".summary").fadeIn('fast').html(data);
		});		
	});
});

// PAYMENT
$(".summary").on("click",".pay-btn", function(){  	
  	var ship_cost = parseFloat($('select[name=method]').val());
    if(isNaN(ship_cost))
  	{
  		alert("You have to select the transport type");
  	}
  	else
  	{  	
        var parameters = {"ship": ship_cost};
		$.ajax({
		    data: parameters,
            method: "POST",
            url: "pay.php"
        })
        .done(function(data) {
            alert("Payment processed succesfully!");
            location.reload();
        });  		
  	}
});

// THIS FUNCTION UPDATES THE TOTAL PRICE [IN "PAY" BUTTON]
// WHEN THE TRANSPORT TYPE CHANGES
$(document).on("change","select", function(){
  	var sum = 0;
  	var sum2 = 0;
  	sum2 += parseFloat($('.cash-input').val());

	$('.total-amount').each(function(){
	    sum += parseFloat($(this).val());	    
	});

	$('.total-span').text(sum.toFixed(2));
	$('.rest-span').text((sum2 - sum).toFixed(2));	
});

// RATING SYSTEM
$('.stars input').click(function(){
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
