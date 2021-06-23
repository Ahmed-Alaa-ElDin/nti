<?php 

class user 
{
    var $name, $age;

    public function __construct($name , $age) {
        $this->name = $name;
        $this->age = $age;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAge()
    {
        return $this->age;
    }
}

$user = new user('Ahmed',20);

echo $user->getName();
echo '<br>';
echo $user->getAge();


?>