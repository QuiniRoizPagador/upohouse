<?php

namespace model\dao\dto;

class Report {

    private $id;
    private $uuid;
    private $title;
    private $description;
    private $user_id;
    private $state;
    private $user_reported;
    private $comment_reported;
    private $request_reported;
    private $ad_reported;

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

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function getUser_reported() {
        return $this->user_reported;
    }

    public function setUser_reported($user_reported) {
        $this->user_reported = $user_reported;
    }

    public function getComment_reported() {
        return $this->comment_reported;
    }

    public function setComment_reported($comment_reported) {
        $this->comment_reported = $comment_reported;
    }

    public function getRequest_reported() {
        return $this->request_reported;
    }

    public function setRequest_reported($request_reported) {
        $this->request_reported = $request_reported;
    }

    public function getAd_reported() {
        return $this->ad_reported;
    }

    public function setAd_reported($ad_reported) {
        $this->ad_reported = $ad_reported;
    }

}
