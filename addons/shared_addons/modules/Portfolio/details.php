<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Portfolio extends Module {
	
	/* Version */
	public $version = '1.0';

	/* Info */
	public function info()
	{
		return array(
			'name' => array('en' => 'Portfolio'),
			'description' => array('en' => 'Managing Portfolio'),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content',
			'sections' => array(
				'items' => array(
					'name' => 'Portfolio',
					'uri' => 'admin/portfolio',
					'shortcuts' => array(
						'create' => array(
							'name' => 'Add Portfolio',
							'uri' => 'admin/portfolio/create',
							'class' => 'add'
						)
					)
				)
			)
		);
	}

	/* Install */
	public function install()
	{
		$this->dbforge->drop_table('tbl_portfolio');
		$this->db->delete('settings', array('module' => 'portfolio'));

		$portfolio = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => '11',
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'description' => array(
				'type' => 'TEXT',
			),
			'type' => array(
				'type'	=> 'ENUM',
				'constraint' => array('N/A','Mobile','Website'),
				'default' => 'N/A'
			),
			'image' => array(
				'type'	=> 'VARCHAR',
				'contraint' => '100'
			),
			'created_by' => array(
				'type' => 'INT',
				'constraint' => '11'
			),
			'date_created' => array(
				'type' => 'timestamp'
			)
		);

		$portfolio_setting = array(
			'slug' => 'portolio_setting',
			'title' => 'Portfolio Setting',
			'description' => 'A Yes or No option for the Portfolio module',
			'default' => '1',
			'value' => '1',
			'type' => 'select',
			'options' => '1=Yes|0=No',
			'is_required' => 1,
			'is_gui' => 1,
			'module' => 'portfolio'
		);

		$this->dbforge->add_field($portfolio);
		$this->dbforge->add_key('id', TRUE);

		if (!$this->dbforge->create_table('portfolio') OR !$this->db->insert('settings', $portolio_setting))
		{
			return FALSE;
		}

		if (!is_dir($this->upload_path,'portfolio') AND !@mkdir($this->upload_path.'portfolio', 0777, TRUE))
		{
			return FALSE;
		}

		return TRUE;
	}

	/* Uninstall */
	public function uninstall()
	{
		$this->dbforge->drop_table('portfolio');
		$this->db->delete('portfolio', array('module' => 'portfolio'));

		return TRUE;
	}

	public function upgrade($old_verion)
	{
		return TRUE;
	}

	public function help()
	{
		return 'Here you can enter HTML with paragraph tags or whatever you like';

		return $this->load->view('help', NULL, TRUE);;
	}

}

?>
