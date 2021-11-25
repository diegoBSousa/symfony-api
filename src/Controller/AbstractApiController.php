<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as ControllerAbstractController;
use Symfony\Component\Form\FormInterface;

abstract class AbstractController extends ControllerAbstractController
{
  protected function buildForm(
    string $type,
    $data = null,
    array $options = []
  ): FormInterface {
    $options = array_merge($options, [
      'csrf_protection' => false,
    ]);

    return $this->container->get('form.factory')
      ->createNamed('', $type, $data, $options);
  }
}
