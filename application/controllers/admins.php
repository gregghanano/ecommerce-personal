<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admins extends CI_Controller {
  public function login_user()
  {
    $this->load->model('Admin');
    $admin = $this->Admin->get_admin_by_email($this->input->post('email'));
    if($admin && $admin['password'] == $this->input->post('password'))
    {
      //user validation successful, set user session, redirect to profile function
      $admin_info = array(
          'admin_id' => $admin['id'],
          'admin_is_logged_in' => TRUE,
          'name' => $admin['first_name']);
      $this->session->set_userdata($admin_info);
      redirect('/admins/orders/');

    }
    else
    {
      //invalid login - redirect to login page, display errors
      $errors[] = 'Invalid credentials, please try again.';
      $this->session->set_flashdata('errors', $errors);
      redirect('/welcome/admin/');
    }
  }

  public function orders()
  {

    if ($this->session->userdata('admin_is_logged_in'))
    {
      $this->load->model('Admin');
      $results['customers'] = $this->Admin->get_orders_with_customers();
      // var_dump($results);
      // die();
      $this->load->view('search', $results);
 
    }
  }

  public function order_id($id)
  {
    // var_dump($id);
    // die();
    // var_dump($row);
    // die();
    $this->load->model('Admin');
    $status = $this->input->post('status');

    $status_details = array(
                      'order_status' => $status);
    // var_dump($status_details);
    // die();

    $status = array(
                  $id => $status);

    // var_dump($status);
    // die();

    //update database
    $status_update=$this->Admin->update_status($status_details, $id);

    $this->load->model('Admin');
    $row['customer'] = $this->Admin->get_orders_with_customer($id);
    $row['shipping'] = $this->Admin->get_orders_with_shipping($id);
    $row['products'] = $this->Admin->get_orders_with_products($id);
    // var_dump($row);
    // die();
    $this->session->set_userdata($row);
    $this->load->view('order_id',$row);

  }

 public function product_inventory()
 {
  $this->load->model('Admin');
  $results['products'] = $this->Admin->get_all_pictures_with_products();
  // var_dump($results);
  // die();
  $this->load->view('product_inventory', $results);
 }

 public function add_product()
 {
  $this->load->model('Admin');

 }

 public function edit_product($id)
 {
  $this->load->model('Admin');
  $product_name = $this->input->post('product_name');
  $product_description = $this->input->post('product_description');
  $product_category = $this->input->post('product_category');
  $img_src = $this->input->post('img_src');

  $product_update = array(
                      'product_name' => $product_name,
                      'product_description' => $product_description,
                      'product_category' => $product_category,
                      'img_src'=>$img_src
                      );

  // var_dump($product_update);
  // die();

  $this->Admin->update_product($product_update, $id);

  $results['products'] = $this->Admin->get_all_pictures_with_products();

  // var_dump($results);
  // die();

  $this->load->view('product_inventory', $results);

 }

 public function insert_product()
 {
  $this->load->model('Admin');
  $product_name = $this->input->post('product_name');
  $product_description = $this->input->post('product_description');
  if($this->input->post('new_category') != NULL)
  {
    $product_category = $this->input->post('new_category');
  }
  else
  {
    $product_category = $this->input->post('product_category');
  }
  $product_price = $this->input->post('product_price');
  $inventory_count = $this->input->post('inventory_count');


  $product_insert = array(
                    'product_name' => $product_name,
                    'product_description' => $product_description,
                    'product_category' => $product_category,
                    'product_price' => $product_price,
                    'inventory_count' => $inventory_count,
                    );

  $img_name = $this->input->post('img_name');
  $img_url = $this->input->post('img_url');

  $picture_insert = array(
                    'img_name' => $img_name,
                    'img_url' => $img_url
                    );
  $results['products']= $this->Admin->insert_product($product_insert);
  
  $this->Admin->insert_picture($picture_insert, $results['products']);
  // var_dump($results);
  // die();

  redirect('/Admins/product_inventory');

 }


public function product_delete($id)
{
  $this->load->model('Admin');
  $this->Admin->update_inventory_count($id);
  redirect('/Admins/product_inventory');

}




  // public function update()
  // {
  //   $this->load->model('Admin');
  //   $new_product = $this->input->post();
  //   $new_product_details = array(
  //                           'product_name' => $new_product['product_name'],
  //                           'product_description' => $new_product['product_description'],
  //                           'product_category' => $new_product['product_category'],
  //                           );
  //   var_dump($new_product_details);
  //   die();

  // }

  public function search()
  {
    $this->load->model('Admin');
    $search = $this->input->post('order_search');
    $customer_data['customers'] = $this->Admin->search_customers($search);
    $this->load->view('search', $customer_data);
  }

  public function search_product()
  {
    $this->load->model('Admin');
    $search = $this->input->post('search');
    $product_data['products'] = $this->Admin->search_products($search);
    $this->load->view('product_inventory', $product_data);

  }

  // public function pagination($pages, $search_data)
  // {
  //   $data['html'] = "";

  //   // get pagination buttons based on order id
  //   if(isset($search_data['order_id']))
  //   {
  //     foreach(range(1, $pages) as $page)
  //     {
  //       $this->view_data = array(
  //         'search' => $search_data['first_name'],
  //         'page' => $page
  //         );

  //       $data['html'] .= $this->load->view('/partial_button', $this->view_data, TRUE); 
  //     }
  //   }
  //   // get pagination buttons based on first_name search
  //   elseif(isset($search_data['first_name']))
  //   {
  //     foreach(range(1, $pages) as $page)
  //     {
  //       $this->view_data = array(
  //         'search' => $search_data['first_name'],
  //         'page' => $page
  //         );

  //       $data['html'] .= $this->load->view('/partial_button', $this->view_data, TRUE);

  //     }
  //   }

  //   elseif(isset($search_data['order_date']))
  //   {
  //     foreach(range(1, $pages) as $page)
  //     {
  //       $this->view_data = array(
  //         'search' => $search_data['order_date'],
  //         'page' => $page
  //         );

  //       $data['html'] .= $this->load->view('/partial_button', $this->view_data, TRUE);
  //     }
  //   } 

  //   elseif(isset($search_data['address']))
  //   {
  //     foreach(range(1, $pages) as $page)
  //     {
  //       $this->view_data = array(
  //         'search' => $search_data['address'],
  //         'page' => $page
  //         );

  //       $data['html'] .= $this->load->view('/partial_button', $this->view_data, TRUE);
  //     }
  //   }

  //   else
  //   {
  //     $search = $search_data[0]. ',' .$search_data[1];
  //     foreach(range(1, $pages) as $page)
  //     {
  //       $this->view_data = array(
  //         'search' => $search,
  //         'page' => $page
  //         );

  //       $data['html'] .= $this->load->view('/partial_button', $this->view_data, TRUE);
  //     }
  //   }

  //   return $data['html'];
  // }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect("/Welcome/admin");
  }
}


/* End of file admins.php */
/* Location: ./application/controllers/admins.php */