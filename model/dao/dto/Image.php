<?php

namespace model\dao\dto;

class Image {

    private $id;
    private $uuid;
    private $ad_id;
    private $image;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function setid($id) {
        $this->id = $id;
    }

    public function getUuid() {
        return $this->uuid;
    }

    public function setUuid($uuid) {
        $this->uuid = $uuid;
    }

    public function getAd_id() {
        return $this->ad_id;
    }

    public function setAd_id($ad_id) {
        $this->ad_id = $ad_id;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

}
