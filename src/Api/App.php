<?php

namespace Paylike\Api;

use Symfony\Component\OptionsResolver\OptionsResolver;

class App extends AbstractApi
{
    /**
     * Create a new app.
     *
     * @param array $options
     *
     * @return array
     */
    public function create($options)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setDefined(['name']);

        $options = $resolver->resolve($options);

        $uri = '/apps';

        return $this->post($uri, $options);
    }

    /**
     * Fetch the current app.
     *
     * @return array
     */
    public function findOne()
    {
        $uri = '/me';

        return $this->get($uri);
    }

    /**
     * Add an app to a merchant.
     *
     * @param string $merchantId
     * @param array  $options
     *
     * @return array
     */
    public function add($merchantId, $options)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['appId']);

        $options = $resolver->resolve($options);

        $uri = '/merchants/'.$merchantId.'/apps';

        return $this->post($uri, $options);
    }

    /**
     * Revoke an app from a merchant.
     *
     * @param string $merchantId
     * @param string $appId
     *
     * @return array
     */
    public function revoke($merchantId, $appId)
    {
        $uri = '/merchants/'.$merchantId.'/apps/'.$appId;

        return $this->delete($uri, $options);
    }

    /**
     * Fetch all apps.
     *
     * @param string $merchantId
     * @param array  $options
     *
     * @return array
     */
    public function find($merchantId, $options)
    {
        throw new \Exception('Not yet implemented');
    }
}
