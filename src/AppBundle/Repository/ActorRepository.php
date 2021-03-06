<?php

namespace AppBundle\Repository;

/**
 * ActorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActorRepository extends \Doctrine\ORM\EntityRepository
{
    public function getActors(){
        $results = $this
            ->createQueryBuilder("actor")//construction de requête en DQL qui attends en param l'alias de l'entité
            //si on ne fait pas de select il fait toutes les sous requêtes avec et renvoie une entité. Sinon, il renvoi un tableau de tableau
            ->select('DISTINCT actor.lastname, actor.id')
            ->setFirstResult(0)//a partir de 0
            ->orderBy('actor.lastname', 'ASC')

            ->getQuery()
            ->getResult()//getArrayResult

        ;

        return $results;

    }
}
