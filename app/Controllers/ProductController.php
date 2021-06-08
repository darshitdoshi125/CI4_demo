<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class ProductController extends BaseController
{
	public $db;
	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$is_logged_in = session()->get('userData')->logged_in;
		if(!isset($is_logged_in) || $is_logged_in!==TRUE) {
			redirect('/');
			exit;
		}
	}

	public function index()
	{
		$data['title'] = 'Product List';
		$data['menu'] = "productList";
		$data['main_content'] = 'product/product_list';
		return view('partials/template',$data);
	}

	public function ajaxLoadProductData()
	{
		$params['draw'] = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $search_value = $_REQUEST['search']['value'];

        if(!empty($search_value))
		{
            $total_count = $this->db->query("SELECT * from tbl_product WHERE id like '%".$search_value."%' OR product_name like '%".$search_value."%' OR description like '%".$search_value."%' OR price like '%".$search_value."%' OR stock like '%".$search_value."%'")->getResult();

            $data = $this->db->query("SELECT * from tbl_product WHERE id like '%".$search_value."%' OR product_name like '%".$search_value."%' OR description like '%".$search_value."%' OR price like '%".$search_value."%' OR stock like '%".$search_value."%' limit $start, $length")->getResult();
        }
		else
		{
            $total_count = $this->db->query("SELECT * from tbl_product where status != 'deleted'")->getResult();

            $data = $this->db->query("SELECT * from tbl_product where status != 'deleted' limit $start, $length")->getResult();
        }
        
        $json_data = array(
            "draw" => intval($params['draw']),
            "recordsTotal" => count($total_count),
            "recordsFiltered" => count($total_count),
            "data" => $data   // total data array
        );

        echo json_encode($json_data);
	}

	public function addProduct($id = '')
	{
		if($id != '')
		{
			$productModel = new ProductModel();
			$data['title'] = 'Edit Product';
			$data['menu'] = "productList";
			$productModel->select('*');
			$productModel->where('id', $id);		
			$productModel->where('status', 'active');			
			$query = $productModel->get();
			$data['product_data'] = $query->getRow();
		}
		else
		{
			$data['title'] = 'Add Product';
			$data['menu'] = "productList";
		}
		$data['main_content'] = 'product/add_product';
		return view('partials/template',$data);
	}

	public function saveProduct()
	{
		$productModel = new ProductModel();
		$id = $this->request->getVar('id');
		if($file = $this->request->getFile('file')) 
		{
			if ($file->isValid() && !$file->hasMoved()) 
			{
				if($id != 0) 
				{
					$productModel->select('product_image');
					$productModel->where('id', $id);		
					$productModel->where('status', 'active');			
					$query = $productModel->get();
					$product_image = $query->getRow()->product_image;
					if(file_exists('../public/uploads/product/'.$product_image)) 
					{
						unlink('../public/uploads/product/'.$product_image);
					}	
				}
               	$name = $file->getName();
               	$ext = $file->getClientExtension();
               	$newName = $file->getRandomName(); 
               	$file->move('../public/uploads/product', $newName);

               	$data['product_image'] = $newName;
			}
			else 
			{
				$response = [
					'error' => false,
					'msg' => "File not uploaded",
				];
			}
		}
		$data['product_name'] = $this->request->getVar('product_name');
		$data['description'] = $this->request->getVar('description');
		$data['price'] = $this->request->getVar('price');
		$data['stock'] = $this->request->getVar('stock');
		$data['user_id'] = session()->get('userData')->id;
		
		if($id == 0) 
		{
			if ($productModel->insert($data)) 
			{
				$response = [
					'success' => true,
					'msg' => "Product added successfully",
				];
			} 
			else 
			{
				$response = [
					'error' => false,
					'msg' => "something went wrong please try again",
				];
			}
		}
		else 
		{
			if ($productModel->update($id, $data)) 
			{
				$response = [
					'success' => true,
					'msg' => "Product updated successfully",
				];
			} 
			else 
			{
				$response = [
					'error' => false,
					'msg' => "something went wrong please try again",
				];
			}
		}
		return $this->response->setJSON($response);
	}

	public function checkProduct() 
	{
		$productModel = new ProductModel();
		$product_name = $this->request->getVar('product_name');
		$product_id = $this->request->getVar('product_id');

		if($product_id != 0)
		{
			$productModel->select('*');
			$productModel->where('id !=', $product_id);		
			$productModel->where('product_name', $product_name);		
			$productModel->where('status', 'active');		
			$check_product = $productModel->get();
		}
		else
		{
			$productModel->select('*');
			$productModel->where('product_name', $product_name);		
			$productModel->where('status', 'active');			
			$check_product = $productModel->get();
		}

		if(empty($check_product->getRow()))
		{
			echo json_encode(true);
		}
		else
		{
			echo json_encode('Product already exists.');
		}
	}

	public function changeBlockStatus()
	{
		$productModel = new ProductModel();
		$id = $this->request->getVar('id');
		$flag = $this->request->getVar('flag');

		$edit_data['status'] = ($flag != '0') ? 'inactive' : 'active';
		return $productModel->update($id, $edit_data);
	}

	public function deleteProduct()
	{
		$productModel = new ProductModel();
		$product_lists = explode(',', $this->request->getVar('list_array'));
		$is_deleted = 0;
		$edit_data['status'] = 'deleted';
		$productModel->update($product_lists, $edit_data);
		$is_deleted = 1;
		if ($is_deleted) {
			return $is_deleted;
		}
	}
}
