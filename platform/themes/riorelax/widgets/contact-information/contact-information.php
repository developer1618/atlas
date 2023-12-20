<?php

use Botble\Widget\AbstractWidget;

class ContactInformationMenuWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Contact information'),
            'description' => __('Contact information'),
            'phone' => null,
            'email' => null,
            'address' => null,
        ]);
    }

    protected function data(): array
    {
        $config = $this->getConfig();

        $phoneNumber =  nl2br($config['phone_number']);
        $email = nl2br($config['email']);
        $address = nl2br($config['address']);

        return compact('phoneNumber', 'email', 'address');
    }
}
