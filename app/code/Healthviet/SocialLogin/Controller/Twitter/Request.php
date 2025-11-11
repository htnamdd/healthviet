<?php
namespace Healthviet\SocialLogin\Controller\Twitter;

class Request extends \Magento\Framework\App\Action\Action
{
    /**
     *
     */
    public function execute()
    {
        $client = $this->_objectManager->create('Healthviet\SocialLogin\Model\Twitter\Client');
        $client->fetchRequestToken();
    }
}
