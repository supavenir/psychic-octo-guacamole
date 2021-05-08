<?php
namespace controllers;

 use models\User_;
 use Ubiquity\controllers\Controller;
 use Ubiquity\orm\DAO;

 /**
 * Controller MainController
 **/
class MainController extends Controller {
	public function __construct() {}
	public function index(){
		$users=DAO::getAll(User_::class,'',['category_']);
		foreach ($users as $user) {
			echo $user->getCategory_()->getName();
		}
	}

}
