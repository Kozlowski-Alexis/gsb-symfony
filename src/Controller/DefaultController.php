<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        $user = $this->getUser();
        return $this->render('default/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user_datas", name="userDatas")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userDatas()
    {
        $user = $this->getUser();
        return $this->render('default/user_datas.html.twig', [
            'user' => $user,
        ]);
    }
}
