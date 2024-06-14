<?php
if(@$_GET){
	switch($_GET['p']){
		case "register";
			include "user/register.php";
		break;
		case "profil";
			include "user/profil.php";
		break;
		case "login";
			include "user/login.php";
		break;
		case "logout";
			include "user/logout.php";
		break;
		case "delete";
			include "user/deleteaccount.php";
		break;
		case "success";
			include "user/success.php";
		break;
		case "single";
			include "page/single.php";
		break;
		case "brands";
			include "page/brands.php";
		break;
		case "home";
			include "page/home.php";
		break;
		case "productbrand";
			include "page/productbrand.php";
		break;
		case "cart";
			include "cart/cart.php";
		break;
		case "checkout";
			include "cart/checkout.php";
		break;
		case "order";
			include "cart/order_detail.php";
		break;
		case "blazercoats";
			include "subkat/blazercoats.php";
		break;
		case "jeans";
			include "subkat/jeans.php";
		break;
		case "tshirt";
			include "subkat/t-shirts.php";
		break;
		case "casualshirt";
			include "subkat/casual_shirts.php";
		break;
		case "jackets";
			include "subkat/jackets.php";
		break;
		case "tops";
			include "subkat/tops.php";
		break;
		case "jacketwomen";
			include "subkat/jacketwaistcoat.php";
		break;
		case "shortskirts";
			include "subkat/shortskirts.php";
		break;
		case "boysjackets";
			include "subkat/boy_jackets.php";
		break;
		case "boysshirts";
			include "subkat/boy_shirts.php";
		break;
		case "boyscasualshoes";
			include "subkat/boy_casual_shoes.php";
		break;
		case "boysportshoes";
			include "subkat/boy_sports_shoes.php";
		break;
		case "boystshirts";
			include "subkat/boy_t-shirts.php";
		break;
		case "girlsdresses";
			include "subkat/girl_dresses.php";
		break;
		case "girlsjeans";
			include "subkat/girl_jeans.php";
		break;
		case "girlssweaters";
			include "subkat/girl_sweater.php";
		break;
		case "girlstopstshirts";
			include "subkat/girl_t-shirts.php";
		break;
		default:
			echo '<div class="container">
							<div class="row">
								<div class="col-md-12">
									<h2 class="text-center text1">Page was not found</h2>
								</div>
							</div>
					</div>';
		break;
	}
}else{
	include "page/home.php";
}
?>