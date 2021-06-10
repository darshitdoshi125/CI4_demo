<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Product extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'user_id' => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'product_name' => [
				'type'       => 'VARCHAR',
				'constraint' => '200',
			],
			'description' => [
				'type' => 'TEXT',
			],
			'price' => [
				'type' => 'FLOAT',
			],
			'stock' => [
				'type' => 'DECIMAL',
				'constraint' => '10,0',
			],
			'product_image' => [
				'type' => 'VARCHAR',
				'constraint' => '300',
			],
			'status' => [
				'type' => 'ENUM',
				'constraint' => "'active', 'inactive', 'deleted'",
				'default' => 'active'
			],
			'created_date' => [
				'type' => 'datetime default current_timestamp',
			],
			'updated_date' => [
				'type' => 'datetime default current_timestamp',
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('tbl_product');
	}

	public function down()
	{
		$this->forge->dropTable('tbl_product');
	}
}
