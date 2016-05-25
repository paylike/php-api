<?php

namespace Paylike\Api;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Merchant extends AbstractApi
{
    /**
     * Create a new merchant.
     *
     * @param array $options
     *
     * @return array
     */
    public function create($options)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['currency', 'email', 'website', 'descriptor'])
            ->setDefined(['name', 'test', 'bank']);

        $options = $resolver->resolve($options);

        $uri = '/merchants';

        return $this->post($uri, $options);
    }

    /**
     * Update a merchant.
     *
     * @param string $merchantId
     * @param array  $options
     *
     * @return array
     */
    public function update($merchantId, $options)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setDefined(['name', 'email', 'descriptor']);

        $options = $resolver->resolve($options);

        $uri = '/merchants/'.$merchantId;

        return $this->put($uri, $options);
    }

    /**
     * Fetch a single merchant.
     *
     * @param string $merchantId
     *
     * @return array
     */
    public function findOne($merchantId)
    {
        $uri = '/merchants/'.$merchantId;

        return $this->get($uri);
    }

    /**
     * Fetch all merchants.
     *
     * @param string $appId
     * @param array  $options
     *
     * @return array
     */
    public function find($appId, $options)
    {
        throw new \Exception('Not yet implemented');
    }
}
