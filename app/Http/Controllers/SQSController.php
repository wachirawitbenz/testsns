<?php

namespace App\Http\Controllers;
require '../vendor/autoload.php';
use Aws\Sns\SnsClient; 
use Aws\Sqs\SqsClient; 
use Aws\Exception\AwsException;
use Illuminate\Http\Request;

class SQSController extends Controller
{
    
    private $key = 'AKIAIJM2F6K6IRMUUJ4Q';
    private $secret = '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';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sqsindex');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $SnSclient = new SnsClient([
            'version' => 'latest',
            'region' => 'ap-southeast-1',
            'credentials' => [
                'key'    => $this->key,
                'secret' => $this->secret,
            ],
        ]);
        
        $message = 'Username';
        $topic = 'arn:aws:sns:ap-southeast-1:953396867242:Benz';
        try {
            ////publish
            $result = $SnSclient->publish([
                'Message' => $message,
                'MessageAttributes' => [
                    'firstname' => [
                        'StringValue' => 'Prayut',
                        'DataType' => 'String' 
                    ],
                ],
                'TopicArn' => $topic,
            ]);
            dd($result);
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        } 
        
    }
    public function addTopic()
    {
        $SnSclient = new SnsClient([
            'version' => 'latest',
            'region' => 'ap-southeast-1',
            'credentials' => [
                'key'    => $this->key,
                'secret' => $this->secret,
            ],
        ]);
        
        $message = 'Username';
        $topicname = 'User';
        try {
            ////create
            $result = $SnSclient->createTopic([
                'Name' => $topicname,
            ]);
            dd($result);
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        } 
        
    }
    public function receive(Request $request)
    {
        $queueUrl ='https://sqs.ap-southeast-1.amazonaws.com/953396867242/TestQueue';

        $client = new SqsClient([
            'version' => 'latest',
            'region' => 'ap-southeast-1',
            'credentials' => [
                'key'    => $this->key,
                'secret' => $this->secret,
            ],
        ]);

        try {
            $result = $client->receiveMessage(array(
                'AttributeNames' => ['SentTimestamp'],
                'MaxNumberOfMessages' => 1,
                'MessageAttributeNames' => ['All'],
                'QueueUrl' => $queueUrl, // REQUIRED
                'WaitTimeSeconds' => 0,
            ));
            if (count($result->get('Messages')) > 0) {
                var_dump($result->get('Messages')[0]);
                $result = $client->deleteMessage([
                    'QueueUrl' => $queueUrl, // REQUIRED
                    'ReceiptHandle' => $result->get('Messages')[0]['ReceiptHandle'] // REQUIRED
                ]);
            } else {
                echo "No messages in queue. \n";
            }
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
