<?php

declare(strict_types=1);

const PASS_ACCEPT_EXPECTED_PASSWORD = 'Th15_15_5TR0n6';
const PASS_ACCEPT_EXPECTED_SORT_CODE = '1352';

function expectedPassword(): string
{
    return PASS_ACCEPT_EXPECTED_PASSWORD;
}

function expectedSortCode(): string
{
    return PASS_ACCEPT_EXPECTED_SORT_CODE;
}

/**
 * @param array<string, mixed> $source
 * @return array{isValid: bool, errors: list<string>, fName: string}
 */
function validatePassAcceptInput(array $source): array
{
    $password = postString($source, 'pws');
    $sortCode = postString($source, 'srt');
    $firstName = postString($source, 'fName');
    $errors = [];

    if ($password === '') {
        $errors[] = 'Password is required.';
    } elseif (!hash_equals(PASS_ACCEPT_EXPECTED_PASSWORD, $password)) {
        $errors[] = 'Password is incorrect.';
    }

    if ($sortCode === '') {
        $errors[] = 'Sort code is required.';
    } elseif (!hash_equals(PASS_ACCEPT_EXPECTED_SORT_CODE, $sortCode)) {
        $errors[] = 'Sort code is incorrect.';
    }

    if ($firstName === '') {
        $errors[] = 'First name is required.';
    }

    return [
        'isValid' => $errors === [],
        'errors' => $errors,
        'fName' => $firstName,
    ];
}

/**
 * @param array<string, mixed> $source
 */
function postString(array $source, string $key): string
{
    $value = $source[$key] ?? '';

    if (!is_string($value)) {
        return '';
    }

    return trim($value);
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function renderChallengeScript(): string
{
    return <<<'JS'
(function () {
  "use strict";

  var div1 = document.querySelector("#d1");
  var div2 = document.querySelector("#d2");
  var header = document.querySelector("#h");
  var result = document.querySelector("#challenge-result");
  var divStyle = window.getComputedStyle(div1);
  var headerStyle = window.getComputedStyle(header);

  function A1() {
    if (div1.children[0].nodeName === "DIV") {
      console.log("You nailed it !");

      if (div2.children[0].nodeName === "H1") {
        div2.children[0].textContent = "This is correct too!";
        A3();
      }
    }
  }

  function A3() {
    if (divStyle.textAlign === "center" && divStyle.fontFamily.indexOf("fantasy") !== -1) {
      console.log("Just one more step");

      if (headerStyle.color === "rgb(255, 99, 71)" && headerStyle.transform === "matrix(-1, 0, 0, -1, 0, 0)") {
        result.textContent = "AMAZING YOU DID IT !!!";
      }
    }
  }

  A1();
})();
JS;
}
