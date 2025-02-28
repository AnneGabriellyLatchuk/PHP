<?php
// Substitua todas as vogais em uma string por asteriscos (*)

function substituirVogais($str) {
    return preg_replace('/[aeiouAEIOU]/', '*', $str);
}

echo substituirVogais("Oiiiii povo!!!!");

// Verifique se um número é primo ou não

function ehPrimo($num) {
    if ($num <= 1) return false;
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) return false;
    }
    return true;
}

echo ehPrimo(7) ? "É primo" : "Não é primo";

// Inverta uma string sem usar a função strrev()

function inverterString($str) {
    $inverted = '';
    for ($i = strlen($str) - 1; $i >= 0; $i--) {
        $inverted .= $str[$i];
    }
    return $inverted;
}

echo inverterString("Oiiiiii!!!!");

// Crie uma função que receba um número e retorne se é positivo, negativo ou zero

function verificarNumero($num) {
    if ($num > 0) return "Positivo";
    if ($num < 0) return "Negativo";
    return "Zero";
}

echo verificarNumero(-60);

// Conte o número de palavras em uma frase e imprima cada palavra em uma nova linha

function contarPalavras($frase) {
    $palavras = explode(' ', $frase);
    foreach ($palavras as $palavra) {
        echo $palavra . "\n";
    }
    return count($palavras);
}

echo "Número de palavras: " . contarPalavras("Boa noite pessoal!!!);


// Crie uma função que verifique se uma palavra é um palíndromo

function ehPalindromo($palavra) {
    $palavra = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $palavra));
    return $palavra == strrev($palavra);
}

echo ehPalindromo("Boa noite povo!!!") ? "É palíndromo" : "Não é palíndromo";

// Crie um programa que imprima os números de 1 a 20, substituindo múltiplos de 3 por "x"

for ($i = 1; $i <= 20; $i++) {
    if ($i % 3 == 0) {
        echo "x\n";
    } else {
        echo $i . "\n";
    }
}

// Crie uma função que remova os espaços em branco de uma string

function removerEspacos($str) {
    return str_replace(' ', '', $str);
}

echo removerEspacos("Boa noite povo!!!");

// Crie um programa que calcule e imprima os números Fibonacci até o décimo termo

function fibonacci($n) {
    $fib = [0, 1];
    for ($i = 2; $i < $n; $i++) {
        $fib [] = $fib [$i - 1] + $fib [$i - 2];
    }
    return $fib;
}

$fib = fibonacci(10);
foreach ($fib as $num) {
    echo $num . "\n";
}

// Crie uma função que receba um texto e retorne se é um pangrama (contém todas as letras do alfabeto pelo menos uma vez).

function ehPangrama($texto) {
    $alfabeto = range('a', 'z');
    $texto = strtolower(preg_replace('/[^a-z]/', '', $texto));
    foreach ($alfabeto as $letra) {
        if (strpos($texto, $letra) === false) {
            return false;
        }
    }
    return true;
}

echo ehPangrama("Boa noite pessoal!!!") ? "É pangrama" : "Não é pangrama";

?>