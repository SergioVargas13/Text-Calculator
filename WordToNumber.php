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
     * @var array $mathOperators
     */
    protected $mathOperators;

    /**
     * @param string $words
     * @return void
     */
    public function __construct(string $words = "")
    {
        $this->words = strtolower(trim($words));
        $this->numbers = NumericWords::getNumbers();
        $this->mathOperators = MathOperators::getOperators();
    }

    /**
     * Convert words to numbers operators
     * 
     * @return array
     */
    public function convertWordsToNumbersOperators()
    {
        $this->validateWords();

        $results = ['numbers' => [], 'operators' => []];

        $accumulator = 0;
        $foundOperator = false;

        $words = explode(' ', $this->words);
        foreach ($words as $word) {
            $isNumber = isset($this->numbers[$word]);
            $isOperator = isset($this->mathOperators[$word]);

            if ($isNumber || $isOperator) {

                if ($foundOperator) {
                    ++$accumulator;
                }

                $foundOperator = false;

                if ($isOperator) {
                    $foundOperator = true;
                    $results['operators'][] = $this->mathOperators[$word];
                } else {
                    $results['numbers'][$accumulator][] = $this->numbers[$word];
                }
            }
        }

        return $results;
    }

    /**
     * @return void
     */
    public function validateWords()
    {
        if (empty($this->words)) {
            throw new Exception('La cadena está vacía');
        }

        if (is_numeric($this->words)) {
            throw new Exception('Debe ingresar una cadena de texto');
        }
    }
}
