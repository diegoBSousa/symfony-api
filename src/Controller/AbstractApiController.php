<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractApiController extends AbstractController
{
  /**
   * @var SerializerInterface
   */
  protected SerializerInterface $serializer;

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

  public function __construct(SerializerInterface $serializer)
  {
    $this->serializer = $serializer;
  }
}
