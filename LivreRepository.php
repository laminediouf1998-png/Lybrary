<?php

namespace App\Repository;
use DateTime; //on pouvait ajoiter \DateTime dans la fonction pour ne pas mettre un use
use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    public function date_intervalle(int $annee_debut,int $annee_fin):array{
        $date_debut=new \dateTime($annee_debut.'-01-01');
        $date_fin=new \DateTime($annee_debut.'-12-31');

        return $this->createQueryBuilder('d')
        ->where('d.DateDeParition BETWEEN :dat1 AND :dat2')
        ->orderBy('d.DateDeParition','ASC')
        ->setParameter('dat1',$date_debut)
        ->setParameter('dat2',$date_fin)
        ->getQuery()
        ->getResult();
    }

        public function autantHommeFemme():array{
            return $this->createQueryBuilder('l')
            ->join('l.auteurs','a')
            ->addSelect('a.id')
            ->having("
                sum(case when a.sexe='F' then 1 else 0 end)
                =
                sum(case when a.sexe='M' then 1 else 0 end)
            "
            )
            ->getQuery()
            ->getResult();
        }

   public function searchByTitle(string $mot): array
   {
    return $this->createQueryBuilder('l')
        ->leftJoin('l.auteurs', 'a')
        ->leftJoin('l.genres', 'g')
        ->addSelect('a', 'g')
        ->where('l.titre LIKE :mot')
        ->orWhere('a.nomPrenom LIKE :mot')
        ->orWhere('g.nom LIKE :mot')
        ->setParameter('mot', '%' . $mot . '%')
        ->distinct()
        ->getQuery()
        ->getResult();
  }

        
       public function genres_livres():array{
        return $this->createQueryBuilder('l')
        ->join('l.auteurs','a')
        ->groupBy('l.id')
        ->having('count(l.id) >=1')
        ->getQuery()
        ->getResult();
    }

    //A refaire
    // src/Repository/LivreRepository.php

public function totalPagesParGenre(int $genreId): int
{
    return (int) $this->createQueryBuilder('l')
        ->select('SUM(l.nbpages)')
        ->join('l.genres', 'g')
        ->where('g.id = :idGenre')
        ->setParameter('idGenre', $genreId)
        ->getQuery()
        ->getSingleScalarResult();
}


public function Livres2date2notesDonnes(int $dateDebut,int $dateFin, ?float $note1, ?float $note2 ){
    $date1=new \DateTime($dateDebut.'-01-01');
    $date2=new \DateTime($dateFin.'-12-31');
   $qb= $this->createQueryBuilder('l')
    ->where('l.dateDeParition BETWEEN :d1 AND :d2')
    ->setParameter('d1',$date1)
    ->setParameter('d2',$date2);
    if($note1 != NULL && $note2 != NULL){
        $qb->andWhere('l.note BETWEEN :n1 AND :n2')
        ->setParameter('n1',$note1)
        ->setParameter('n2',$note2);
    }
    return $qb->getQuery()
    ->getResult();

}



public function autantHommesFemmes(){
    return $this->createQueryBuilder('l')
    ->join('l.auteurs','a')
    ->getQuery()
    ->getResult();

}



public function livreNationaliteDiff(){
    return $this->createQueryBuilder('l')
    ->where('a.nationalite DISTINCT')
    ->join('l.auteurs','a')
    ->getQuery()
    ->getResult();

}

public function findDerniersLivres(int $limit = 5): array
{
    return $this->createQueryBuilder('l')
        ->leftJoin('l.auteurs', 'a')
        ->addSelect('a')
        ->leftJoin('l.genres', 'g')
        ->addSelect('g')
        ->orderBy('l.id', 'DESC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}

public function total_livres()
{
    return (int) $this->createQueryBuilder('l')
        ->select('COUNT(l.id)')        
        ->getQuery()
        ->getSingleScalarResult();
}

 public function plusRecent():array{

        return $this->createQueryBuilder('l')
        ->orderBy('l.dateDeParition','DESC')
        ->getQuery()
        ->getResult();
    }


   



    //    /**
    //     * @return Livre[] Returns an array of Livre objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Livre
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

