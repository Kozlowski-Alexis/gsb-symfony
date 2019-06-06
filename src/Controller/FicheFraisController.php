<?php

namespace App\Controller;
use App\Entity\FicheFrais;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FicheFraisController extends AbstractController
{
    /**
     * @Route("/fichesByUser", name="fichesByUser")
     * @return Response
     */
    public function showAllByUser(): Response
    {
        $user = $this->getUser();
        $fichesFrais = $this->getDoctrine()
            ->getRepository(FicheFrais::class)
            ->findByUser($user->getId());
        return $this->render('fiche_frais/show_all_by_user.html.twig', [
            'fichesFrais' => $fichesFrais
        ]);
    }
    /**
     * @Route("/fichesInfoByUser/{id}", name="fichesInfoByUser")
     * @param  FicheFrais $fiche
     * @return Response
     */
    public function showInfoByUser(FicheFrais $fiche): Response
    {
        $user = $this->getUser();
        $lignesFraisHorsForfait = $fiche->getLigneFraisHorsForfaits();
        return $this->render('fiche_frais/show_info_by_user.html.twig', [
            'user' => $user,
            'ficheFrais' => $fiche,
            'lignesFraisHorsForfait' => $lignesFraisHorsForfait
        ]);
    }

}
