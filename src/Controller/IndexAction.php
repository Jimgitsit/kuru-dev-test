<?php

namespace Kuru\DevTest\Controller;

use Kuru\DevTest\Model\PageManager;
use Kuru\DevTest\Model\User;
use Kuru\DevTest\Model\UserManager;
use Kuru\DevTest\Model\WebsiteManager;

class IndexAction
{

    /**
     * @var WebsiteManager
     */
    private $websiteManager;
    
    private $pageManager;

    /**
     * @var User
     */
    private $user;

    public function __construct(UserManager $userManager, WebsiteManager $websiteManager, PageManager $pageManager)
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        if (isset($_SESSION['login'])) {
            $this->user = $userManager->getByLogin($_SESSION['login']);
        }
    }

    protected function getWebsites()
    {
        if($this->user) {
            return $this->websiteManager->getAllByUser($this->user);
        } 
        return [];
    }
    
    protected function getPages()
    {
        if( $this->user) {
            return $this->pageManager->getAllByUser($this->user);
        }
        return [];
    }

    public function execute()
    {
        require __DIR__ . '/../view/index.phtml';
    }
}