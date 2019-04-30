(function($) {
	'use strict';
	
	$(document).ready(function(){
		if(document.location.href.endsWith("/checkout/")){
			fbq('track', 'InitiateCheckout');
			snaptr('track','START_CHECKOUT');
		}
		if(document.location.href.indexOf("/order-received/") != -1){
			fbq('track', 'Purchase', {value: OrderValue, currency: 'SAR'});
			snaptr('track', 'PURCHASE', {'currency': 'SAR', 'price': OrderValue});
		}
		$(".extra-menu-item.menu-item-cart.mini-cart,.add_to_cart_button").click(function(){
			fbq('track', 'AddToCart');
			snaptr('track','ADD_CART');
		});
		
		$(".extra-menu-item.menu-item-wishlist,.add_to_wishlist").click(function(){
			fbq('track', 'AddToWishlist');
		});
		
		$("form.woocommerce-checkout").submit(function(){
			fbq('track', 'AddPaymentInfo');
			snaptr('track','ADD_Billing');
		});
		
		$("form.wpcf7-form").submit(function(){
			fbq('track', 'Contact');
		});
	});	
})(jQuery);