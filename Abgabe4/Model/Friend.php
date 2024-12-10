<?php
namespace Model;

use JsonSerializable;

class Friend implements JsonSerializable
{
    private $username;
    private $status;
    private $unread;

    public function __construct($username = "")
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function  getUnread() {
        return $this->unread;
    }

    public function  getStatus() {
        return $this->status;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    public static function fromJson($data) {
        $friend = new Friend();
        foreach ($data as $key => $value) {
            $friend->{$key} = $value;
        }
        return $friend;
    }
}