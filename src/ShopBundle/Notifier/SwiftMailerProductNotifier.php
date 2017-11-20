<?php

namespace ShopBundle\Notifier;

use ShopBundle\Entity\Product;

class SwiftMailerProductNotifier implements ProductNotifier
{
    /** @var \Swift_Mailer */
    private $mailer;

    /**
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /** {@inheritdoc} */
    public function notify(Product $product)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setTo('fake@example.com')
            ->setBody('Product with id '.$product->getId().' created.');

        $this->mailer->send($message);
    }
}