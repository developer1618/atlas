<?php

namespace Botble\Team\Http\Controllers;

use Botble\SeoHelper\Facades\SeoHelper;
use Botble\SeoHelper\SeoOpenGraph;
use Botble\Slug\Facades\SlugHelper;
use Botble\Team\Models\Team;
use Botble\Theme\Facades\Theme;
use Illuminate\Routing\Controller;

class PublicController extends Controller
{
    public function getTeam(string $slug)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Team::class));

        if (! $slug) {
            abort(404);
        }

        $team  = Team::query()
            ->wherePublished()
            ->findOrFail($slug->reference_id);

        SeoHelper::setTitle($team->name)
            ->setDescription($team->description);

        SeoHelper::setSeoOpenGraph(
            (new SeoOpenGraph())
                ->setDescription($team->description)
                ->setUrl($team->url)
                ->setTitle($team->name)
                ->setType('article')
        );

        Theme::breadcrumb()
            ->add(__('Home'), route('public.index'))
            ->add($team->name, $team->url);

        return Theme::scope('teams.team', compact('team'))->render();
    }
}
