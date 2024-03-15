<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'prestashop.core.form.identifiable_object.data_handler.profile_form_data_handler' shared service.

return $this->services['prestashop.core.form.identifiable_object.data_handler.profile_form_data_handler'] = new \PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataHandler\ProfileFormDataHandler(($this->services['prestashop.core.command_bus'] ?? $this->load('getPrestashop_Core_CommandBusService.php')), ($this->services['prestashop.adapter.image.uploader.profile_image_uploader'] ?? ($this->services['prestashop.adapter.image.uploader.profile_image_uploader'] = new \PrestaShop\PrestaShop\Adapter\Image\Uploader\ProfileImageUploader((\dirname(__DIR__, 4).'/img/pr/'), (\dirname(__DIR__, 4).'/img/tmp/')))));