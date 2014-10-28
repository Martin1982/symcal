<?php

namespace Martin1982\Operators;

abstract class OperatorAbstract implements OperatorInterface
{
    public $leftOperand;
    public $rightOperand;

    public function __construct($leftOperand) {
        return $this->setRightOperand($leftOperand);
    }


    public function setLeftOperand($number) {
        $this->leftOperand = $number;
        return $this;
    }

    public function setRightOperand($number) {
        $this->rightOperand = $number;
        return $this;
    }

    /**
     * Check if the string matches the implementation's STRING_OPERATOR constant
     * @param $inputOperator
     * @return bool
     */
    public static function matchesStringOperator($inputOperator) {
        return ($inputOperator === STRING_OPERATOR);
    }
}