<?php

namespace Botble\Team\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Team\Http\Requests\TeamRequest;
use Botble\Team\Models\Team;
use Illuminate\Support\Arr;

class TeamForm extends FormAbstract
{
    public function buildForm(): void
    {
        $social = $this->model->socials ?? [];

        $this
            ->setupModel(new Team())
            ->setValidatorClass(TeamRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('plugins/team::team.forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/team::team.forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('title', 'text', [
                'label' => trans('plugins/team::team.forms.title'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('plugins/team::team.forms.title_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('content', 'editor', [
                'label' => trans('core/base::forms.content'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('core/base::forms.description_placeholder'),
                    'with-short-code' => true,
                ],
            ])
            ->add('phone', 'number', [
                'label' => trans('plugins/team::team.forms.phone_number'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('plugins/team::team.forms.phone_number'),
                    'data-counter' => 120,
                ],
            ])
            ->add('email', 'text', [
                'label' => trans('plugins/team::team.forms.email'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('plugins/team::team.forms.email'),
                    'data-counter' => 120,
                ],
            ])
            ->add('address', 'text', [
                'label' => trans('plugins/team::team.forms.address'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('plugins/team::team.forms.address'),
                    'data-counter' => 120,
                ],
            ])
            ->add('website', 'text', [
                'label' => trans('plugins/team::team.forms.website'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('plugins/team::team.forms.website'),
                    'data-counter' => 120,
                ],
            ])
            ->add('location', 'text', [
                'label' => trans('plugins/team::team.forms.location'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('plugins/team::team.forms.location_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('socials[facebook]', 'text', [
                'label' => trans('plugins/team::team.forms.socials_facebook'),
                'label_attr' => ['class' => 'control-label'],
                'value' => Arr::get($social, 'facebook'),
                'attr' => [
                    'placeholder' => trans('plugins/team::team.forms.socials_facebook_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('socials[twitter]', 'text', [
                'label' => trans('plugins/team::team.forms.socials_twitter'),
                'label_attr' => ['class' => 'control-label'],
                'value' => Arr::get($social, 'twitter'),
                'attr' => [
                    'placeholder' => trans('plugins/team::team.forms.socials_twitter_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('socials[instagram]', 'text', [
                'label' => trans('plugins/team::team.forms.socials_instagram'),
                'label_attr' => ['class' => 'control-label'],
                'value' => Arr::get($social, 'instagram'),
                'attr' => [
                    'placeholder' => trans('plugins/team::team.forms.socials_instagram_placeholder'),
                    'data-counter' => 120,

                ],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label'],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->add('photo', 'mediaImage', [
                'label' => trans('plugins/team::team.forms.photo'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('plugins/team::team.forms.photo_placeholder'),
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}
