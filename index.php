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

//file-AAodcnLvHzbw3A07z1MnZQcY
//pre($chat->uploadFile($pdf));

//asst_ovk1Tl3ylTiAjV4ZEV4o22LG
//asst_tqFenMU76wBxYt83H4YD2FWK
//pre($chat->createAssistant());

//pre($chat->listAssistants());
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
pre($chat->modifyMessage('thread_B8ynqR6jQY0603NoB77G6W7L','msg_GpCDdnRv4I5PS9foZgkVyIeV',['metadata'=>["modified"=>"true","user"=>"ancsd"]]));



