<?php

namespace BaconCustomUserBundle\Service;

/**
 * Classe responsavel pela integração com a API do RD Station
 *
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 * @version 0.1
 */
class User
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param string $userClass
     * @throws \Exception
     */
    public function __construct($userClass)
    {
        if ( empty($userClass)  )
            throw new \Exception("Inform BaconCustomUser.userClass as the first argument.");

        $this->class = $userClass; 
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getRepository()
    {
        $classArray = explode('\\',  $this->class);
        $entity = array_pop($classArray);
        $bundle = array_shift($classArray);
        return $bundle . ':' . $entity;
    }
}