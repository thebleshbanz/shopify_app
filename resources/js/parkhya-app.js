import "../css/custom.css";


function addWishList(){
	console.log('Adding Item Wishlist');
}

function removeWishList(){
	console.log('Removed Item Wishlist');
}


var wishlistButton = document.querySelector(".parkhya-wishlist-btn");

wishlistButton.addEventListener('click', function(){
	console.log("This: ", this);
});