<?php
namespace Model;

use JsonSerializable;

class User implements JsonSerializable
{
    private $username;
    private $firstName;
    private $lastName;
    private $coffeeOrTea;
    private $description;
    private $chatLayout;
    private $changeHistory = [];

    public function __construct($username = null)
    {
        $this->username = $username;
    }

    // Getters
    public function getUsername() { return $this->username; }
    public function getFirstName() { return $this->firstName; }
    public function getLastName() { return $this->lastName; }
    public function getCoffeeOrTea() { return $this->coffeeOrTea; }
    public function getDescription() { return $this->description; }
    public function getChatLayout() { return $this->chatLayout; }
    public function getChangeHistory() { return $this->changeHistory; }

    // Setters
    public function setFirstName($firstName) { $this->firstName = $firstName; }
    public function setLastName($lastName) { $this->lastName = $lastName; }
    public function setCoffeeOrTea($coffeeOrTea) { $this->coffeeOrTea = $coffeeOrTea; }
    public function setDescription($description) { $this->description = $description; }
    public function setChatLayout($chatLayout) { $this->chatLayout = $chatLayout; }
    
    public function addToHistory() {
        $this->changeHistory[] = date('Y-m-d H:i:s');
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    public static function fromJson($data) {
        $user = new User();
        foreach ($data as $key => $value) {
            if (property_exists($user, $key)) {
                $user->{$key} = $value;
            }
        }
        return $user;
    }
}