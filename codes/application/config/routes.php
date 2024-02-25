<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'Users/login';
// Products
$route['products'] = 'Products';
$route['products/(:num)'] = 'Products/view_item/$1';
$route['products/filter'] = 'Products/filter_products';

// Carts Orders
$route['cart'] = 'Orders';
$route['Orders/add_to_cart'] = 'Orders/add_to_cart';
$route['/Orders/archive_order/(:num)'] = 'Orders/archive_order/$1';
$route['/Orders/pay_order/(:num)'] = 'Orders/pay_order/$1';
// Users
$routes['signup'] = 'Users/register';
$routes['login'] = 'Users/login';
// Admin
$routes['dashboard/orders'] = 'Admin_orders/orders';
$routes['dashboard/products'] = 'Dashboards/products';
