<?php

namespace Application\Controller;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class DOSCGController extends AbstractActionController
{
    public function __construct() {
        // ** For testing purpose only!.
        header("Access-Control-Allow-Origin: *");
    }
    
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

    public function equationAction()
    {
        $A = 21;
        $B = 23 - $A;
        $C = - (21 + $A);

        $results['A'] = $A;
        $results['B'] = $B;
        $results['C'] = $C;

        return new JsonModel($results);
    }

    public function lineBotAction()
    {
        $httpClient = new CurlHTTPClient('ov+j0G0eE1v2IaKs0l3nMXLx+SdPSqu0pnpRXl7pG2YKxeF35PFM/qM0lMiiHUgJuKg1Q1FQ7vTF04VadTpoHcJmhLZs/faGJ8sXQv0a09tNz9Xb+3+82QtMoAk4bgR3cfi0f7+Njdo1S0mSTS/CzQdB04t89/1O/w1cDnyilFU=');
        $bot = new LINEBot($httpClient, ['channelSecret' => '6cb8840aeb5d6a22faa9cf7d6d6f34b3']);

        // Receive data from the LINE Messaging API.
        $content = file_get_contents('php://input');
        // Decode json to array.
        $events = json_decode($content, true);
        $message = $events['events'][0]['message']['text'];

        if ($message == 'Hi') {
            $reply = 'Hi there! I\'m just a bot';
        } else if ($message == 'How are you doing?') {
            $reply = 'I\'m great! how about you?';
        } else {
            sleep(10);

            $reply = 'I\'m not smart enough :(. I don\'t understand your message.';
        }

        $textMessageBuilder = new TextMessageBuilder($reply);
        $response = $bot->replyMessage($events['events'][0]['replyToken'], $textMessageBuilder);

        if ($response->isSucceeded()) {
            return new JsonModel('Succeeded!');
        }

        // Fail.
        return new JsonModel([
            'status' => $response->getHTTPStatus(),
            'body' => $response->getRawBody()
        ]);
    }
}
