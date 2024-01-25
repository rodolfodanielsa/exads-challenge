<?php

namespace App\Service;

class AsciiArrayService
{

    private const INITIAL_CHAR = ',';
    private const FINAL_CHAR = '|';

    public function detectMissingChar(): string
    {
        $asciiArray = $this->getAsciiArray();

        $removedCharFromArray = $this->removeCharFromArray($asciiArray);

        $missingChar = $this->returnMissingChar($asciiArray);

        return $this->generateResponse($removedCharFromArray, $missingChar);
    }

    private function getAsciiArray(): array
    {
        return range(self::INITIAL_CHAR, self::FINAL_CHAR);
    }

    private function generateResponse(mixed $missingChar, mixed $missingCharDiff): string
    {
        $response = 'Original ASCII Array: ' . implode(',', $this->getAsciiArray()) . "\n";
        $response .= 'Randomly Removed Char: ' . $missingChar . "\n";
        $response .= 'Missing Char after Validation: ' . $missingCharDiff . "\n";

        return $response;
    }

    private function returnMissingChar(array $asciiArray): mixed
    {
        $missingCharDiff = array_diff($this->getAsciiArray(), $asciiArray);

        return array_values($missingCharDiff)[0];
    }

    private function removeCharFromArray(array &$asciiArray): string
    {
        $asciiRandomChar = array_rand($asciiArray);

        $missingChar = $asciiArray[$asciiRandomChar];
        unset($asciiArray[$asciiRandomChar]);

        return $missingChar;
    }
}
