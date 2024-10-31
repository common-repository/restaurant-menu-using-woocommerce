=== Restaurant Menu / bulk order plugin for WooCommerce ===
Contributors: rajeshsingh520
Tags: bulk order, Restaurant, online food order, restaurant menu, simple restaurant menu,food ordering, cafe, coffee, food, pizza, food menu,food order,food ordering, restaurant menu plugin
Requires at least: 4.8
Tested up to: 6.6.1
Stable tag: 6.2.61
Requires PHP: 7.2

Simple Restaurant menu, even a child can use this online restaurant menu. sell pizza, coffee online, Woocommerce bulk order

== Description ==

[Documentation link](https://woo-restaurant.com/category/restaurant-menu-documentation/) | [Buy Pro Version Now](https://www.piwebsolution.com/cart/?add-to-cart=574&variation_id=675) | [Demo link](https://woo-restaurant.com/menu/)

[Use this plugin to allow delivery date and time](https://wordpress.org/plugins/pi-woocommerce-order-date-time-and-type/)

[youtube https://www.youtube.com/watch?v=tjQd9nzGXF0]

[Watch How to sort product and sub category in Menu](https://www.youtube.com/watch?v=xfqHU6fBb20&t=42s)


* Create <strong>single page restaurant menu</strong>, It is so easy to use that even a child can place an order using it.
* Prepare your order from a <strong>single page</strong>, no need to browse through different pages
* You sell different <strong>side</strong> dishes with each item, no problem you can add as many side dishes as you want.
* Your <strong>side dishes are not free</strong>, no problem you can either mark them as FREE or add there cost and that will be added to the product cost when that side dish is selected
* Ohh you have <strong>multiple categories</strong>, no problem you can show them all on this page, the user can browse then by selecting a category and it will load on the same page
* Customer don't know the category, then they can <strong>search by product name</strong>
* Product search can <strong>search in all the menu items</strong> on your site
* Don't want to <strong>show the image</strong>, you can disable it.
* You have an image but not for all the menu items, then set that <strong>image as category image</strong> and it will be shown on all the menu item of that category if there is no image for that specific menu item
* User can <strong>read product description</strong> from the same page in a popup, you can add your complete recipe or ingredients in this description part
* You can <strong>hide categories</strong> that you don't want to show on the menu page 
* You can set <strong>minimum item that must be selected</strong> from each of the side dish group
* Variable product can be made to load in menu, but they cant be added to cart from the menu page they will open in a popup on same page where user can select the variation and add the product to cart 
* Give option to user to hide the cart and see it wen they want to check the added products (pro)
* Now you can create a side dish template, and reuse that template for making products for future
* You can Change color of various element of the plugin as per your need, from within the plugin setting
* You can show side dishes even on the single product page 
* If you don't want to have product selection option on your cart page and have a normal cart page of WooCommerce then you can do that as well by adding a small piece of code to your theme **functions.php** file
<code>
add_filter('pisol_rm_disable_cart_page_overwrite', '__return_true');
</code>

* Multiple food type like Veg, Non Veg, Hot, Vegan, Contains Nuts
* This allows customer to place bulk order quickly

== Premium support: We respond to all support topics within 24 hours ==

== Frequently Asked Questions ==

= It is not installing =
Just make sure WooCommerce is pre-installed and active on your website

= Where is my menu page = 
Plugin converts your WooCommerce cart page into your menu page, so your WooCommerce cart page is converted into the menu page.

= I don't see Menu on Cart page =
Make sure you have set a cart page for your site from the WooCommerce > settings > Advanced (tab) -> Cart Page, if you have not set the cart page from WooCommerce setting then WooCommerce will show its own default cart page and this plugin won't work properly

= My Shop page is redirecting to menu page =
By default, it will redirect your shop page to your cart or menu page.
We have added this because we think you won't need shop page as all your product will be on the menu page, but if you still want that sho page then you can have our Pro version it has the option to disable this feature 

= My Single product page is redirecting to menu page =
All the single product will be redirected to the menu page, but if you don't want that redirect then you can use our Pro version it has the option to disable this feature

= Product image is not shown =
Pro version has the option to enable this feature 

= Open menu with the product from a specific category =
Say you have a category page and you want to link them to the menu page, but you want to show the menu specific to that category then 
you can do that, just add ?cat_id=(id if the category that you want to show)

E.g https://woo-restaurant.com/menu/?cat_id=100 
on our demo site, this will open "Magic of Basmati"

https://woo-restaurant.com/menu/?cat_id=106
this will open "Indian food"

If you add a nonexisting cat_id then it will show the default category (selected in plugin setting)

= Show Short description below Item name(PRO) =
Now you can show a short description below the product name in the menu, this option is only in Paid version

= Can I change the cart position in menu page layout =
Yes you can do that in the pro version, it gives you option of 4 different positions
    *Cart to the left product on the right 
	*Product on right cart to the left
	*Product on top and cart to the bottom
	*Cart to top and products on the bottom

= I don't want to show the out of stock product =
In the pro version, there is an option to remove out of stock product from the menu 

= I want to set minimum item that must be selected in a side dish =
Yes you can set a minimum item amount number in each of the side dish group, if you set minimum item amount then the customer won't be able to add that product to cart until he selects that many item from that particular group 

= Can i add side dishes to variable product =
No, side dishes can only be added to the simple product 

= Variable product are shown in the Menu, can I remove them from menu =
In pro version there is option disable the variable product from appearing in menu

= How the variable product are shown =
Variable product will open in a popup on the menu page itself and the user can select the variation and then add the product to cart 

= I want to sort the products =
Yes you can sort it using WooCommerce default sorting method and it will follow that sorting

= I don't want to show the cart all the time instead give the option to user so they can see there cart =
This can be done in the pro version, it will allow the user to see the hide the cart and view it when he want to see the product added

= Can i copy side dish across different product =
Yes, there is a Side dish template option, you can make template in there and reuse them on the product page 

= I want to change the color of the menu =
Yes, plugin allows you to change most of the plugin element color from within the plugin setting

= Food type is missing from the site =
We have introduced a option for food type you will have to enable it from plugn setting "Design Tab"

= Menu load slower =
We have implemented caching to make the Ajax loading of the product faster, you have to enable this option in the Speed settings tab. 

= My product changes are not showing on menu page =
If you have caching enable in the plugin make sure to delete your cache after you have made changes in the plugin settings, Products, or Category

= I want to show come custom product types in the menu =
You can add custom product type using the filter function like below
add_filter('pisol_rm_product_type_filter', function($type){
	return array('simple', 'variable');
});

= Can user add side dishes from the single product page =
Yes from the version 4.7.9.3 we have given the option to allow customer to add side dishes from single product page as well

= If you don't want to show the product selection option on your cart page then you can disable that feature =
you can disable that feature by adding the below code in your theme functions.php file 
add_filter('pisol_rm_disable_cart_page_overwrite', '__return_true');

= I will like to show the product image on the mobile =
There is an option in the Design tab to enable the product image for the mobile devices as well 

= Is it HPOS compatible =
Yes the Free version and PRO version both are HPOS compatible

== Changelog ==

= 6.2.46 =
* Tested for WC 9.1.4

= 6.2.7 =
* Tested for WP 6.2.2

= v6.2.6 =
* Tested for WC 7.7.0

= v6.2.0 =
* Tested for latest WC v7.4.1