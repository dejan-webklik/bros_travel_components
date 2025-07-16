<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;

$controller = BaseController::getInstance('Brostravel');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
