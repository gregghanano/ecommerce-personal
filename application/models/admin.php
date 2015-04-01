<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Model 
{

	function get_admin_by_email($email)
	{
		return $this->db->query('SELECT * FROM users WHERE email = ?', array($email))->row_array();
	}

	function get_orders_with_customers()
	{

		$query = "SELECT customers.*, orders.id AS order_id, orders.order_date, orders.order_status, products.*, products_has_orders.products_quantity
					FROM orders
					LEFT JOIN customers ON orders.customers_id = customers.id
					LEFT JOIN products_has_orders ON orders.id = products_has_orders.orders_id
					LEFT JOIN products ON products_has_orders.products_id = products.id
					GROUP BY order_id
					ORDER BY order_id DESC";

		return $this->db->query($query)->result_array();
	}


	function search_customers($search)
	{

		$query = "SELECT customers.*, orders.id AS order_id, orders.order_date, orders.order_status, products.*, products_has_orders.products_quantity
					FROM orders
					LEFT JOIN customers ON orders.customers_id = customers.id
					LEFT JOIN products_has_orders ON orders.id = products_has_orders.orders_id
					LEFT JOIN products ON products_has_orders.products_id = products.id
					WHERE customers.first_name = '$search'
					OR customers.address = '$search'
					OR customers.created_at = '$search'
					OR orders.id = '$search'
					GROUP BY order_id
					ORDER BY order_id DESC";

		return $this->db->query($query)->result_array();
	}


	function get_all_pictures_with_products()
	{
		return $this->db->query('SELECT pictures.name AS pic_name, pictures.description AS pic_desc, products.*
									FROM pictures
									LEFT JOIN products ON products.id = pictures.products_id;')->result_array();
	}

	function search_products($search)
	{
		return $this->db->query("SELECT pictures.name AS pic_name, pictures.description AS pic_desc, products.*
									FROM pictures
									LEFT JOIN products ON products.id =pictures.products_id
									WHERE products.name LIKE '%$search%'
									OR	  products.id ='$search';")->result_array();
	}

	// function get_orders_with_customers_pag()
	// {
	// 	$query = "SELECT orders.id AS order_id, customers.*,  orders.order_date, orders.order_status, products.*, products_has_orders.products_quantity
	// 			  FROM orders
	// 			  LEFT JOIN customers ON orders.customers_id = customers.id
	// 			  LEFT JOIN products_has_orders ON orders.id = products_has_orders.orders_id
	// 			  LEFT JOIN products ON products_has_orders.products_id = products.id
	// 			  GROUP BY order_id
	// 			  ORDER BY orders_id DESC
	// 			  LIMIT 2";

	// 	return $this->db->query($query)->result_array();

	// }

	function get_orders_with_customer($id)
	{

		return $this->db->query("SELECT customers.*, orders.*
					FROM orders
					LEFT JOIN customers ON orders.customers_id = customers.id
					WHERE orders.id = ?", array($id))->row_array();

	}

	function get_orders_with_shipping($id)
	{
		return $this->db->query("SELECT orders.*, shipping_information.*
					FROM orders
					LEFT JOIN shipping_information ON orders.shipping_information_id = shipping_information.id
					WHERE orders.id = ?", array($id))->row_array();

	}

	function get_orders_with_products($id)
	{
		return $this->db->query("SELECT orders.*, products.*, products_has_orders.products_quantity
									FROM orders
									LEFT JOIN products_has_orders ON orders.id = products_has_orders.orders_id
									LEFT JOIN products ON products_has_orders.products_id = products.id
									WHERE orders.id = ?", array($id))->result_array();
	}

	function get_orders_with_product()
	{
		return $this->db->query("SELECT orders.*, products.*,pictures.name AS pic_name, pictures.description AS pic_desc, products_has_orders.products_quantity
									FROM orders
									LEFT JOIN products_has_orders ON orders.id = products_has_orders.orders_id
									LEFT JOIN products ON products_has_orders.products_id = products.id
									LEFT JOIN pictures ON products.id = pictures.products_id
									ORDER BY products.id ASC")->result_array();
	}

	function update_status($status, $id)
	{
		$query = "UPDATE orders SET order_status = ?
					WHERE orders.id = ?";
		$values = array($status['order_status'], $id);
		return $this->db->query($query, $values);
	}



	function get_user($name)
	{		
		return $this->db->query('SELECT * FROM customers WHERE email LIKE ? ORDER BY first_name ASC', $name.'%')->result_array();
	}

	function update_product($status, $id)
	{
		$query = "UPDATE products
					INNER JOIN pictures
					ON products.id = pictures.products_id
					SET products.name = ?, 
					products.description = ?,
					products.category = ?,
					pictures.description = ?
					WHERE products.id = ?";

		$values = array($status['product_name'], $status['product_description'], $status['product_category'], $status['img_src'], $id);
	
		return $this->db->query($query, $values);

	}

	function insert_product($product)
	{
		$query = "INSERT INTO products (products.name, products.description, products.category, products.price, products.inventory_count, products.quantity_sold, products.created_at, products.updated_at)
					VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$values = array($product['product_name'], $product['product_description'], $product['product_category'], $product['product_price'], $product['inventory_count'], 0, 'NOW()', 'NOW()');

		$this->db->query($query, $values);
		$product_id=mysql_insert_id();
		return $product_id;

	}

	function insert_picture($picture, $product_id)
	{
		$query = "INSERT INTO pictures (name, description, created_at, updated_at, products_id)
				  VALUES (?, ?, ?, ?, ?)";
		$values = array($picture['img_name'], $picture['img_url'], 'NOW()', 'NOW()', $product_id);

		 $this->db->query($query, $values);
	}

	function update_inventory_count($id)
	{
		$this->db->query("UPDATE products SET products.inventory_count = 0 WHERE products.id = $id");

	}







	// function get_order($order_data = NULL)
	// {
	// 	$sql = "SELECT customers.*, orders.id AS order_id, orders.order_date, orders.order_status, products.*, products_has_orders.products_quantity
	// 				FROM orders
	// 				LEFT JOIN customers ON orders.customers_id = customers.id
	// 				LEFT JOIN products_has_orders ON orders.id = products_has_orders.orders_id
	// 				LEFT JOIN products ON products_has_orders.products_id = products.id
	// 				GROUP BY order_id
	// 				ORDER BY order_id DESC
	// 				LIMIT ?
	// 				OFFSET ?";

	// 	if($order_data['search'] == NULL)
	// 		$where = array(LEAD_LIMIT, 0)

	// 	elseif(isset($order_data['page_number']) && isset($lead_data['search']))
	// 	{

	// 		if($order_data['search'] == "")
	// 			$where = array(LEAD_LIMIT, $lead_data['page_number']);
	// 		else
	// 		{
	// 			if(is_array($order_data['search']))
	// 			{
	// 				$sql = ""
	// 			}
	// 		}
	// 	}
	// }




}
/* End of file user.php */
/* Location: ./application/controllers/user.php */