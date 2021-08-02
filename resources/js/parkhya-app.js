
import "../css/custom.css";

import "toastr";

import Vue from "vue";
window.Vue = Vue;
// import vuex instance
// import store from "./store/index.js";

// Vue.config.productionTip = false
// use vuex in vue instance
// Vue.use(store)

let axios = require('axios');
window.axios = axios;

let jQuery = require('jquery');
window.jQuery = jQuery;

import "../css/custom.css";
import "toastr";

/* Polaris Vue start */
import PolarisVue from '@eastsideco/polaris-vue';

// Recommended: import the correct CSS for the version of Polaris the library uses.
import '@eastsideco/polaris-vue/lib/polaris-vue.css';

// Register the plugin with Vue
Vue.use(PolarisVue);


// Vue Components
// Vue.component('app-entry', require('./App.vue').default);
// Vue.component('ps-wishlist-btn', require('./components/WishlistBtn').default);
// Vue.component('ps-wishlist', require('./components/Wishlist').default);

new window.Vue({
	el: '#app',
	delimiters: ['${', '}'],
});

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

	if (wishlistButton) {
		console.log(wishlistButton);
	    var customer = wishlistButton.data('customer');
	    var id = wishlistButton.data('product');
	    checkWishlist(customer,id);
	}


})