<?php

namespace Botble\Hotel\Http\Controllers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Hotel\Forms\TaxForm;
use Botble\Hotel\Http\Requests\TaxRequest;
use Botble\Hotel\Models\Tax;
use Botble\Hotel\Tables\TaxTable;
use Exception;
use Illuminate\Http\Request;

class TaxController extends BaseController
{
    public function index(TaxTable $dataTable)
    {
        PageTitle::setTitle(trans('plugins/hotel::tax.name'));

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/hotel::tax.create'));

        return $formBuilder->create(TaxForm::class)->renderForm();
    }

    public function store(TaxRequest $request, BaseHttpResponse $response)
    {
        $tax = Tax::query()->create($request->input());

        event(new CreatedContentEvent(TAX_MODULE_SCREEN_NAME, $request, $tax));

        return $response
            ->setPreviousUrl(route('tax.index'))
            ->setNextUrl(route('tax.edit', $tax->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Tax $tax, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $tax->title]));

        return $formBuilder->create(TaxForm::class, ['model' => $tax])->renderForm();
    }

    public function update(Tax $tax, TaxRequest $request, BaseHttpResponse $response)
    {
        $tax->fill($request->input());
        $tax->save();

        event(new UpdatedContentEvent(TAX_MODULE_SCREEN_NAME, $request, $tax));

        return $response
            ->setPreviousUrl(route('tax.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Tax $tax, Request $request, BaseHttpResponse $response)
    {
        try {
            $tax->delete();
            event(new DeletedContentEvent(TAX_MODULE_SCREEN_NAME, $request, $tax));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
