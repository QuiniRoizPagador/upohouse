<?php

class Community {

    private $id;
    private $slug;
    private $community;
    private $capital_id;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function setid($id) {
        $this->id = $id;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function getCommunity() {
        return $this->community;
    }

    public function setCommunity($community) {
        $this->community = $community;
    }

    public function getCapital_id() {
        return $this->capital_id;
    }

    public function setCapital_id($capital_id) {
        $this->capital_id = $capital_id;
    }


}
