<?php

require_once 'core/RegularUtils.php';
require_once 'model/dao/dto/Comment.php';

use core\AbstractController;
use core\RegularUtils;
use model\dao\dto\Comment;

class CommentController {

    private $commentModel;

    public function __construct() {
        parent::__construct();
        $this->commentModel = new CommentModel();
    }
    
    public function createComment()
    {
        
    }

}
