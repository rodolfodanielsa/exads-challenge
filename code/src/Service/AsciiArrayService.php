<?php

namespace App\Service;

class AsciiArrayService
{

    private const INITIAL_CHAR = ',';
    private const FINAL_CHAR = '|';

    public function detectMissingChar(): string
    {
        $asciiArray = $this->getAsciiArray();

        $asciiRandomChar = array_rand($asciiArray);

        $missingChar = $asciiArray[$asciiRandomChar];
        unset($asciiArray[$asciiRandomChar]);

        $missingCharDiff = array_diff($this->getAsciiArray(), $asciiArray);
        $missingCharDiff = array_values($missingCharDiff)[0];

        $response = 'Original ASCII Array: ' . implode(',', $this->getAsciiArray()) . "\n";
        $response .= 'Removed Char: ' . $missingChar . "\n";
        $response .= 'Removed Char after checking: ' . $missingCharDiff . "\n";

        return $response;
    }

    private function getAsciiArray(): array
    {
        return range(self::INITIAL_CHAR, self::FINAL_CHAR);
    }
}
