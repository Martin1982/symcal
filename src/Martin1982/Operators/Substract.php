<?php

namespace Martin1982\Operators;

class Substract extends OperatorAbstract {

    const STRING_OPERATOR = '-';

    public function calculate()
    {
        return $this->leftOperand - $this->rightOperand;
    }
}