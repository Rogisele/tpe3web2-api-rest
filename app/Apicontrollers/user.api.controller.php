<?php

    require_once 'tpe3web2-api-rest/app/Apimodels/user.api.model.php';
    require_once 'tpe3web2-api-rest/app/Apiviews/apiView.php';
    

    class UserApiController {
        private $model;
        private $view;

        public function __construct() {
            $this->model = new UserModel();
            $this->view = new apiView();
        }

        
    }