<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Fields.Gallery
 *
 * @copyright   Copyright (C) Guido De Gobbis (JoomTools), Barbara Assmann.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Model\BaseDatabaseModel;

JLoader::import('components.com_fields.libraries.fieldsplugin', JPATH_ADMINISTRATOR);

/**
 * Fields Imagelist Plugin
 *
 * @since  1.0
 */
class PlgFieldsGallery extends FieldsPlugin
{
	/**
	 * @var   string
	 *
	 * @since   1.0
	 */
	private $context;

	/**
	 * Show field only in allowed sections
	 *
	 * @return   array|\string[][]
	 *
	 * @since    1.0
	 */
	public function onCustomFieldsGetTypes()
	{
		if (in_array($this->context, array(
			'com_fields.field.com_content.article',
			'com_fields.field.com_content.categories',
			null,
		)))
		{
			return parent::onCustomFieldsGetTypes();
		}

		return array();
	}

	/**
	 * Set context for validation of allowed sections
	 *
	 * @param   \JForm     $form
	 * @param   \stdClass  $data
	 *
	 * @return   void
	 *
	 * @since   1.0
	 */
	public function onContentPrepareForm(JForm $form, $data)
	{
		$this->context = $form->getName();

		return parent::onContentPrepareForm($form, $data);
	}
	/**
	 * Transforms the field into a DOM XML element and appends it as a child on the given parent.
	 *
	 * @param   stdClass    $field   The field.
	 * @param   DOMElement  $parent  The field node parent.
	 * @param   JForm       $form    The form.
	 *
	 * @return  DOMElement
	 *
	 * @since   3.9.0
	 */
	public function onCustomFieldsPrepareDom($field, DOMElement $parent, JForm $form)
	{
		$fieldNode = parent::onCustomFieldsPrepareDom($field, $parent, $form);

		if (!$fieldNode)
		{
			return $fieldNode;
		}

		$readonly = false;

		if (!FieldsHelper::canEditFieldValue($field))
		{
			$readonly = true;
		}

		$fieldNode->setAttribute('type', 'subform');
//		$fieldNode->setAttribute('layout', 'joomla.form.field.subform.repeatable-table');
		$fieldNode->setAttribute('required', false);

		// Build the form source
		$fieldParams = JPATH_PLUGINS . '/' . $this->_type . '/' . $this->_name . '/xml/gallery.xml';
		$fieldsXml = new SimpleXMLElement($fieldParams, 0, true);

		$fieldNode->setAttribute('formsource', $fieldsXml->asXML());

		// Return the node
		return $fieldNode;
	}

	/**
	 * The save event.
	 *
	 * @param   string   $context  The context
	 * @param   JTable   $item     The article data
	 * @param   boolean  $isNew    Is new item
	 * @param   array    $data     The validated data
	 *
	 * @return  boolean
	 *
	 * @since   3.9.0
	 */
	public function onContentAfterSave($context, $item, $isNew, $data = array())
	{
		// Create correct context for category
		if ($context == 'com_categories.category')
		{
			$context = $item->get('extension') . '.categories';

			// Set the catid on the category to get only the fields which belong to this category
			$item->set('catid', $item->get('id'));
		}

		// Check the context
		$parts = FieldsHelper::extract($context, $item);

		if (!$parts)
		{
			return true;
		}

		// Compile the right context for the fields
		$context = $parts[0] . '.' . $parts[1];

		// Loading the fields
		$fields = FieldsHelper::getFields($context, $item);

		if (!$fields)
		{
			return true;
		}

		// Get the fields data
		$fieldsData = !empty($data['com_fields']) ? $data['com_fields'] : array();

		// Loading the model
		/** @var FieldsModelField $model */
		$model = BaseDatabaseModel::getInstance('Field', 'FieldsModel', array('ignore_request' => true));

		// Loop over the fields
		foreach ($fields as $field)
		{
			// Find the field of this type repeatable
			if ($field->type !== $this->_name)
			{
				continue;
			}

			// Determine the value if it is available from the data
			$value = key_exists($field->name, $fieldsData) ? $fieldsData[$field->name] : null;

			// Setting the value for the field and the item
			$model->setFieldValue($field->id, $item->get('id'), json_encode($value));
		}

		return true;
	}
}
