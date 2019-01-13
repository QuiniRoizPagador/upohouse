<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class ImageDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Images");
    }

    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, `ad_id`, `image`)
                VALUES(?, ?, ?)";
        $data = array("sis", "uuid" => $obj->getUuid(), "ad_id" => $obj->getAd_id(), "image" => $obj->getImage());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function update($obj) {
        $prev = $this->search("uuid", $obj->getUuid(), FALSE);
        if (trim($obj->getImage()) == '') {
            $obj->setImage($prev->image);
        }
        $query = "UPDATE $this->table SET image = ? WHERE uuid = ?";
        $data = array("ss", "image" => $obj->getImage(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function deleteAllByAd($id) {
        $query = "DELETE FROM $this->table WHERE ad_id = ?";
        $data = array('i', "id" => $id);
        $res = $this::preparedStatement($query, $data, FALSE);
        return $res;
    }

}
