<?php
require_once('ChatAssistant.php');
function pre($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

$key = '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';
$pdf = [realpath('pdfs/ChatGenie-Plugin.pdf')];

$chat = new ChatAssistant($key);

$assistantId = 'asst_tYLTx5OXMEoNMPVUAybJxoG5';

//1st step
//$createThread = $chat->createThread();
//pre($createThread);
$threadId = 'thread_u1vS9A2PpmBQP6u73MLUoAWt';

//2nd step
//$message = ["role"=>"user","content"=>"Hi, How are you?"];
//$createMessage = $chat->createMessage($threadId,$message);
//pre($createMessage);

//$messageId = 'msg_sah82L1SJmlwztZGILZwqxSm';

//3rd step
//$runData = ['assistant_id'=>$assistantId];
//$run = $chat->run($threadId,$runData);
//pre($run);

//$runId = 'run_Ug4NVqrFJUPCghIOFju1JdmG';

//4th step
//$runStatus = $chat->retrieveRun($threadId,$runId);
//pre($runStatus);
//if [status] => completed

//
//$getMsges = $chat->listMessages($threadId);
//pre($getMsges);



$message = ["role"=>"user","content"=>"What is chatgenie and what the plugin requirement show in bullets?"];
//$createMessage = $chat->createMessage($threadId,$message);
//pre($createMessage);
$msg2 = "msg_LVcHim0sniVyb0OulCYjGR7n";

//$runData = ['assistant_id'=>$assistantId];
//$run = $chat->run($threadId,$runData);
//pre($run);

//$listRuns = $chat->listRuns($threadId);
//pre($listRuns);

//$runId = 'run_e3CAZgFDDEEKWJf67KNCpNbn';
//$runStatus = $chat->retrieveRun($threadId,$runId);
//pre($runStatus);

//$getMsges = $chat->listMessages($threadId);
//pre($getMsges);

//$attachFileToAssistant = $chat->createAssistantFile($assistantId,['file_id'=>"file-uE5AEjcLLt9J5L98kBK2PPvZ"]);
//pre($attachFileToAssistant);

//$getAttachment = $chat->getAssistantFiles($assistantId);
//pre($getAttachment);

//$getAssistant = $chat->getAssistant($assistantId);
//pre($getAssistant);


//file-AAodcnLvHzbw3A07z1MnZQcY
//pre($chat->uploadFile($pdf));

//asst_ovk1Tl3ylTiAjV4ZEV4o22LG
//asst_tqFenMU76wBxYt83H4YD2FWK
//pre($chat->createAssistant());

//pre($chat->listAssistants());
//$assistantId = 'asst_ovk1Tl3ylTiAjV4ZEV4o22LG';


//pre($chat->getAssistantFiles('asst_7DIBT7Fb57rayZ32z6D3D8HB'));
//pre($chat->getAssistant('asst_7DIBT7Fb57rayZ32z6D3D8HB'));
//pre($chat->modifyAssistant('asst_7DIBT7Fb57rayZ32z6D3D8HB',['name' =>'ahsan modify test']));
//pre($chat->deleteAssistant('asst_7DIBT7Fb57rayZ32z6D3D8HB'));
//asst_JwhW3OZKuYUgFC7mCugHbkTo
//pre($chat->deleteAssistantFiles('asst_JwhW3OZKuYUgFC7mCugHbkTo','file-AAodcnLvHzbw3A07z1MnZQcY'));

//thread_FY4lwIN6fREGLWD8Li9BpzuB
//pre($chat->createThread());
//pre($chat->getThread('thread_FY4lwIN6fREGLWD8Li9BpzuB'));
//pre($chat->modifyThread('thread_FY4lwIN6fREGLWD8Li9BpzuB',['metadata' =>["modified"=>"true","user"=>"ahsan-123"]]));
//pre($chat->deleteThread('thread_FY4lwIN6fREGLWD8Li9BpzuB'));

//pre($chat->createMessage('thread_B8ynqR6jQY0603NoB77G6W7L',["role"=>"user","content"=>"What is chat genie?"]));

//pre($chat->listMessages('thread_B8ynqR6jQY0603NoB77G6W7L'));
//pre($chat->getMessagesFiles('thread_B8ynqR6jQY0603NoB77G6W7L','msg_GpCDdnRv4I5PS9foZgkVyIeV'));
//pre($chat->getMessage('thread_B8ynqR6jQY0603NoB77G6W7L','msg_GpCDdnRv4I5PS9foZgkVyIeV'));
//pre($chat->getSingleMessageFile('thread_B8ynqR6jQY0603NoB77G6W7L','msg_GpCDdnRv4I5PS9foZgkVyIeV','file-AAodcnLvHzbw3A07z1MnZQcY'));
//pre($chat->modifyMessage('thread_B8ynqR6jQY0603NoB77G6W7L','msg_GpCDdnRv4I5PS9foZgkVyIeV',['metadata'=>["modified"=>"true","user"=>"ancsd"]]));

//pre($chat->run('thread_B8ynqR6jQY0603NoB77G6W7L',["assistant_id"=>$assistantId]));
/*pre($chat->createThreadAndRun(
    [
        'assistant_id'=>$assistantId,
        'thread' => [
            "messages" =>[[
                    "role" =>"user",
                    "content" => "What is chat genie",
                ]
            ]
        ]
    ]    
));
*/

//pre($chat->listRuns('thread_B8ynqR6jQY0603NoB77G6W7L'));
//pre($chat->retrieveRun('thread_B8ynqR6jQY0603NoB77G6W7L','run_0rHp3kYrRmYix1AYKa00kxCF'));
//pre($chat->listRunSteps('thread_B8ynqR6jQY0603NoB77G6W7L','run_0rHp3kYrRmYix1AYKa00kxCF'));
//pre($chat->retrieveRunStep('thread_B8ynqR6jQY0603NoB77G6W7L','run_0rHp3kYrRmYix1AYKa00kxCF','step_30234234WER'));
//pre($chat->modifyRun('thread_B8ynqR6jQY0603NoB77G6W7L','run_0rHp3kYrRmYix1AYKa00kxCF',['metadata' =>["modified"=>"true","user"=>"ahsan-123"]]));
//pre($chat->submitToolOutputToRun('thread_B8ynqR6jQY0603NoB77G6W7L','run_0rHp3kYrRmYix1AYKa00kxCF'));

//pre($chat->cancelRun('thread_B8ynqR6jQY0603NoB77G6W7L','run_0rHp3kYrRmYix1AYKa00kxCF'));

