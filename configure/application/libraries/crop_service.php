<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Crop_service extends Base_service {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('db/area_model');
		$this->load->library('upload_service');
	}
	
	/** 
     * 生成截图 
     * 根据图片的格式，生成不同的截图 
     */  
    public function add_icon($file_path, $save_path, $save_name, $prefix, $img_name, $img_obj, $width, $height, $service_url)  
    {  
        switch($img_name['type'])  
        {  
            case '.jpg': 
			case '.jpeg': 
                return $this->generate_jpg($file_path, $save_path, $save_name, $prefix, $img_name, $img_obj, $width, $height, $service_url);  
                break;  
            case '.png':  
                return $this->generate_png($file_path, $save_path, $save_name, $prefix, $img_name, $img_obj, $width, $height, $service_url);  
                break;  
            case '.gif':  
                return $this->generate_gif($file_path, $save_path, $save_name, $prefix, $img_name, $img_obj, $width, $height, $service_url);  
                break;  
            default:  
                return false;  
        }  
    }  
	
    /** 
     * 生成jpg格式的图片 
     *  
     */  
    private function generate_jpg($file_path, $save_path, $save_name, $prefix, $img_name, $img_obj, $width, $height, $service_url)  
    { 
        $shot_name = CNGROOT_PATH.'/docroot/upload/images/'.$save_path.$prefix.$save_name.$img_name['type'];
        $img_r = imagecreatefromjpeg(CNGROOT_PATH.'/docroot/upload/images/'.$file_path.$img_name['name'].$img_name['type']);
        $dst_r = ImageCreateTrueColor($width, $height);  
        imagecopyresampled($dst_r, $img_r, 0, 0, $img_obj['x'], $img_obj['y'], $width, $height, $img_obj['w'], $img_obj['h']);  
        imagejpeg($dst_r,$shot_name,90);
		$ask = $this->upload_service->upload_file_server($shot_name, $service_url.$prefix.$save_name.$img_name['type']);
		if($ask){
			unlink($shot_name);
        	return true;
		}else{
			return false;
		}
    } 
	 
    /** 
     * 生成gif格式的图片 
     *  
     */  
    private function generate_gif($file_path, $save_path, $save_name, $prefix, $img_name, $img_obj, $width, $height, $service_url)  
    {
        $shot_name = CNGROOT_PATH.'/docroot/upload/images/'.$save_path.$prefix.$save_name.$img_name['type'];
        $img_r = imagecreatefromgif(CNGROOT_PATH.'/docroot/upload/images/'.$file_path.$img_name['name'].$img_name['type']);  
        $dst_r = ImageCreateTrueColor($width, $height); 
		imagecopyresampled($dst_r, $img_r, 0, 0, $img_obj['x'], $img_obj['y'], $width, $height, $img_obj['w'], $img_obj['h']);  
        imagejpeg($dst_r,$shot_name);
		$ask = $this->upload_service->upload_file_server($shot_name, $service_url.$prefix.$save_name.$img_name['type']);
		if($ask){
			unlink($shot_name);
        	return true;
		}else{
			return false;
		}
    }  
	
    /** 
     * 生成png格式的图片 
     *  
     */  
    private function generate_png($file_path, $save_path, $save_name, $prefix, $img_name, $img_obj, $width, $height, $service_url)  
    { 
        $shot_name = CNGROOT_PATH.'/docroot/upload/images/'.$save_path.$prefix.$save_name.$img_name['type'];
        $img_r = imagecreatefrompng(CNGROOT_PATH.'/docroot/upload/images/'.$file_path.$img_name['name'].$img_name['type']);
        $dst_r = ImageCreateTrueColor($width, $height); 
		imagecopyresampled($dst_r, $img_r, 0, 0, $img_obj['x'], $img_obj['y'], $width, $height, $img_obj['w'], $img_obj['h']);  
        imagepng($dst_r,$shot_name);
		$ask = $this->upload_service->upload_file_server($shot_name, $service_url.$prefix.$save_name.$img_name['type']);
		if($ask){
			unlink($shot_name);
        	return true;
		}else{
			return false;
		}
    }  
	
	//生成图片名
	public function get_img_name(){
		$str = md5(uniqid(mt_rand(), true));   
    	$uuid  = substr($str,0,8) . '-';   
    	$uuid .= substr($str,8,4) . '-';   
    	$uuid .= substr($str,12,4) . '-';   
    	$uuid .= substr($str,16,4) . '-';   
    	$uuid .= substr($str,20,12);   
    	return $uuid;
	}
}