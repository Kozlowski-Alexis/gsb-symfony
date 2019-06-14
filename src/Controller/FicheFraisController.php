<?php

namespace App\Controller;
use App\Entity\FicheFrais;
use App\Entity\LigneFraisForfait;
use App\Entity\LigneFraisHorsForfait;
use App\Form\FicheType;
use App\Entity\Etat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
        $lignesFraisForfait = $fiche->getLigneFraisForfaits();

        $montantTotalFHF = $this->getDoctrine()
            ->getRepository(LigneFraisHorsForfait::class)
            ->getTotalByFiche($fiche);
        $montantTotalFF = $this->getDoctrine()
            ->getRepository(LigneFraisForfait::class)
            ->getTotalByFiche($fiche);
        $montantTotal = $montantTotalFHF[0]['montant'] + $montantTotalFF[0]['montant'];

        return $this->render('fiche_frais/show_info_by_user.html.twig', [
            'user' => $user,
            'ficheFrais' => $fiche,
            'lignesFraisHorsForfait' => $lignesFraisHorsForfait,
            'lignesFraisForfait' => $lignesFraisForfait,
            'montantTotalFHF' => $montantTotalFHF[0]['montant'],
            'montantTotalFF' => $montantTotalFF[0]['montant'],
            'montantTotal' => $montantTotal
        ]);
    }

    /**
     * Affiche toutes les fiches de frais (seulement accessible au comptables)
     * @Route("/manage_all", name="manage_all")
     * @return Response
     */
    public function manageAll(): Response
    {
        $fichesFrais = $this->getDoctrine()
            ->getRepository(FicheFrais::class)
            ->findAllNotValid();
        return $this->render('fiche_frais/show_all_manage.html.twig', [
            'fichesFrais' => $fichesFrais
        ]);
    }

    /**
     * @Route("/manage_details/{id}", name="manage_details")
     * Affiche les details d'une fiche de frais (seulement accessible au comptable)
     * @param FicheFrais $fiche
     * @param Request $request
     * @return Response
     */
    public function manageDetails(FicheFrais $fiche, Request $request): Response
    {
        $user = $this->getUser();
        // Récupère la fiche de frais en fonction de l'utilisateur et de l'id de la fiche de frais
        $ficheFrais = $this->getDoctrine()
            ->getRepository(FicheFrais::class)
            ->find($fiche);
        // Redirection si la fiche de frais n'a pas été trouvé
        if ($ficheFrais == null) {
            return $this->redirectToRoute('manage_all');
        }
        // Récupère les fiches de frais forfait et hors forfait de la fiche de frais consultée
        $lignesFraisHorsForfait = $ficheFrais->getLigneFraisHorsForfaits();
        $lignesFraisForfait = $ficheFrais->getLigneFraisForfaits();
        // Calcul le total des frais hors forfait de la fiche de frais consultée
        $montantTotalFHF = $this->getDoctrine()
            ->getRepository(LigneFraisHorsForfait::class)
            ->getTotalByFiche($fiche);
        // Calcul le total des frais forfait de la fiche de frais consultée
        $montantTotalFF = $this->getDoctrine()
            ->getRepository(LigneFraisForfait::class)
            ->getTotalByFiche($fiche);
        // Calcul le total des différents frais de la fiche de frais consultée
        $montantTotal = $montantTotalFHF[0]['montant'] + $montantTotalFF[0]['montant'];
        $form = $this->createForm(FicheType::class, $ficheFrais);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        // Vérifie si le formulaire à bien été soumis et s'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Recupère l'entité Etat "Valide"
            $etat = $this->getDoctrine()
                ->getRepository(Etat::class)
                ->find(1);
            // Vérifie que le montant validé ne soit pas supérieur au montant total de la fiche de frais
            if ($request->request->get('fiche_frais')['montantValide'] > $montantTotal) {
                $this->addFlash('error', 'Le montant validé ne peut pas être supérieur au montant total de la fiche de frais.');
                return $this->redirectToRoute('manage_all');
            }
            // MAJ du montant valide, de l'état et de la date de validation de la fiche de frais
            $ficheFrais->setMontantValide($request->request->get('fiche')['montantValide']);
            $ficheFrais->setEtat($etat);
            $ficheFrais->setDateMotif(new \DateTime());
            $entityManager->persist($ficheFrais);
            $entityManager->flush();
            $this->addFlash('success', 'L\'état de la fiche de frais à bien été mis à jour.');
            return $this->redirectToRoute('manage_all');
        }
        return $this->render('fiche_frais/show_manage_info.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'ficheFrais' => $ficheFrais,
            'lignesFraisHorsForfait' => $lignesFraisHorsForfait,
            'lignesFraisForfait' => $lignesFraisForfait,
            'montantTotalFHF' => $montantTotalFHF[0]['montant'],
            'montantTotalFF' => $montantTotalFF[0]['montant'],
            'montantTotal' => $montantTotal
        ]);
    }

}
