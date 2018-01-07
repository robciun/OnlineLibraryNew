<?php
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 1/6/2018
 * Time: 7:55 PM
 */

namespace AppBundle\Entity;


use Doctrine\ORM\EntityRepository;
use FOS\ElasticaBundle\Repository;
use AppBundle\Entity\Search;

class SearchRepository extends EntityRepository
{
    public function getQueryForSearch(Search $search)
    {
        if ($search->getTitle() != null && $search != '') {
            $query = new \Elastica\Query\Match();
            $query->setFieldQuery('book.title', $search->getTitle());
            $query->setFieldFuzziness('book.title', 0.7);
            $query->setFieldMinimumShouldMatch('book.title', '80%');
        } else {
            $query = new \Elastica\Query\MatchAll();
        }
        $baseQuery = $query;

        // then we create filters depending on the chosen criterias
        $boolQuery = new \Elastica\Query\Bool();
        $boolQuery->addMust($query);


        $filtered = new \Elastica\Query\Filtered($baseQuery, $boolQuery);

        $query = \Elastica\Query::create($filtered);

        $query = new \Elastica\Query($boolQuery);
        $query->setSort(array(
            $search->getSort() => array(
                'order' => $search->getDirection()
            )
        ));

        return $query;
    }

    public function search(Search $search)
    {
        $query = $this->getQueryForSearch($search);

        return $this->find($query);
    }
}