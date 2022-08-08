<?php

/**
 * This file contains functionality to generate Email Notification payloads.
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email;

/**
 * Email Notification Payload Generator.
 */
class EmailPayload
{

    /**
     * Array of Email Notification message elements.
     * @var array
     */
    protected array $elements;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->elements = [
            'charset'  => 'UTF-8',
            'encoding' => 'base64',
        ];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->elements);
    }

    /**
     * Construct the payload for the email notification.
     *
     * @return string The Email Payload
     */
    public function get_payload(): string
    {
        return json_encode($this->elements);
    }

    /**
     * Sets the email body of the payload.
     *
     * @param string $body The body of the email
     *
     * @return EmailPayload Self Reference
     */
    public function set_body(string $body): self
    {
        $this->elements['body'] = $body;

        return $this;
    }

    /**
     * Sets the email body of the payload.
     *
     * @param string $subject The subject of the email
     *
     * @return EmailPayload Self Reference
     */
    public function set_subject(string $subject): self
    {
        $this->elements['subject'] = $subject;

        return $this;
    }

    /**
     * Sets the email character set of the payload.
     *
     * Default character set is UTF-8.
     *
     * @param string $charset The character set of the email
     *
     * @return EmailPayload Self Reference
     */
    public function set_charset(string $charset): self
    {
        $this->elements['charset'] = $charset;

        return $this;
    }

    /**
     * Sets the email encoding of the payload.
     *
     * Default encoding is base64.
     *
     * @param string $encoding The encoding of the email
     *
     * @return EmailPayload Self Reference
     */
    public function set_encoding(string $encoding): self
    {
        $this->elements['encoding'] = $encoding;

        return $this;
    }

}

?>
