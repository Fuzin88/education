<?php

// Варіант 3 Необхідно реалізувати в класі магічні методи і приклади їх використання
// __call(), __unset(), __toString()

class Student
{
    private $name;
    private $surname;
    private $age;
    protected $school = 'Hillel';
    private $city;


    public function __construct (string $name, string $surname, int $age )
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->age = $age;
    }

    protected function changeSchool($name)
    {
       $this->school = $name;
    }
    public function __set($name, $value)
    {
        $this->city = $value;
    }

    public function getSchool() :string
    {
        return $this->school;
    }

    public function __toString()
    {
        return 'Student info:' .  $this->name. ' ' .  $this->surname . ' ' . $this->age .PHP_EOL;
    }

     public function __call($method, $arguments) // переробив звернення у метод
    {
        if($method == 'changeSchool') {
            return $this->getSchool();
        }
    }

    public function __unset($param)
    {
        echo 'Значення ' . $param . ' стерто' . PHP_EOL;
        unset($this->city);
    }

}
$inputDataName = readline('Введіть ваше Ім\'я: ');
$inputDataSurname = readline('Введіть ваше Прізвище: ');
$inputDataAge = readline('Введіть ваш Вік: ');

$student = new Student($inputDataName, $inputDataSurname, $inputDataAge);
echo $student; // перевірка на роботу магічного методу __toString

$student->city = 'Kyiv';
unset($student->city); // перевірка на можливість видалення властивості класу (P.S. шторм ругається що властивість private але магія діє та видаляє)
 echo $student->setSity('Lviv') ; // перевірка на працездатнцість магічного методу __call

echo $student->changeSchool('Oxford') . PHP_EOL; // перевіряв чи зайде у магічний метод __call





