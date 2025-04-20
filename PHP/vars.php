<?php
// Las variables en PHP se definen con este signo $, estas son relativas al bloque en que son declaradas
// Las variables globales se declaran con la palabra reservada global
// Por otro lado en POO las variables se declaran con la palabra reservada public, private o protected
$greet = "Hello World";
echo $greet; // Hello World

class Greet {
    private $greet = "Hello World from private";
    public $greet2 = "Hello World 2 from public";
    public function greet() {
        return $this->greet;
    }
}
$greet = new Greet();
echo $greet->greet(); // Hello World
echo $greet->greet2; // Hello World 2

?>