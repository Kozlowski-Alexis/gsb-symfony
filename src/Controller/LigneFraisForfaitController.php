<?php

namespace App\Controller;
use App\Entity\Etat;
use App\Entity\FicheFrais;
use App\Entity\FraisForfait;
use App\Entity\LigneFraisForfait;
use App\Form\LigneFraisForfaitType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LigneFraisForfaitController extends AbstractController
{
    /**
     * @Route("/new_frais_forfait", name="new_frais_forfait")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $ligneFraisForfait = new LigneFraisForfait();
        $form = $this->createForm(LigneFraisForfaitType::class, $ligneFraisForfait);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération de la fiche de frais de l'utilisateur en fonction du mois et de l'année de consommation du frais hors forfait
            $fichesFrais = $this->getDoctrine()
                ->getRepository(FicheFrais::class)
                ->findByUserAndDate($user->getId(), $request->request->get('ligne_frais_forfait')['date']);
            $fraisForfait = $this->getDoctrine()
                ->getRepository(FraisForfait::class)
                ->find($request->request->get('ligne_frais_forfait')['fraisForfait']);
            $this->addFlash('success', 'Le frais hors forfait à bien été ajouté à la fiche de frais.');
            // Si une fiche existe, on ajoute le frais hors forfait en bdd en le liant à la fiche de frais existante
            if (isset($fichesFrais[0]) && !empty($fichesFrais[0])) {
                $ligneFraisForfait->setFicheFrais($fichesFrais[0]);
                $ligneFraisForfait->setFraisForfait($fraisForfait);
                $entityManager->persist($ligneFraisForfait);
                $entityManager->flush();
                return $this->redirectToRoute('fichesInfoByUser', ['id' => $fichesFrais[0]->getId()]);
                // Sinon, on crée une nouvelle fiche de frais et on ajoute le frais hors forfait en le liant à la fiche de frais créée
            } else {
                $etat = $this->getDoctrine()
                    ->getRepository(Etat::class)
                    ->find(2);
                $ficheFrais = new FicheFrais();
                $ficheFrais->setMois(DateTime::createFromFormat('Y-m-d', $request->request->get('ligne_frais_forfait')['date']));
                $ficheFrais->setNbJustificatifs(0);
                $ficheFrais->setMontantValide(0);
                $ficheFrais->setDateMotif(new DateTime());
                $ficheFrais->setUser($user);
                $ficheFrais->setEtat($etat);
                $ligneFraisForfait->setFicheFrais($ficheFrais);
                $ligneFraisForfait->setFraisForfait($fraisForfait);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($ficheFrais);
                $entityManager->persist($ligneFraisForfait);
                $entityManager->flush();
                return $this->redirectToRoute('fichesInfoByUser', ['id' => $ficheFrais->getId()]);
            }
        }
        return $this->render('ligne_frais_forfait/new.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}