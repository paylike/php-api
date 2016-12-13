<?php
namespace Paylike;
/**
 * Class Card
 * @package Paylike
 * Handles card operations.
 *
 * @version    1.0.0
 */
if ( ! class_exists( 'Paylike\\Card' ) ) {
    class Card {

        /**
         * Fetches information about a card
         *
         * @link https://github.com/paylike/api-docs#create-a-transaction
         *
         * @param $cardId
         *
         * @return int|mixed
         */
        public static function fetch( $cardId ) {
            $adapter = Client::getAdapter();
            if ( ! $adapter ) {
                trigger_error( 'Adapter not set!', E_USER_ERROR );
            }

            return $adapter->request( 'cards/' . $cardId, $data = null, $httpVerb = 'get' );
        }
    }
}
