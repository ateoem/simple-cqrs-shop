<?php
/**
 * Created by PhpStorm.
 * User: atom
 * Date: 20.11.17
 * Time: 06:44
 */

namespace ShopBundle\EventListener;


use ShopBundle\Event\ProductWasCreated;

class NotifyWhenProductCreated
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

    public function onProductCreated(ProductWasCreated $productWasCreated)
    {
        $productId = $productWasCreated->getProduct()->getId();

        $message = (new \Swift_Message('Product was created'))
            ->setTo('fake@example.com')
            ->setBody(sprintf('Product with id "%s" created.', $productId),
                'text/html'
            );

        $this->mailer->send($message);
    }
}