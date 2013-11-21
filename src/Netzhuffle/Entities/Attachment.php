<?php
namespace Netzhuffle\Entities;

use \Netzhuffle\Entities\Mail;

/** @Entity */
class Attachment
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Mail", inversedBy="attachments")
     */
     private $mail;

    /**
     * @Column(type="string")
     */
    private $mimetype;

    /**
     * @Column(type="string")
     */
    private $originalName;

    /**
     * @Column(type="string")
     */
    private $newName;

    /**
     * @Column(type="integer")
     */
    private $size;

    public function getId()
    {
        return $this->id;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    public function getMimetype()
    {
        return $this->mimetype;
    }

    public function setMimetype($mimetype)
    {
        $this->mimetype = $mimetype;
    }

    public function getOriginalName()
    {
        return $this->originalName;
    }

    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
    }

    public function getNewName()
    {
        return $this->newName;
    }

    public function setNewName($newName)
    {
        $this->newName = $newName;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }
}
