<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class DOSCGController extends AbstractActionController
{
    public function sequenceAction() {
        // Declare variables necessary.
        $list = ['X', 'Y', 5, 9, 15, 23, 'Z'];
        $keys = ['X', 'Y', 'Z'];
        $diffs = [0];

        // Find the number pattern (2,4,6,8,10,..) and store it to a variable.
        for ($i = 1; $i < count($list); $i++) {
            $diffs[$i] = $diffs[$i - 1] + 2;
        }

        // Store missing keys (X, Y, Z) to a variable.
        $index = [];
        for ($i = 0; $i < count($list); $i++) {
            if (!is_numeric($list[$i])) {
                array_push($index, $i);
            }
        }

        do {
            $foundMissing = 0;

            for ($i = 0; $i < count($index); $i++) {
                if (!is_numeric($list[$index[$i]])) {
                    // Scan through the left side.
                    if ($index[$i] + 1 < count($list)) {
                        if (is_numeric($list[$index[$i] + 1])) {
                            // Subtract the pattern number from the next value so that we can get the missing key.
                            $list[$index[$i]] = $list[$index[$i] + 1] - $diffs[$index[$i]];
                        }
                    // Scan through the right side.
                    } else {
                        if (is_numeric($list[$index[$i] - 1])) {
                            // Add the pattern number to the previous value so that we can get the missing key.
                            $list[$index[$i]] = $list[$index[$i] - 1] + $diffs[$index[$i] - 1];
                        }
                    }
                }
            }

            // If there's sill missing key, do everything all over again.
            for ($i = 0; $i < count($list); $i++)
            {
                if (!is_numeric($list[$i])) {
                    $foundMissing++;
                }
            }

        } while ($foundMissing != 0);

        $results = [];

        for ($i = 0; $i < count($index); $i++) {
            $results[$i]['key'] = $keys[$i];
            $results[$i]['value'] = $list[$index[$i]];
        }

        return new JsonModel($results);
    }
}
