<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractApiController extends AbstractFOSRestController
{
  /**
   * @var SerializerInterface
   */
  protected SerializerInterface $serializer;

  public function __construct(SerializerInterface $serializer)
  {
    $this->serializer = $serializer;
  }

  protected function buildForm(
    string $type,
    $data = null,
    array $options = []
  ): FormInterface {
    $options = array_merge($options, [
      //'csrf_protection' => false, // have to install security bundle
    ]);

    return $this->container->get('form.factory')
      ->createNamed('', $type, $data, $options);
  }
}
