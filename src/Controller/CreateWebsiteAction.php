<?php

namespace Kuru\DevTest\Controller;

use Kuru\DevTest\Model\UserManager;
use Kuru\DevTest\Model\WebsiteManager;

class CreateWebsiteAction
{
    /**
     * @var UserManager
     */
    private $userManager;
    /**
     * @var WebsiteManager
     */
    private $websiteManager;

    public function __construct(UserManager $userManager, WebsiteManager $websiteManager)
    {
        $this->userManager = $userManager;
        $this->websiteManager = $websiteManager;
    
        if (isset($_SESSION['login'])) {
            $this->user = $userManager->getByLogin($_SESSION['login']);
        }
        else {
            header("Location: /login");
        }
    }

    public function execute()
    {
        $name = $_POST['name'];
        $hostname = $_POST['hostname'];

        if(!empty($name) && !empty($hostname)) {
            if (isset($_SESSION['login'])) {
                $user = $this->userManager->getByLogin($_SESSION['login']);
                if ($user) {
                    if ($this->websiteManager->create($user, $name, $hostname)) {
                        $_SESSION['flash'] = 'Website ' . $name . ' added!';
                    }
                }
            }
        } else {
            $_SESSION['flash'] = 'Name and Hostname cannot be empty!';
        }

        header('Location: /');
    }
}