<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

//product page functions
 public function index()
 {
  $this->session->unset_userdata('categ');
  $this->load->model('Products_model');
  $product['product']=$this->Products_model->get_all_products();
  $product['categories']=$this->Products_model->get_all_categories();
  $product['category']='All Products';
  if(($this->session->userdata('cart')['total_items'])==0)
    {
    $empty=array('total_items'=>0);
    $cart=$this->session->set_userdata('cart',$empty);
    }
    else
    {
      $cart = $this->session->userdata('cart'); 
    }
  $this->load->view('products',$product);
 }

  public function sortBy()
 {
  $sortBy=$this->input->post('sortBy');
  if($sortBy=='blank')
  {
    redirect('/');
  }  
  $this->load->model('Products_model');

  if(!$this->session->userdata('categ'))
    {      
      $product['product']=$this->Products_model->get_all_products_sort($sortBy);
      $product['categories']=$this->Products_model->get_all_categories();
      $product['category']='All Products';
    }
    else if($this->session->userdata('categ'))
    {
      $category=$this->session->userdata('categ');
      $product['product']=$this->Products_model->get_all_products_sort_category($sortBy,$category);
      $product['categories']=$this->Products_model->get_all_categories();
      $product['category']=$category;
    }
  if(($this->session->userdata('cart')['total_items'])==0)
    {
    $empty=array('total_items'=>0);
    $cart=$this->session->set_userdata('cart',$empty);
    }
    else
    {
      $cart = $this->session->userdata('cart'); 
    }
  if($sortBy=="quantity_sold")
  {
    $sortBy="Most Popular";
  }
  else if ($sortBy=="price")
  {
   $sortBy="Price (low-high)" ;
  }
  $this->session->set_userdata('sortBy',$sortBy);
  $this->load->view('products',$product);
 }

  public function product_category($category)
  {
    $this->load->model('Products_model');
    $product['product']=$this->Products_model->get_by_category($category);
    $product['categories']=$this->Products_model->get_all_categories();
    $product['category']=$category;
    if(($this->session->userdata('cart')['total_items'])==0)
    {
    $empty=array('total_items'=>0);
    $cart=$this->session->set_userdata('cart',$empty);
    }
    else
    {
      $cart = $this->session->userdata('cart'); 
    }

  $this->session->unset_userdata('sortBy');
  $this->session->set_userdata('categ',$category);
  $this->load->view('products',$product);
  }

  public function product_desc($id)
 {
  $this->load->model('Products_model');
  $product['product']=$this->Products_model->get_by_id($id);
  $cat=$product['product']['category'];
  $product['prod_pictures']=$this->Products_model->get_picture_by_id($id);
  $product['categories']=$this->Products_model->get_by_category($cat);
  $product['all_pictures']=$this->Products_model->get_all_pictures();
  $this->load->view('product_desc',$product);
 }

public function search()
{
  $search=$this->input->post('productName');
  if ($search==null)
  {
    redirect ('/');
  }
  $this->load->model('Products_model');
  $searchResults=$this->Products_model->search_products($search);
  if(count($searchResults)<1)
  {
    redirect ('/');
  }
  $product['product']=$searchResults;
  $product['categories']=$this->Products_model->get_all_categories();
  $product['category']=$search;
  if(($this->session->userdata('cart')['total_items'])==0)
    {
    $empty=array('total_items'=>0);
    $cart=$this->session->set_userdata('cart',$empty);
    }
    else
    {
      $cart = $this->session->userdata('cart'); 
    }

  $this->load->view('products',$product);

}
 
//shopping cart functions
 public function cart()
 {
   // to show cart with items
   // get info for each item in cart & build array to send to the view for display of each item in the cart

   // get current cart
   $cart = $this->session->userdata('cart');

   // load the model
   $this->load->model('Cart');

   // temporary array to build display info
   $show_cart = array();
   // temporary variable to hold total price
   $total_price = 0;

   // loop through each item in cart $key=item id, $value=quantity

   foreach($cart as $key => $value)
   {
     if($key != 'total_items')
     {
       // call model with id of each product in cart
       // these are the actual products. build view array based off of these
       $item = $this->Cart->get_by_id($key);

       // for each item in cart add associative array of the values needed in the view
       $show_cart[] = array(
           'id' => $item['id'],
           'name'=> $item['name'],
           'price' => $item['price'],
           'quantity' => $value,
           'total' => ($item['price'] * $value),
           'inventory' => $item['inventory_count'],
         );
       // continue adding to total price
       $total_price += ($item['price'] * $value);
     }
   }
   // put total price into array for display info
   $show_cart['total_price'] = $total_price;

   // save in array variable with key that you can access on the view side (the key on the controller side is the variable on the view side)
   $send['cart'] = $show_cart;
 
   // load view with data  
   $this->load->view('cart', $send); 
 }

 public function add_item_to_cart()
  {
    // get item info from post
    $product_id = $this->input->post('product_id', TRUE);
    $quantity = $this->input->post('quantity', TRUE);
    // get current cart
    $cart = $this->session->userdata('cart');    
  
    // determine if item exists in cart
    if(array_key_exists($product_id, $cart))
    {
      // item already in cart, update value (quantity) for this item's key in cart
      $cart['total_items'] +=  $quantity;
      $cart[$product_id] += $quantity;
      $this->session->set_userdata('cart', $cart);
    }
    else
    {
      // add new key=>value pair to cart for new item id=>quantity
      $cart['total_items'] += $quantity;
      $cart[$product_id] = $quantity;
      // populate cart in session
      $this->session->set_userdata('cart', $cart);
    }
  

    redirect('/Welcome/product_desc/'.$product_id);
  }

  public function update($id)
  {

    //delete the product from the cart first
    // get current cart
    $cart = $this->session->userdata('cart');

    // update the total items in the cart array
    $total_items = $this->session->userdata('cart')['total_items'];
    
    $total_items -= $cart[$id];
    
    //reset cart 'total_items'
    $cart['total_items'] = $total_items;
   
    // remove item from cart array in session
    unset($cart[$id]);
    //populate cart in session
    $this->session->set_userdata('cart', $cart);
  
    $cartProductId=$id;
    $cartQuantity = $this->input->post('cartQuantity', TRUE);

    //add new quantity back to cart
    // get item info from post
    $product_id = $cartProductId;
    $quantity = $cartQuantity;

    // get current cart
    $cart = $this->session->userdata('cart'); 

    // add new key=>value pair to cart for new item id=>quantity
    $cart['total_items'] += $quantity;
    $cart[$product_id] = $quantity;
    // populate cart in session
    $this->session->set_userdata('cart', $cart);
    redirect('/Welcome/cart/');
  }

  public function delete($id)
  {
    // get current cart
    $cart = $this->session->userdata('cart');

    // update the total items in the cart array
    $total_items = $this->session->userdata('cart')['total_items'];
    $total_items -= $cart[$id];
    //reset cart 'total_items'
    $cart['total_items'] = $total_items;
    // remove item from cart array in session
    unset($cart[$id]);
    // populate cart in session
    $this->session->set_userdata('cart', $cart);
    redirect('/Welcome/cart');
  }

  public function pay()
 {
  //get cart information
 $cart=$this->session->userdata('cart');

  //get shipping info from post data
  $shipping = array(
    'sfname' => $this->input->post('sfname'),
    'slname' => $this->input->post('slname'),
    'saddress' => $this->input->post('saddress'),
    'saddress2' => $this->input->post('saddress2'),
    'sCity' => $this->input->post('sCity'),
    'sState' => $this->input->post('sState'),
    'sZipcode' => $this->input->post('sZipcode'),
  );
  //get billing info from post data

    $billing = array(
    'bfname' => $this->input->post('bfname'),
    'blname' => $this->input->post('blname'),
    'baddress' => $this->input->post('baddress'),
    'baddress2' => $this->input->post('baddress2'),
    'bCity' => $this->input->post('bCity'),
    'bState' => $this->input->post('bState'),
    'bZipcode' => $this->input->post('bZipcode'),
    
    //this is not saved to db, instead use Stripe to process the card
    // 'cardnum' => $this->input->post('cardnum'),
    // 'security' => $this->input->post('security'),
    // 'month' => $this->input->post('month'),
    // 'year' => $this->input->post('year'),
  );
    
  //now, submit all order data to the database
  $this->load->model('Cart');
  $customer_id=$this->Cart->create_customer($billing);
  $shipping_id=$this->Cart->create_shipping($shipping);
  $order_id=$this->Cart->create_order($customer_id,$shipping_id);  
  $product_total=0;
  foreach($cart as $key => $value)
    {     
      if($key !== 'total_items')
      {
        $this->Cart->add_to_products_has_orders($order_id,$key,$value);
      }
    }
  $empty=array('total_items'=>0);
  $cart=$this->session->set_userdata('cart',$empty);
  $cart = $this->session->userdata('cart');
  $this->load->view('pay_success');
 }

//admin controller functions
  public function admin()
 {
  $this->load->view('admin_login');
 }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */