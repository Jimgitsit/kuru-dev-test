<?php

use Kuru\DevTest\Command\MigrateCommand;
use Kuru\DevTest\Command\WarmCommand;
use Kuru\DevTest\Component\CommandRepository;
use Kuru\DevTest\Component\Menu;
use Kuru\DevTest\Component\Migrations;
use Kuru\DevTest\Component\RouteRepository;
use Kuru\DevTest\Controller\CreatePageAction;
use Kuru\DevTest\Controller\CreateWebsiteAction;
use Kuru\DevTest\Controller\IndexAction;
use Kuru\DevTest\Controller\LoginAction;
use Kuru\DevTest\Controller\LoginFormAction;
use Kuru\DevTest\Controller\LogoutAction;
use Kuru\DevTest\Controller\RegisterAction;
use Kuru\DevTest\Controller\RegisterFormAction;
use Kuru\DevTest\Controller\WebsiteAction;
use Kuru\DevTest\Menu\LoginMenu;
use Kuru\DevTest\Menu\RegisterMenu;
use Kuru\DevTest\Menu\WebsitesMenu;

RouteRepository::registerRoute('GET', '/', IndexAction::class, 'execute');
RouteRepository::registerRoute('GET', '/login', LoginFormAction::class, 'execute');
RouteRepository::registerRoute('POST', '/login', LoginAction::class, 'execute');
RouteRepository::registerRoute('GET', '/logout', LogoutAction::class, 'execute');
RouteRepository::registerRoute('GET', '/register', RegisterFormAction::class, 'execute');
RouteRepository::registerRoute('POST', '/register', RegisterAction::class, 'execute');
RouteRepository::registerRoute('GET', '/website/{id:\d+}', WebsiteAction::class, 'execute');
RouteRepository::registerRoute('POST', '/website', CreateWebsiteAction::class, 'execute');
RouteRepository::registerRoute('POST', '/page', CreatePageAction::class, 'execute');

CommandRepository::registerCommand('migrate_db', MigrateCommand::class);
CommandRepository::registerCommand('warm [id]', WarmCommand::class);

Menu::register(LoginMenu::class, 200);
Menu::register(RegisterMenu::class, 250);
Menu::register(WebsitesMenu::class, 10);

Migrations::registerComponentMigration('Kuru\\DevTest', 3);