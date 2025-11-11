<?php
namespace Healthviet\Blog\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const CONFIG_PATH_ACTIVE = 'tm_blog/general/active';
    const CONFIG_PATH_MENU_ACTIVE = 'tm_blog/general/menu_active';
    const CONFIG_PATH_TITLE = 'tm_blog/general/title';
    const CONFIG_PATH_META_TITLE = 'tm_blog/general/meta_title';
    const CONFIG_PATH_TOPLINK = 'tm_blog/general/toplink_active';
    const CONFIG_PATH_TOPLINK_LABEL = 'tm_blog/general/toplink_label';
    const CONFIG_PATH_ROUTE = 'tm_blog/general/route';
    const CONFIG_PATH_LIMITS = 'tm_blog/general/limits';
    const CONFIG_PATH_POST_LAYOUT = 'tm_blog/general/post_layout';
    const CONFIG_PATH_POST_LIST_LAYOUT = 'tm_blog/general/list_layout';
    const CONFIG_PATH_META_KEYWORDS = 'tm_blog/general/meta_keywords';
    const CONFIG_PATH_META_DESCRIPTION = 'tm_blog/general/meta_description';
    const CONFIG_PATH_RECAPTCHA_ACTIVE = 'tm_blog/general/recaptcha';
    const CONFIG_PATH_RECAPTCHA_API = 'tm_blog/general/recaptcha_api';
    const CONFIG_PATH_RECAPTCHA_SECRET = 'tm_blog/general/recaptcha_secret';
    const CONFIG_PATH_DATA_FORMAT = 'tm_blog/general/data_format';
    const CONFIG_PATH_RELATED_POSTS_ENABLE = 'tm_blog/post_view/related_posts/enabled';
    const CONFIG_PATH_RELATED_POSTS_NUMBER = 'tm_blog/post_view/related_posts/posts_number';
    const CONFIG_PATH_RELATED_POSTS_NUMBER_PER_VIEW = 'tm_blog/post_view/related_posts/posts_number_per_view';
    const CONFIG_PATH_RELATED_LAYOUT_VIEW = 'tm_blog/post_view/related_posts/layout_view';
    const CONFIG_PATH_RELATED_PRODUCTS_ENABLE = 'tm_blog/post_view/related_products/enabled';
    const CONFIG_PATH_RELATED_PRODUCTS_NUMBER = 'tm_blog/post_view/related_products/products_number';
    const CONFIG_PATH_RELATED_PRODUCTS_NUMBER_PER_VIEW = 'tm_blog/post_view/related_products/products_number_per_view';
    const CONFIG_PATH_RELATED_SHOW_LINKS = 'tm_blog/post_view/related_products/show_links';
    const CONFIG_PATH_SIDEBAR_SHOW_CATEGORIES = 'tm_blog/sidebar/show_categories';
    const CONFIG_PATH_SIDEBAR_CATEGORIES_NUMBER = 'tm_blog/sidebar/categories_number';
    const CONFIG_PATH_SIDEBAR_SHOW_POSTS = 'tm_blog/sidebar/show_posts';
    const CONFIG_PATH_SIDEBAR_POSTS_NUMBER = 'tm_blog/sidebar/posts_number';
    const CONFIG_PATH_SIDEBAR_SHOW_COMMENTS = 'tm_blog/sidebar/show_comments';
    const CONFIG_PATH_SIDEBAR_COMMENTS_NUMBER = 'tm_blog/sidebar/comments_number';

    const DEFAULT_TITLE = 'Blog';

    protected $_scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->_scopeConfig = $scopeConfig;
    }

    protected function getConfigValue($path, $scope)
    {
        return $this->_scopeConfig->getValue($path, $scope);
    }

    public function isModuleActive()
    {
        return $this->getConfigValue(self::CONFIG_PATH_ACTIVE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function isReCaptchaActive()
    {
        return $this->getConfigValue(self::CONFIG_PATH_RECAPTCHA_ACTIVE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getReCaptchaApi()
    {
        return $this->getConfigValue(self::CONFIG_PATH_RECAPTCHA_API, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getReCaptchaSecret()
    {
        return $this->getConfigValue(self::CONFIG_PATH_RECAPTCHA_SECRET, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getDataFormat()
    {
        return $this->getConfigValue(self::CONFIG_PATH_DATA_FORMAT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function isAllowTopLink()
    {
        return $this->getConfigValue(self::CONFIG_PATH_TOPLINK, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function isAllowMenu()
    {
        return $this->getConfigValue(self::CONFIG_PATH_MENU_ACTIVE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getLinkLabel()
    {
        return $this->getConfigValue(self::CONFIG_PATH_TOPLINK_LABEL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getTitle()
    {
        $value = $this->getConfigValue(self::CONFIG_PATH_TITLE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        return $value ? $value : self::DEFAULT_TITLE;
    }

    public function getMetaTitle()
    {
        return $this->getConfigValue(self::CONFIG_PATH_META_TITLE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getRoute()
    {
        return $this->getConfigValue(self::CONFIG_PATH_ROUTE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getLimits()
    {
        return $this->getConfigValue(self::CONFIG_PATH_LIMITS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getPostLayout()
    {
        return $this->getConfigValue(self::CONFIG_PATH_POST_LAYOUT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getPostListLayout()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_POST_LIST_LAYOUT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getMetaKeywords()
    {
        return $this->getConfigValue(self::CONFIG_PATH_META_KEYWORDS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getMetaDescription()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_META_DESCRIPTION,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function isRelatedPostsEnabled()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_RELATED_POSTS_ENABLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getRelatedPostsNumber()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_RELATED_POSTS_NUMBER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getRelatedPostsLayoutView()
    {
        $options = [
            0 => 'grid',
            1 => 'list'
        ];
        return $options[$this->getConfigValue(
            self::CONFIG_PATH_RELATED_LAYOUT_VIEW,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )];
    }

    public function getRelatedPostsNumberPerView()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_RELATED_POSTS_NUMBER_PER_VIEW,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function isRelatedProductsEnabled()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_RELATED_PRODUCTS_ENABLE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getRelatedProductsNumber()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_RELATED_PRODUCTS_NUMBER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getRelatedProductsNumberPerView()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_RELATED_PRODUCTS_NUMBER_PER_VIEW,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getRelatedPostsShowLinks()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_RELATED_SHOW_LINKS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getSidebarShowCategories()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_SIDEBAR_SHOW_CATEGORIES,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getSidebarCategoriesNumber()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_SIDEBAR_CATEGORIES_NUMBER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getSidebarShowPosts()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_SIDEBAR_SHOW_POSTS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getSidebarPostsNumber()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_SIDEBAR_POSTS_NUMBER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getSidebarShowComments()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_SIDEBAR_SHOW_COMMENTS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getSidebarCommentsNumber()
    {
        return $this->getConfigValue(
            self::CONFIG_PATH_SIDEBAR_COMMENTS_NUMBER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function removeVietnameseAccentsAndConcat($str, $seperator) {
        $accents_arr = array(
            'á'=>'a','à'=>'a','ả'=>'a','ã'=>'a','ạ'=>'a',
            'ă'=>'a','ắ'=>'a','ằ'=>'a','ẳ'=>'a','ẵ'=>'a','ặ'=>'a',
            'â'=>'a','ấ'=>'a','ầ'=>'a','ẩ'=>'a','ẫ'=>'a','ậ'=>'a',
            'é'=>'e','è'=>'e','ẻ'=>'e','ẽ'=>'e','ẹ'=>'e',
            'ê'=>'e','ế'=>'e','ề'=>'e','ể'=>'e','ễ'=>'e','ệ'=>'e',
            'í'=>'i','ì'=>'i','ỉ'=>'i','ĩ'=>'i','ị'=>'i',
            'ó'=>'o','ò'=>'o','ỏ'=>'o','õ'=>'o','ọ'=>'o',
            'ô'=>'o','ố'=>'o','ồ'=>'o','ổ'=>'o','ỗ'=>'o','ộ'=>'o',
            'ơ'=>'o','ớ'=>'o','ờ'=>'o','ở'=>'o','ỡ'=>'o','ợ'=>'o',
            'ú'=>'u','ù'=>'u','ủ'=>'u','ũ'=>'u','ụ'=>'u',
            'ư'=>'u','ứ'=>'u','ừ'=>'u','ử'=>'u','ữ'=>'u','ự'=>'u',
            'ý'=>'y','ỳ'=>'y','ỷ'=>'y','ỹ'=>'y','ỵ'=>'y',
            'Á'=>'A','À'=>'A','Ả'=>'A','Ã'=>'A','Ạ'=>'A',
            'Ă'=>'A','Ắ'=>'A','Ằ'=>'A','Ẳ'=>'A','Ẵ'=>'A','Ặ'=>'A',
            'Â'=>'A','Ấ'=>'A','Ầ'=>'A','Ẩ'=>'A','Ẫ'=>'A','Ậ'=>'A',
            'É'=>'E','È'=>'E','Ẻ'=>'E','Ẽ'=>'E','Ẹ'=>'E',
            'Ê'=>'E','Ế'=>'E','Ề'=>'E','Ể'=>'E','Ễ'=>'E','Ệ'=>'E',
            'Í'=>'I','Ì'=>'I','Ỉ'=>'I','Ĩ'=>'I','Ị'=>'I',
            'Ó'=>'O','Ò'=>'O','Ỏ'=>'O','Õ'=>'O','Ọ'=>'O',
            'Ô'=>'O','Ố'=>'O','Ồ'=>'O','Ổ'=>'O','Ỗ'=>'O','Ộ'=>'O',
            'Ơ'=>'O','Ớ'=>'O','Ờ'=>'O','Ở'=>'O','Ỡ'=>'O','Ợ'=>'O',
            'Ú'=>'U','Ù'=>'U','Ủ'=>'U','Ũ'=>'U','Ụ'=>'U',
            'Ư'=>'U','Ứ'=>'U','Ừ'=>'U','Ử'=>'U','Ữ'=>'U','Ự'=>'U',
            'Ý'=>'Y','Ỳ'=>'Y','Ỷ'=>'Y','Ỹ'=>'Y','Ỵ'=>'Y',
            'đ'=>'d','Đ'=>'D'
        );

        // Remove accents
        $str = strtr($str, $accents_arr);

        // Convert to lowercase
        $str = strtolower($str);

        // Replace spaces and multiple spaces
        $str = preg_replace('/[^a-zA-Z0-9]+/', ' ', $str);
        return preg_replace('/\s+/', $seperator, trim($str));
    }
}
