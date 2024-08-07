<?php

/**
 * This file contains functionality to generate Email Notification payloads.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\Email;

/**
 * Email Notification Payload Generator.
 *
 * @phpstan-type MailPayload array{
 *     charset: string,
 *     encoding: "8bit"|"7bit"|"binary"|"base64"|"quoted-printable",
 *     subject: string,
 *     body: string
 * }
 */
class EmailPayload
{

    /**
     * Array of Email Notification message elements.
     * @var MailPayload
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
            'subject'  => '',
            'body'     => '',
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
     * @return MailPayload The Email Payload
     */
    public function get_payload(): array
    {
        return $this->elements;
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
        $this->elements['body']  = $body;

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
     * @param "8bit"|"7bit"|"binary"|"base64"|"quoted-printable" $encoding The encoding of the email
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
