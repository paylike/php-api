<?php

namespace Paylike\Api;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Transaction extends AbstractApi
{
    /**
     * Create a new transaction from a previous transaction.
     *
     * @param string $merchantId
     * @param array  $options
     *
     * @return array
     */
    public function createFromPrevious($merchantId, $options)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['transactionId', 'amount', 'currency'])
            ->setDefined(['descriptor', 'custom']);

        $options = $resolver->resolve($options);

        $uri = '/merchants/'.$merchantId.'/transactions';

        return $this->post($uri, $options);
    }

    /**
     * Create a new transaction based on a previously saved card.
     *
     * @param string $merchantId
     * @param array  $options
     *
     * @return array
     */
    public function createFromCard($merchantId, $options)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['cardId', 'amount', 'currency'])
            ->setDefined(['descriptor', 'custom']);

        $options = $resolver->resolve($options);

        $uri = '/merchants/'.$merchantId.'/transactions';

        return $this->post($uri, $options);
    }

    /**
     * Fetch a single transaction.
     *
     * @param string $transactionId
     *
     * @return array
     */
    public function findOne($transactionId)
    {
        $uri = '/transactions/'.$transactionId;

        return $this->get($uri);
    }

    /**
     * Fetch all transactions.
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

    /**
     * Capture a payment.
     *
     * @param string $transactionId
     * @param array  $options
     *
     * @return array
     */
    public function capture($transactionId, $options)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['amount'])
            ->setDefined(['currency', 'descriptor']);

        $options = $resolver->resolve($options);

        $uri = '/transactions/'.$transactionId.'/captures';

        return $this->post($uri, $options);
    }

    /**
     * Refund a payment.
     *
     * @param string $transactionId
     * @param arrat  $options
     *
     * @return arrat
     */
    public function refund($transactionId, $options)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['amount'])
            ->setDefined(['descriptor']);

        $options = $resolver->resolve($options);

        $uri = '/transactions/'.$transactionId.'/refunds';

        return $this->post($uri, $options);
    }

    /**
     * Voids a complete or partial reserved amount.
     *
     * @param string $transactionId
     * @param array  $options
     *
     * @return array
     */
    public function void($transactionId, $options)
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['amount']);

        $options = $resolver->resolve($options);

        $uri = '/transactions/'.$transactionId.'/voids';

        return $this->post($uri, $options);
    }
}
