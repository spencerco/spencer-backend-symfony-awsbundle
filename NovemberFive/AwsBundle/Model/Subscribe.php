<?php
/**
 * This file is part of lib_serverside_awsbundle.
 *
 * (c) 2016 November Five BVBA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NovemberFive\AwsBundle\Model;

/**
 * Class Subscribe
 * @package NovemberFive\AwsBundle\Model
 */
class Subscribe
{
    const PROTOCOL_HTTP        = 'http';
    const PROTOCOL_HTTPS       = 'https';
    const PROTOCOL_EMAIL       = 'email';
    const PROTOCOL_EMAIL_JSON  = 'email-json';
    const PROTOCOL_SMS         = 'sms';
    const PROTOCOL_SQS         = 'sqs';
    const PROTOCOL_APPLICATION = 'application';
    const PROTOCOL_LAMBDA      = 'lambda';
}