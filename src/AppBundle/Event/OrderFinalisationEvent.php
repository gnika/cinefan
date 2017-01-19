<?php
/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 28/12/16
 * Time: 16:50
 */

namespace AppBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class OrderFinalisationEvent Extends Event
{
    private $cart;
    private $userEmail;
    private $fileName;

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return mixed
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param mixed $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * @param mixed $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    public function __construct()
    {
    }
}