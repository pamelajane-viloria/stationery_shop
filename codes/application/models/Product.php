<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model {
	
    public function __construct() {
        parent::__construct();
        // $this->load->library('form_validation');
    }

    public function get_all_products() {
        $query = "SELECT products.product_id, products.name, products.category_id, products.price, images.image_id, images.image_path, images.is_main 
            FROM  products LEFT JOIN  images ON products.product_id = images.product_id WHERE images.is_main = '1'";
        return $this->db->query($query)->result_array();
    }

    public function search_by_product_name($keyword) {
        $query = "SELECT products.*, images.image_path FROM products LEFT JOIN images ON products.product_id = images.product_id 
        WHERE products.name LIKE ? AND images.is_main = 1";
        $name = '%' . $this->security->xss_clean($keyword) . '%';
        return $this->db->query($query, $name)->result_array();
    }

    public function get_product_by_id($product_id) {
        $query = "SELECT * FROM products WHERE product_id = ?";
        $id = $this->security->xss_clean($product_id);
        return $this->db->query($query, $id)->result_array()[0];
    }

    public function get_productimage_by_id($product_id) {
        $query = "SELECT *, images.is_main as is_main_image FROM images WHERE product_id = ?";
        $id = $this->security->xss_clean($product_id);
        return $this->db->query($query, $id)->result_array();
    }

    public function get_products_by_category($category) {
        $query = "SELECT products.*, categories.name AS category_name, images.image_path FROM products INNER JOIN categories ON products.category_id = categories.category_id 
            INNER JOIN images ON products.product_id = images.product_id WHERE categories.name = ? GROUP BY products.name";
        $category_name = $this->security->xss_clean($category);
        return $this->db->query($query, $category_name)->result_array();
    }

    public function get_categories_with_product_count() {
        $query = "SELECT categories.*, COUNT(products.product_id) AS product_count FROM categories LEFT JOIN products ON categories.category_id = products.category_id GROUP BY categories.category_id";
        return $this->db->query($query)->result_array();
    }

    public function get_category_by_product_id($product_id) {
        $query = "SELECT category_id FROM products WHERE product_id = ?";
        $id = $this->security->xss_clean($product_id);
        return $this->db->query($query, $id)->result_array()[0];
    }

    public function get_related_products($category_id, $product_id) {
        $query = "SELECT products.*, images.image_path FROM products JOIN images ON products.product_id = images.product_id 
            WHERE products.category_id = ? AND products.product_id != ? AND images.is_main = 1";
        $id = $this->security->xss_clean($product_id);
        $category = $this->security->xss_clean($category_id);
        return $this->db->query($query, array($category, $id))->result_array();
    }
}