<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'Products';
// Products
$route['products'] = 'Products';
$route['products/(:num)'] = 'Products/view_item/$1';
$route['products/filter'] = 'Products/filter_products';

// Carts
$route['cart'] = 'Carts';
// Users
$routes['signup'] = 'Users/register';
$routes['login'] = 'Users/login';
// Admin
$routes['dashboard/orders'] = 'Dashboards/orders';
$routes['dashboard/products'] = 'Dashboards/products';
