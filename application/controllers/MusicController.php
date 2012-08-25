<?php

class MusicController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $albums = new Application_Model_DbTable_Albums();
		
		/* Check for null values:
			If both the row and order are available, use those
			If only the row is available, use ascending default
			Else just mark it null		
		*/
		if( $this->_request->getParam('sort') != null && $this->_request->getParam('sortorder') != null ) {
			$sortparams = $this->_request->getParam('sort') . " " . $this->_request->getParam('sortorder');
		} else if( $this->_request->getParam('sort') != null && $this->_request->getParam('sortorder') == null ) {
			$sortparams = $this->_request->getParam('sort') . " ASC";
		} else {
			$sortparams = null;
		}
		
		$this->view->albums = $albums->fetchAll(null, "$sortparams");
		
		if ( $this->_request->getParam('sortorder') === "ASC" ) {
			if($this->_request->getParam('sort') === "artist") {
				$this->view->titleorder = "ASC";
				$this->view->artistorder = "DESC";
			} else {
				$this->view->titleorder = "DESC";
				$this->view->artistorder = "ASC";				
			}
		} else {
			$this->view->titleorder = "ASC";
			$this->view->artistorder = "ASC";
		}
	}

    public function addAction()
    {
        $form = new Application_Form_Album();
		$form->submit->setLabel('Add');
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
		
			if ($form->isValid($formData)) {
				$artist = $form->getValue('artist');
				$title = $form->getValue('title');
				$albums = new Application_Model_DbTable_Albums();
				$albums->addAlbum($artist, $title);
				
				$this->_helper->redirector('index');
			} else {
				$form->populate($formData);
			}
		}		
    }

    public function editAction()
    {
        $form = new Application_Form_Album();
		$form->submit->setLabel('Save');
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
		
			if ($form->isValid($formData)) {
				$id = (int)$form->getValue('id');
				$artist = $form->getValue('artist');
				$title = $form->getValue('title');
				$albums = new Application_Model_DbTable_Albums();
				$albums->updateAlbum($id, $artist, $title);
				
				$this->_helper->redirector('index');
			} else {
				$form->populate($formData);
			}
		} else {
			$id = $this->_getParam('id', 0);
			if ($id > 0) {
				$albums = new Application_Model_DbTable_Albums();
				$form->populate($albums->getAlbum($id));
			}
		}
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
            if ($del == 'Yes') { 
                $id = $this->getRequest()->getPost('id');
                $albums = new Application_Model_DbTable_Albums();
                $albums->deleteAlbum($id);
            }
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id', 0);
            $albums = new Application_Model_DbTable_Albums();
            $this->view->album = $albums->getAlbum($id);
        } 
    }
}









