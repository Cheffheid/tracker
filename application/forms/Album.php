<?php

class Application_Form_Album extends Zend_Form
{

	public function init()
	{
		$this->setName('album');
		
		// Add hidden field "id"
		$id = new Zend_Form_Element_Hidden('id');
		$id->addFilter('Int');
		
		// Add text field "artist"
		$artist = new Zend_Form_Element_Text('artist');
		$artist->setLabel('Artist')
			   ->setRequired(true)
			   ->addFilter('StripTags')
			   ->addFilter('StringTrim')
			   ->addValidator('NotEmpty');
			   
		// Add text field "title"
		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Title')
			  ->setRequired(true)
			  ->addFilter('StripTags')
			  ->addFilter('StringTrim')
			  ->addValidator('NotEmpty');
		
		// Add submit button
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		
		$this->addElements(array($id, $artist, $title, $submit));
	}
}

