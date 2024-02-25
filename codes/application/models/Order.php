<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function add_to_cart($post_data, $product_id, $user_id) {
        $query = "INSERT INTO `cart`(`user_id`, `product_id`, `quantity`, `total_amount`, `created_at`, `updated_at`) VALUES (?,?,?,?,NOW(), NOW())";
        $values = array(
            $this->security->xss_clean($user_id), 
            $this->security->xss_clean($product_id), 
            $this->security->xss_clean($post_data['quantity']), 
            $this->security->xss_clean($post_data['total_amount']), 
        ); 
        return $this->db->query($query, $values);
    }

    public function count_items_by_user($user_id) {
        $query = "SELECT COUNT(*) AS item_count FROM cart WHERE user_id = ? AND is_archived = 0 GROUP BY user_id";
        $id = $this->security->xss_clean($user_id);
        $result = $this->db->query($query, $id)->result_array();
        if ($result) {
            return $result;
        } else {
            return 0;
        }
    }

    public function get_cart_items_by_user_id($user_id) {
        $query = "SELECT cart.cart_id, cart.user_id, cart.product_id, cart.quantity, cart.total_amount, products.name, products.price, images.image_path FROM cart
        JOIN products ON cart.product_id = products.product_id LEFT JOIN images ON products.product_id = images.product_id
        WHERE cart.user_id = ? AND images.is_main = 1 AND cart.is_archived = 0 GROUP BY product_id";
        $id = $this->security->xss_clean($user_id);
        $result = $this->db->query($query, $id)->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            return null;
        }
    }

    public function archive_order_by_id($cart_id) {
        $query = "UPDATE `cart` SET `is_archived`='1',`updated_at`= NOW() WHERE cart_id = ?";
        $id = $this->security->xss_clean($cart_id);
        return $this->db->query($query, $id);
    }

    public function edit_product_quantity($item_data, $cart_id) {
        $query = "UPDATE `cart` SET `quantity`= ?,`total_amount`= ?,`updated_at`= NOW() WHERE cart_id = ?";
        $values = array(
            $this->security->xss_clean($item_data['update_cart_item_id']), 
            $this->security->xss_clean($item_data['item_total_amount']), 
            $this->security->xss_clean($cart_id), 
        ); 
        return $this->db->query($query, $values);
    }

    public function search_by_product_name($keyword, $user_id) {
        $query = "SELECT cart.cart_id, cart.user_id, cart.product_id, cart.quantity, cart.total_amount, products.name, products.price, images.image_path FROM cart
        JOIN products ON cart.product_id = products.product_id LEFT JOIN images ON products.product_id = images.product_id
        WHERE cart.user_id = ? AND images.is_main = 1 AND cart.is_archived = 0 AND products.name LIKE ? GROUP BY product_id";
        $keyword = '%' . $this->security->xss_clean($keyword) . '%';
        return $this->db->query($query, array($user_id, $keyword))->result_array();
    }

    public function insert_order($order_data, $user_id) {
        $shipping_query = "INSERT INTO `orders`(`user_id`,`total_amount`, `shipping_first_name`, `shipping_last_name`, `shipping_address_1`, `shipping_address_2`, `shipping_city`, `shipping_state`, `shipping_zip_code`, `billing_first_name`, `billing_last_name`, `billing_address_1`, `billing_address_2`, `billing_city`, `billing_state`, `billing_zip_code`, `created_at`, `updated_at`) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,Now(),NOW())";
        $shipping_values = array(
            $this->security->xss_clean($user_id),
            $this->security->xss_clean($order_data['total_amount']),
            $this->security->xss_clean($order_data['shipping_first_name']),
            $this->security->xss_clean($order_data['shipping_last_name']),
            $this->security->xss_clean($order_data['shipping_address_1']),
            $this->security->xss_clean($order_data['shipping_address_2']),
            $this->security->xss_clean($order_data['shipping_city']),
            $this->security->xss_clean($order_data['shipping_state']),
            $this->security->xss_clean($order_data['shipping_zip_code']),
            $this->security->xss_clean($order_data['billing_first_name']),
            $this->security->xss_clean($order_data['billing_last_name']),
            $this->security->xss_clean($order_data['billing_address_1']),
            $this->security->xss_clean($order_data['billing_address_2']),
            $this->security->xss_clean($order_data['billing_city']),
            $this->security->xss_clean($order_data['billing_state']),
            $this->security->xss_clean($order_data['billing_zip_code']),
        );
        $this->db->query($shipping_query, $shipping_values);
        $order_id = $this->db->insert_id();
        $cart_items = $this->get_cart_items_by_user_id($user_id);

        foreach ($cart_items as $item) {
            $order_items_query = "INSERT INTO `order_items`( `order_id`, `user_id`, `product_id`, `quantity`, `total_amount`, 
            `created_at`, `updated_at`) VALUES (?,?,?,?,?,NOW(),NOW())";
            $order_items_values = array(
                $this->security->xss_clean($order_id),
                $this->security->xss_clean($user_id),
                $this->security->xss_clean($item['product_id']),
                $this->security->xss_clean($item['quantity']),
                $this->security->xss_clean($item['total_amount']),
            );
            $this->db->query($order_items_query, $order_items_values);
        }
        $delete_cart_items_query = "DELETE FROM cart WHERE user_id = ?";
        $id = $this->security->xss_clean($user_id);
        $this->db->query($delete_cart_items_query, $id);        
    }    

    public function insert_payment($order_data) {
        $last_id_query = "SELECT order_id FROM `orders` ORDER BY order_id DESC LIMIT 1";
        $order_id = $this->db->query($last_id_query)->result_array()[0];
        $payment_query = "UPDATE `orders` SET `card_name`= ?, `payment_details`= ?, `updated_at`= NOW() WHERE order_id = ?";
        $payment_values = array(
            $this->security->xss_clean($order_data['payment_data']),
            $this->security->xss_clean($order_data['stripe_token']),
            $this->security->xss_clean($order_id)
        );
        $this->db->query($payment_query, $payment_values);  
    }

    public function fetch_orders() {
        $query = "SELECT order_id, DATE_FORMAT(created_at,'%m/%d/%Y') as date_ordered, shipping_first_name, shipping_last_name, shipping_address_1, shipping_city, shipping_state, shipping_zip_code, total_amount, status FROM `orders`";
        return $this->db->query($query)->result_array();
    }

    public function search_order($keyword) {
        $keyword = $this->security->xss_clean($keyword);
        $keyword = '%' . $this->db->escape_like_str($keyword) . '%';
        $query = "SELECT order_id, DATE_FORMAT(created_at,'%m/%d/%Y') as date_ordered, shipping_first_name, shipping_last_name, shipping_address_1, shipping_city, shipping_state, shipping_zip_code, total_amount, status FROM `orders`
        WHERE order_id LIKE ? OR shipping_first_name LIKE ? OR shipping_last_name LIKE ? OR shipping_address_1 LIKE ? OR shipping_city LIKE ? OR shipping_state LIKE ? OR shipping_zip_code LIKE ? OR total_amount LIKE ?";
        return $this->db->query($query, array($keyword, $keyword, $keyword, $keyword, $keyword, $keyword, $keyword, $keyword))->result_array();
    }

    public function filter_orders_by_status($status) {
        $whereClause = '';
        $params = array();
        if ($status !== 'All') {
            $whereClause = 'WHERE status = ?';
            $params[] = $this->security->xss_clean($status);
        }
        $query = "SELECT order_id, DATE_FORMAT(created_at,'%m/%d/%Y') as date_ordered, shipping_first_name, shipping_last_name, shipping_address_1, shipping_city, shipping_state, shipping_zip_code, total_amount, status FROM orders $whereClause ";
        return $this->db->query($query, $params)->result_array();
    }
    
    public function update_order_status($status, $order_id) {
        $query = "UPDATE `orders` SET `status`= ?, `updated_at`= NOW() WHERE `order_id`= ?";
        $status = $this->security->xss_clean($status);
        $id = $this->security->xss_clean($order_id);
        return $this->db->query($query, array($status, $id));
    }

    public function count_items_by_status() {
        $query = "SELECT status, COUNT(status) as count FROM `orders` GROUP BY status";
        return $this->db->query($query)->result_array();
    }
}