<?php
require_once SCRIPT_PATH . 'PhpThumb' . DS . 'ThumbLib.inc.php';    
class Upload
{   
   
	public function uploadFile($fileObj, $folderUpload, $options = null){
        if($options == null){
           if($fileObj['tmp_name'] != null){
               $uploadDir   = UPLOAD_PATH . $folderUpload . DS;
               $extension   = '.' . pathinfo($fileObj['name'], PATHINFO_EXTENSION);
               $newFileName = $this->randomString(8);
               $fileName    = $uploadDir . $newFileName . $extension;
               
               @copy($fileObj['tmp_name'], $fileName); 
               
               $thumb = PhpThumbFactory::create($fileName);
               $thumb->save($uploadDir . $newFileName . $extension);
            
           }
        }
        return $newFileName . $extension;
    }

    public function removeFile($folderUpload, $fileName){
        $fileName = UPLOAD_PATH . $folderUpload . DS . $fileName;
        @unlink($fileName);
    }

    private function randomString($length = 5){
       $arrCharacter = array_merge(range('a', 'z'), range(0,9));
       $arrCharacter = implode('', $arrCharacter);
       $arrCharacter = str_shuffle($arrCharacter);
       
       $result = substr($arrCharacter, 0 ,$length);
       return $result;
    }


}
