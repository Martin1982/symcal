<?php

namespace Martin1982\Operators;

interface OperatorInterface
{
    public function setLeftOperand($number);
    public function setRightOperand($number);
    public function calculate();
}