<?php

namespace Kuru\DevTest\Migration;

use Kuru\DevTest\Core\Database;
use Kuru\DevTest\Model\PageManager;
use Kuru\DevTest\Model\UserManager;
use Kuru\DevTest\Model\WebsiteManager;

class Version3
{
    /**
     * @var Database|\PDO
     */
    private $database;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var WebsiteManager
     */
    private $websiteManager;
    /**
     * @var PageManager
     */
    private $pageManager;

    public function __construct(
        Database $database,
        UserManager $userManager,
        WebsiteManager $websiteManager,
        PageManager $pageManager
    ) {
        $this->database = $database;
        $this->userManager = $userManager;
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
    }

    public function __invoke()
    {
        $this->addLastVisitToPageTable();
    }

    private function addLastVisitToPageTable()
    {
        $createQuery = <<<SQL
ALTER TABLE `kuru_dev_test`.`pages` 
ADD COLUMN `last_visit` DATETIME NULL AFTER `website_id`;
SQL;
        $this->database->exec($createQuery);
    }
}