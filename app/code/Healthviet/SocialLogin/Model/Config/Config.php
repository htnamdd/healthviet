<?php

namespace Healthviet\SocialLogin\Model\Config;

use Magento\Backend\App\ConfigInterface;
use Magento\Backend\Block\Template\Context;
use Healthviet\SocialLogin\Model\Twitter\Client as clientTwitter;
use Healthviet\SocialLogin\Model\Facebook\Client as clientFacebook;
use Healthviet\SocialLogin\Model\Google\Client as clientGoogle;
use Healthviet\SocialLogin\Model\Amazon\Client as clientAmazon;
use Healthviet\SocialLogin\Model\Line\Client as clientLine;
use Healthviet\SocialLogin\Model\Pinterest\Client as clientPinterest;
use Healthviet\SocialLogin\Model\Reddit\Client as clientReddit;
use Healthviet\SocialLogin\Model\Linkedin\Client as clientLinkedIn;
use Healthviet\SocialLogin\Model\Instagram\Client as clientInstagram;

class Config extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var ConfigInterface
     */
    protected $_config;
    /**
     * @var clientTwitter
     */
    protected $clientTwitter;
    /**
     * @var clientFacebook
     */
    protected $clientFacebook;
    /**
     * @var clientGoogle
     */
    protected $clientGoogle;
    /**
     * @var clientAmazon
     */
    protected $clientAmazon;
    /**
     * @var clientLine
     */
    protected $clientLine;
    /**
     * @var clientReddit
     */
    protected $clientReddit;
    /**
     * @var clientPinterest
     */
    protected $clientPinterest;
    /**
     * @var clientInstagram
     */
    protected $clientInstagram;
    /**
     * @var clientLinkedIn
     */
    protected $clientLinkedIn;

    /**
     * @param Context $context
     * @param ConfigInterface $config
     * @param clientTwitter $clientTwitter
     * @param clientFacebook $clientFacebook
     * @param clientGoogle $clientGoogle
     * @param clientAmazon $clientAmazon
     * @param clientInstagram $clientInstagram
     * @param clientLine $clientLine
     * @param clientLinkedIn $clientLinkedIn
     * @param clientReddit $clientReddit
     * @param clientPinterest $clientPinterest
     * @param array $data
     */
    public function __construct(
        Context $context,
        ConfigInterface $config,
        clientTwitter $clientTwitter,
        clientFacebook $clientFacebook,
        clientGoogle $clientGoogle,
        clientAmazon $clientAmazon,
        clientPinterest $clientPinterest,
        clientInstagram $clientInstagram,
        clientLine $clientLine,
        clientReddit $clientReddit,
        clientLinkedIn $clientLinkedIn,
        array $data = array()
    )
    {
        $this->_config = $config;
        $this->clientTwitter = $clientTwitter;
        $this->clientFacebook = $clientFacebook;
        $this->clientGoogle = $clientGoogle;
        $this->clientAmazon = $clientAmazon;
        $this->clientInstagram = $clientInstagram;
        $this->clientLine = $clientLine;
        $this->clientLinkedIn = $clientLinkedIn;
        $this->clientPinterest = $clientPinterest;
        $this->clientReddit = $clientReddit;
        parent::__construct($context, $data);
    }

    /**
     * create element for Access token field in store configuration
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _renderValue(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $id = $element->getId();
        switch ($id) {
            case 'healthviet_twitter_redirect_uri' :
                $url = $this->clientTwitter->getRedirectUri();
                $element->addData([
                    'value' => $url,
                    'tooltip' => 'Use this Redirect Uri value when creating your app',
                    'comment' => '<a href="https://apps.twitter.com/app/new" target="_blank">Click here to navigate to go to Twitter\'s app page</a>',
                ]);
                break;
            case 'healthviet_healthviet_fblogin_facebook_redirect_uri' :
                $url = $this->clientFacebook->getRedirectUri();
                $element->setData([
                    'value' => $url,
                    'tooltip' => 'Use this Redirect Uri value when creating your app',
                    'comment' => '<a href="https://developers.facebook.com/apps" target="_blank">Click here to navigate to Facebook\'s app page</a>',
                ]);
                break;
            case 'healthviet_google_redirect_uri' :
                $url = $this->clientGoogle->getRedirectUri();
                $element->setData([
                    'value' => $url,
                    'tooltip' => 'Use this Redirect Uri value when creating your app',
                    'comment' => '<a href="https://console.developers.google.com/projectselector/apis/library" target="_blank">Click here to navigate to Google\'s app page</a>',
                ]);
                break;
            case 'healthviet_amazon_redirect_uri' :
                $url = $this->clientAmazon->getRedirectUri();
                $element->setData([
                    'value' => $url,
                    'tooltip' => 'Use this Redirect Uri value when creating your app',
                    'comment' => '<a href="https://sellercentral.amazon.com/gp/homepage.html" target="_blank">Click here to navigate to Amazon\'s app page</a>',
                ]);
                break;
            case 'healthviet_line_redirect_uri' :
                $url = $this->clientLine->getRedirectUri();
                $element->setData([
                    'value' => $url,
                    'tooltip' => 'Use this Redirect Uri value when creating your app',
                    'comment' => '<a href="https://developers.line.me/ba/" target="_blank">Click here to navigate to Line\'s app page</a>',
                ]);
                break;
            case 'healthviet_pinterest_redirect_uri' :
                $url = $this->clientPinterest->getRedirectUri();
                $element->setData([
                    'value' => $url,
                    'tooltip' => 'Use this Redirect Uri value when creating your app',
                    'comment' => '<a href="https://developers.pinterest.com/apps/" target="_blank">Click here to navigate to Pinterest\'s app page</a>',
                ]);
                break;
            case 'healthviet_instagram_redirect_uri' :
                $url = $this->clientInstagram->getRedirectUri();
                $element->setData([
                    'value' => $url,
                    'tooltip' => 'Use this Redirect Uri value when creating your app',
                    'comment' => '<a href="https://www.instagram.com/developer/clients/register/" target="_blank">Click here to navigate to Instagram\'s app page</a>',
                ]);
                break;
            case 'healthviet_reddit_redirect_uri' :
                $url = $this->clientReddit->getRedirectUri();
                $element->setData([
                    'value' => $url,
                    'tooltip' => 'Use this Redirect Uri value when creating your app',
                    'comment' => '<a href="https://www.reddit.com/prefs/apps" target="_blank">Click here to navigate to Reddit\'s app page</a>',
                ]);
                break;
            case 'healthviet_linkedin_redirect_uri' :
                $url = $this->clientLinkedIn->getRedirectUri();
                $element->setData([
                    'value' => $url,
                    'tooltip' => 'Use this Redirect Uri value when creating your app',
                    'comment' => '<a href="https://www.linkedin.com/developer/apps/new" target="_blank">Click here to navigate to LinkedIn\'s app page</a>',
                ]);
                break;
        }
        $element->setData('onclick', 'this.select()');
        return parent::_renderValue($element);
    }
}
