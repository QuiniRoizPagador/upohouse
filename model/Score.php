<?php

class Score {

    private $id;
    private $uuid;
    private $ad_id;
    private $user_id;
    private $score;

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

    public function getUser_id() {
        return $this->user_id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function getScore() {
        return $this->score;
    }

    public function setScore($score) {
        $this->score = $score;
    }



}
