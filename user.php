<?php
class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $address;

    public function __construct($id, $username, $email, $password, $address)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->address = $address;
    }

// Getters and setters for each property
// (omitted for brevity)
}
?>