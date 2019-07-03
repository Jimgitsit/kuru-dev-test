<?php

namespace Kuru\DevTest\Model;

use Kuru\DevTest\Core\Database;

class PageManager
{

    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    
    public function getAllByUser(User $user)
    {
        $userId = $user->getUserId();
        $query = $this->database->prepare('SELECT * FROM pages INNER JOIN websites ON pages.website_id = websites.website_id WHERE websites.user_id = :user_id ORDER BY last_visit ASC');
        $query->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Page::class);
    }

    public function getAllByWebsite(Website $website)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $query */
        $query = $this->database->prepare('SELECT * FROM pages WHERE website_id = :website');
        $query->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Page::class);
    }

    public function create(Website $website, $url)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO pages (url, website_id) VALUES (:url, :website)');
        $statement->bindParam(':url', $url, \PDO::PARAM_STR);
        $statement->bindParam(':website', $websiteId, \PDO::PARAM_INT);
        $statement->execute();
        return $this->database->lastInsertId();
    }
    
    public function setLastViewed(Website $website, Page $page, $dt)
    {
        $websiteId = $website->getWebsiteId();
        $pageId = $page->getPageId();
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare("UPDATE pages SET last_visit = :dt WHERE website_id = :website_id AND page_id = :page_id;");
        $statement->bindParam(':dt', $dt, \PDO::PARAM_STR);
        $statement->bindParam(':website_id', $websiteId, \PDO::PARAM_INT);
        $statement->bindParam(':page_id', $pageId, \PDO::PARAM_INT);
        return $statement->execute();
    }
}