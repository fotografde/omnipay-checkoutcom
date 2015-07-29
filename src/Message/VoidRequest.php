<?php
/**
 * Checkout.com Void Request
 */

namespace Omnipay\Checkoutcom\Message;

/**
 * Checkout.com Void Request
 *
 * Checkout.com does not support voiding, per se, but
 * we treat it as a full refund.
 *
 * See RefundRequest for additional information
 *
 * Example -- note this example assumes that the purchase has been successful
 * and that the transaction ID returned from the purchase is held in $sale_id.
 * See PurchaseRequest for the first part of this example transaction:
 *
 * <code>
 *   // Do a void transaction on the gateway
 *   $transaction = $gateway->void(array(
 *       'transactionReference' => $sale_id,
 *   ));
 *   $response = $transaction->send();
 *   if ($response->isSuccessful()) {
 *       echo "Void transaction was successful!\n";
 *       $void_id = $response->getTransactionReference();
 *       echo "Transaction reference = " . $void_id . "\n";
 *   }
 * </code>
 *
 * @see RefundRequest
 * @see Omnipay\Checkoutcom\Gateway
 * @link https://stripe.com/docs/api#create_refund
 */
class VoidRequest extends RefundRequest
{
    public function getData()
    {
        $this->validate('transactionReference');

        if ($this->getRefundApplicationFee()) {
            $data['refund_application_fee'] = "true";
        }

        return null;
    }
}
