<?php

namespace Model\Entities;

use App\Entity;

final class Message extends Entity{
    private $id;
    private $text;
    private $messCreatedAt;
    private User $user;
    private Topic $topic;

    public function __construct($data){
        $this->hydrate($data);
    }


    /**
     * Get the value of text
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @return  self
     */ 
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the value of messCreatedAt
     */ 
    public function getMessCreatedAt()
    {
        return $this->messCreatedAt;
    }

    /**
     * Set the value of messCreatedAt
     *
     * @return  self
     */ 
    public function setMessCreatedAt($messCreatedAt)
    {
        $formatDate = strtotime( $messCreatedAt );      
        //utilisée pour convertir la date en timestamp Unix.
        //Cela signifie que la date est convertie en un nombre qui représente le nombre de secondes écoulées depuis le 1er janvier 1970 à 00:00:00 UTC.
        $messCreatedAt = date( 'd/m/Y', $formatDate );      //utilisée pour formater ce timestamp en une chaîne de caractères représentant la date au format 'd/m/Y' (jour/mois/année).

        $this->messCreatedAt = $messCreatedAt;

        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of topic
     */ 
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set the value of topic
     *
     * @return  self
     */ 
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}