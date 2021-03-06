<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
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
			'full_name' => [
				'type'       => 'VARCHAR',
				'constraint' => '200',
			],
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => '200',
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => '200',
			],
			'mobile_no' => [
				'type' => 'VARCHAR',
				'constraint' => '15',
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => '200',
			],
			'profile_image' => [
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
		$this->forge->createTable('tbl_user');
	}

	public function down()
	{
		$this->forge->dropTable('tbl_user');
	}
}
