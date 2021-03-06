<?php

require_once "core/AbstractDao.php";

use core\AbstractDao;

class ImageDao extends AbstractDao {

    public function __construct() {
        parent::__construct("Images");
    }

    public function create($obj) {
        $query = "INSERT INTO $this->table (`uuid`, `ad_id`, `image`, `thumbnail`)
                VALUES(?, ?, ?, ?)";
        $data = array("siss", "uuid" => $obj->getUuid(), "ad_id" => $obj->getAd_id(),
            "image" => $obj->getImage(), "thumbnail" => $obj->getThumbnail());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function update($obj) {
        $prev = $this->search("uuid", $obj->getUuid(), FALSE);
        if (trim($obj->getImage()) == '') {
            $obj->setImage($prev->image);
        }
        if (trim($obj->getThumbnail()) == '') {
            $obj->setThumbnail($prev->image);
        }
        $query = "UPDATE $this->table SET image = ?, `thumbnail` = ? WHERE uuid = ?";
        $data = array("sss", "image" => $obj->getImage(), "thumbnail" => $obj->getThumbnail(), "uuid" => $obj->getUuid());
        $res = parent::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function deleteAllByAd($id) {
        $query = "DELETE FROM $this->table WHERE ad_id = ?";
        $data = array('i', "id" => $id);
        $res = $this::preparedStatement($query, $data, FALSE);
        return $res;
    }

    public function readByAd($id) {
        $query = "SELECT * FROM $this->table WHERE ad_id = ?";
        $data = array('s', "ad_id" => $id);
        return $this->preparedStatement($query, $data);
    }

}
