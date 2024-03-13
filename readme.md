# #PHP Class for OpenAI Assistant

This class allows you to create interactive chat assistant using OpenAI


# Create Object

    $key = 'CHAT_API_KEY'
    $chat = new AhsanZameer\ChatAssistant($key);

##   Set Chat Model

    $chat->setChatModel(''gpt-4-turbo-preview'); //default is 'gpt-4-turbo-preview

##  Set Instructions

    $chat->setInstrutions('You are a very good customer support chatbot');
    
## Set Tools

    $chat->setTools([["type"  =>  "retrieval"]]);

## Upload File

    $pdf = 'pdf-file.pdf';
    $uploadFile = $chat->uploadFile($pdf); //array

## Get File

	$fileId= 'file-random-string';
    $file = $chat->getFile($fileId);


## Create Assistant

    $assistant = $chat->createAssistant('my-new-assistant'); //array

## Create Assistant with File

    $fileArray = ['file-woer23223423']; //array
	$assistant = $chat->createAssistant('assistant-with-file',$fileArray);

## Get Assistant

    $assistantId = 'asst_random-id-string';
	$getAssistant = $chat->getAssistant($assistantId); //array

## Create Thread

    $createThread = $chat->createThread(); //array
    
## Create Message

    $threadId = $createThread['id'];
	$message = ["role"=>"user","content"=>"ok cool"];
	$createMessage = $chat->createMessage($threadId,$message);

## Run Thread

    $runData = ['assistant_id'=>$assistantId];
	$run = $chat->run($threadId,$runData);

## Retrieve Run

	$runId = $run['id'];
    $runStatus = $chat->retrieveRun($threadId,$runId);

## List Messages

    $getMsges = $chat->listMessages($threadId);
