
<?php

class ChatAssistant{
    const BASE_URL = "https://api.openai.com/v1/";
    const ASSISTANT_VERSION = "assistants=v1";

    private $apiKey = '';
    private $chatModel='gpt-3.5-turbo';
    private $instructions ='You are a customer support chatbot. Use your knowledge base to best respond to customer queries.';
    private $tools = [["type" =>  "retrieval"]];
    private $threadID = '';
    

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

    public function getAssistantFiles(string $assistantId):array{
        $url = 'assistants/'.$assistantId.'/files';
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    public function getAssistant(string $assistantId):array{
        $url = 'assistants/'.$assistantId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'GET');
        return $getResponse;
    }

    //https://platform.openai.com/docs/api-reference/assistants/modifyAssistant
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

    public function deleteAssistantFiles(string $assistantId, string $fileId):array{
        $url = "assistants/".$assistantId."/files/".$fileId;
        $data=[];
        $getResponse = $this->curlRequest($url,$data,'DELETE');
        return $getResponse;
    }

    public function createThread(){
        
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