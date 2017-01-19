<?php

/**
 * Created by PhpStorm.
 * User: wamobi5
 * Date: 26/12/16
 * Time: 09:26
 */

namespace  AppBundle\Form\Model;

//cette class est un mappage du formulaire qui permet de rerentrer les données dans le formulaire une fois qu'il a été soumis
class SearchTypeModel
{
    private $title;
    private $releaseDate;
    private $category;
    private $price;

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    private $actor_search;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param mixed $releaseDate
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getActorSearch()
    {
        return $this->actor_search;
    }

    /**
     * @param mixed $actor_search
     */
    public function setActorSearch($actor_search)
    {
        $this->actor_search = $actor_search;
    }



}