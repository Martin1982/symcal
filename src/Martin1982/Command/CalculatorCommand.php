<?php

namespace Martin1982\Command;

use Martin1982\Operators\Add;
use Martin1982\Operators\Divide;
use Martin1982\Operators\Modulus;
use Martin1982\Operators\Multiply;
use Martin1982\Operators\OperatorAbstract;
use Martin1982\Operators\Substract;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class CalculatorCommand extends Command {

    /**
     * Configure the calculator command
     */
    protected function configure()
    {
        $this->setName("calculate")
             ->setDescription("Calculates an operation")
             ->setDefinition(
                 array(
                     new InputOption('calculation', 'c', InputOption::VALUE_REQUIRED)
                 )
             )
             ->setHelp("Use the -c option to define the calculation to run.");
    }

    /**
     * Execute the calculation and show the result
     * @Todo handle this properly in a class
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $calculation = $input->getOption('calculation');

        $regexp = '/[^\d.]|[\d.]++/';
        preg_match_all($regexp, $calculation, $calculationInputs);

        $startValue = 0;
        $operation = array();

        if (is_numeric($calculationInputs[0][0])) {
            $startValue = array_shift($calculationInputs[0]);
        }

        foreach ($calculationInputs[0] as $inputKey => $calculationInput) {
            if (is_numeric($calculationInput)) {
                $operand = $calculationInput;
            } else {
                $operator = $calculationInput;
            }

            if (isset($operand) && isset($operator)) {
                switch ($operator) {
                    case '*':
                        $operation[0][] = new Multiply($operand);
                        unset($operand);
                        unset($operator);
                        break;
                    case '/':
                        $operation[1][] = new Divide($operand);
                        unset($operand);
                        unset($operator);
                        break;
                    case '%':
                        $operation[2][] = new Modulus($operand);
                        unset($operand);
                        unset($operator);
                        break;
                    case '+':
                        $operation[3][] = new Add($operand);
                        unset($operand);
                        unset($operator);
                        break;
                    case '-':
                        $operation[4][] = new Substract($operand);
                        unset($operand);
                        unset($operator);
                        break;
                    default:
                        throw new \Exception('Invalid operator given:' . $operator);
                        break;
                }
            }
        }
        ksort($operation);

        foreach($operation as $key => $executeables) {
            if (count($executeables)) {
                foreach($executeables as $executeable) {
                    $startValue = $executeable->setLeftOperand($startValue)
                                              ->calculate();

                }
            }
        }

        $output->writeln('The result of "' . $calculation . '" is ' . $startValue);
    }

}
