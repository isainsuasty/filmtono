<?php

namespace Model;

class UserLabels extends ActiveRecord{
    protected static $tabla = 'sellos';
    protected static $columnasDB = ['labelName', 'labelDate', 'labelId', 'userId', 'userName', 'companyId', 'companyName', 'musicType'];

    public function __construct($args = [])
    {
        $this->labelName = $args['labelName'] ?? '';
        $this->labelDate = $args['labelDate'] ?? '';
        $this->labelId = $args['labelId'] ?? '';
        $this->userId = $args['userId'] ?? '';
        $this->userName = $args['userName'] ?? '';
        $this->companyId = $args['companyId'] ?? '';
        $this->companyName = $args['companyName'] ?? '';
        $this->musicType = $args['musicType'] ?? '';
    }
}
