<?php
namespace AhsanZameer;
/**
  * @author Ahsan Zameer
  * @author Ahsan Zameer <ahsn_zmeer@hotmail.com>
  * @license GPL 
  */
  
class ChatAssistant{
    const BASE_URL = "https://api.openai.com/v1/";
    const ASSISTANT_VERSION = "assistants=v1";

    private string $apiKey = '';
    private string $chatModel='gpt-4-turbo-preview';
    private string $instructions ='You are a customer support chatbot. Use your knowledge base to best respond to customer queries.';
    private array $tools = [["type" =>  "retrieval"]];
    private string $threadID = '';
    

    public function __construct(string $key) {
        $this->apiKey = $key;
    }

    /**
    * Will set the chat model
    * 
    * @param string $model
    * @return void
    */
    public function setChatModel(string $model):void{
        $this->chatModel = $model;
    }

    /**
    * Will get the chat model
    * 
    * @return string
    */
    public function getChatModel(): string{
        return $this->chatModel;
    }

    /**
    * Will set the Initial Instrucutions
    * 
    * @param string $instruction
    * @return void
    */    
    public function setInstrutions(string $instruciton):void{
        $this->instructions = $instruciton;
    }

    /**
    * Will get the Instructions
    * 
    * @return string
    */
    public function getInstructions():string{
        return $this->instructions;
    }

    /**
    * Will set the Initial tools
    * 
    * @param string $tools
    * @return void
    */    
    public function setTools(array $tools):void{
        $this->tools = $tools;
    }

    
    /**
    * Will get the Tools
    * 
    * @return array
    */
    public function getTools():array{
        return $this->tools;
    }

    /**
    * Create assistant
    * @link https://platform.openai.com/docs/api-reference/assistants/createAssistant
    * @param string $assistantName
    * @param array $fields default null
    * @return array
    */
    public function createAssistant(string $assistantName, array $fileIds=null):array{
        $data = [
            'name' => $assistantName,
            'instructions'=>$this->instructions,
            "tools"=>$this->tools,
            "model"=>$this->chatModel,
        ];

        if(!is_null($fileIds) && !empty($fileIds)){
            $data["file_ids"] = $fileIds;
        }

        $getResponse = $this->curlRequest('assistants',$data,'POST');

        return $getResponse;
    }

    /**
    * List assistants
    * @link https://platform.openai.com/docs/api-reference/assistants/listAssistants
    * @param string $order Optional default is desc
    * @param int $limit Optional default is 20
    * @param string $after Optional default is null
    * @param string $before Optional default is null
    * @return array
    */
    public function listAssistants(string $order="desc", int $limit=20,string $after=null,string $before=null):array{
        $data = [
            "order" => $order,
            "limit" => $limit,
        ];

        if(!is_null($after)){
            $data['after'] = $after;
        }

        if(!is_null($before)){
            $data['before'] = $before;
        }

        $getResponse = $this->curlRequest('assistants',$data,'GET');
        return $getResponse;
    }

    /**
    * Get assistant by id
    * @link https://platform.openai.com/docs/api-reference/assistants/getAssistant
    * @param string $assistantId
    * @return array
    */
    public function getAssistant(string $assistantId):array{
        $url = 'assistants/'.$assistantId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    /**
    * Modify Assistant using $assistantId
    * @link https://platform.openai.com/docs/api-reference/assistants/modifyAssistant
    * @param string @assistantId
    * @param array @data
    * @return array 
    */
    public function modifyAssistant(string $assistantId, array $data):array{
        $url = "assistants/".$assistantId;

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    /**
     * Delete Assistant using $assistantId
     * @link https://platform.openai.com/docs/api-reference/assistants/deleteAssistant
     * @param string @assistantId
     * @return array 
     */
    public function deleteAssistant(string $assistantId):array{
        $url = "assistants/".$assistantId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'DELETE');
        return $getResponse;
    }

    /**
     * Get File(s) linked with Assistant
     * @link https://platform.openai.com/docs/api-reference/assistants/listAssistantFiles
     * @param string $assistantId
     */
    public function getAssistantFiles(string $assistantId):array{
        $url = 'assistants/'.$assistantId.'/files';
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    /**
     * Create Assistant File
     * @link https://platform.openai.com/docs/api-reference/assistants/createAssistantFile
     * @param string $assistantId
     * @param array $data
     */
    public function createAssistantFile(string $assistantId,$data):array{
        $url = "assistants/".$assistantId."/files";

        if(!isset($data['file_id'])){
            throw new Exception('No file id found');
        }

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    /**
     * Delete Chat Assistant File
     * @link https://platform.openai.com/docs/api-reference/assistants/deleteAssistantFile
     * @param string $assistantId
     * @param string $fileId
     * @return array
     */
    public function deleteAssistantFile(string $assistantId, string $fileId):array{
        $url = "assistants/".$assistantId."/files/".$fileId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'DELETE');
        return $getResponse;
    }

    /**
     * Create Thread
     * @link https://platform.openai.com/docs/api-reference/threads/createThread
     * @return array
     */
    public function createThread():array{
        $url = "threads";
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    /**
     * Get thread using $threadId
     * @link https://platform.openai.com/docs/api-reference/threads/getThread
     * @param $threadId
     * @return array
     */
    public function getThread(string $threadId):array{
        $url = 'threads/'.$threadId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    /**
     * Modify Thread using $threadId
     * @link https://platform.openai.com/docs/api-reference/threads/modifyThread
     * @param string $threadId
     * @param array $data
     * @return array
     */
    public function modifyThread(string $threadId,array $data):array{
        $url = "threads/".$threadId;
        
        if(!isset($data['metadata'])){
            throw new Exception('No metadata found');
        }

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    /**
     * Delete Thread using $threadId
     * @link https://platform.openai.com/docs/api-reference/threads/deleteThread
     * @param string $threadId
     * @return array 
     */
    public function deleteThread(string $threadId):array{
        $url = "threads/".$threadId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'DELETE');
        return $getResponse;
    }

    /**
     * Create message under Thread
     * @link https://platform.openai.com/docs/api-reference/messages/createMessage
     * @param string $threadId
     * @param array $data Must contain role and content key
     * @return array
     */
    public function createMessage(string $threadId,array $data):array{
        $url = "threads/".$threadId."/messages";

        if(!isset($data['role']) || !isset($data['content'])){
            throw new Exception('Invalid data passed. It must contain role and content key');
        }

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    /**
     * List messages
     * @link https://platform.openai.com/docs/api-reference/messages/listMessages
     * @param string $threadId
     * @param string $order Optional. Default is desc
     * @param int $limit Optional. Default is 20
     * @param string $after Optional. Deafault is NULL
     * @param string $before Opitonal. Default is NULL
     * @return array
     */
    public function listMessages(string $threadId,string $order="desc", int $limit=20,string $after=null,string $before=null):array{
        $url = 'threads/'.$threadId.'/messages';

        $data = [
            "order" => $order,
            "limit" => $limit,
        ];

        if(!is_null($after)){
            $data['after'] = $after;
        }

        if(!is_null($before)){
            $data['before'] = $before;
        }
        
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    /**
     * Get Messages files(s)
     * @link https://platform.openai.com/docs/api-reference/messages/listMessageFiles
     * @param string $threadId
     * @param string $msgId
     * @return array
     */
    public function getMessagesFiles(string $threadId,string $msgId):array{
        $url = 'threads/'.$threadId.'/messages/'.$msgId.'/files';
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    /**
     * Get Message
     * @link https://platform.openai.com/docs/api-reference/messages/getMessage
     * @param string $threadId
     * @param string $msgId
     * @return array
     */
    public function getMessage(string $threadId,string $msgId):array{
        $url = 'threads/'.$threadId.'/messages/'.$msgId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }
    
    /**
     * Get Single Message File
     * @link https://platform.openai.com/docs/api-reference/messages/getMessageFile
     * @param string $threadId
     * @param string $msgId
     * @return array
     */
    public function getSingleMessageFile(string $threadId,string $msgId, string $fileId):array{
        $url = 'threads/'.$threadId.'/messages/'.$msgId.'/files/'.$fileId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    /**
     * Modify Message
     * @link https://platform.openai.com/docs/api-reference/messages/modifyMessage
     * @param string $threadId
     * @param string $msgId
     * @param array $data Array must contain metadata index
     * @return array
     */
    public function modifyMessage(string $threadId,string $msgId,array $data):array{
        $url = 'threads/'.$threadId.'/messages/'.$msgId;
        
        if(!isset($data['metadata'])){
            throw new Exception('No metadata found');
        }

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    /**
     * Run Thread with data
     * @link https://platform.openai.com/docs/api-reference/runs/createRun
     * @param string $threadId
     * @param array $data
     * @return array
     */
    public function run(string $threadId,array $data):array{
        $url = 'threads/'.$threadId.'/runs';

        if(!isset($data['assistant_id'])){
            throw new Exception('No Assistant Id found');
        }

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    /**
     * Create a thread and run it in one request
     * @link https://platform.openai.com/docs/api-reference/runs/createThreadAndRun
     * @param array $data Must contain [assistant_id] index and [thread] index. e.g $data['assistant_id'=>'asst_2304234023','thread'=>['role'=>'user','contant'=>'how are you?']]
     * @return array
     */
    public function createThreadAndRun(array $data):array{
        $url = 'threads/runs';

        if(!isset($data['assistant_id'])){
            throw new Exception('No assistant id  found');
        }

        if(!isset($data['thread'])){
            throw new Exception('No thread index found');
        }

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    /**
     * Returns a list of runs belonging to a thread.
     * @link https://platform.openai.com/docs/api-reference/runs/listRuns
     * @param string $threadId
     * @return array
     */
    public function listRuns(string $threadId):array{
        $url = 'threads/'.$threadId.'/runs';
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    /**
     * Returns a list of run steps belonging to a run.
     * @link https://platform.openai.com/docs/api-reference/runs/listRunSteps     
     * @param string $threadId
     * @param string $runId
     * @return array
     */
    public function listRunSteps(string $threadId, string $runId):array{
        $url = 'threads/'.$threadId.'/runs/'.$runId.'/steps';
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    /**
     * Retrieves a run
     * @link https://platform.openai.com/docs/api-reference/runs/getRun
     * @param string $threadId
     * @param string $runId
     * @return array
     */
    public function retrieveRun(string $threadId, string $runId):array{
        $url = 'threads/'.$threadId.'/runs/'.$runId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    /**
     * Retrieves a run step.
     * @link https://platform.openai.com/docs/api-reference/runs/getRunStep
     * @param string $threadId
     * @param string $runId
     * @param string $stepId
     * @return array
     */
    public function retrieveRunStep(string $threadId, string $runId, string $stepId):array{
        $url = 'threads/'.$threadId.'/runs/'.$runId.'/steps/'.$stepId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    /**
     * Modifies a run.
     * @link https://platform.openai.com/docs/api-reference/runs/modifyRun
     * @param string $threadId
     * @param string $runId
     * @param array $data Must containt metadata index
     * @return array
     */
    public function modifyRun(string $threadId, string $runId,array $data):array{
        $url = 'threads/'.$threadId.'/runs/'.$runId;

        if(!isset($data['metadata'])){
            throw new Exception('No metadata found');
        }

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }
   
    /**
     * When a run has the status: "requires_action" and required_action.type is submit_tool_outputs, this endpoint can be used to submit the outputs from the tool calls once they're all completed. All outputs must be submitted in a single request.
     * @link https://platform.openai.com/docs/api-reference/runs/submitToolOutputs
     * @param string $threadId
     * @param string $runId
     * @return array
     */
    public function submitToolOutputToRun(string $threadId, string $runId):array{
        $url = 'threads/'.$threadId.'/runs/'.$runId.'/submit_tool_outputs';
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    /**
     * Cancels a run that is in_progress.
     * @link https://platform.openai.com/docs/api-reference/runs/cancelRun
     * @param string $threadId
     * @param string $runId
     * @return array
     */
    public function cancelRun(string $threadId, string $runId):array{
        $url = 'threads/'.$threadId.'/runs/'.$runId.'/cancel';
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    /**
     * This method verify API key by calling list of Assistants
     * @return string
     */
    public function verifyApiKey():string{
        $listAssistants = $this->listAssistants();
        return $listAssistants['error']['code']??'valid_api_key';
    }

    /**
     * Will upload file in OpenAi's Storage
     * @param string $filePath
     * @return array
     */
    public function uploadFile(string $filePath):array{
        $getStatus = $this->curlFileUpload($filePath);
        return $getStatus;
    }

    /**
     * Will delete file
     * @param string $fileId
     * @return array
     */
    public function deleteFile(string $fileId):array{
        $url = "files/".$fileId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'DELETE');
        return $getResponse;
    }

    /**
     * Get file
     * @param string $fileId
     * @return array
     */
    public function getFile(string $fileId):array{
        $url = "files/".$fileId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    /**
     * CURL request for POST GET PUT DELETE
     * @param string $action
     * @param array $data Optional. Default is Empty
     * @param string $type Default is GET.
     * @return array
     */
    public function curlRequest(string $action, array $data=[],string $type='GET'):array{
        $url = self::BASE_URL.$action;

        $curl = curl_init($url);
        $headers = array(
            "Authorization: Bearer ".$this->apiKey,
            "OpenAI-Beta:".self::ASSISTANT_VERSION,
            "Content-Type: application/json",
        );
        
        
        if($type == "POST"){
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }else{
            if (count($data) > 0) {
                $qs = http_build_query($data);
                $url .= "?{$qs}";
            }
        }
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        
        $response = curl_exec($curl);

        if(curl_errno($curl)) {
            echo 'Curl error: ' . curl_error($curl);
        }

        curl_close($curl);

        return json_decode($response,true);
    }

    /**
     * CURL request for uploading file
     * @param string $filePath
     * @return array
     */
    public function curlFileUpload(string $filePath):array{
        $url = self::BASE_URL."files";

        // Initialize cURL
        $curl = curl_init($url);

        // Set the HTTP headers
        $headers = array(
            "Authorization: Bearer ".$this->apiKey,
            "OpenAI-Beta: ".self::ASSISTANT_VERSION,
            "Content-Type: multipart/form-data",
        );

        // Set cURL options
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_POST, true); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'purpose' => "assistants", // Specify the purpose
            'file' => new CURLFile($filePath) // Specify the file parameter
        ));
        
        $response = curl_exec($curl);

        if(curl_errno($curl)) {
            echo 'Curl error: ' . curl_error($curl);
        }

        curl_close($curl);

        return json_decode($response,true);
    }
}