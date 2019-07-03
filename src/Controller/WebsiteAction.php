<?php

namespace Kuru\DevTest\Controller;

use Kuru\DevTest\Model\PageManager;
use Kuru\DevTest\Model\UserManager;
use Kuru\DevTest\Model\Website;
use Kuru\DevTest\Model\WebsiteManager;

class WebsiteAction
{

    /**
     * @var WebsiteManager
     */
    private $websiteManager;
    /**
     * @var PageManager
     */
    private $pageManager;
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var Website
     */
    private $website;

    public function __construct(UserManager $userManager, WebsiteManager $websiteManager, PageManager $pageManager)
    {
        $this->websiteManager = $websiteManager;
        $this->pageManager = $pageManager;
        $this->userManager = $userManager;
    
        if (isset($_SESSION['login'])) {
            $this->user = $userManager->getByLogin($_SESSION['login']);
        }
        else {
            header("Location: /login");
        }
    }

    public function execute($id)
    {
        if (isset($_SESSION['login'])) {
            $user = $this->userManager->getByLogin($_SESSION['login']);

            $website = $this->websiteManager->getById($id);

            if ($website->getUserId() == $user->getUserId()) {
                $this->website = $website;
            }
        }

        require __DIR__ . '/../view/website.phtml';
    }

    protected function getPages()
    {
        if($this->website) {
            return $this->pageManager->getAllByWebsite($this->website);
        } 
        return [];
    }
}