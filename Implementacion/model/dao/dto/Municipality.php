<?php

namespace model\dao\dto;

class Municipality {

    private $province_id;
    private $municipality;
    private $id;
    private $slug;
    private $latitude;
    private $longitude;

    public function __construct() {
        
    }

    public function getProvince_id() {
        return $this->province_id;
    }

    public function setProvince_id($province_id) {
        $this->province_id = $province_id;
    }

    public function getMunicipality() {
        return $this->municipality;
    }

    public function setMunicipality($municipality) {
        $this->municipality = $municipality;
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

    public function getLatitude() {
        return $this->latitude;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

}
