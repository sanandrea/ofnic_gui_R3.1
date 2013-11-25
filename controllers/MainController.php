<?php
/**
 * Copyright 2013 (C) Universita' di Roma La Sapienza
 *
 * This file is part of OFNIC Uniroma GEi
 *
 * OFNIC is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OFNIC is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OFNIC.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Andi Palo
 * @created 02/11/2014
 */
if (!defined('OFNIC'))
	die('Direct access not allowed!');

/**
 * OFNIC Main Web Site Controller class file
 */

use Guzzle\Http\Client;
use Guzzle\Plugin\Cookie\CookiePlugin;
use Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar;
 
Class MainController Extends Controller {
	
	
	protected $ofnicWSRoot = 'https://130.206.82.172/netic.v1';
	//protected $ofnicWSRoot = 'https://localhost/netic.v1';
	protected $rootSuffix = '/OFNIC/';
	protected $client;
	protected $cookiePlugin;
	protected $cookieName = 'TWISTED_SESSION_Nicira_Management_Interface';

	public $navItemsArray = array(
		    "synchronize" => "Synchronize",
		    "routing" => "Routing",
		    "statistics" => "Statistics",
		    "acl" => "Access Control"
		);
	/**
	 * Constructor, we avoid external instantiation of this class
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		
		$this -> cookiePlugin = new CookiePlugin(new ArrayCookieJar());

		$this -> client = new Client($this->ofnicWSRoot);

		$this -> client->setDefaultOption('verify', false);
	}

	private function getNav($focus){
		$result = array();

		foreach ($this->navItemsArray as $key => $value) {
			if ($key == $focus){
				$format = sprintf("<li %s><a href=\"./?a=%s\">%s</a></li>",'class="active"',$key, $value);
				// sprintf($format,'class="active"',$key, $value);
			}else{
				// sprintf($format,'class=""',$key, $value);
				$format = sprintf("<li %s><a href=\"./?a=%s\">%s</a></li>",'class=""',$key, $value);
			}
			$result[] = $format;
		}
		return $result;
	}

	private function getPage($pageName, $pageTitle = '', $pageContent = ''){
		$view = new View($pageName, 'index.html');
		$view -> assign('content', $pageContent);
		$modules['navbar'] = self::getNav($pageName);
		$view -> page(array('title' => $pageTitle, 'modules' => $modules));
	}

	/**
	 * Main index, no action
	 *
	 * @access public
	 *
	 * @see core/controller.class#index()
	 *
	 * @return void
	 */
	public function index() {
		self::getPage('synchronize','Synchronize');
	}

	public function synchronize(){
		self::getPage(__FUNCTION__, ucfirst(__FUNCTION__));
	}
	public function statistics(){
		self::getPage(__FUNCTION__, ucfirst(__FUNCTION__));
	}
	public function routing(){
		self::getPage(__FUNCTION__, ucfirst(__FUNCTION__));
	}
	public function acl(){
		self::getPage(__FUNCTION__, ucfirst(__FUNCTION__));
	}
	
	public function showLogin(){
		$view = new View('login','login.html');
		$modules['login'] = TRUE;
		$view -> page(array('title' => 'Login', 'modules' => $modules));
	}
	
	

	public function login(){
		
		$request = $this -> client -> post($this -> ofnicWSRoot.'/login', null, array(
    			'username' => $_POST['uid'],
    			'password' => $_POST['pwd']
				));
		$response = $request->send();
		$cookieField = $response->getSetCookie();

		if ($cookieField != null){
			$cookieValue = $this->parseCookie($cookieField);
			$_SESSION['cookieValue'] = $cookieValue;
			$_SESSION['uid'] = $_POST['uid'];
			
			//don't send index, instead redirect to home page
			header("Location: .");

			//$this -> index();
		}else{
			$this -> showLogin();
		}

		return;
	}
	
	public function register(){
		$request = $this -> client -> post($this -> ofnicWSRoot.'/register', null, array(
    			'username' => $_POST['uid'],
    			'password' => $_POST['pwd']
				));

		try {
    		$response = $request -> send();
		} catch (Guzzle\Http\Exception\BadResponseException $e) {
		    echo 'Uh oh! ' . $e->getMessage();
		    #echo 'HTTP request URL: ' . $e->getRequest()->getUrl() . "\n";
		    #echo 'HTTP request: ' . $e->getRequest() . "\n";
		    echo 'Sent cookie: ' . $e -> getRequest()->getCookie($this->cookieName) . "\n";
		    echo 'HTTP response status: ' . $e->getResponse()->getStatusCode() . "\n";
		    echo 'HTTP response: ' . $e->getResponse() . "\n";
		}

		echo $response->getBody();
		
		
	}

	public function logout(){
		unset($_SESSION['cookieValue']);
		unset($_SESSION['uid']);
		header("Location: .");
		//$this -> showLogin();
	}

	public function ws($wscall){
		$convertCall = str_replace("_", "/", $wscall);
		Logger::addLog('convertCall is: ' . $convertCall);
		$url = $this->ofnicWSRoot . $this->rootSuffix . $convertCall; 


		$method = $_SERVER['REQUEST_METHOD'];
		$request = null;

		switch ($method) {
		  case 'PUT':
		    
		    break;
		  case 'POST':
		  	$ar = array();
		  	//foreach ($_POST as $key => $value)
		      //echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
		  	$request = $this -> client -> post($url, null, $_POST);
		    break;
		  case 'GET':
		    $request = $this -> client -> get($url);
		    break;
		  case 'HEAD':
		    
		    break;
		  case 'DELETE':
		    $request = $this -> client -> delete($url);
		    break;
		  case 'OPTIONS':
		    
		    break;
		  default:
		    rest_error($request);
		    break;
		}
		$request->addCookie($this->cookieName, $_SESSION['cookieValue']);
		
		try {
    		$response = $request -> send();
		} catch (Guzzle\Http\Exception\BadResponseException $e) {
		    echo 'Uh oh! ' . $e->getMessage();
		    #echo 'HTTP request URL: ' . $e->getRequest()->getUrl() . "\n";
		    #echo 'HTTP request: ' . $e->getRequest() . "\n";
		    echo 'Sent cookie: ' . $e -> getRequest()->getCookie($this->cookieName) . "\n";
		    echo 'HTTP response status: ' . $e->getResponse()->getStatusCode() . "\n";
		    echo 'HTTP response: ' . $e->getResponse() . "\n";
		}

		echo $response->getBody();
	}


	private function parseCookie($cookieField){
		$semiColonPos = strrpos ($cookieField, ';');
		$cookieNameLength = strlen($this->cookieName) + 1;

		return substr ( $cookieField, $cookieNameLength , $semiColonPos - $cookieNameLength );
	}
	
}
?>
