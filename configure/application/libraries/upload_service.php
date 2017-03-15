<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require CNGROOT_PATH.'/configure/application/plugin/vendor/autoload.php';
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

class Upload_service extends Base_service {
	
	public function __construct() {
		parent::__construct();
	}
	
	//上传文件到服务器
	public function upload_file_server($url, $name){
		$config = $this->config->item('qiniu_sdk_key');
		$accessKey = $config['accessKey'];
		$secretKey = $config['secretKey'];
		$auth = new Auth($accessKey, $secretKey);
		//设置put policy的其他参数
		$opts = array();
		$token = $auth->uploadToken($config['bucket'], $name, $config['expires'], $opts);
		$uploadMgr = New UploadManager();
		list($ret, $err) = $uploadMgr->putFile($token, $name, $url);
		if ($err !== null) {
			//var_dump($err);
			return false;
		} else {
		    return true;
		}
	}
	
	//删除服务器上的文件
	public function delete_file_server($key){
		$config = $this->config->item('qiniu_sdk_key');
		$accessKey = $config['accessKey'];
		$secretKey = $config['secretKey'];
		$auth = new Auth($accessKey, $secretKey);
		$bucketMgr = new BucketManager($auth);
		list($ret, $err) = $bucketMgr->delete($config['bucket'], $key);
		if ($err !== null) {
		    return false;
		} else {
		    return true;
		}
	}
}
