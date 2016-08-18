<?php
/**
 * Upwork auth library for using with public API by OAuth
 *
 * @final
 * @package     UpworkAPI
 * @since       04/21/2014
 * @copyright   Copyright 2014(c) Upwork.com
 * @author      Maksym Novozhylov <mnovozhilov@upwork.com>
 * @license     Upwork's API Terms of Use {@link https://developers.upwork.com/api-tos.html}
 */

namespace Upwork\API\Routers;

use Upwork\API\Debug as ApiDebug;
use Upwork\API\Client as ApiClient;

/**
 * Message Center
 *
 * @link http://developers.upwork.com/Message-Center-API
 */
final class Messages extends ApiClient
{
    const ENTRY_POINT = UPWORK_API_EP_NAME;

    /**
     * @var Client instance
     */
    private $_client;

    /**
     * Constructor
     *
     * @param   ApiClient $client Client object
     */
    public function __construct(ApiClient $client)
    {
        ApiDebug::p('init ' . __CLASS__ . ' router');
        $this->_client = $client;
        parent::$_epoint = self::ENTRY_POINT;
    }

    /**
     * Get rooms
     *
     * @param string $company Company ID
     * @access  public
     * @return  object
     */
    public function getRooms($company)
    {
        ApiDebug::p(__FUNCTION__);

        $response = $this->_client->get('/messages/v3/' . $company . '/rooms', ['returnUsers' => 'true']);
        ApiDebug::p('found rooms', $response);

        return $response;
    }

    /**
     * List room details based on room id
     *
     * @param   string $company Company ID
     * @param   integer $roomId Room ID
     * @access  public
     * @return  object
     */
    public function getRoomDetails($company, $roomId)
    {
        ApiDebug::p(__FUNCTION__);

        $response = $this->_client->get('/messages/v3/' . $company . '/rooms/' . $roomId, array('returnStories' => 'true', 'limit' => 1000));
        ApiDebug::p('found room', $response);

        return $response;
    }

    /**
     * Get a specific room by application ID
     *
     * @param   string $company Company ID
     * @param   integer $applicationId Application ID
     * @param   string $context (Optional) Context
     * @access  public
     * @return  object
     */
    public function getRoomByApplicationID($username, $applicationId)
    {
        ApiDebug::p(__FUNCTION__);

        $response = $this->_client->get('/messages/v3/rooms/' . $username . '/applications/' . $applicationId);
        ApiDebug::p('found thread', $response);

        return $response;
    }


    /**
     * Get a specific thread by context (last message content)
     *
     * @param   string $username Username
     * @param   string $jobKey Job key
     * @param   integer $applicationId Application ID
     * @param   string $context (Optional) Context
     * @access  public
     * @return  object
     */
    public function getThreadByContextLastPosts($username, $jobKey, $applicationId, $context = 'Interviews')
    {
        ApiDebug::p(__FUNCTION__);

        $response = $this->_client->get('/mc/v1/contexts/' . $username . '/' . $context . ':' . $jobKey . ':' . $applicationId . '/last_posts');
        ApiDebug::p('found thread', $response);

        return $response;
    }

    /**
     * Update threads based on user actions
     *
     * @param   string $username Username
     * @param   integer $threadId Thread ID
     * @param   array $params Parameters
     * @access  public
     * @return  object
     */
    public function markThread($username, $threadId, $params)
    {
        ApiDebug::p(__FUNCTION__);

        $response = $this->_client->put('/mc/v1/threads/' . $username . '/' . $threadId, $params);
        ApiDebug::p('found response', $response);

        return $response;
    }

    /**
     * Send new message
     *
     * @param   string $username User ID
     * @param   array $params Parameters
     * @access  public
     * @return  object
     */
    public function startNewThread($username, $params)
    {
        ApiDebug::p(__FUNCTION__);

        $response = $this->_client->post('/mc/v1/threads/' . $username, $params);
        ApiDebug::p('found response', $response);

        return $response;
    }

    /**
     * Reply to existend thread
     *
     * @param   string $username User ID
     * @param   integer $threadId Thread ID
     * @param   array $params Parameters
     * @access  public
     * @return  object
     */
    public function replyToThread($username, $threadId, $params)
    {
        ApiDebug::p(__FUNCTION__);

        $response = $this->_client->post('/mc/v1/threads/' . $username . '/' . $threadId, $params);
        ApiDebug::p('found response', $response);
        
        return $response;
    }
}
