<?php

namespace Botble\Team\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\Slug\Facades\SlugHelper;
use Botble\Team\Models\Team;
use Botble\Team\Repositories\Eloquent\TeamRepository;
use Botble\Team\Repositories\Interfaces\TeamInterface;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class TeamServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register(): void
    {
        $this->app->bind(TeamInterface::class, function () {
            return new TeamRepository(new Team());
        });
    }

    public function boot(): void
    {
        SlugHelper::registerModule(Team::class, 'Teams');
        SlugHelper::setPrefix(Team::class, 'teams', true);

        $this
            ->setNamespace('plugins/team')->loadHelpers()
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes();

        if (defined('LANGUAGE_MODULE_SCREEN_NAME') && defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            LanguageAdvancedManager::registerModule(Team::class, [
                'name',
                'title',
                'location',
            ]);
        }

        Event::listen(RouteMatched::class, function () {
            DashboardMenu::registerItem([
                'id' => 'cms-plugins-team',
                'priority' => 5,
                'parent_id' => null,
                'name' => 'plugins/team::team.name',
                'icon' => 'fa fa-list',
                'url' => route('team.index'),
                'permissions' => ['team.index'],
            ]);
        });
    }
}
