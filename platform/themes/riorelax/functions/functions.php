<?php

use Botble\Base\Facades\MetaBox;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Models\BaseModel;
use Botble\Hotel\Models\Amenity;
use Botble\Media\Facades\RvMedia;
use Botble\Page\Models\Page;
use Botble\SimpleSlider\Models\SimpleSliderItem;
use Illuminate\Http\Request;

register_page_template([
    'default' => __('Default'),
    'side-menu' => __('Side menu'),
    'full-menu' => __('Full menu'),
    'blog-sidebar' => __('Blog sidebar'),
    'full-width' => __('Full width'),
]);

register_sidebar([
    'id' => 'footer_sidebar',
    'name' => 'Footer sidebar',
    'description' => __('Area for footer widgets'),
]);

register_sidebar([
    'id' => 'blog_sidebar',
    'name' => __('Blog sidebar'),
    'description' => __('Sidebar on the right of the blog detail site.'),
]);

register_sidebar([
    'id' => 'room_sidebar',
    'name' => __('Room details sidebar'),
    'description' => __('Sidebar in the room page'),
]);

register_sidebar([
    'id' => 'rooms_sidebar',
    'name' => __('Rooms sidebar'),
    'description' => __('Sidebar in the rooms page'),
]);

register_sidebar([
    'id' => 'service_sidebar',
    'name' => __('Service sidebar'),
    'description' => __('Sidebar in the service page'),
]);

RvMedia::setUploadPathAndURLToPublic();
RvMedia::addSize('medium', 440, 340)
    ->addSize('small', 300, 340)
    ->addSize('room-image', 850, 460);

add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function (FormAbstract $form, BaseModel $data): FormAbstract {
    switch (get_class($data)) {
        case Page::class:
            $form
                ->addAfter('template', 'breadcrumb_background', 'mediaImage', [
                    'label' => __('Breadcrumb background'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => $data->getMetaData('breadcrumb_background', true),
                ])
                ->addAfter('template', 'breadcrumb', 'customSelect', [
                    'label' => __('Breadcrumb'),
                    'label_attr' => ['class' => 'control-label'],
                    'choices' => [1 => __('Yes'), 0 => __('No')],
                    'selected' => $data->getMetaData('breadcrumb', true),
                ]);

            break;

        case SimpleSliderItem::class:
            $form
                ->addAfter('title', 'subtitle', 'text', [
                    'label' => __('Subtitle'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => MetaBox::getMetaData($data, 'subtitle', true),
                    'attr' => [
                        'placeholder' => __('Enter the subtitle'),
                    ],
                ])
                ->addAfter('subtitle', 'description', 'textarea', [
                    'label' => __('Description'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => MetaBox::getMetaData($data, 'description', true),
                    'attr' => [
                        'placeholder' => __('Enter the description'),
                    ],
                ])
                ->addAfter('subtitle', 'button_primary_url', 'text', [
                    'label' => __('Button URL'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => MetaBox::getMetaData($data, 'button_primary_url', true),
                    'attr' => [
                        'placeholder' => __('Enter the button URL'),
                    ],
                ])
                ->addAfter('subtitle', 'button_primary_label', 'text', [
                    'label' => __('Button label'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => MetaBox::getMetaData($data, 'button_primary_label', true),
                    'attr' => [
                        'placeholder' => __('Enter the button label'),
                    ],
                ])
                ->addAfter('subtitle', 'button_play_label', 'text', [
                    'label' => __('Button play label'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => MetaBox::getMetaData($data, 'button_play_label', true),
                    'attr' => [
                        'placeholder' => __('Enter the button play label'),
                    ],
                ])
                ->addAfter('subtitle', 'youtube_url', 'text', [
                    'label' => __('YouTube URL'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => MetaBox::getMetaData($data, 'youtube_url', true),
                    'attr' => [
                        'placeholder' => __('Enter the YouTube URL'),
                    ],
                ]);

            break;

        case Amenity::class:
            $form
                ->addAfter('icon', 'icon_image', 'mediaImage', [
                    'value' => MetaBox::getMetaData($data, 'icon_image', true),
                    'label' => __('Icon Image (It will replace Font Icon if it is present)'),
                ])
                ->addAfter('name', 'description', 'textarea', [
                    'value' => MetaBox::getMetaData($data, 'description', true),
                    'label' => __('Description'),
                    'attr' => ['rows' => 3],
                ]);
    }

    return  $form;
}, 99, 2);

add_action([BASE_ACTION_AFTER_CREATE_CONTENT, BASE_ACTION_AFTER_UPDATE_CONTENT], function (string $type, Request $request, BaseModel $model): void {
    switch ($model::class) {
        case Page::class:
            if ($request->has('breadcrumb')) {
                MetaBox::saveMetaBoxData($model, 'breadcrumb', $request->input('breadcrumb'));
            }

            if ($request->has('breadcrumb_background')) {
                MetaBox::saveMetaBoxData($model, 'breadcrumb_background', $request->input('breadcrumb_background'));
            }

            break;

        case SimpleSliderItem::class:
            if ($request->has('subtitle')) {
                MetaBox::saveMetaBoxData($model, 'subtitle', $request->input('subtitle'));
            }

            if ($request->has('description')) {
                MetaBox::saveMetaBoxData($model, 'description', $request->input('description'));
            }

            if ($request->has('button_primary_label')) {
                MetaBox::saveMetaBoxData($model, 'button_primary_label', $request->input('button_primary_label'));
            }

            if ($request->has('button_primary_url')) {
                MetaBox::saveMetaBoxData($model, 'button_primary_url', $request->input('button_primary_url'));
            }

            if ($request->has('button_play_label')) {
                MetaBox::saveMetaBoxData($model, 'button_play_label', $request->input('button_play_label'));
            }

            if ($request->has('youtube_url')) {
                MetaBox::saveMetaBoxData($model, 'youtube_url', $request->input('youtube_url'));
            }

            break;

        case Amenity::class:
            if ($request->has('icon_image')) {
                MetaBox::saveMetaBoxData($model, 'icon_image', $request->input('icon_image'));
            }

            if ($request->has('description')) {
                MetaBox::saveMetaBoxData($model, 'description', $request->input('description'));
            }
    }
}, arguments: 3);
