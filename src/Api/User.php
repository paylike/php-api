<?php

namespace Paylike\Api;

use Symfony\Component\OptionsResolver\OptionsResolver;

class User extends AbstractApi
{
    /**
     * Invite a user to a merchant.
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
            ->setRequired(['email']);

        $options = $resolver->resolve($options);

        $uri = '/merchants/'.$merchantId.'/users';

        return $this->post($uri, $options);
    }

    /**
     * Revoke a user from a merchant.
     *
     * @param string $merchantId
     * @param string $userId
     *
     * @return array
     */
    public function revoke($merchantId, $userId)
    {
        $uri = '/merchants/'.$merchantId.'/users/'.$userId;

        return $this->delete($uri, $options);
    }

    /**
     * Fetch all users.
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
