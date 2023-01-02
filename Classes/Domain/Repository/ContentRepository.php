<?php
namespace MMC\Ceselector\Domain\Repository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class ContentRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

  /**
  * function findRecords
  *
  * @param array $records
  * @param array $pages
  * @param string $sortBy
  * @param bool $sortAsc
  * @return array
  */
  public function findRecords($records = [], $pages = [], $sortBy = '', $sortAsc = true) {
    $query = $this->createQuery();
    $query->matching(
      $query->logicalOr(
        $query->in('uid', $records),
        $query->in('pid', $pages)
      )
    );
    $query->getQuerySettings()->setRespectStoragePage(FALSE);
    if( $sortBy ){
      $query->setOrderings(
        [$sortBy => $sortAsc ? QueryInterface::ORDER_ASCENDING : QueryInterface::ORDER_DESCENDING]
      );
    }
    $resArray = $query->execute()->toArray();
    if (!$sortBy){
      shuffle($resArray);
    }
    return $resArray;
  }


  /**
  * function recordExists
  *
  * @param mixed $uid
  * @return bool
  */
  public function recordExists($uid){
    $query = $this->createQuery();
    $query->getQuerySettings()->setRespectStoragePage(FALSE);
    return $query->matching( $query->equals('uid', $uid) )->count() > 0;
  }

}
