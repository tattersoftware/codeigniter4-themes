<?php namespace Tatter\Themes\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_table_themes extends Migration
{
	public function up()
	{
		$fields = [
			'name'         => ['type' => 'VARCHAR', 'constraint' => 255],
			'path'         => ['type' => 'VARCHAR', 'constraint' => 255],
			'description'  => ['type' => 'TEXT'],
			'dark'         => ['type' => 'BOOLEAN', 'default' => 0],
			'created_at'   => ['type' => 'DATETIME', 'null' => true],
			'updated_at'   => ['type' => 'DATETIME', 'null' => true],
			'deleted_at'   => ['type' => 'DATETIME', 'null' => true],
		];
		
		$this->forge->addField('id');
		$this->forge->addField($fields);

		$this->forge->addKey('name');
		$this->forge->addKey('created_at');
		
		$this->forge->createTable('themes');
	}

	public function down()
	{
		$this->forge->dropTable('themes');
	}
}
