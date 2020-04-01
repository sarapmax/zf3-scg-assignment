<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class DOSCGController extends AbstractActionController
{
    public function sequenceAction() {
        $list = ['X', 'Y', 5, 9, 15, 23, 'Z'];
        $keys = ['X', 'Y', 'Z'];
        $diffs = [0];

        for ($i = 1; $i < count($list); $i++) {
            $diffs[$i] = $diffs[$i - 1] + 2;
        }

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
                    if ($index[$i] + 1 < count($list)) {
                        if (is_numeric($list[$index[$i] + 1])) {
                            $list[$index[$i]] = $list[$index[$i] + 1] - $diffs[$index[$i]];
                        }
                    } else {
                        if (is_numeric($list[$index[$i] - 1])) {
                            $list[$index[$i]] = $list[$index[$i] - 1] + $diffs[$index[$i] - 1];
                        }
                    }
                }
            }

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
