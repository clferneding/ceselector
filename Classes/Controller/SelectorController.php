<?php
namespace MMC\Ceselector\Controller;

class SelectorController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

  protected $cookie_name = 'T3_ceselector_';
  protected $contentRepository;
  protected $configurationManager;
  protected $cObject;
  protected $ctElUidList = [];

  public function __construct(
    \MMC\Ceselector\Domain\Repository\ContentRepository $contentRepository,
    \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
  ){
    $this->contentRepository = $contentRepository;
    $this->configurationManager = $configurationManager;
    $this->cObject = $this->configurationManager->getContentObject();
    // unique cookie name for each plugin instance
    $this->cookie_name .= $this->cObject->data['uid'];
  }


	/**
	 * Fetches tt_content uid's from the plugin-cookie
	 * and pushes them to $UidList.
	 *
	 * @return void
	 */
	private function loadUidListFromCookie(){
    // reset Uid list
		$this->ctElUidList = [];
		if ( $this->cObject->data['tx_ceselector_persistent_mode'] == 0 ) {
			return; // persistent mode is off, nothing to do
    }
		if( isset($_COOKIE[$this->cookie_name]) ){
      $cookie_data = unserialize($_COOKIE[$this->cookie_name]);
      if( !( isset($cookie_data['plts']) && isset($cookie_data['uids']) && is_array($cookie_data['uids']) ) ){
        return; // invalid cookie data
      }
      if($cookie_data['plts'] != $this->cObject->data['tstamp']){
        return; // plugin record modified, drop saved cookie data
      }
			foreach( $cookie_data['uids'] as $uid ){
        // check if record exists in DB
				if( preg_match('/^[1-9][0-9]*$/', $uid) && $this->contentRepository->recordExists($uid) ){
          $this->ctElUidList[] = $uid; // push to UID list
        }
			}
		}
	}


	/**
	 * Writes tt_content uid's from $UidList to the plugin-cookie
	 *
	 * @return void
	 */
	private function saveUidListToCookie(){
		if ($this->cObject->data['tx_ceselector_persistent_mode'] == 0 )
			return; // persistent mode is off, nothing to do
		// build cookie-expire timestamp (0 if tx_ceselector_cookie_exp == 0)
		$cookie_expire = $this->cObject->data['tx_ceselector_cookie_exp'] ?
			time() + $this->cObject->data['tx_ceselector_cookie_exp'] : 0;
		// set cookie, save imploded uid list as data
		setcookie(
			$this->cookie_name, // name
			serialize([
        'plts' => $this->cObject->data['tstamp'],
        'uids' => $this->ctElUidList
      ]), // data
			$cookie_expire, // expire timestamp
			'/', // path
			$_SERVER['SERVER_NAME'] // domain
		);
	}

	/**
	 * Fetches tt_content uid's according to plugin-parameters
	 * and pushes them to $this->ctElUidList.
	 *
	 * @return void
	 */
	private function pushToUidListFromDB( ){
		// build oder-by statement
		switch( $this->cObject->data['tx_ceselector_orderby'] ){
			case 1:
        $sortAsc = true;
        $sortBy = 'sorting';
        break;
			case 2:
        $sortAsc = false;
        $sortBy = 'sorting';
        break;
		  case 3:
        $sortAsc = true;
        $sortBy = 'header';
        break;
			case 4:
        $sortAsc = false;
        $sortBy = 'header';
        break;
			default:
        $sortAsc = true;
        $sortBy = '';
		}
		// prepare list of uid's from records
		$table_records = explode(',', $this->cObject->data['records']);
		$records = [];
    $m = [];
		foreach($table_records as $tr){
			if( preg_match('/^(tt_content_)?([0-9]+)$/', $tr, $m) ){
				$records[] = $m[2];
      }
		}
		$pages = explode(',', $this->cObject->data['pages']);
    $ctElementsFromDB = $this->contentRepository->findRecords($records, $pages, $sortBy, $sortAsc);
    foreach($ctElementsFromDB as $ctEl){
      // push uid to list (only if unique)
      $uid = $ctEl->getUid();
      if( array_search( $uid, $this->ctElUidList ) === false ){
        $this->ctElUidList[] = $uid;
      }
    }
	}


  public function renderAction(){
    $this->loadUidListFromCookie();
    // if not max elements to display is reached, add elements from db
    if( count($this->ctElUidList) < $this->cObject->data['tx_ceselector_max_el'] ){
      $this->pushToUidListFromDB();
    }
    // build list of ct-elements to display
    $displayUidList = [];
    for($i = 0; $i < count($this->ctElUidList); $i++ ){
      if( $this->cObject->data['tx_ceselector_persistent_mode'] == 2 ){
        // rotate-mode, move element to end
        $uid = array_shift($this->ctElUidList);
        $this->ctElUidList[] = $uid;
        $displayUidList[] = $uid;
      } else {
        // no rotation, just copy uid at offset
        $displayUidList[] = $this->ctElUidList[$i];
      }
      if( count($displayUidList) == $this->cObject->data['tx_ceselector_max_el'] ){
        break; // stop iterating if enough elements are collected
      }
    }
    $this->saveUidListToCookie();
    $this->view->assign('ctElUidList', implode(',', $displayUidList) );
  }

}
