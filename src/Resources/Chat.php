<?php
/*
 * This file is part of shopee-php.
 *
 * Copyright (c) 2024 Jin <j@sax.vn> All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EcomPHP\Shopee\Resources;

use EcomPHP\Shopee\Resource;
use GuzzleHttp\RequestOptions;

class Chat extends Resource
{
    /**
     * API: v2.sellerchat.get_message
     * To get messages history for a specific conversation, which can display the messages detail from sender and receiver.
     */
    public function getMessage($conversation_id, $params = [])
    {
        $params['conversation_id'] = $conversation_id;

        return $this->call('GET', 'sellerchat/get_message', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.sellerchat.send_message
     * 1. To send a message and select the correct message type (Do not use this API to send batch messages)
     * 2.Currently TW region is not supported to send messages.
     */
    public function sendMessage($to_id, $message_type, $content)
    {
        if (is_string($content)) {
            $content = [
                'text' => $content
            ];
        }

        $params = [
            'to_id' => $to_id,
            'message_type' => $message_type,
            'content' => $content,
        ];

        return $this->call('POST','sellerchat/send_message', [
            RequestOptions::JSON => $params,
        ]);
    }

    /**
     * API: v2.sellerchat.get_conversation_list
     * To get conversation list and its params data
     */
    public function getConversationList($params = [])
    {
        $params = array_merge([
            'direction' => 'latest',
            'type' => 'all',
        ], $params);

        return $this->call('GET', 'sellerchat/get_conversation_list', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.sellerchat.get_one_conversation
     * To get a specific conversation's basic information.
     */
    public function getOneConversation($conversation_id)
    {
        $params = [
            'conversation_id' => $conversation_id,
        ];

        return $this->call('GET', 'sellerchat/get_one_conversation', [
            RequestOptions::QUERY => $params,
        ]);
    }

    /**
     * API: v2.sellerchat.delete_conversation
     * To delete a specific conversation
     */
    public function deleteConversation($conversation_id)
    {
        return $this->call('POST', 'sellerchat/delete_conversation', [
            RequestOptions::JSON => [
                'conversation_id' => $conversation_id,
            ],
        ]);
    }

    /**
     * API: v2.sellerchat.get_unread_conversation_count
     * To get the number of unread conversations from a shop (not unread messages)
     */
    public function getUnreadConversationCount()
    {
        return $this->call('GET', 'sellerchat/get_unread_conversation_count');
    }

    /**
     * API: v2.sellerchat.pin_conversation
     * To pin a specific conversation
     */
    public function pinConversation($conversation_id)
    {
        return $this->call('POST', 'sellerchat/pin_conversation', [
            RequestOptions::JSON => [
                'conversation_id' => $conversation_id,
            ],
        ]);
    }

    /**
     * API: v2.sellerchat.unpin_conversation
     * To unpin a specific conversation
     */
    public function unpinConversation($conversation_id)
    {
        return $this->call('POST', 'sellerchat/unpin_conversation', [
            RequestOptions::JSON => [
                'conversation_id' => $conversation_id,
            ],
        ]);
    }

    /**
     * API: v2.sellerchat.read_conversation
     * To send read request for a specific conversation
     */
    public function readConversation($conversation_id, $last_read_message_id)
    {
        return $this->call('POST', 'sellerchat/read_conversation', [
            RequestOptions::JSON => [
                'conversation_id' => $conversation_id,
                'last_read_message_id' => $last_read_message_id,
            ],
        ]);
    }

    /**
     * API: v2.sellerchat.unread_conversation
     * To mark a conversation as unread
     */
    public function unreadConversation($conversation_id)
    {
        return $this->call('POST', 'sellerchat/unread_conversation', [
            RequestOptions::JSON => [
                'conversation_id' => $conversation_id,
            ],
        ]);
    }

    /**
     * API: v2.sellerchat.get_offer_toggle_status
     * To get the toggle status to check if the shop has allowed buyer to negotiate price with seller.
     */
    public function getOfferToggleStatus()
    {
        return $this->call('GET', 'sellerchat/get_offer_toggle_status');
    }

    /**
     * API: v2.sellerchat.set_offer_toggle_status
     * To set the toggle status.If set as "enabled", then seller doesn't allow buyer negotiate the price.
     */
    public function setOfferToggleStatus($make_offer_status)
    {
        return $this->call('POST', 'sellerchat/set_offer_toggle_status', [
            RequestOptions::JSON => [
                'make_offer_status' => $make_offer_status,
            ],
        ]);
    }

    /**
     * API: v2.sellerchat.upload_image
     * When you need to send an image type message, please request this API first to upload the image file to get image url. Then proceed to request the send message API with the image url.
     */
    public function uploadImage($image)
    {
        $filename = 'image.jpg';
        if ($image instanceof \SplFileInfo) {
            $filename = $image->getFilename();
            $image = file_get_contents($image->getPathname());
        }

        return $this->call('POST', 'sellerchat/upload_image', [
            RequestOptions::MULTIPART => [
                [
                    'name' => 'file',
                    'contents' => $image,
                    'filename' => $filename,
                ]
            ],
        ]);
    }

    /**
     * API: v2.sellerchat.send_autoreply_message
     * 1. To send automatic messages. Automatic messages can only be in the form of text messages.
     * 2. Currently TW region is not supported to send auto-reply messages.
     */
    public function sendAutoreplyMessage($to_id, $content)
    {
        return $this->call('POST', 'sellerchat/send_autoreply_message', [
            RequestOptions::JSON => [
                'to_id' => $to_id,
                'content' => $content,
            ],
        ]);
    }

    /**
     * API: v2.sellerchat.mute_conversation
     * To send mute request for a specific conversation
     */
    public function muteConversation($conversation_id)
    {
        return $this->call('POST', 'sellerchat/mute_conversation', [
            RequestOptions::JSON => [
                'conversation_id' => $conversation_id,
            ],
        ]);
    }

    /**
     * API: v2.sellerchat.reply_offer
     * To reply offer accept / reject offers by OpenAPI.
     */
    public function replyOffer($offer_id, $message_id, $operation)
    {
        return $this->call('POST', 'sellerchat/reply_offer', [
            RequestOptions::JSON => [
                'offer_id' => $offer_id,
                'message_id' => $message_id,
                'operation' => $operation,
            ],
        ]);
    }

    /**
     * API: v2.sellerchat.get_offer_detail
     * Get offer detail.
     */
    public function getOfferDetail($offer_id, $message_id)
    {
        return $this->call('GET', 'sellerchat/get_offer_detail', [
            RequestOptions::QUERY => [
                'offer_id' => $offer_id,
                'message_id' => $message_id,
            ],
        ]);
    }
}
