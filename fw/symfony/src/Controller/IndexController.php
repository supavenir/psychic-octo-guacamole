<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
		$repository = $this->getDoctrine()->getRepository(User::class);
		$users = $repository->findAll();
		$res='';
		foreach ($users as $user){
			$res.=$user->getIdcategory()->getName();
		}
        return new Response($res);
    }
}
