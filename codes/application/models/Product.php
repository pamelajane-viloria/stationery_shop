<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model {
	
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function get_all_products() {
        $query = "SELECT products.product_id, products.name, products.category_id, products.price, products.rating, products.inventory, products.sold, images.image_id, images.image_path, images.is_main 
            FROM  products LEFT JOIN  images ON products.product_id = images.product_id WHERE images.is_main = '1' AND products.is_archived = '0'";
        return $this->db->query($query)->result_array();
    }

    public function get_paginated_products($offset, $items_per_page) {
        $query = "SELECT products.product_id, products.name, products.category_id, products.price, products.rating, products.inventory, products.sold, images.image_id, images.image_path, images.is_main 
            FROM products LEFT JOIN images ON products.product_id = images.product_id WHERE images.is_main = '1' AND products.is_archived = '0' ORDER BY products.product_id LIMIT $offset, $items_per_page";
        return $this->db->query($query, array($offset, $items_per_page))->result_array();
    }
    
    
    public function count_all_products() {
        $query = "SELECT count(*) as total_count FROM `products` where is_archived = 0";
        $result = $this->db->query($query)->row_array();
        return $result['total_count'];
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
        $whereClause = '';
        $params = array();
        if ($category !== 'All') {
            $whereClause = 'WHERE categories.name = ?';
            $params[] = $this->security->xss_clean($category);
        }
        $query = "SELECT products.*, categories.name AS category_name, images.image_path 
                  FROM products 
                  INNER JOIN categories ON products.category_id = categories.category_id 
                  INNER JOIN images ON products.product_id = images.product_id 
                  $whereClause 
                  GROUP BY products.name";
        return $this->db->query($query, $params)->result_array();
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

    public function archive_product($product_id) {
        $query = "UPDATE `products` SET `is_archived`='1',`updated_at`= NOW() WHERE product_id = ?";
        $id = $this->security->xss_clean($product_id);
        return $this->db->query($query, $id);
    }

    public function validate_product_data() {
        $this->form_validation->set_rules('prouct_name', 'Product Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');        
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('inventory', 'Inventory', 'required');
        if(!$this->form_validation->run()) {
            return validation_errors();
        }
        return null;
    }
    
    public function update_product($product_id, $product_data, $uploaded_images) {
        $query = "UPDATE `products` SET `category_id`=?, `name`=?, `description`=?, `price`=?, `inventory`=?, `updated_at`=? WHERE `product_id`=?";
        $values = array(
            $this->security->xss_clean($product_data['category']), 
            $this->security->xss_clean($product_data['prouct_name']), 
            $this->security->xss_clean($product_data['description']), 
            $this->security->xss_clean($product_data['price']),
            $this->security->xss_clean($product_data['inventory']),
            date('Y-m-d H:i:s'),
            $this->security->xss_clean($product_id),
        ); 
        $query_result = $this->db->query($query, $values);
        if (!$query_result) {
            $error_message = $this->db->error();
            var_dump($error_message);
        }

        $query = "DELETE FROM `images` WHERE `product_id`= ?";
        $this->db->query($query, $this->security->xss_clean($product_id));

        $is_main = 0; // Reset to 0 for each image
        foreach ($uploaded_images as $image) { 
            $image_path = $image['filename'];
            $is_main = $image['is_main'];
            $image_values = array(
                $this->security->xss_clean($product_id),
                $this->security->xss_clean($image_path),
                $this->security->xss_clean($is_main),
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            );

            $image_query = "INSERT INTO `images`(`product_id`, `image_path`, `is_main`, `created_at`, `updated_at`) VALUES (?,?,?,?,?)";
            $image_query_result = $this->db->query($image_query, $image_values);
            if (!$image_query_result) {
                $error_message = $this->db->error();
                var_dump($error_message);
            }
        }
    }

    public function add_product($post_data, $uploaded_images) {
        $product_query = "INSERT INTO `products`(`category_id`, `name`, `description`, `price`, `inventory`, `created_at`, `updated_at`) 
            VALUES (?,?,?,?,?,?,?)";
        $product_values = array(
            $this->security->xss_clean($post_data['category']), 
            $this->security->xss_clean($post_data['prouct_name']), 
            $this->security->xss_clean($post_data['description']), 
            $this->security->xss_clean($post_data['price']),
            $this->security->xss_clean($post_data['inventory']),
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s'),
        ); 
        $query_result = $this->db->query($product_query, $product_values);
        if (!$query_result) {
            $error_message = $this->db->error();
            var_dump($error_message);
        } else {
            $product_id = $this->db->insert_id();
            $is_main = 0; // Reset to 0 for each image
            foreach ($uploaded_images as $image) { 
                $image_path = $image['filename'];
                $is_main = $image['is_main'];
                $image_values = array(
                    $this->security->xss_clean($product_id),
                    $this->security->xss_clean($image_path),
                    $this->security->xss_clean($is_main),
                    date('Y-m-d H:i:s'),
                    date('Y-m-d H:i:s')
                );
                var_dump($image_values);
                $image_query = "INSERT INTO `images`(`product_id`, `image_path`, `is_main`, `created_at`, `updated_at`) VALUES (?,?,?,?,?)";
                $image_query_result = $this->db->query($image_query, $image_values);
                if (!$image_query_result) {
                    $error_message = $this->db->error();
                    var_dump($error_message);
                }
            }
        } 
        
    }
    
}