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
     * Perform math operation
     * 
     * @return void
     */
    public function processMathOperation()
    {
        $results = $this->convertWordsToNumbersAndOperators();

        $groupNumbers = $results['numbers'];
        $operators = $results['operators'];

        $expression = $this->extractValuesAndOperator($groupNumbers, $operators);

        $result = $this->calculateExpression($expression);

        return $result;
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
                if ($number >= 1000000 != 0) {
                    $tempNumber = bcmul($tempNumber, $number);
                }
                if ($number >= 1000 && $number <= 1000000) {
                    $tempNumber = bcmul($tempNumber, $number);
                } else {
                    $tempNumber = bcadd($tempNumber, $number);
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
        $result = null;
        switch ($operator) {
            case '+':
                $result = $prevValue + $value;
                break;
            case '-':
                $result = $prevValue - $value;
                break;
            case '*':
                $result = $prevValue * $value;
                break;
            case '/':
                if ($value == 0) {
                    throw new Exception('Division by zero is not allowed');
                }
                $result = $prevValue / $value;
                break;
            case '%':
                $result = $prevValue % $value;
                break;
            default:
                throw new Exception('Invalid operator');
        }
        //echo "Valor: $prevValue \nOperador: $operator \nValor: $value \n";
        return $result;
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

        return $this->result;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = file_get_contents("php://input");
    
    $data = json_decode($data, true);

    $words = $data['words'];

    $textCalculator = new TextCalculator($words);
    $result = $textCalculator->processMathOperation();

    echo json_encode($result);
}

/*echo "Por favor, ingresa el texto a calcular: ";
$text = fgets(STDIN);

$textCalculator = new TextCalculator($text);
$textCalculator->processMathOperation();*/
