<?php

namespace model\dao\dto;

class Ad {

    public $id;
    public $uuid;
    public $user_id;
    public $price;
    public $rooms;
    public $m_2;
    public $bath;
    public $description;
    public $housing_type;
    public $operation_type;
    public $accepted_request;
    public $community_id;
    public $province_id;
    public $municipality_id;
    public $state;

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

    public function getUser_id() {
        return $this->user_id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getRooms() {
        return $this->rooms;
    }

    public function setRooms($rooms) {
        $this->rooms = $rooms;
    }

    public function getM_2() {
        return $this->m_2;
    }

    public function setM_2($m_2) {
        $this->m_2 = $m_2;
    }

    public function getBath() {
        return $this->bath;
    }

    public function setBath($bath) {
        $this->bath = $bath;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getHousing_type() {
        return $this->housing_type;
    }

    public function setHousing_type($housing_type) {
        $this->housing_type = $housing_type;
    }

    public function getOperation_type() {
        return $this->operation_type;
    }

    public function setOperation_type($operation_type) {
        $this->operation_type = $operation_type;
    }

    public function getAccepted_request() {
        return $this->accepted_request;
    }

    public function setAccepted_request($accepted_request) {
        $this->accepted_request = $accepted_request;
    }

    public function getCommunity_id() {
        return $this->community_id;
    }

    public function setCommunity_id($community_id) {
        $this->community_id = $community_id;
    }

    public function getProvince_id() {
        return $this->province_id;
    }

    public function setProvince_id($province_id) {
        $this->province_id = $province_id;
    }

    public function getMunicipality_id() {
        return $this->municipality_id;
    }

    public function setMunicipality_id($municipality_id) {
        $this->municipality_id = $municipality_id;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
    }

}
