<?php

namespace App\Service;


/**
* @var PasswordGenerator
*/
class PasswordGenerator
{
  private $passwordGenerator;
public function generateRandomStrongPassword(int $length): string
{
$uppercaseLetters = $this->generateCharactersWithCharCodeRange([65, 90]);
$lowercaseLetters = $this->generateCharactersWithCharCodeRange([97, 122]);
$numbers = $this->generateCharactersWithCharCodeRange([48, 57]);
$symbols = $this->generateCharactersWithCharCodeRange([33, 47, 58, 64, 91, 96, 123, 126]);
$allCharacteres = array_merge($uppercaseLetters, $lowercaseLetters, $numbers, $symbols);
$isArrayShuffled = shuffle($allCharacteres);
if (!$isArrayShuffled) 
{
throw new \LogicException('écoué');

}
return implode('', array_slice($allCharacteres, 0, $length));
}
private function generateCharactersWithCharCodeRange(array $range): array
{
if (count($range) === 2) {
return range(chr($range[0]), chr($range[1]));
}else {
return 
$passwordGenerator = array_merge(...array_map(fn($range)=>range(chr($range[0]), chr($range[1])), array_chunk($range, 2)));
}

}
}

