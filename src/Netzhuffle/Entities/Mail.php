<?php

namespace Netzhuffle\Entities;

use \Netzhuffle\Entities\Attachment;

/** @Entity */
class Mail
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string")
     */
    private $recipient;

    /**
     * @Column(type="string")
     */
    private $sender;

    /**
     * @Column(type="string")
     */
    private $originalFrom;

    /**
     * @Column(type="string")
     */
    private $subject;

    /**
     * @Column(type="string")
     */
    private $bodyPlain;

    /**
     * @Column(type="string")
     */
    private $strippedText;

    /**
     * @Column(type="string")
     */
    private $strippedSignature;

    /**
     * @Column(type="string")
     */
    private $bodyHtml;

    /**
     * @Column(type="string")
     */
    private $strippedHtml;

    /**
     * @Column(type="string")
     */
    private $messageHeaders;

    /**
     * @Column(type="string")
     */
    private $spam;

    /**
     * @Column(type="string")
     */
    private $spamScore;

    /**
     * @Column(type="string")
     */
    private $dkimResult;

    /**
     * @Column(type="string")
     */
    private $spf;

    /**
     * @Column(type="datetime")
     */
    private $datetime;

    /**
     * @Column(type="datetime")
     */
    private $originalDatetime;

    /**
     * @OneToMany(targetEntity="Attachment", mappedBy="mail")
     */
    private $attachments;

    public function __constructor()
    {
        $this->attachments = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setOriginalFrom($originalFrom)
    {
        $this->originalFrom = $originalFrom;
    }

    public function getOriginalFrom()
    {
        return $this->originalFrom;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setBodyPlain($bodyPlain)
    {
        $this->bodyPlain = $bodyPlain;
    }

    public function getBodyPlain()
    {
        return $this->bodyPlain;
    }

    public function setStrippedText($strippedText)
    {
        $this->strippedText = $strippedText;
    }

    public function getStrippedText()
    {
        return $this->strippedText;
    }

    public function setStrippedSignature($strippedSignature)
    {
        $this->strippedSignature = $strippedSignature;
    }

    public function getStrippedSignature()
    {
        return $this->strippedSignature;
    }

    public function setBodyHtml($bodyHtml)
    {
        $this->bodyHtml = $bodyHtml;
    }

    public function getBodyHtml()
    {
        return $this->bodyHtml;
    }

    public function setStrippedHtml($strippedHtml)
    {
        $this->strippedHtml = $strippedHtml;
    }

    public function getStrippedHtml()
    {
        return $this->strippedHtml;
    }

    public function setMessageHeaders($messageHeaders)
    {
        $this->messageHeaders = $messageHeaders;
    }

    public function getMessageHeaders()
    {
        return $this->messageHeaders;
    }

    public function setSpam($spam)
    {
        $this->spam = $spam;
    }

    public function getSpam()
    {
        return $this->spam;
    }

    public function setSpamScore($spamScore)
    {
        $this->spamScore = $spamScore;
    }

    public function getSpamScore()
    {
        return $this->spamScore;
    }

    public function setDkimResult($dkimResult)
    {
        $this->dkimResult = $dkimResult;
    }

    public function getDkimResult()
    {
        return $this->dkimResult;
    }

    public function setSpf($spf)
    {
        $this->spf = $spf;
    }

    public function getSpf()
    {
        return $this->spf;
    }

    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function setOriginalDatetime($originalDatetime)
    {
        $this->originalDateTime = $originalDatetime;
    }

    public function getOriginalDatetime()
    {
        return $this->originalDatetime;
    }

    public function addAttachment($attachment)
    {
        $this->attachments[] = $attachment;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }
}
