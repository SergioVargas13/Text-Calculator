<?php

require_once 'MathOperators.php';
require_once 'NumericWords.php';

class WordToNumber
{

    /**
     * @var string $words
     */
    protected $words;

    /**
     * @var array $numbers
     */
    protected $numbers;

    /**
     * @var array $operators
     */
    protected $operators;

    /**
     * @param string $words
     * @return void
     */
    public function __construct(string $words = "")
    {
        $this->words = strtolower(trim($words));
        $this->numbers = NumericWords::getNumbers();
        $this->operators = MathOperators::getOperators();
    }

    /**
     * Convert words to numbers and operators
     * 
     * @return array
     */
    public function convertWordsToNumbersAndOperators()
    {
        $this->validateWord();

        $results = ['numbers' => [], 'operators' => []];

        $accumulator = 0;
        $foundOperator = false;

        $words = explode(' ', $this->words);
        foreach ($words as $word) {
            $isNumber = isset($this->numbers[$word]);
            $isOperator = isset($this->operators[$word]);

            if ($foundOperator) {
                ++$accumulator;
            }

            if ($isNumber || $isOperator) {

                $foundOperator = false;

                if ($isOperator) {
                    $foundOperator = true;
                    $results['operators'][] = $this->operators[$word];
                } else {
                    $results['numbers'][$accumulator][] = $this->numbers[$word];
                }
            } else if (is_numeric($word)) {
                $results['numbers'][$accumulator][] = $word;
            }
        }

        $this->validateOperators($results['operators']);

        return $results;
    }

    /**
     * @return void
     */
    private function validateWord()
    {
        if (empty($this->words)) {
            throw new Exception('La cadena está vacía');
        }
    }

    /**
     * Validate operators
     * 
     * @param array $operators
     * @return void
     */
    private function validateOperators($operators)
    {
        if (empty($operators)) {
            throw new Exception('No operator found.');
        }
    }
}
