<?php


class SiteUser
{
    public $id = null;
    public $firstname = null;
    public $lastname = null;
    public $email = null;
    public $password = null;
    public $desription = null;
    public $userdate = null;
    public $username = null;
    public $canconfigure = null;
    public $canchangeusers = null;
    public $canchangemenu = null;
    public $canchangematerials = null;
    public function __construct($user)
    {
        foreach ($user as $key=>$item) {
            $this->$key = $item;
        }


    }

}
