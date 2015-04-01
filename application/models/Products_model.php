<?php
class Products_model extends CI_Model {
	
	function get_all_products() 
	{	
		// $query="SELECT * from products ORDER BY price ASC";

		$query="SELECT products.inventory_count,products.name, products.price, products.id,pictures.description
			from products
			join pictures
			on products.id=pictures.products_id
			where pictures.main=1
			order by products.price DESC";
		return $this->db->query($query)->result_array();
	}

		function get_all_products_sort($sortBy) 
	{	
		$query="SELECT products.inventory_count,products.name, products.price, products.id,pictures.description
			from products
			join pictures
			on products.id=pictures.products_id
			where pictures.main=1
			order by products.$sortBy";
		return $this->db->query($query)->result_array();
	}

		function get_all_products_sort_category($sortBy, $category) 
	{	
		$query="SELECT products.inventory_count,products.name, products.price, products.id,pictures.description
			from products
			join pictures
			on products.id=pictures.products_id
			where pictures.main=1 AND products.category='$category'
			order by products.$sortBy";
		return $this->db->query($query)->result_array();
	}
	
	function get_by_id($id) 
	{		
		$query="SELECT * from products WHERE id=?";
		return $this->db->query($query,$id)->row_array();

	}

	function get_all_categories()
	{
		$query="SELECT category, count(category) AS count FROM products
				group by category";
		return $this->db->query($query)->result_array();		
	}

	function get_by_category($cat) 
	{		
		$query="SELECT products.inventory_count,products.name, products.price, products.id,pictures.description
			from products
			join pictures
			on products.id=pictures.products_id
			where pictures.main=1 and products.category=?
			order by products.price ASC";
		return $this->db->query($query,$cat)->result_array();
	}
	
	function get_picture_by_id($id)
	{
		$query="SELECT * from pictures WHERE products_id=?";
		return $this->db->query($query,$id)->result_array();

	}

	function get_all_pictures()
	{
		$query="SELECT * from pictures";
		return $this->db->query($query)->result_array();

	}

	function search_products($search)
	{
		$query="SELECT products.inventory_count,products.name, products.price, 
				products.id,pictures.description
				from products
				JOIN pictures
				on products.id=pictures.products_id
				where pictures.main=1
				AND (products.name like '%$search%' 
				OR
				products.description like '%$search%'
				OR
				products.category like '%$search%')
				order by products.price ASC";
		return $this->db->query($query)->result_array();
	}
}
