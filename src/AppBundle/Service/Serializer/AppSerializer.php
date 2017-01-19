<?php

Namespace AppBundle\Service\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AppSerializer
{
    private $normalizers = [];
    private $encoders = [];
    private $serializer;

    public function __construct(ObjectNormalizer $objectNormalizer, array $encoders)
    {
        $this->normalizers[] = $objectNormalizer;
        $this->encoders = $encoders;


        //serialisateur
        $this->serializer = new Serializer($this->normalizers, $this->encoders);

        $this->normalizers[0]->setCircularReferenceHandler(function ($object) {
            return $object;
        });



    }

    public function serialize($data, $format){
        return $this->serializer->serialize($data, $format);
    }
}