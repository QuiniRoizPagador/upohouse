<?php

class Province {

    private $id;
    private $slug;
    private $province;
    private $community_id;
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

    public function getProvince() {
        return $this->province;
    }

    public function setProvince($province) {
        $this->province = $province;
    }

    public function getCommunity_id() {
        return $this->community_id;
    }

    public function setCommunity_id($community_id) {
        $this->community_id = $community_id;
    }

    public function getCapital_id() {
        return $this->capital_id;
    }

    public function setCapital_id($capital_id) {
        $this->capital_id = $capital_id;
    }

}
