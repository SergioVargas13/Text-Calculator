<?php

require_once 'WordToNumber.php';

class TextCalculator extends WordToNumber
{
    /**
     * @var string $word;
     */
    protected $word;

    /**
     * @var int $result
     */
    protected $result;

    /**
     * @var string $operator
     */
    protected $operator;

    /**
     * @param string $word;
     * @return void 
     */
    public function __construct(string $word)
    {
        parent::__construct($word);
        $this->word = $word;
    }

    /**
     * Perform mathematical operation
     * 
     * @return void
     */
    public function performMathematicalOperation()
    {
        echo "Realizando operación matemática...\n";

        $results = $this->convertWordsToNumbersOperators();

        $groupNumbers = $results['numbers'];
        $operators = $results['operators'];

        $this->validateInput($operators);

        $expression = $this->extractValuesAndOperator($groupNumbers, $operators);

        $this->showResult($expression);
    }

    /**
     * Validate input
     * 
     * @param array $operators
     * @return void
     */
    private function validateInput($operators)
    {
        if (empty($operators)) {
            throw new Exception('No se encontro el operador');
        }
    }

    /**
     * Extract values and operator
     * 
     * @param array $groupNumbers
     * @param array $operators
     * @return void
     */
    private function extractValuesAndOperator($groupNumbers, $operators)
    {
        $tempNumber = 0;

        $expression = [];
        foreach ($groupNumbers as $key => $numbers) {
            foreach ($numbers as $number) {
                if ($number >= 1000000) {
                    $tempNumber = bcmul($tempNumber, strval($number));
                } else {
                    $tempNumber = bcadd($tempNumber, strval($number));
                }
            }

            if (isset($operators[$key])) {
                $expression[] = $tempNumber;
                $expression[] = $operators[$key];
                $tempNumber = 0;
            } else {
                $expression[] = $tempNumber;
            }
        }

        $expression = implode('', $expression);

        return $expression;
    }

    /**
     * Calculate expression
     * 
     * @param string $expression
     */
    private function calculateExpression($expression)
    {
        $operators = ['+', '-', '*', '/', '%'];
        $tokens = preg_split('/(\D)/', $expression, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        $accumulator = [];
        $currentOperator = null;

        foreach ($tokens as $token) {
            if (in_array($token, $operators)) {
                $currentOperator = $token;
            } else {
                $value = (int) $token;
                if ($currentOperator === null) {
                    $accumulator[] = $value;
                } else {
                    $prevValue = array_pop($accumulator);
                    $accumulator[] = $this->applyOperator($currentOperator, $prevValue, $value);
                    $currentOperator = null;
                }
            }
        }

        if (count($accumulator) !== 1) {
            throw new Exception('Invalid expression');
        }

        return $accumulator[0];
    }

    /**
     * Apply operator
     * 
     * @param string $operator
     * @param int $prevValue
     * @param int $value
     * @return void
     */
    private function applyOperator($operator, $prevValue, $value)
    {
        switch ($operator) {
            case '+':
                echo "Valor: $prevValue \nOperador: + \nValor: $value \n";
                return $prevValue + $value;
            case '-':
                echo "Valor: $prevValue \nOperador: - \nValor: $value \n";
                return $prevValue - $value;
            case '*':
                echo "Valor: $prevValue \nOperador: * \nValor: $value \n";
                return $prevValue * $value;
            case '/':
                if ($value == 0) {
                    throw new Exception('División por cero no permitida');
                }
                echo "Valor: $prevValue \nOperador: / \nValor: $value \n";
                return $prevValue / $value;
            case '%':
                echo "Valor: $prevValue \nOperador: % \nValor: $value \n";
                return $prevValue % $value;
            default:
                throw new Exception('Operador no válido');
        }
    }

    /**
     * Show result
     * 
     * @param string $expression
     * @return void
     */
    private function showResult($expression)
    {
        echo "------------------------------------- \n";
        echo "El texto ingresado es: $this->word \n";

        $this->result = $this->calculateExpression($expression);

        echo "El resultado es: $this->result \n";
        echo "------------------------------------- \n";
    }
}

echo "Por favor, ingresa el texto a calcular: ";
$text = fgets(STDIN);

$textCalculator = new TextCalculator($text);
$textCalculator->performMathematicalOperation();
