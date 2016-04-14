<?php

namespace Paylike\Api;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Card extends AbstractApi
{
    /**
     * Saves a credit card that were used in a previous transaction.
     *
     * @param string $merchantId
     * @param array  $options
     *
     * @return array
     */
    public function save($merchantId, $options)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['transactionId'])
            ->setDefined(['notes']);

        $options = $resolver->resolve($options);

        $uri = '/merchants/'.$merchantId.'/cards';

        return $this->post($uri, $options);
    }
}
