<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Livre;
use App\Entity\Genre;
use App\Entity\Auteur;
use Doctrine\ORM\EntityManagerInterface;
use Dom\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\VarDumper\Cloner\Stub;
use Symfony\Component\Form\FormError;

// use App\Repository\GenreRepository;

class LivreController extends AbstractController
{
    public function list_genre_all(EntityManagerInterface $em)
    {
        $genres = $em->getRepository(Genre::class)->findAll();
        // if(!$genres)
        //     throw $this->createNotFoundException("Aucun genre n'est trouvé ");
        return $this->render(
            'Genre/genre_list_all.html.twig',
            array('genres' => $genres)
        );
    }

    #[Route('/ajouter_genre', name: 'ajouter_genre')]
    public function ajouter_genre(EntityManagerInterface $em, request $request)
    {
        $genre = new Genre;
        $form = $this->createFormBuilder($genre)
            ->add('nom', TextType::class)
            ->add('Envoyer', SubmitType::class)
            ->getform();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($genre);
            $em->flush();
            $genres = $em->getRepository(Genre::class)->findAll();
            return $this->render(
                'Genre/genre_list_all.html.twig',
                array('genres' => $genres)
            );
        }
        return $this->render('ajouter_genre.html.twig', array('monFormulaire' => $form->createView()));
    }

    #[Route('/afficher_detail_auteur/{id}', name: 'afficher_detail_auteur')]
    public function afficher_detail_auteur(EntityManagerInterface $em, int $id)
    {
        $auteur = $em->getRepository(Auteur::class)->find($id);
        if (!$auteur)
            throw $this->createNotFoundException("Il n'y a aucun auteur correspond à cet ID");
        $livres_auteur = $auteur->getLivres();
        return $this->render(
            '/Auteur/detail_auteur.html.twig',
            array(
                'auteur' => $auteur,
                'livres' => $livres_auteur,
            )
        );
    }

    #[Route('/ajouter_auteur', name: 'ajouter_auteur')]
    public function ajouter(EntityManagerInterface $em, Request $request)
    {
        $auteur = new Auteur;
        $form = $this->createFormBuilder($auteur)
            ->add('nomPrenom', TextType::class)
            ->add('sexe', Texttype::class)
            ->add('dateDeNaissance', DateType::class, ['years' => Range(1950, date('Y'))])
            ->add('nationalite', Texttype::class)
            ->add('Envoyer', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        $auteurs = $em->getRepository(auteur::class)->findAll();
        if ($form->isSubmitted()) {
            $existant = $em->getRepository(Auteur::class)
                ->findOneBy(['nomPrenom' => $auteur->getnomPrenom()]);
            if ($existant) {
                $form->get('nomPrenom')->addError(
                    new FormError("Cet auteur existe déjà.")
                );
            }
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($auteur);
            $em->flush();
            return $this->render(
                'Auteur/list_auteurs.html.twig',
                array('auteurs' => $auteurs)
            );
        }
        return $this->render(
            'Auteur/ajouter_auteur.html.twig',
            array('monFormulaire' => $form->createView())
        );
    }


    #[Route('/modifier_auteur/{id}', name: 'modifier_auteur')]
    public function modifier_auteur(EntityManagerInterface $em, int $id, Request $request)
    {
        $auteur = $em->getRepository(auteur::class)->find($id);
        $livres = $auteur->getLivres();
        $form = $this->createFormBuilder($auteur)
            ->add('nomPrenom', TextType::class)
            ->add('sexe', TextType::class)
            ->add('dateDeNaissance', DateType::class, ['years' => range(1950, date('Y'))])
            ->add('nationalite', TextType::class)
            ->add('Envoyer', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $existant = $em->getRepository(Auteur::class)
                ->findOneBy(['nomPrenom' => $auteur->getnomPrenom()]);
            if ($existant && $existant->getId() !== $auteur->getId()) {
                $form->get('nomPrenom')->addError(
                    new FormError("Cet auteur existe déjà.")
                );
            }
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($auteur);
            $em->flush();
            return $this->render(
                'Auteur/detail_auteur.html.twig',
                array(
                    'auteur' => $auteur,
                    'livres' => $livres
                )
            );
        }
        return $this->render(
            'Auteur/ajouter_auteur.html.twig',
            array('monFormulaire' => $form->createView())
        );
    }

    #[Route('/supprimer_auteur/{id}', name: 'supprimer_auteur')]
    public function supprimer_auteur(EntityManagerInterface $em, int $id)
    {
        $auteur = $em->getRepository(auteur::class)->find($id);
        $auteurs = $em->getRepository(auteur::class)->findAll();
        if (!$auteur)
            throw $this->createNotFoundException("l'ID de cet auteur n'existe pas");
        $em->remove($auteur);
        $em->flush();
        return $this->render(
            'Auteur/list_auteurs.html.twig',
            array('auteurs' => $auteurs)
        );
    }
    #[Route('/supprimer_genre/{id}', name: 'supprimer_genre')]
    public function supprimer_genre(EntityManagerInterface $em, int $id)
    {
        $genre = $em->getRepository(Genre::class)->find($id);
        if (!$genre)
            throw $this->createNotFoundException("l'ID de ce genre n'existe pas");
        $em->remove($genre);
        $em->flush();
        return $this->redirectToRoute('lister_genres');
    }

    #[Route('/modifier_genre/{id}', name: 'modifier_genre')]
public function modifier_genre(
    EntityManagerInterface $em,
    int $id,
    Request $request
) {
    $genre = $em->getRepository(Genre::class)->find($id);

    if (!$genre) {
        throw $this->createNotFoundException(
            "Le genre demandé n'existe pas."
        );
    }

    $form = $this->createFormBuilder($genre)
        ->add('nom', TextType::class, [
            'label' => 'Nom du genre',
        ])
       
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();

        return $this->redirectToRoute('lister_genres');
    }

    return $this->render('Genre/modifier_genre.html.twig', [
        'monFormulaire' => $form->createView(),
        'genre' => $genre
    ]);
}


    #[Route('/livre_titre_inverse', name: 'livre_titre_inverse')]
    public function inversé_titre_livre(EntityManagerInterface $em)
    {
        $livres = $em->getRepository(Livre::class)->findBy([], ['titre' => 'DESC']);
        return $this->render(
            'Livre/list_livres.html.twig',
            array('livres' => $livres)
        );
    }

    #[Route('/details_livre/{id}', name: 'details_livre')]
    public function details_livre(EntityManagerInterface $em, int $id)
    {
        $livre = $em->getRepository(Livre::class)->find($id);
        $genres = $livre->getGenres();
        $auteurs = $livre->getAuteurs();
        if (!$livre)
            throw $this->createNotFoundException("il n'y a aucun livre correspond à cet ID");
        return $this->render(
            'Livre/detail_livre.html.twig',
            array(
                'livre' => $livre,
                'genres' => $genres,
                'auteurs' => $auteurs
            )
        );
    }


#[Route('/recherche', name: 'recherche_livre')]
public function rechercheLivre(Request $request, EntityManagerInterface $em)
{
    $mot = $request->query->get('q');

    if (!$mot) {
        return $this->redirectToRoute('livre_titre_inverse');
    }

    $livres = $em->getRepository(Livre::class)->searchByTitle($mot);

    return $this->render('Livre/search_livre.html.twig', [
        'livres' => $livres,
        'mot' => $mot
    ]);
}


#[Route('/menu', name: 'menu')]
public function menu(EntityManagerInterface $em)
{
    $livres = $em->getRepository(Livre::class)->findDerniersLivres(5);
    $total_livres=$em->getRepository(Livre::class)->total_livres();
    $total_auteurs=$em->getRepository(Auteur::class)->total_auteurs();

    return $this->render('menu.html.twig', [
        'livres' => $livres,
        'total_livres'=>$total_livres,
        'total_auteurs'=>$total_auteurs,
    ]);
}


    //livre
    #[Route('/ajouter_livre', name: 'ajouter_livre')]
    public function ajouter_livre(EntityManagerInterface $em, Request $request)
    {
        $livres = $em->getRepository(Livre::class)->findAll();
        $livre = new Livre;
        $form = $this->createFormBuilder($livre)
            ->add('isbn', TextType::class)
            ->add('titre', TextType::class)
            ->add('nbPages', IntegerType::class)
            ->add('dateDeParition', DateType::class)
            ->add('note', TextType::class)
            ->add('auteurs', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => 'nomPrenom',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('genres', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('Envoyer', SubmitType::class)
            ->getform();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($livre);
            $em->flush();
            return $this->render(
                'Livre/list_livres.html.twig',
                ['livres' => $livres]
            );
        }
        return $this->render(
            '/Livre/formulaire.html.twig',
            array('monFormulaire' => $form->createView())
        );
    }


    #[Route('/modifier_livre/{id}', name: 'modifier_livre')]
    public function modifier_livre(EntityManagerInterface $em, int $id, Request $request)
    {
        $livre = $em->getRepository(Livre::class)->find($id);

        $form = $this->createFormBuilder($livre)
            ->add('isbn', TextType::class)
            ->add('titre', TextType::class)
            ->add('nbPages', IntegerType::class)
            ->add('dateDeParition', DateType::class)
            ->add('note', TextType::class)
            ->add(
                'auteurs',
                EntityType::class,
                [
                    'class' => Auteur::class,
                    'choice_label' => 'nomPrenom',
                    'multiple' => true,
                    'expanded' => true
                ]
            )
            ->add('genres', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('Envoyer', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($livre);
            $em->flush();
            $livres = $em->getRepository(Livre::class)->findAll();
            return $this->render(
                'Livre/list_livres.html.twig',
                array(
                    'livres' => $livres
                )
            );
        }
        return $this->render(
            'Livre/formulaire.html.twig',
            array('monFormulaire' => $form->createView())
        );
    }

    #[Route('/supprimer_livre/{id}', name: 'supprimer_livre')]
    public function supprimer_livre(EntityManagerInterface $em, int $id)
    {
        $livre = $em->getRepository(Livre::class)->find($id);
        $em->remove($livre);
        $em->flush();
        $livres = $em->getRepository(Livre::class)->findAll();

        return $this->render(
            'Livre/list_livres.html.twig',
            ['livres' => $livres]
        );
    }

    #[Route('/lister_livres_date/{annee_debut}/{annee_fin}', name: 'lister_livres_date')]
    public function lister_livres_date(EntityManagerInterface $em, int $annee_debut, int $annee_fin)
    {
        $livres = $em->getRepository(Livre::class)->date_intervalle($annee_debut, $annee_fin);
        if (!$livres)
            throw $this->createNotFoundException("aucun livre correcpond a cet intervalle");
        else
            return $this->render(
                'Livre/list_livres.html.twig',
                ['livres'=>$livres]
            );
    }

        #[Route('/auteur_3_livres_au_moins', name: 'auteur_3_livres_au_moins')]
        public function auteur_3_livres_au_moins(EntityManagerInterface $em){
            $livres=$em->getRepository(Auteur::class)->auteur_3_livres_au_moins();
            if(!$livres)
                throw $this->createNotFoundException("Aucun auteur écrit plus de 3 livres pour le moment");
            else
                return $this->render('Auteur/list_auteurs.html.twig',
            ['auteurs'=>$livres]);

        }

        #[Route('/autantHommeFemme', name: 'autantHommeFemme')]
        public function autantHommeFemme(EntityManagerInterface $em){
            $livres=$em->getRepository(Livre::class)->autantHommeFemme();
            if (empty($livres))
                throw $this->createNotFoundException("Aucune parité dans ces livres !");
            else
                return $this->render('Livre/list_livres.html.twig',
            ['livres'=>$livres]);

        }

        #[Route('/genres/auteurs', name: 'genres_auteurs')]
public function genresAuteurs(EntityManagerInterface $em)
{
    $genres = $em->getRepository(Genre::class)->genresAvecAuteurs();

    if (empty($genres)) {
        throw $this->createNotFoundException(
            "Aucun genre ne possède d’auteurs ayant publié"
        );
    }

    return $this->render(
        'Genre/list_genres_auteurs.html.twig',
        [
            'genres' => $genres
        ]
    );
}

#[Route('/genre/{id}/total-pages', name: 'genre_total_pages')]
public function totalPagesGenre(int $id, EntityManagerInterface $em) {
    $total = $em->getRepository(Livre::class)->totalPagesParGenre($id);

    if ($total === 0) {
        throw $this->createNotFoundException(
            "Aucun livre pour ce genre"
        );
    }

    return $this->render('Genre/total_pages.html.twig', [
        'total' => $total
    ]);
}

#[Route('/auteurs/genres', name: 'auteurs_genres')]
public function auteursGenres(EntityManagerInterface $em)
{
    $resultats = $em->getRepository(Auteur::class)
                    ->genresParAuteur();

    if (!$resultats) {
        throw $this->createNotFoundException(
            "Aucun auteur trouvé"
        );
    }

    return $this->render('Auteur/list_auteurs_genres.html.twig', [
        'resultats' => $resultats
    ]);
}

#[Route('/Livres2date2notes/{dateDebut}/{dateFin}/{note1?}/{note2?}', name:'Livres2date2notes')]
public function Livres2date2notes(EntityManagerInterface $em, int $dateDebut,int $dateFin, ?float $note1, ?float $note2){
    $livres=$em->getRepository(Livre::class)->Livres2date2notesDonnes($dateDebut,$dateFin,$note1,$note2);
    if(!$livres)
        throw $this->createNotFoundException("y a aucun livre pour cette intervalle");
    return $this->render('Livre/list_livres.html.twig',
    ['livres'=>$livres]);

}


#[Route('/auteur3livresAuMoins', name:'auteur3livresAuMoins')]
    public function auteur3livresAuMoins(EntityManagerInterface $em){
        $auteurs=$em->getRepository(Auteur::class)->auteur3livresAuMoins();
        return $this->render('Auteur/list_auteurs.html.twig',
        array('auteurs'=>$auteurs));
}

 #[Route('/autantHommesFemmes',name:'autantHommesFemmes')]
 public function autantHommesFemmes(EntityManagerInterface $em){
    $livres=$em->getRepository(Livre::class)->autantHommesFemmes();
    $result=[];
    foreach($livres as $livre){
        $homme=0;
        $femme=0;

        foreach($livre->getAuteurs() as $auteur){
            if($auteur->getSexe()=='M')
                $homme++;
             elseif($auteur->getSexe()=='F')
                $femme++;
        }
          if($homme==$femme && $femme > 0)
            $result[]=$livre;
            
    }
      
    
       if(empty($result))
        throw $this->createNotFoundException("il n' a aucune parité pour moment dans les livres");
        else{
        return $this->render('Livre/list_livres_parite.html.twig',
        ['result'=>$result]);
    }


 }


 
#[Route('/livreNationaliteDiff', name:'livreNationaliteDiff')]
    public function livreNationaliteDiff(EntityManagerInterface $em){
        $livres=$em->getRepository(Livre::class)->livreNationaliteDiff();
        return $this->render('Livre/list_livres.html.twig',
        array('livres'=>$livres));
}

 #[Route('/lister_livres', name: 'lister_livres')]
    public function lister_livres(EntityManagerInterface $em)
    {
        $livres = $em->getRepository(Livre::class)->plusRecent();
        if (!$livres)
            throw $this->createNotFoundException("Il n' y a aucun livre pour le moment !");
        else
            return $this->render(
                'Livre/list_livres.html.twig',
                ['livres'=>$livres]
            );
    }

    #[Route('/lister_auteurs', name: 'lister_auteurs')]
    public function list_auteurs(EntityManagerInterface $em, Request $request)
    {
        $auteurs = $em->getRepository(auteur::class)->findAll();
            return $this->render(
                'Auteur/list_auteurs.html.twig',
                array('auteurs' => $auteurs)
            );
   }

        #[Route('/lister_genres', name: 'lister_genres')]
    public function list_genres(EntityManagerInterface $em, Request $request)
    {
        $genres = $em->getRepository(Genre::class)->findAll();
            return $this->render(
                'Genre/genre_list_all.html.twig',
                array('genres' => $genres)
            );
        }

}
