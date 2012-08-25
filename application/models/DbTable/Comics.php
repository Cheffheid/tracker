<?php

class Application_Model_DbTable_Comics extends Zend_Db_Table_Abstract
{

    protected $_name = 'comics';
	
	public function getComic($id)
	{
		$id = (int)$id;
		$row = $this->fetchRow('id = ' . $id);
		if (!$row) {
			throw new Exception("Could not find row $id");
		}
		return $row->toArray();	
	}
	
	public function addComic($issuenr, $title)
	{
		$data = array(
			'issuenr' => $issuenr,
			'title' => $title,
		);
		$this->insert($data);	
	}
	
	public function updateComic($id, $issuenr, $title)
	{
		$data = array(
			'issuenr' => $issuenr,
			'title' => $title,
		);
		$this->update($data, 'id = ' . (int)$id);
	}
	
	public function deleteComic($id)
	{
		$this->delete('id =' . (int)$id);
	}


}

