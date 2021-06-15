import "../css/custom.css";
import "toastr";

window.axios = require('axios');

const appDomain = "https://parkhyamapps.co.in/shopify_app";

function addWishList(customer, product_id){
	axios.post(appDomain+'/api/addToWishlist', {shop_id: Shopify.shop, customer_id: customer, product_id: product_id })
        .then(response => {
            console.log("Response: ", response);
        })
        .catch( error => {
            console.log("ERROR: ", error);
        });
}

function removeWishList(customer, product_id){
    axios.post(appDomain+'/api/removeWishlist', {shop_id: Shopify.shop,customer_id: customer, product_id: product_id })
        .then(response => {
            console.log("Response: ", response);
        })
        .catch( error => {
            console.log("ERROR: ", error);
        });
}

// check wishlist is it an active or not?
function checkWishlist(customer, product_id){
    axios.post(appDomain+'/api/checkWishlist', {shop_id: Shopify.shop,customer_id: customer, product_id: product_id })
        .then(response => {
            console.log("Response: ", response);
        })
        .catch( error => {
            console.log("ERROR: ", error);
        });
}


// var wishlistButton = document.querySelector('.parkhya-wishlist-btn');

/*wishlistButton.addEventListener('click', function(){
	console.log("This: ", this);
});*/

$(document).ready(function(){
	var wishlistButton = $(document).find('.parkhya-wishlist-btn');
	console.log(wishlistButton);

	if (wishlistButton) {
	    var customer = wishlistButton.data('customer');
	    var id = wishlistButton.data('product');
	    alert(customer, id);
	    checkWishlist(customer,id);
	}

	$(document).on('click', '.parkhya-wishlist-btn', function(){
		if($(this).hasClass('active')){
			var customer = $(this).data('customer');
			var product  = $(this).data('product');
			removeWishList(customer, product);
			$(this).removeClass('active');
		}else{
			$(this).addClass('active');
			var customer = $(this).data('customer');
			var product  = $(this).data('product');
			addWishList(customer, product);
		}
	})

})