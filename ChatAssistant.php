
<?php
 /**
  * @author Ahsan Zameer
  * @author Ahsan Zameer <ahsn_zmeer@hotmail.com>
  * @license GPL 
  */
  
class ChatAssistant{
    const BASE_URL = "https://api.openai.com/v1/";
    const ASSISTANT_VERSION = "assistants=v1";

    private string $apiKey = '';
    private string $chatModel='gpt-4';
    private string $instructions ='You are a customer support chatbot. Use your knowledge base to best respond to customer queries.';
    private array $tools = [["type" =>  "gpt-4-turbo-preview"]];
    private string $threadID = '';
    

    public function __construct(string $key) {
        $this->apiKey = $key;
    }

    public function setChatModel(string $model):void{
        $this->chatModel = $model;
    }

    public function getChatModel(): string{
        return $this->chatModel;
    }

    public function setInstrutions(string $instruciton):void{
        $this->instructions = $instruciton;
    }

    public function getInstructions():string{
        return $this->instructions;
    }

    public function setTools(array $tools):void{
        $this->tools = $tools;
    }

    public function getTools():array{
        return $this->tools;
    }

    public function createAssistant(array $fileIds=null):array{
        $data = [
            'name' => 'Chat Genie',
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

    public function getAssistant(string $assistantId):array{
        $url = 'assistants/'.$assistantId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    public function modifyAssistant(string $assistantId, array $data):array{
        $url = "assistants/".$assistantId;

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    public function deleteAssistant(string $assistantId):array{
        $url = "assistants/".$assistantId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'DELETE');
        return $getResponse;
    }

    public function getAssistantFiles(string $assistantId):array{
        $url = 'assistants/'.$assistantId.'/files';
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    public function createAssistantFile(string $assistantId,$data):array{
        $url = "assistants/".$assistantId."/files";

        if(!isset($data['file_id'])){
            throw new Exception('No file id found');
        }

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    public function deleteAssistantFiles(string $assistantId, string $fileId):array{
        $url = "assistants/".$assistantId."/files/".$fileId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'DELETE');
        return $getResponse;
    }

    public function createThread():array{
        $url = "threads";
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    public function getThread(string $threadId):array{
        $url = 'threads/'.$threadId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    public function modifyThread(string $threadId,array $data):array{
        $url = "threads/".$threadId;
        
        if(!isset($data['metadata'])){
            throw new Exception('No metadata found');
        }

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    public function deleteThread(string $threadId):array{
        $url = "threads/".$threadId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'DELETE');
        return $getResponse;
    }

    public function createMessage(string $threadId,$data):array{
        $url = "threads/".$threadId."/messages";
        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

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

    public function getMessagesFiles(string $threadId,string $msgId):array{
        $url = 'threads/'.$threadId.'/messages/'.$msgId.'/files';
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    public function getMessage(string $threadId,string $msgId):array{
        $url = 'threads/'.$threadId.'/messages/'.$msgId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    public function getSingleMessageFile(string $threadId,string $msgId, string $fileId):array{
        $url = 'threads/'.$threadId.'/messages/'.$msgId.'/files/'.$fileId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    public function modifyMessage(string $threadId,string $msgId,$data):array{
        $url = 'threads/'.$threadId.'/messages/'.$msgId;
        
        if(!isset($data['metadata'])){
            throw new Exception('No metadata found');
        }

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    public function run(string $threadId,array $data):array{
        $url = 'threads/'.$threadId.'/runs';

        if(!isset($data['assistant_id'])){
            throw new Exception('No Assistant Id found');
        }

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

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

    public function listRuns(string $threadId):array{
        $url = 'threads/'.$threadId.'/runs';
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    public function listRunSteps(string $threadId, string $rundId):array{
        $url = 'threads/'.$threadId.'/runs/'.$rundId.'/steps';
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    public function retrieveRun(string $threadId, string $rundId):array{
        $url = 'threads/'.$threadId.'/runs/'.$rundId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    public function retrieveRunStep(string $threadId, string $rundId, string $stepId):array{
        $url = 'threads/'.$threadId.'/runs/'.$rundId.'/steps/'.$stepId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    public function modifyRun(string $threadId, string $rundId,array $data):array{
        $url = 'threads/'.$threadId.'/runs/'.$rundId;

        if(!isset($data['metadata'])){
            throw new Exception('No metadata found');
        }

        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }
   
    public function submitToolOutputToRun(string $threadId, string $rundId):array{
        $url = 'threads/'.$threadId.'/runs/'.$rundId.'/submit_tool_outputs';
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    public function cancelRun(string $threadId, string $rundId):array{
        $url = 'threads/'.$threadId.'/runs/'.$rundId.'/cancel';
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'POST');
        return $getResponse;
    }

    
    public function verifyApiKey():string{
        $listAssistants = $this->listAssistants();
        return $listAssistants['error']['code']??'valid_api_key';
    }

    public function uploadFile(array $filePath){
        $getStatus = $this->curlFileUpload($filePath);
        return $getStatus;
    }

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


    public function curlFileUpload(array $filePath){
        $url = self::BASE_URL."files";

        // Initialize cURL
        $curl = curl_init($url);

        // Set the HTTP headers
        $headers = array(
            "Authorization: Bearer ".$this->apiKey,
            "OpenAI-Beta: ".self::ASSISTANT_VERSION,
            "Content-Type: multipart/form-data",
        );

        //pre($headers);
        //exit();

        // Set cURL options
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_POST, true); 
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'purpose' => "assistants", // Specify the purpose
            'file' => new CURLFile($filePath[0]) // Specify the file parameter
        ));
        

        //$post_fields = array();
        //foreach ($filePath as $index => $file_path) {
            //$post_fields["file$index"] = new CURLFile($file_path,'application/pdf');
        //    $post_fields[$index]["file"] = new CURLFile($file_path);
        //    $post_fields[$index]["purpose"] = "assistants";
       // }


        $response = curl_exec($curl);

        if(curl_errno($curl)) {
            echo 'Curl error: ' . curl_error($curl);
        }

        curl_close($curl);

        return $response;
    }
}