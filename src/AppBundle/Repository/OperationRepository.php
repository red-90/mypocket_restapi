<?php
/**
 * Created by PhpStorm.
 * User: radouane.achebak
 * Date: 19/09/2018
 * Time: 12:46
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations

class OperationRepository extends EntityRepository
{

  public function getOperationsByDate()
  {
    return $this
      ->createQueryBuilder('o')
      ->groupBy('o.operation_date')
      ->getQuery()
      ->getResult();
  }
}