<?php

namespace App\Repository;

use App\Entity\Auteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Auteur>
 */
class AuteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auteur::class);
    }

     public function auteur_3_livres_au_moins():array{
        return $this->createQueryBuilder('a')
        ->join('a.livres','l')
        ->groupBy('a.id')
        ->having('count(l.id) >=3')
        ->getQuery()
        ->getResult();
    }

    // src/Repository/AuteurRepository.php

public function genresParAuteur(): array
{
    return $this->createQueryBuilder('a')
        ->join('a.livres', 'l')
        ->join('l.genres', 'g')
        ->addSelect('l')
        ->addSelect('g')
        ->groupBy('a.id, g.id')
        ->orderBy('a.nomPrenom', 'ASC')
        ->getQuery()
        ->getResult();
}

public function auteur3livresAuMoins(){
    return $this->createQueryBuilder('a')
    ->GroupBy('a.id')
    ->having('COUNT(l.id) >=3')
     ->join('a.livres','l')
    ->getQuery()
    ->getResult();
    
}

public function total_auteurs()
{
    return (int) $this->createQueryBuilder('a')
        ->select('count(a.id)')
        ->getQuery()
        ->getSingleScalarResult();
}


 

    //    /** 
    //     * @return Auteur[] Returns an array of Auteur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Auteur
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
