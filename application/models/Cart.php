<?php
class Cart extends CI_Model {

  //needed to build the cart
  public function get_all_products()
  {
    return $this->db->query("SELECT * FROM products")->result_array();
  }

  public function get_by_id($id)
  {
    $query = 'SELECT * FROM products WHERE id = ?';
    return $this->db->query($query, $id)->row_array();
  }

  //needed to submit order after Pay is clicked
  //first step, add customer and billing info to database and return customer id
  public function create_customer($billing)
  {
  	$query = "INSERT INTO `ecommerce`.`customers` 
		(`first_name`, `last_name`, `address`, 
		`address_2`, `city`, `state`, `zipcode`, 
		`created_at`, `updated_at`) 
		VALUES (?,?,?,?,?,?,?,Now(),Now())";
	$values = array($billing['bfname'],$billing['blname'],$billing['baddress'],
		 $billing['baddress2'], $billing['bCity'],$billing['bState'], $billing['bZipcode']);
   $this->db->query($query, $values);
   $customer_id=mysql_insert_id();
   return  $customer_id;
  }

  //needed to submit order after Pay is clicked
  //second step, add shipping info to databsse and return shipping id
  public function create_shipping($shipping)
  {
  	$price=rand(2, 20);
  	$query = "INSERT INTO `ecommerce`.`shipping_information` 
		(`first_name`, `last_name`, `address`, 
		`address_2`, `city`, `state`, `zipcode`, `price`,
		`created_at`, `updated_at`) 
		VALUES (?,?,?,?,?,?,?,?,Now(),Now())";
	$values = array($shipping['sfname'],$shipping['slname'],$shipping['saddress'],
		 $shipping['saddress2'], $shipping['sCity'],$shipping['sState'], $shipping['sZipcode'],$price);
   $this->db->query($query, $values);
   $shipping_id=mysql_insert_id();
   return  $shipping_id;
  }

  //needed to submit order after Pay is clicked
  //third step, add order info to databsse and return order id
  public function create_order($customer_id,$shipping_id)
  {
  $query = "INSERT INTO `ecommerce`.`orders` 
		(`order_date`,`order_status` ,`customers_id`, `shipping_information_id`,
		`created_at`, `updated_at`) 
		VALUES (Now(),'Order in Process',$customer_id,$shipping_id,Now(),Now())";
   $this->db->query($query);
   $order_id=mysql_insert_id();
   return  $order_id;
  }

  //needed to submit order after Pay is clicked
  //fourth step, add order details to the product_has_orders table
 
  public function add_to_products_has_orders($order_id,$key,$value)
  {  	
	$query = "INSERT INTO `ecommerce`.`products_has_orders` 
			(`orders_id`, `products_id`, `products_quantity`) 
			VALUES ($order_id, $key, $value)";
  $this->db->query($query);
  $query1="UPDATE products SET inventory_count = inventory_count - $value 
      WHERE id=$key";
  $this->db->query($query1);
  $query2="UPDATE products SET quantity_sold = quantity_sold + $value 
      WHERE id=$key";
  $this->db->query($query2);
  }   
}
